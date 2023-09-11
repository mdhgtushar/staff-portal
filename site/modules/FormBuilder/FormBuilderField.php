<?php namespace ProcessWire;

/**
 * ProcessWire Form Builder Field
 *
 * Serves as an individual field in a Form Builder form.
 * It is an intermediary between the JSON/array form and Inputfields.
 *
 * Copyright (C) 2020 by Ryan Cramer Design, LLC
 * 
 * PLEASE DO NOT DISTRIBUTE
 * 
 * This file is commercially licensed, supported and distributed. 
 * 
 * @property string $name
 * @property string $type
 * @property string $label
 * @property string $description
 * @property string $notes
 * @property string $head
 * @property FormBuilderField|null $parent
 * @property bool $required
 * @property string $requiredIf
 * @property string $showIf
 * @property int $columnWidth
 * @property string $defaultValue
 * @property int $level
 * @property int $numChildren
 * @property array $children
 * @property FormBuilderForm $form
 * @property string $formName
 * 
 */

class FormBuilderField extends FormBuilderData {

	/**
	 * Used when getting a flat representation of all fields
	 *
	 */
	static protected $allFields = array();

	/**
	 * Children of this field
	 *
	 */
	protected $children = array();

	/**
	 * Set default/starting values
	 *
	 */
	public function __construct() {
		foreach($this->getDefaultsArray() as $key => $value) {
			$this->set($key, $value); 
		}
	}

	/**
	 * Get default settings for a blank FormBuilderField object
	 * 
	 * @return array
	 * 
	 */
	public function getDefaultsArray() {
		return array(
			'name' => '',
			'type' => '',
			'label' => '',
			'description' => '',
			'notes' => '',
			'head' => '',
			'parent' => null, // containing parent
			'required' => false,
			'columnWidth' => 0,
			'defaultValue' => '',
			'level' => 0,
		);
	}

	/**
	 * Set a value to the field
	 * 
	 * @param string $key
	 * @param mixed $value
	 * @return FormBuilderData|$this
	 *
	 */
	public function set($key, $value) {
		if($key == 'name') return $this->setName($value);
		return parent::set($key, $value); 
	}

	/**
	 * Set field name
	 * 
	 * @param string $name
	 * @return FormBuilderData
	 * 
	 */
	public function setName($name) {
		
		if(!ctype_alnum($name)) {
			if(!ctype_alnum(str_replace(array('-', '_', '.'), '', $name))) {
				$name = preg_replace('/[^-_.a-zA-Z0-9]/', '_', $name);
			}
		}
		
		if(strpos($name, '_END') !== false && substr($name, -4) === '_END') {
			// end of fieldset
		} else {
			$name = strtolower($name);
		}
		
		return parent::set('name', $name);

	}

	/**
	 * @return FormBuilderForm|null
	 * 
	 */
	public function fbForm() {
		if($this instanceof FormBuilderForm) return $this;
		if($this->parent) return $this->parent->fbForm();
		throw new WireException('No form for ' . $this->name);
		return null;
	}

	/**
	 * Get a value from this form field
	 * 
	 * @param string $key
	 * @return mixed
 	 *
	 */
	public function get($key) {

		if($key === 'form' || $key === 'fbForm') {
			// return the root parent (form)
			$value = $this->fbForm();
		} else if($key === 'formName') {
			$form = $this->fbForm();
			$value = $form ? $form->name : '?';
		} else if($key === 'children') {
			$value = $this->children;
		} else if($key === 'numChildren') {
			$value = count($this->children);
		} else {
			$value = parent::get($key); 
		}

		if($value === null && isset($this->children[$key])) {
			// deprecated legacy behavior of accessing child name directly
			$value = $this->children[$key];
		}

		return $value;
	}

	/**
	 * Get a setting only, no fallback to getting field by name
	 * 
	 * @param string $key
	 * @return mixed|null
	 * @since 0.4.0
	 * 
	 */
	public function getSetting($key) {
		return parent::get($key);
	}

