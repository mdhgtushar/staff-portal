<?php namespace ProcessWire;

class ProcessFormBuilderImport extends Wire {

	/**
	 * @var FormBuilderForm
	 * 
	 */
	protected $form;

	/**
	 * Construct
	 *
	 * @param FormBuilderForm $form
	 * 
	 */
	public function __construct(FormBuilderForm $form) {
		$this->form = $form;
		parent::__construct();
	}
	
	/**
	 * Execute the 'import' process
	 *
	 * Requires the following POST variables:
	 * - form_id (int)
	 * - _import_json (string)
	 * - _import_children (array) if submit_import_commit clicked
	 * - _import_properties (array) if submit_import_commit clicked
	 *
	 * Expects one of the following submit buttons in POST:
	 * - submit_import
	 * - submit_import_commit
	 *
	 * @return string
	 * @throws WireException
	 * @throws WirePermissionException
	 *
	 */
	public function execute() {

		/** @var WireInput $input */
		$input = $this->wire('input');
		$form = $this->form;

		/** @var Modules $modules */
		$modules = $this->wire('modules');
		/** @var Session $session */
		$session = $this->wire('session');
		
		$formEditUrl = '../editForm/?id=' . $form->id;

		$json = $input->post('_import_json');
		if(!$json) throw new WireException('No JSON data specified');
		$newData = json_decode($json, true);

		if(!$newData) {
			$this->error($this->_('Invalid import JSON data'));
			$session->redirect($formEditUrl);
		}

		/** @var InputfieldForm $inputfields */
		$inputfields = $modules->get('InputfieldForm');
		$inputfields->attr('id', 'import_form');
		$inputfields->attr('method', 'post');
		$inputfields->attr('action', '../import/');

		/** @var InputfieldHidden $f */
		$f = $modules->get('InputfieldHidden');
		$f->attr('name', 'form_id');
		$f->attr('value', $form->id);
		$inputfields->add($f);

		$f = $modules->get('InputfieldTextarea');
		$f->attr('name', '_import_json');
		$f->attr('value', $json);
		$f->label = 'Import Data (JSON)';
		$f->collapsed = Inputfield::collapsedYes;
		$f->wrapAttr('hidden', 'hidden');
		$inputfields->add($f);

		if($input->post('submit_import_commit')) {
			// process submitted data
			$numChanges =
				$this->processImportChildren($form, $newData['children']) +
				$this->processImportProperties($form, $newData);
			
			if(in_array('sort', $input->post('_import_properties'))) {
				$order = explode(',', $input->post('_import_sort'));
				$this->importFormOrder($form, $order); 
				$this->message($this->_('Updated fields sort'));
				$numChanges++;
			}
			
			if($numChanges) {
				$this->wire('forms')->save($form);
			}
		} else {
			$numChanges = 0;
		}

		// analyze submitted data
		/** @var InputfieldCheckboxes $fc */
		$fc = $modules->get('InputfieldCheckboxes');
		$fc->attr('name', '_import_children');
		$fc->label = $this->_('Select the fields you would like to import');
		$fc->description = $this->_('Below is a list of fields found in the import data that are not identical to those already in the form.');
		$fc->appendMarkup = "<p class='detail'>" . $this->wire('sanitizer')->unentities(
				$this->_('Values indicated <del>in red</del> are the old value while values indicated <ins>in green</ins> are the new value.') . ' ' .
				$this->_('Note that only changed values are shown.')
			) . "</p>";
		$fc->table = true;
		$fc->thead =
			$this->_('Name') . '|' .
			$this->_('Label') . '|' .
			$this->_('Type')  . '|' .
			$this->_('Differences');
		$fc->entityEncodeText = false;
		$fc->set('themeOffset', 1);

		/** @var InputfieldCheckboxes $fp */
		$fp = $modules->get('InputfieldCheckboxes');
		$fp->attr('name', '_import_properties');
		$fp->label = $this->_('Select the form properties you would like to import');
		$fp->description = $this->_('Below is a list of properties found in the import data that are not identical to those already in the form.');
		$fp->appendMarkup = $fc->appendMarkup;
		$fp->table = true;
		$fp->thead =
			$this->_('Property') . '|' .
			$this->_('Action') . '|' .
			$this->_('Value');
		$fp->entityEncodeText = false;
		$fp->set('themeOffset', 1);

		$order1 = $this->getFormOrder($form);
		$order2 = array(); // new order
		$numChildrenDifferences = $this->buildImportChildren($form, $fc, $newData['children'], '', $order2);
		$numPropertyDifferences = $this->buildImportProperties($form, $fp, $newData);

		if($order1 !== $order2) {
			$order = $this->mergeFormOrders($order1, $order2);
			$diff = $this->getFormOrderDiff($order1, $order); 
			if(strpos($diff, '<') !== false) {
				// <ins> and/or <del> present
				$fieldsLabel = $this->_('Fields');
				$sortLabel = $this->_('Order');
				$row = "<strong>$fieldsLabel</strong>|$sortLabel|$diff";
				$fp->addOption('sort', $row, array());
				$numPropertyDifferences++;
				$sortOrder = implode(',', $order);
				$fp->appendMarkup = "<input type='hidden' name='_import_sort' value='$sortOrder' />";
			}
		}

		$numDifferences = $numChildrenDifferences + $numPropertyDifferences;
		
		if($numDifferences) {
			if($numChildrenDifferences && $numPropertyDifferences) {
				// $fp->collapsed = Inputfield::collapsedYes;
				$fc->label = $fc->label . " ($numChildrenDifferences)";
				$fp->label = $fp->label . " ($numPropertyDifferences)";
			}
			if($numPropertyDifferences) $inputfields->prepend($fp);
			if($numChildrenDifferences) $inputfields->prepend($fc);
		} else {
			if(!$numChanges) {
				$inputfields->prependMarkup = '<p>' . wireIconMarkup('check') . ' ' .
					$this->_('The import data is consistent with the current form (no field differences found).') . '</p>';
			}
		}
		
		$removals = $this->findRemoveFields($form, $newData);
		if(count($removals)) {
			$f = $modules->get('InputfieldMarkup');
			$f->label = $this->_('Field removals?') . ' (' . count($removals) . ')';
			$out = $this->_('The following fields are present on the current form, but not in the import data. If these fields should be deleted, please delete them manually:') . ' ';
			$out = "<p>$out</p><ul class='pwfb-import-diff'><li>" . implode('</li><li>', $removals) . '</li></ul>';
			$f->value = $out;
			$f->collapsed = Inputfield::collapsedYes;
			$inputfields->add($f);
		}

		
		if($numChanges) {
			$f = $modules->get('InputfieldMarkup');
			$f->label = $this->_('Import results');
			$ul = '';
			foreach($this->wire('notices') as $notice) {
				$ul .= "<li>" . $this->wire('sanitizer')->entities($notice->text) . '</li>';
			}
			$f->value = "<ul class='pwfb-import-diff'>$ul</ul>";
			$inputfields->prepend($f);
		}
	
		if($numDifferences) {
			/** @var InputfieldSubmit $submit */
			$submit = $modules->get('InputfieldSubmit');
			$submit->attr('name', 'submit_import_commit');
			$submit->attr('value', 'Import Now');
			$submit->icon = 'sign-in';
			$submit->showInHeader(true);
			$inputfields->add($submit);
		}

		/** @var InputfieldButton $f */
		$f = $modules->get('InputfieldButton');
		$f->href = $formEditUrl;
		$f->value = $this->_('Return to form editor');
		$f->icon = 'angle-right';
		$f->setSecondary(true);
		$inputfields->add($f);
		
		return $inputfields->render();
	}