	/**
	 * Given an array of data, populate the data to this form field
	 *
	 * Recursively populate 'children' field when present
	 * 
	 * @param array $data
	 * @return void
	 *
	 */
	public function setArray(array $data) {

		foreach($data as $key => $value) {
			if($key === 'children') {
				if(is_array($value)) {
					foreach($value as $name => $childData) {
						// convert each child in $value from array to object
						$child = new FormBuilderField();
						$child->parent = $this;
						if($this->wire) $child->setWire($this->wire);
						$child->name = $name;
						$child->setArray($childData);
						$this->add($child);
					}
				}
			} else {
				$this->set($key, $value); 
			}
		}		
	}

	/**
	 * Return an array representing this field and children (when present)
	 *
	 * @return array
	 *
	 */	
	public function getArray() {

		// get $data from WireData
		$data = parent::getArray();

		// we don't need a 'name' in the return array
		// because the field name is the key
		if(!empty($data['parent'])) unset($data['name']); 

		// remove fields that aren't needed in returns array
		// because they are already represented by the array structure
		unset($data['parent'], $data['form'], $data['level'], $data['id']); 

		// check if this field is a container for other fields (children)
		if(count($this->children)) {
			$children = array();
			foreach($this->children as $name => $child) {
				/** @var FormBuilderField $child */
				// use name defined with object, rather than key, in case it has changed
				$name = $child->name; 
				$children[$name] = $child->getArray(); 
			}
			$data['children'] = $children;
		}

		// remove any empty values for reduced storage requirements
		foreach($data as $key => $value) {
			if($value === null || $value === '') {
				unset($data[$key]);
			}
		}

		return $data; 	
	}

	/**
	 * Add a new child to this form/field
	 *
	 * @param FormBuilderField $child
	 * @return $this
	 *
	 */
	public function add(FormBuilderField $child) {

		// remove from old parent if it has one
		if($child->parent && $child->parent !== $this) {
			$child->parent->remove($child);
		}

		// set new parent and level
		$child->parent = $this; 
		$child->level = $this->level+1; 

		// unset it first in case it's already set, so that it gets appended to the end
		unset($this->children[$child->name]); 
		$formName = $this->formName;
		if(!isset(self::$allFields[$formName]) || !is_array(self::$allFields[$formName])) self::$allFields[$formName] = array();
		unset(self::$allFields[$formName][$child->name]); 

		// now add it
		$this->children[$child->name] = $child; 
		self::$allFields[$formName][$child->name] = $child;

		return $this; 
	}

	/**
	 * Remove the given child from this form/field
	 *
	 * @param FormBuilderField|string The actual field or it's name
	 * @return FormBuilderData|$this
	 *
	 */
	public function remove($key) {
		
		if(is_string($key) && array_key_exists($key, $this->data)) {
			return parent::remove($key);
		}

		if($key instanceof FormBuilderField) {
			$child = $key;
		} else {
			$child = $this->child($key);
		}

		if($child) {
			// unset the child's parent
			$child->parent = null;

			// remove from our children array
			unset($this->children[$child->name]); 
			unset(self::$allFields[$this->formName][$child->name]); 
		}

		return $this; 
	}

	/**
	 * Return array of all children
	 *
	 * @return array
	 *
	 */
	public function children() {
		return $this->children; 
	}

	/**
	 * Return a flattened (non structured) array of all children
	 *
	 * Fieldset structure is instead represented by an opening fieldset which is 
	 * closed with a field of the same name with '_END' appended to it. 
	 *
	 * This function also sets a 'level' (integer) and 'parent' (FormBuilderField)
	 * to each child, for convenience. 
	 *
	 * @param array $options
	 *  - `level` (int): For internal recursion use
	 * @return array
	 *
	 */
	public function getChildrenFlat(array $options = array()) {
		
		$defaults = array(
			'level' => 0, 
			'skipTypes' => array(), 
			'includeNestedForms' => false,  // include nested FormBuilderForm fields?
		);

		$options = array_merge($defaults, $options);
		$children = array();

		foreach($this->children as $key => $child) {
			
			/** @var FormBuilderField $child */
			$childType = $child->type;
			
			$child->level = $options['level'];
			$child->parent = $this;

			if(!in_array($childType, $options['skipTypes'])) $children[$child->name] = $child;
			$numChildren = $child->numChildren;
			
			if($childType === 'FormBuilderForm' && $options['includeNestedForms']) {
				/** @var FormBuilderForm $form */
				$form = $this->forms->load($child->get('addForm'));
				if($form) {
					foreach($form->getChildrenFlat($options) as $c) {
						$c = clone $c;
						$c->parent = $child;
						$children["{$child->name}_{$c->name}"] = $c;
					}
				}
				
			} else if($numChildren || $childType === 'Fieldset') {
				// check if there are children 
				// we also check for Fieldset in case it's an empty Fieldset

				// append the children
				if($numChildren) {
					$o = $options;
					$o['level']++;
					foreach($child->getChildrenFlat($o) as $name => $c) {
						$children[$name] = $c;
					}
				}

				// close the fieldset
				if(!in_array('Fieldset', $options['skipTypes'])) {
					$end = new FormBuilderField();
					$end->setWire($this->wire());
					$name = $child->name . '_END';
					$end->name = $name;
					$end->type = '';
					$end->level = $options['level'];
					$children[$name] = $end;
				}
			}

		}

		return $children;
	}