	/**
	 * Build the import children checkboxes field
	 *
	 * @param FormBuilderForm $form
	 * @param InputfieldCheckboxes $checkboxes
	 * @param array $newData
	 * @return int
	 *
	 */
	protected function buildImportProperties(FormBuilderForm $form, InputfieldCheckboxes $checkboxes, array $newData) {

		$sanitizer = $this->wire('sanitizer');
		$numDifferences = 0;
		$oldData = $form->getArray();

		ksort($newData);
		ksort($oldData);

		$skips = array('children', 'name', 'method', 'type', 'action', 'roles');
		foreach($skips as $name) {
			unset($oldData[$name], $newData[$name]);
		}

		$newFramework = isset($newData['framework']) ? $newData['framework'] : '';
		$oldFramework = isset($oldData['framework']) ? $oldData['framework'] : '';

		foreach($newData as $key => $newValue) {
			if(strpos($key, 'fr') === 0 && preg_match('/^fr([A-Z][a-zA-Z0-9]+)_/', $key, $matches)) {
				$frameworkName = $matches[1];
				if($frameworkName != $newFramework) continue;
			}
			if(isset($oldData[$key])) {
				$oldValue = $oldData[$key];
			} else {
				$oldValue = is_array($newValue) ? array() : '';
			}
			if($newValue == $oldValue) continue;
			if($key === 'saveFlags') {
				$newValue = FormBuilderProcessor::saveFlagsLabels((int) $newValue);
				$oldValue = FormBuilderProcessor::saveFlagsLabels((int) $oldValue);
			}
			$oldLength = is_array($oldValue) ? count($oldValue) : strlen($oldValue);
			$newLength = is_array($newValue) ? count($newValue) : strlen($newValue);
			if(!$oldLength && !$newLength) continue;
			if(!$oldLength) $action = $this->_('Add');
			else if(!$newLength) $action = $this->_('Remove');
			else $action = $this->_('Modify');
			if(is_array($oldValue)) $oldValue = "[ '" . implode("', '", $oldValue) . "' ]";
			if(is_array($newValue)) $newValue = "[ '" . implode("', '", $newValue) . "' ]";
			$br = $oldLength && $newLength ? '<br />' : '';
			$row =
				"<strong>$key</strong>|$action|" .
				"<del>" . $sanitizer->entities($oldValue) . "</del> " . $br .
				"<ins>" . $sanitizer->entities($newValue) . "</ins>";
			$checkboxes->addOption($key, $row);
			$numDifferences++;
		}

		foreach($oldData as $key => $oldValue) {
			if(isset($newData[$key])) continue;
			if(strpos($key, 'fr') === 0 && preg_match('/^fr([A-Z][a-zA-Z0-9]+)_/', $key, $matches)) {
				$frameworkName = $matches[1];
				if($frameworkName != $oldFramework) continue;
			}
			$row =
				"<strong>$key</strong>|" .
				$this->_('Remove') . "|" .
				"<del>" . $sanitizer->entities($oldValue) . "</del> ";
			$checkboxes->addOption($key, $row);
			$numDifferences++;
		}

		// $checkboxes->label .= " ($numDifferences)";

		return $numDifferences;
	}