	/**
	 * Get contents of the self::$allFields property containing all addded fields at runtime
	 *
	 * This should only be used in cases where only 1 form is loaded in memory. For other cases,
	 * you should use the getChildrenFlat() method.
	 *
	 * @param array $options
	 * @return array
	 *
	 */
	public function findAll(array $options = array()) {
		$defaults = array(
			'type' => '',
			'getProperty' => '',
		);
		$options = array_merge($defaults, $options);
		$property = $options['getProperty'];
		$a = array();
		$formName = $this->formName;
		if(!isset(self::$allFields[$formName])) self::$allFields[$formName] = array();
		if($options['type']) {
			$options['type'] = strtolower($options['type']);
			foreach(self::$allFields[$formName] as $name => $field) {
				if(strtolower($field->type) === $options['type']) {
					$a[$name] = $property ? $field->$property : $field;
				}
			}
		} else if($property) {
			foreach(self::$allFields[$formName] as $name => $field) {
				$a[$name] = $field->$property;
			}
		} else {
			$a = self::$allFields[$formName];
		}
		return $a;
	}

	/**
	 * Check if field present in allFields or add field to it
	 * 
	 * @param array|string|FormBuilderField|null $value
	 * @return array|FormBuilderField|null
	 * 
	 */
	public function allFields($value = null) {
		if($value === null) {
			// get all
			$formName = $this->formName;
			return isset(self::$allFields[$formName]) ? self::$allFields[$formName] : array();
			
		} else if(is_array($value)) {
			// get all matching array of options query, delegate to findAll $options argument
			return $this->findAll($value); 
			
		} else if(is_string($value)) {
			// return field if present or null if not
			$formName = $this->formName;
			return isset(self::$allFields[$formName][$value]) ? self::$allFields[$formName][$value] : null;
			
		} else if($value instanceof FormBuilderForm) {	
			// add form
			$formName = $value->name;
			if(!isset(self::$allFields[$formName])) self::$allFields[$formName] = array();
			return $value;
			
		} else if($value instanceof FormBuilderField) {
			// add field
			$formName = $this->formName;
			if(!isset(self::$allFields[$formName])) self::$allFields[$formName] = array();
			self::$allFields[$formName][$value->name] = $value;
			return $value;
		}
		
		return null;
	}

	/**
	 * Return the direct child given by $name
	 *
	 * @param string $name
	 * @return FormBuilderField|null
	 *
	 */
	public function child($name) {
		if(isset($this->children[$name])) return $this->children[$name];
		return null;
	}

	/**
	 * Recursively find the field named $name (alias of getFieldByName)
	 *
	 * @param string $name
	 * @return FormBuilderField|null
	 * @deprecated Use getFieldByName instead
	 *
	 */
	public function find($name) {
		return $this->getFieldByName($name);
	}

	/**
	 * Get a field by name, within entire form
	 * 
	 * @param string $name
	 * @return FormBuilderField|null
	 * @since 0.4.4
	 * 
	 */
	public function getFieldByName($name) {
		$field = null;
		$formName = $this->formName;
		
		if(isset(self::$allFields[$formName][$name])) {
			$field = self::$allFields[$formName][$name];
			
		} else if(strpos($name, '_')) {
			// check for field nested in type=FormBuilderForm field
			foreach(self::$allFields[$formName] as $child) {
				/** @var FormBuilderField $child */
				if($child->type != 'FormBuilderForm') continue;
				if(!$child->get('addForm')) continue;
				if(strpos($name, $child->name) !== 0) continue; // (previous_location)_[city]
				if($child->form && $this->form && $child->form->name != $this->form->name) continue;
				/** @var FormBuilderForm $_form */
				$_form = $this->forms->load($child->get('addForm'));
				$_name = substr($name, strlen($child->name)+1);
				if($_form) $field = $_form->getFieldByName($_name);
				if(!$field) continue;
				$field = clone $field;
				$field->name = $name;
				break;
			}
			
		} else if(ctype_digit("$name")) {
			// determine if this ID check is still useful (which types use IDs?)
			foreach(self::$allFields[$formName] as $child) {
				if($child->id == $name) { 
					$field = $child;
					break;
				}
			}
		}
		
		if(!$field) {
			// note: this may be redundant with the isset() check at the beginning?
			foreach(self::$allFields[$formName] as $child) {
				if($child->name === $name) {
					$field = $child;
					break;
				}
			}
		}
		
		return $field;
	}

	/**
	 * Get new Inputfield for this FormBuilderField (for public API usage)
	 * 
	 * Please note: 
	 *  - Returns a new Inputfield instance on every call. 
	 *  - Returned Inputfield has no value assigned yet. 
	 *  - This method is NOT used for forms rendered or processed by FormBuilder (see FormBuilderMaker::makeInputfield for that)
	 *  - This method can be used by the entries CSV Export function for some Inputfield types. 
	 *  - This method is very similar to FormBuilderMaker::makeInputfield() and should mirror most of what it does,
	 *    but the context is different enough that they need to be separate methods. The context of this method
	 *    is more specific to public API usage or other cases where an Inputfield is needed, but we are not in a 
	 *    case where an entire form will be rendered or processed. 
	 * 
	 * @param array $options
	 *  - `language` (Language|int|string): Optionally get for this non-default language
	 *  - `type` (string): Type to use, or omit to use type assigned to this FormBuilderField
	 * @return Inputfield
	 * @since 0.4.4
	 * 
	 */
	public function getInputfield(array $options = array()) {
		
		$defaults = array('language' => null, 'type' => $this->type);
		$options = array_merge($defaults, $options);
		list($type, $language, $languageID, $processor) = array($options['type'], $options['language'], 0, null);
		$skipKeys = array('id', 'name', 'type', 'children', 'level', 'parent', 'form'); // do not add to Inputfield
		$langKeys = array('label', 'description', 'notes', 'placeholder', 'detail'); // can have other languages

		if($language && $this->wire()->languages) {
			if(is_string($language) && ctype_digit("$language")) $language = (int) "$language";
			if(!is_object($language)) $language = $this->wire()->languages->get($language); /** @var Language $language */
			if($language && $language->id && !$language->isDefault()) $languageID = $language->id;
		}
		
		/** @var Inputfield|InputfieldWrapper $f */
		$f = $this->wire()->modules->get(strpos($type, 'Inputfield') === 0 ? $type : 'Inputfield' . ucfirst($type));
		if(!$f) $f = $this->wire()->modules->get('InputfieldText');

		$f->setAttributes(array('name' => $this->name, 'id' => "Inputfield_$this->name"));
		$f->setArray(array('formBuilder' => true, 'hasFieldtype' => false)); 

		// set extra values to InputfieldFormBuilder derived Inputfields
		if($f instanceof InputfieldFormBuilderInterface && $this->form && $processor = $this->form->processor()) {
			$f->set('processor', $processor);
			$f->set('formID', $processor->id);
		}

		// populate any other settings to the Inputfield
		foreach($this->data as $key => $value) {
			if(!in_array($key, $skipKeys)) $f->$key = $this->data[$key];
		}

		// if multi-language, populate the other language properties
		if($languageID) foreach($langKeys as $key) {
			$langKey = $key . $languageID;
			$langVal = $f->$langKey;
			if(strlen($langVal)) $f->$key = $langVal;
		}
		
		/** @var InputfieldFormBuilderForm $f */
		if($processor && wireInstanceOf($f, 'InputfieldFormBuilderForm')) $f->setup($processor);

		return $f;
	}
	
	public function __toString() {
		return $this->name; 
	}

}