	/**
	 * Build the import children checkboxes field
	 *
	 * @param FormBuilderForm $form
	 * @param InputfieldCheckboxes $checkboxes
	 * @param array $children
	 * @param string $namePrefix
	 * @param array $order
	 * @return int
	 * @throws WireException
	 *
	 */
	protected function buildImportChildren(FormBuilderForm $form, InputfieldCheckboxes $checkboxes, array $children, $namePrefix, array &$order) {

		$lastExistingName = '';
		$lastName = '';
		$numDifferences = 0;

		/** @var Sanitizer $sanitizer */
		$sanitizer = $this->wire('sanitizer');

		foreach($children as $name => $item) {

			if(empty($name)) continue;
			$optionAttrs = array();
			$item['label'] = str_replace('|', ' ', $item['label']);
			$label = $item['label'];
			$value = $namePrefix ? "$namePrefix/$name" : $name;
			$value .= ":$lastName:";
			if($lastName !== $lastExistingName) $value .= $lastExistingName;
			$label = $sanitizer->entities($label);
			// $level = substr_count($value, '/'); 
			// $label = ($level ? ' ' . str_repeat('—', $level) . ' ' : '') . 
			$order[] = $name;
			$field = $form->find($name);

			if($field) {
				$diffs = array();
				$fieldData = $field->getArray();
				foreach($item as $k => $v) {
					if(empty($fieldData[$k])) {
						// add
						$diffs[$k] = "<ins>$k</ins>";
					} else if($v != $fieldData[$k]) {
						// modify
						$diffs[$k] = "$k: " .
							"<del>" . $sanitizer->entities($fieldData[$k]) . "</del> " .
							"<ins>" . $sanitizer->entities($v) . "</ins>";
					}
				}
				foreach($fieldData as $k => $v) {
					// remove
					if(!isset($item[$k])) $diffs[$k] = "<del>$k</del>";
				}
				unset($diffs['children']);
				if(count($diffs)) {
					$diffList = "<li>" . implode("</li><li>", $diffs) . "</li>";
				} else {
					$diffList = '';
					$optionAttrs['disabled'] = 'disabled';
				}
				$lastExistingName = $name;

			} else {
				$diffList = "<li><ins>" . $this->_('New field') . "</ins></li>";
			}

			if(!empty($diffList)) {
				$diffList = str_replace('|', ' ', $diffList);
				$row = "<strong>$name</strong>|$label|$item[type]|<ul class='pwfb-import-diff'>$diffList</ul></ul>";
				$checkboxes->addOption($value, $row, $optionAttrs);
				$numDifferences++;
			}

			if(!empty($item['children'])) {
				$numDifferences += $this->buildImportChildren($form, $checkboxes, $item['children'], $name, $order);
			}

			$lastName = $name;
		}

		return $numDifferences;
	}

	/**
	 * Process the form properties import
	 *
	 * @param FormBuilderForm $form
	 * @param array $newData
	 * @return int
	 * @throws WireException
	 *
	 */
	protected function processImportProperties(FormBuilderForm $form, array $newData) {
		/** @var WireInput $input */
		$input = $this->wire('input');
		$numChanges = 0;
		$importProperties = $input->post->array('_import_properties');

		foreach($importProperties as $property) {
			$newValue = isset($newData[$property]) ? $newData[$property] : null;
			$oldValue = $form->get($property);

			if($newValue === $oldValue) continue;

			if($newValue === null) {
				$form->__unset($property);
				$this->message("Removed form property: $property");
			} else {
				$form->set($property, $newValue);
				if(empty($oldValue)) {
					$this->message("Added form property: $property");
				} else {
					$this->message("Updated form property: $property");
				}
			}

			$numChanges++;
		}

		return $numChanges;
	}

	/**
	 * Process the form children import
	 *
	 * @param FormBuilderForm $form
	 * @param array $children
	 * @return int
	 * @throws WireException
	 *
	 */
	protected function processImportChildren(FormBuilderForm $form, array $children) {
		/** @var WireInput $input */
		$input = $this->wire('input');
		$numChanges = 0;
		$importChildren = $input->post->array('_import_children');

		foreach($importChildren as $value) {

			list($name, $lastName, $lastExistingName) = explode(':', $value);
			if(empty($lastExistingName) && !empty($lastName)) $lastExistingName = $lastName;
			if($lastExistingName) {} // ignore

			$names = strpos($name, '/') ? explode('/', $name) : array($name);
			$name = array_pop($names);
			$parentNames = $names;

			$data = $children;
			$child = isset($data[$name]) ? $data[$name] : null;
			while($child === null && count($names)) {
				$parentName = array_shift($names);
				$data = $data[$parentName]['children'];
				$child = isset($data[$name]) ? $data[$name] : null;
			}
			if(!$child) {
				$this->error("Unable to find field $name in import data");
				continue;
			}

			$field = $form->find($name);
			if($field) {
				// update existing field
				foreach($child as $k => $v) {
					if($field->get($k) != $v) {
						$field->set($k, $v);
						$this->message("Updated field: $name.$k");
						$numChanges++;
					}
				}
				foreach($field->getArray() as $k => $v) {
					if(!isset($child[$k])) {
						$field->__unset($k);
						$this->message("Removed field setting: $name.$k");
						$numChanges++;
					}
				}
			} else {
				// add new field
				$parent = null;
				foreach(array_reverse($parentNames) as $parentName) {
					$parent = $form->find($parentName);
					if($parent) break;
				}
				if(!$parent) $parent = $form;
				$field = new FormBuilderField();
				$field->setWire($this->wire()); 
				$field->set('name', $name);
				$field->setArray($child);
				$parent->add($field);
				$this->message("Added field: $name " . ($parent !== $form ? "(in $parent)" : ""));
				$numChanges++;
			}
		}

		return $numChanges;
	}
	
	protected function getFormOrder(FormBuilderForm $form) {
		$a = $form->getChildrenFlat();
		return array_keys($a);
	}
	
	protected function getFormOrderDiff(array $order1, array $mergedOrder) {
		include(dirname(__FILE__) . '/diff/diff.php'); 
		$str1 = '• ' . implode(' • ', $order1); 
		$str2 = '• ' . implode(' • ', $mergedOrder); 
		return pwfbHtmlDiff($str1, $str2); 
	}
	
	protected function mergeFormOrders(array $order1, array $order2) {
		$order1 = array_flip($order1); // current
		$order2 = array_flip($order2); // new
		list($n1, $n2) = array(0, 0);
		foreach($order1 as $name => $value) $order1[$name] = (++$n1) * 749;
		foreach($order2 as $name => $value) $order2[$name] = (++$n2) * 500;
		$order = array_merge($order1, $order2);
		asort($order);
		$order = array_flip($order);
		return $order;
	}
	
	protected function importFormOrder(FormBuilderForm $form, array $order) {
		
		$parents = array($form);
		$parent = $form;
		$sanitizer = $this->wire('sanitizer');
		
		foreach($order as $name) {
			$name = $sanitizer->fieldName($name);
			if(empty($name)) continue;

			if(substr($name, -4) == '_END') {
				$parent = array_pop($parents);
				continue;
			}

			$field = $form->find($name);
			if(!$field) continue;

			if($parent) {
				$parent->add($field);
			} else {
				$form->add($field);
			}

			if($field->type == 'Fieldset') {
				if($parent) $parents[] = $parent;
				$parent = $field;
			}
		}
	}
	
	protected function findRemoveFields(FormBuilderForm $form, array $newData) {

		$removals = array();
		$names = array();
		$a = $newData['children'];
		
		while(count($a)) {
			foreach($a as $name => $info) {
				$names[$name] = $name;
				if(!empty($info['children'])) $a = array_merge($a, $info['children']); 
				unset($a[$name]); 
			}
		}
		
		foreach($form->getChildrenFlat() as $item) {
			if(!isset($names[$item->name])) $removals[] = $item->name;
		}
		
		return $removals;
	}

}