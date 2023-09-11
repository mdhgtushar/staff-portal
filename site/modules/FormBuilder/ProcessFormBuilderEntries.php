<?php namespace ProcessWire;

/**
 * ProcessWire Form Builder: Entries Process
 *
 * Copyright (C) 2020 by Ryan Cramer Design, LLC
 *
 * PLEASE DO NOT DISTRIBUTE
 *
 * This file is commercially licensed and distributed.
 *
 * @method InputfieldWrapper buildListEntriesForm(FormBuilderForm $form, array $entries, array $filters, $currentUrl)
 * @method InputfieldWrapper buildListFilterForm(FormBuilderForm $form, $total, array $filters)
 * @method MarkupAdminDataTable buildListEntries(FormBuilderForm $form, array $entries, array $filters)
 *
 * @method string compareEntry(FormBuilderForm $form, array $entry, $pageID)
 * @method array|bool compareEntryIsDifferent($entryValue, $pageValue, $fieldType, array $details)
 * 
 */

class ProcessFormBuilderEntries extends Wire {
	
	const defaultOperator = '*=';
	
	const defaultSort = '-created';

	/**
	 * @var FormBuilder
	 * 
	 */
	protected $forms;

	/**
	 * @var FormBuilderForm
	 * 
	 */
	protected $form;

	/**
	 * @var ProcessFormBuilder
	 * 
	 */
	protected $process;

	/**
	 * @var bool
	 * 
	 */
	protected $hasFilters = false;

	/**
	 * Filters with non-default values that are applied (populated by getFilters method)
	 * 
	 * @var array
	 * 
	 */
	protected $filters = array();

	/**
	 * Query strings in format [ 'name' => 'name=value' ] where values are URL encoded
	 * 
	 * @var array
	 * 
	 */
	protected $queryStrings = array();
	
	/**
	 * Runtime caches for cacheGet() / cacheSet() methods
	 *
	 * @var array
	 *
	 */
	protected $caches = array();

	/**
	 * Entry search operators
	 * 
	 * @var array
	 * 
	 */
	protected $operators = array(
		'=' => 'Equal',
		'!=' => 'Not equal',
		'>' => 'Greater than',
		'>=' => 'Greater than or equal',
		'<' => 'Less than',
		'<=' => 'Less than or equal',
		'~=' => 'Contains all words',
		'~|=' => 'Contains any words',
		'*=' => 'Contains text/phrase', 
		'%=' => 'Contains text like',
		//'=""' => 'Is empty', 
		//'!=""' => 'Is not empty',
	);

	/**
	 * Construct
	 *
	 * @param FormBuilder $forms
	 * @param ProcessFormBuilder $process
	 *
	 */
	public function __construct(FormBuilder $forms, ProcessFormBuilder $process) {
		$this->forms = $forms;
		$this->process = $process; 
		$process->wire($this);
		
		// ProcessWire 3.0.154+ - replace operator labels with potentially translated labels from PW core
		$ops = Selectors::getOperators(array(
			'getIndexType' => 'operator',
			'getValueType' => 'label',
		));
		
		foreach($this->operators as $operator => $label) {
			if(isset($ops[$operator])) $this->operators[$operator] = $ops[$operator];
		}
		
		parent::__construct();
	}
	
	/**
	 * Get label
	 * 
	 * @param string $name
	 * @return string
	 * 
	 */
	public function labels($name) {
		$label = '';
		switch($name) {
			case 'entries': return $this->_('Entries');
			case 'updated-existing-page': return $this->_('Updated existing page');
			case 'sent-entry-to-page': return $this->_('Sent entry to page');
			case 'delete-checked': return $this->_('Delete Checked');
			case 'resend-checked': return $this->_('Resend Checked');
			case 'send-checked-to-pages': return $this->_('Send Checked to Pages');
			case 'modified': return $this->_('Modified');
			case 'modified-date': return $this->_('Modified date');
			case 'created': return $this->_('Created');
			case 'created-date': return $this->_('Created date');
			case 'columns': return $this->_('Columns');
			case 'cols':
			case 'columns-to-show': return $this->_('Columns and order to show');
			case 'completed': return $this->_('Completed');
			case 'partial': return $this->_('Partial');
			case 'any-field': return $this->_('Any field');
			case 'all': return $this->_('All');
			case 'dateFrom':
			case 'date-from': return $this->_('Date from');
			case 'dateTo':
			case 'date-to': return $this->_('Date to');
			case 'sort': return $this->_('Sort');
			case 'limit':
			case 'limit-per-page': return $this->_('Limit (per page)');
			case 'remove': return $this->_('remove');
			case 'new': return $this->_('new');
			case 'old': return $this->_('old');
			case 'high': return $this->_('high');
			case 'low': return $labelLowest = $this->_('low');
			case 'reverse': return $this->_('reverse');
		}
		if(!$label) $label = $this->process->labels($name);
		if(!$label) $label = $name;
		return $label;
	}

	/**
	 * Get field labels and types indexed by field name for given form
	 *
	 * @param FormBuilderForm $form
	 * @param array $options
	 * @return array
	 *
	 */
	public function getFieldLabels(FormBuilderForm $form, array $options = array()) {
		
		$defaults = array(
			'skipFieldsets' => true, 
			'skipRuntime' => true, 
			'maxLabelLength' => 45, 
			'getSystem' => false,
			'getVerbose' => false, 
			'sortByLabel' => true, 
		);
	
		$options = array_merge($defaults, $options);
		$cacheKey = "getFieldLabels,$form->name,$options[skipFieldsets],$options[maxLabelLength]";
		$fieldsetTypes = array('FormBuilderPageBreak', 'Fieldset', 'FieldsetClose');
		$honeypot = $form->honeypot;
		$a = array();
		
		if($this->cacheHas($cacheKey)) {
			$a = $this->cacheGet($cacheKey);
		} else {
			$sanitizer = $this->wire()->sanitizer;
			foreach($form->getChildrenFlat() as $child) {
				/** @var FormBuilderField $child */
				$name = $child->name;
				$type = $child->type;
				$label = $child->label;
				if($options['skipRuntime']) {
					if($honeypot && $name === $honeypot) continue;
					if(strpos($type, 'FormBuilderRecaptcha') !== false) continue;
				}
				if($options['skipFieldsets']) { 
					if(!$type || in_array($type, $fieldsetTypes)) continue;
				}
				if($options['maxLabelLength'] && strlen($label) > $options['maxLabelLength']) {
					$label = $sanitizer->truncate($label, $options['maxLabelLength']);
				}
				if($type === 'FormBuilderForm' && $child->get('addForm')) {
					$addForm = $this->forms->load($child->get('addForm')); 
					if($addForm) {
						$o = array_merge($options, array('skipRuntime' => true, 'getSystem' => false, 'getVerbose' => true));
						foreach($this->getFieldLabels($addForm, $o) as $addName => $addInfo) {
							$addInfo['label'] = $label . ' > ' . $addInfo['label'];
							$a[$name . '_' . $addName] = $addInfo;
						}
					}
				} else {
					$a[$name] = array('label' => $label, 'type' => $type);
				}	
			}
			$this->cacheSet($cacheKey, $a);
		}
		
		if($options['getSystem']) {
			$created = $this->labels('created');
			$modified = $this->labels('modified');
			$dateTime = $this->_('(date/time)'); // Indicates an absolute date/time (not relative)
			$a['id'] = array('label' => 'ID', 'type' => 'Integer'); 
			$a['created'] = array('label' => $created, 'type' => 'Datetime');
			$a['modified'] = array('label' => $modified, 'type' => 'Datetime');
			$a['created_date'] = array('label' => "$created $dateTime", 'type' => 'Datetime');
			$a['modified_date'] = array('label' => "$modified $dateTime", 'type' => 'Datetime');
			$a['limit'] = array('label' => $this->labels('limit'), 'type' => 'Integer');
			$a['cols'] = array('label' => $this->labels('columns-to-show'), 'type' => 'Text');
			$a['sort'] = array('label' => $this->labels('sort'), 'type' => 'Text');
		}
		
		$allLabels = array();
		foreach($a as $name => $info) {
			$label = strtolower($info['label']);
			if(!isset($allLabels[$label])) $allLabels[$label] = array();
			$allLabels[$label][] = $name;
		}

		// ensure any duplicate labels also mention the field name
		foreach($allLabels as $label => $names) {
			if(count($names) < 2) continue;
			foreach($names as $name) {
				$a[$name]['label'] .= " [$name]";
			}
		}

		if($options['sortByLabel']) {
			ksort($allLabels);
			$aa = array();
			foreach($allLabels as $label => $names) {
				foreach($names as $name) {
					$aa[$name] = $a[$name];
				}
			}
			$a = $aa;
		}
		
		if($options['getVerbose']) return $a;
		
		$labels = array();
		foreach($a as $name => $info) {
			$labels[$name] = $info['label'];
		}
		
		return $labels;
	}

	
	/**
	 * Get all sorts where index is sort name and value is sort label
	 * 
	 * @param FormBuilderForm $form
	 * @param bool|int|string $labelType One of 'label', 'name' or 'name:label' 
	 * @return array
	 * 
	 */
	public function getSorts(FormBuilderForm $form, $labelType = 'label') {

		if($this->cacheHas('getSorts')) {
			$values = $this->cacheGet('getSorts');
			return $values[$labelType];
		}
		
		$labelNewest = $this->labels('new');
		$labelOldest = $this->labels('old');
		$labelHighest = $this->labels('high');
		$labelLowest = $this->labels('low'); 
		$reverseLabel = $this->labels('reverse');
		$createdLabel = $this->labels('created-date'); 
		$modifiedLabel = $this->labels('modified-date');
		
		$sorts = array(
			'-created' => "$createdLabel ($labelNewest)", 
			'created' => "$createdLabel ($labelOldest)", 
			'-modified' => "$modifiedLabel ($labelNewest)", 
			'modified' => "$modifiedLabel ($labelOldest)",
			'-id' => "ID ($labelHighest)", 
			'id' => "ID ($labelLowest)",
		);
		
		$values = array(
			'name:label' => $sorts, 
			'label' => $sorts,
			'name' => $sorts,
		);

		$fieldLabels = $this->getFieldLabels($form, array('sortByLabel' => false));
		
		foreach($fieldLabels as $name => $label) {
			
			$values['label']["$name"] = $label;
			$values['label']["-$name"] = "$label ($reverseLabel)";
			
			$values['name']["$name"] = $name;
			$values['name']["-$name"] = "$name ($reverseLabel)";

			$values['name:label']["$name"] = "$name: $label";
			$values['name:label']["-$name"] = "$name: $label ($reverseLabel)";
		}
		
		asort($values['label']);
		ksort($values['name']);
		ksort($values['name:label']);

		$this->cacheSet('getSorts', $values);
		
		return $values[$labelType]; 
	}

	/**
	 * Get current sort 
	 * 
	 * @param FormBuilderForm $form
	 * @return string
	 * 
	 */
	public function getSort(FormBuilderForm $form) {
		$sort = $this->wire()->input->get('sort');
		if(empty($sort)) {
			$filters = $this->getFilters($form);
			$sort = $filters['sort'];
		} else {
			$sorts = $this->getSorts($form, 'name');
			if(!isset($sorts[$sort])) $sort = '';
		}
		if(empty($sort)) $sort = self::defaultSort;
		return $sort;
	}

	/**
	 * Get entries list filters from input, session or defaults
	 * 
	 * @param FormBuilderForm $form
	 * @param bool $onlyModified
	 * @return array
	 * 
	 */
	public function getFilters(FormBuilderForm $form, $onlyModified = false) {

		$cacheValue = $this->cacheGet('getFilters'); 
		if($cacheValue) return $onlyModified ? $this->filters : $cacheValue;
		
		$input = $this->wire()->input;
		$submit = $input->get('submit_filter') || $input->get('submit_update') || $input->get('submit_csv');
		$clearAll = $input->get('clear');
		$remove = $input->get('remove'); 
		$sessionData = $this->sessionGet('getFilters');
		$sanitizer = $this->wire()->sanitizer;
		$data = array();
		$validCols = array_keys($this->getFieldLabels($form, array('getSystem' => true))); 
		$defaultCols = is_array($form->listFields) ? array_merge(array('created'), $form->listFields) : array('created'); 
		
		$this->hasFilters = false;
		$this->filters = array();
		$this->queryStrings = array('id' => "id=$form->id");

		$filters = array(
			// [ 'name' => [ 'type' => 'sanitizerMethod', 'default' => 'defaultValue', 'options' => [] ] ]
			// if 'default' is omitted then blank string '' is assumed
			'qf' => array('type' => 'fieldName', 'default' => ''),
			'qo' => array('type' => 'option', 'options' => array_keys($this->operators), 'default' => self::defaultOperator),
			'qv' => array('type' => 'text', 'default' => ''),
			'dateFrom' => array('type' => 'date', 'default' => 0, 'time' => '00:00:00'),
			'dateTo' => array('type' => 'date', 'default' => 0, 'time' => '23:59:59'),
			'sort' => array('type' => 'option', 'options' => array_keys($this->getSorts($form)), 'default' => self::defaultSort),
			'partial' => array('type' => 'int', 'default' => 0), 
			'limit' => array('type' => 'int', 'default' => 25), 
			'cols' => array('type' => 'array,options', 'options' => $validCols, 'default' => $defaultCols),
			'queries' => array(), 
		);
	
		if($clearAll) {
			$submit = false;
			$sessionData = array();
			$this->sessionRemove('getFilters');
		}
		
		if($remove && $sessionData) {
			// remove of custom filter requested
			$data = $sessionData;
			if(isset($data[$remove])) {
				if(isset($filters[$remove])) {
					$data[$remove] = isset($filters[$remove]['default']) ? $filters[$remove]['default'] : '';
				} else {
					unset($data[$remove]);
				}
			} else if($remove === 'any-field' || $remove === $data['qf']) {
				$data['qf'] = $filters['qf']['default'];
				$data['qo'] = $filters['qo']['default'];
				$data['qv'] = $filters['qv']['default'];
			} else if(isset($data['queries'][$remove])) {
				unset($data['queries'][$remove]);
			}
			$this->sessionSet('getFilters', $data);
			
		} else if($submit) {
			// changes submitted
			foreach($filters as $name => $info) {
				if($name === 'queries') continue;
				$types = strpos($info['type'], ',') ? explode(',', $info['type']) : array($info['type']);
				$default = isset($info['default']) ? $info['default'] : '';
				$options = isset($info['options']) ? $info['options'] : null;
				$value = $input->get($name); 
				foreach($types as $type) {
					$type = trim($type);
					if($value === null) {
						$value = $default;
						break;
					} else if(($type === 'option' || $type === 'options') && is_array($options)) {
						$value = $sanitizer->$type($value, $options);
						if(empty($value)) $value = $default;
					} else if($type === 'date') {
						$time = isset($info['time']) && strpos($value, ':') === false ? $info['time'] : '00:00:00';
						$value = ctype_digit("$value") || empty($value) ? (int) $value : $sanitizer->date(trim("$value $time"));
						if(empty($value)) {
							$value = $default;
						} else {
							$value = date('Y-m-d H:i:s', $value);
						}
					} else {
						$value = $sanitizer->$type($value);
						if($value === null) $value = $default;
					}
				}
				$data[$name] = $value;
			}
			
			if(!empty($sessionData['queries'])) $data['queries'] = $sessionData['queries'];
		
			if($data['qf'] || $data['qv']) {
				$hash = md5("$data[qf]$data[qo]$data[qv]");
				if(!isset($data['queries'][$hash])) $data['queries'][$hash] = array(
					'field' => $data['qf'],
					'operator' => $data['qo'],
					'value' => $data['qv'], 
				);
				$data['qf'] = $filters['qf']['default'];
				$data['qo'] = $filters['qo']['default'];
				$data['qv'] = $filters['qv']['default'];
			}
			
			$this->sessionSet('getFilters', $data);
			
		} else {
			// no submit
			if(!empty($sessionData)) {
				$data = $sessionData;
			} else {
				foreach($filters as $name => $info) {
					$data[$name] = isset($info['default']) ? $info['default'] : '';
				}
			}
			if($input->get('sort')) {
				// allow for sort to be set without submit
				$sort = $sanitizer->option($input->get('sort'), $filters['sort']['options']); 
				if(!empty($sort)) $data['sort'] = $sort;
				if(!empty($sessionData)) $this->sessionSet('getFilters', $data);
			}
		}

		if(empty($data['queries'])) $data['queries'] = array();

		if(count($data['queries'])) {
			$this->filters['queries'] = $data['queries'];
		}

		// identify customized filters 
		foreach($data as $name => $value) {
			if($name === 'queries') continue;
			$default = isset($filters[$name]['default']) ? $filters[$name]['default'] : '';
			if($value == $default) continue;
			$this->hasFilters = true;
			$this->filters[$name] = $value;
			if(is_array($value)) $value = implode(',', $value);
			$input->whitelist($name, $value);
			$this->queryStrings[$name] = "$name=" . urlencode($value);
		}
		
		if(!empty($data['queries'])) $this->hasFilters = true;
	
		$this->cacheSet('getFilters', $data); 
		
		return $onlyModified ? $this->filters : $data;
	}

	/**
	 * Get selectors array for querying entries
	 * 
	 * @param FormBuilderForm $form
	 * @param array $filters Data from getFilters method
	 * @return string
	 * @throws WireException
	 * 
	 */
	public function getFiltersSelector(FormBuilderForm $form, array $filters = array()) {
	
		$input = $this->wire()->input;
		$selectors = array();
		
		if(empty($filters)) $filters = $this->getFilters($form);
	
		// sort
		$selectors[] = ($filters['sort'] ? "sort=$filters[sort]" : "sort=" . self::defaultSort);

		/*
		// custom field
		if(strlen($filters['qo']) && (strlen($filters['qv']) || strlen($filters['qf']))) {
			$field = empty($filters['qf']) ? 'data' : $filters['qf'];
			$operator = $filters['qo'];
			if(!isset($this->operators[$operator])) throw new WireException('Invalid operator');
			$selectors[] = "$field$operator" . $this->wire()->sanitizer->selectorValue($filters['qv']);
		}
		*/
		foreach($filters['queries'] as $query) {
			$field = empty($query['field']) ? 'data' : $query['field'];
			$operator = $query['operator'];
			if(!isset($this->operators[$operator])) throw new WireException('Invalid operator');
			$selectors[] = "$field$operator" . $this->wire()->sanitizer->selectorValue($query['value']);
		}
		
		// limit
		if($filters['limit'] && !$input->get('submit_csv')) {
			$selectors[] = "start=" . $this->getStart($filters['limit']);
			$selectors[] = "limit=$filters[limit]";
		}

		if($filters['dateFrom'] || $filters['dateTo']) {
			$dateField = strpos($filters['sort'], 'modified') !== false ? 'modified' : 'created';
			if($filters['dateFrom']) $selectors[] = "$dateField>=$filters[dateFrom]";
			if($filters['dateTo']) $selectors[] = "$dateField<=$filters[dateTo]";
		}

		if($filters['partial'] == 2) {
			// partial only
			$selectors[] = "flags=" . FormBuilderEntries::flagPartial;
		} else if($filters['partial'] == 1) {
			// all
		} else {
			// completed only
			$selectors[] = "flags!=" . FormBuilderEntries::flagPartial;
		}

		return implode(', ', $selectors); 
	}

	/**
	 * Get URL for current filters
	 * 
	 * @param FormBuilderForm $form 
	 * @param array|null $queryStrings
	 * @return string
	 * 
	 */
	public function getFiltersUrl(FormBuilderForm $form, $queryStrings = null) {
		if($queryStrings === null) $queryStrings = $this->getQueryStrings($form);
		$input = $this->wire()->input;
		$url = './';
		if($input->pageNum > 1) $url .= "page$input->pageNum";
		if(count($queryStrings)) $url .= '?' . implode('&', $queryStrings);
		return $url;
	}

	/**
	 * Get query strings as array of [ 'name' => 'name=value' ] where value is URL encoded
	 * 
	 * @param FormBuilderForm $form
	 * @return array
	 * 
	 */
	public function getQueryStrings(FormBuilderForm $form) {
		if(!empty($this->queryStrings)) return $this->queryStrings;
		$this->getFilters($form);
		return $this->queryStrings;
	}

	/**
	 * Get pagination start
	 * 
	 * @param int $limit
	 * @return int
	 * 
	 */
	public function getStart($limit) {
		$start = 0;
		$input = $this->wire()->input;
		if($limit && !$input->get('submit_csv')) {
			$start = ($input->pageNum - 1) * $limit;
		}
		return $start;
	}

	/**
	 * Get array of filter summaries with removal links
	 * 
	 * @param FormBuilderForm $form
	 * @return array
	 * 
	 */
	public function getFilterSummaries(FormBuilderForm $form) {
		
		$summaries = array();
		$fieldLabels = $this->getFieldLabels($form, array('getSystem' => true));
		$sanitizer = $this->wire()->sanitizer;
		$filters = $this->getFilters($form, true);
		$sorts = $this->getSorts($form, 'label'); 
		$fieldLabels['any-field'] = $this->labels('any-field');
		$numQueries = 0;
		$notes = array();
		
		/*
		// $op = isset($filters['qo']) ? $filters['qo'] : self::defaultOperator;
		// $opLabel = $this->operators[$op];
		// $qv = isset($filters['qv']) ? $filters['qv'] : '';
		if(is_array($qv)) $qv = implode(', ', $qv);
		
		if(!empty($filters['qf']) || $qv !== '') {
			$isEmpty = $qv === '';
			if($isEmpty) $qv = $this->_('(empty)'); 
			$name = empty($filters['qf']) ? 'any-field' : $filters['qf'];
			$label = "$opLabel “" . $qv . "”";
			$filters[$name] = $label;
		}

		unset($filters['qf'], $filters['qo'], $filters['qv']); 
		*/
	
		if(!empty($filters['sort'])) {
			$name = $filters['sort'];
			if(isset($sorts[$name])) {
				$label = $sorts[$name];
			} else if(isset($fieldLabels[$name])) {
				$label = $fieldLabels[$name];
			} else {
				$label = $name;
			}
			$filters['sort'] = $label;
		}
		
		$queryStrings = $this->getQueryStrings($form);
		
		foreach($filters as $name => $value) {
			if($name === 'queries') continue;
			$qs = $queryStrings;
			unset($qs[$name], $qs['qf'], $qs['qo'], $qs['qv']);
			if(is_array($value)) $value = implode(', ', $value);
			$qs['remove'] = "remove=$name";
			$clearUrl = $this->getFiltersUrl($form, $qs);
			$label = isset($fieldLabels[$name]) ? $fieldLabels[$name] : $name;
			if($label === $name) $label = $this->labels($name);
			$label = $sanitizer->entities($label);
			$value = $sanitizer->entities($value);
			$note = isset($notes[$name]) ? $notes[$name] : '';
			$summaries[$name] = $this->getFilterSummaryItem($name, $label, $value, $note, $clearUrl); 
			// if($note) $note = "<span class='detail'>" . $sanitizer->entities($note) . "</span>";
			// $summaries[$name] = "<strong>$label:</strong> $value $note &nbsp; <a href='$clearUrl'>$removeIcon $removeLabel</a>";
		}
		
		if(!empty($filters['queries'])) {
			foreach($filters['queries'] as $hash => $query) {
				
				$field = $query['field'];
				$operator = $query['operator'];
				$value = $query['value'];
			
				if($field) {
					$formField = $form->getFieldByName($field);
					$type = $formField ? $formField->type : '';
				} else {
					$field = 'any-field';
					$formField = null;
					$type = '';
				}
				
				if(is_array($value)) {
					$value = implode(', ', $value);
				} else if(ctype_digit("$value") && $type === 'Page') {
					$pageValue = $this->wire()->pages->findOne("include=hidden, id=" . (int) $value); 
					if($pageValue->id) $value = $pageValue->getUnformatted('title|name'); 
				}
				
				$clearUrl = "./?id=$form->id&remove=$hash";
				$label = isset($fieldLabels[$field]) ? $fieldLabels[$field] : $field;
				if($label === $field) $label = $this->labels($field);
				
				$label = $sanitizer->entities1($label);
				$value = $sanitizer->entities($value);
				$value = $this->operators[$operator] . ' “' . $value . '”';
				$note = isset($notes[$field]) ? $notes[$field] : '';
				if($note) $note = "<span class='detail'>" . $sanitizer->entities($note) . "</span>";
				if($numQueries) $label = "<small>" . $this->_('AND') . " - </small> $label";
				$summaries[$hash] = $this->getFilterSummaryItem($field, $label, $value, $note, $clearUrl, false); 
				// $summaries[$hash] = "<strong>$label:</strong> $value $note &nbsp; <a href='$clearUrl'>$removeIcon $removeLabel</a>";
				// $numQueries++;
			}
		}
		
		if($numQueries) {
			$summaries['note'] = 
				"<span class='description'>" . 
				$this->_('You may add additional search filters — each will be considered an “AND” condition.') . 
				"</span>";
		}
		
		return $summaries;
	}

	/**
	 * Get an item for the getFilterSummaries() method
	 * 
	 * @param string $name
	 * @param string $label
	 * @param string|int $value
	 * @param string $note
	 * @param string $clearUrl
	 * @param bool $entityEncode
	 * @return string
	 * 
	 */
	protected function getFilterSummaryItem($name, $label, $value, $note, $clearUrl, $entityEncode = true) {
		$removeLabel = $this->labels('remove');
		$removeIcon = wireIconMarkup('times');
		if($entityEncode) {
			$sanitizer = $this->wire()->sanitizer;
			$note = $sanitizer->entities($note);
			$label = $sanitizer->entities($label);
			$value = $sanitizer->entities($value);
		}
		if($note) $note = "<span class='detail'>$note</span>";
		if($name === 'partial') {
			$label = $this->labels('entries');
			if($value == 2) {
				$value = $this->labels('partial') . ' ' . $this->_('(only)');
			} else if($value == 1) {
				$value = $this->labels('all') . ' ' . $this->_('(partial and completed)'); 
			}
		}
		return "<strong>$label:</strong> $value $note &nbsp; <a href='$clearUrl'>$removeIcon $removeLabel</a>";
	}
	
	/**
	 * Execute the 'list entries' action
	 *
	 * @return string
	 * @throws WireException|WirePermissionException
	 *
	 */
	public function executeListEntries() {

		$input = $this->wire()->input;
		$sanitizer = $this->wire()->sanitizer;

		$id = (int) $input->get('id');
		if(!$id) $this->wire()->session->redirect('../');

		$input->whitelist('id', $id);
		$form = $this->process->getForm($id, 'entries-list'); 
		
		// query string variables
		$filters = $this->getFilters($form);
		$start = $this->getStart($filters['limit']);
		$selector = $this->getFiltersSelector($form, $filters);
		$url = $this->getFiltersUrl($form);

		// upon request, export CSV then exit
		if($input->get('submit_csv')) {
			$csvAll = $input->get('csv_all');
			$csvOptions = $input->get('csv_options');
			$csvSelector = $csvAll ? 'id>0' : $selector;
			$csvCols = $csvAll ? array() : $input->get('cols'); 
			foreach($csvCols as $key => $col) $csvCols[$key] = $sanitizer->fieldName($col);
			$form->entries()->exportCSV($form, $csvSelector, array(
				'headerType' => (in_array('labels', $csvOptions) ? 'label' : 'name'), 
				'columns' => $csvCols,
				'useBOM' => in_array('useBOM', $csvOptions),
			));
		}
		
		// upon request, process checked entries and redirect back to self
		if($this->processCheckedListEntries($form)) $this->session->redirect($url);

		// find and display entries
		$entries = $form->entries()->find($selector);
		$total = $form->entries()->getLastTotal();
		$filterForm = $this->buildListFilterForm($form, $total, $filters);
		$entriesForm = $this->buildListEntriesForm($form, $entries, $filters, $url);
		$headlines = array($this->labels('entries'));
		
		if($this->forms->hasPermission('form-edit', $form)) {
			$this->process->breadcrumb("../editForm/?id=$form->id", $form->name);
		}

		// pagination
		$pa = new PaginatedArray();
		$this->wire($pa);
		$pa->setTotal($total)->setLimit($filters['limit'])->setStart($start);
		/** @var MarkupPagerNav $pager */
		$pager = $this->modules->get('MarkupPagerNav');
		$pager->baseUrl = './';
		$pagerOut = $total > count($entries) ? $pager->render($pa) : '';
		$headlines[] = $pa->getPaginationString(array('count' => count($entries)));
		
		if($this->hasFilters) {
			$summaries = $this->getFilterSummaries($form);
			$clearLinks = '<ul><li>' . implode('</li><li>', $summaries) . '</li></ul>';
			$this->process->breadcrumb("./?id=$form->id&clear=1", $this->labels('entries'));
			$headlines[] = $this->_('(filtered)'); 
		} else {
			$clearLinks = '';
		}

		$this->process->headline(implode(' ', $headlines));
		$entriesForm->appendMarkup .= $pagerOut;
		
		$out = $filterForm->render() . $clearLinks . $entriesForm->render();

		// clearfix necessary for when no pagination exists, button doesn't look bad
		return "<div class='ui-helper-clearfix'>$out</div>";
	}

	/**
	 * Process checked list entries
	 *
	 * @param FormBuilderForm $form
	 * @return bool True if entries were processed and should redirect to currentUrl, false if not
	 * @throws WireException
	 *
	 */
	protected function processCheckedListEntries(FormBuilderForm $form) {

		$input = $this->wire()->input;
		$checkedEntries = $input->post('checked_entries');
		$numChecked = is_array($checkedEntries) ? count($checkedEntries) : 0;

		if(!$numChecked) return false;

		$entries = $form->entries();

		if($this->input->post('submit_delete_entries') && $form->hasPermission('entries-delete')) {
			foreach($checkedEntries as $entry_id) {
				$entries->delete((int) $entry_id);
			}
			$this->message(sprintf($this->_n('Deleted %d entry', 'Deleted %d entries', $numChecked), $numChecked));
			return true; // redirect to currentUrl

		} else if($input->post('submit_resend_entries') && $form->hasPermission('entries-resend')) {
			$numSent = 0;
			foreach($checkedEntries as $entry_id) {
				$processor = $form->processor(array('reset' => true));
				$entry = $form->entries()->get((int) $entry_id);
				if(empty($entry)) continue;
				$processor->saveFlags = FormBuilderProcessor::saveFlagEmail; // only email
				$processor->populate($entry, $entry_id);
				if($processor->emailForm($processor->getInputfieldsForm(), $entry)) {
					$numSent++;
				}
			}
			$this->message(sprintf($this->_n('Resent %d entry', 'Resent %d entries', $numSent), $numSent));
			return true;

		} else if($input->post('submit_page_entries') && $form->hasPermission('entries-page')) {
			/** @var FormBuilderProcessor $processor */
			$processor = $form->processor();
			foreach($checkedEntries as $entry_id) {
				$data = $entries->get((int) $entry_id);
				$existingPageID = isset($data['_savePage']) ? (int) $data['_savePage'] : 0;
				if($data) {
					$page = $processor->savePage($data, Page::statusOn);
					if($page) {
						if($existingPageID && $page->id == $existingPageID) {
							$this->message($this->labels('updated-existing-page') . ' - ' . $page->path());
						} else {
							$this->message($this->labels('sent-entry-to-page') . ' - ' . $page->path());
						}
						$data['_savePage'] = $page->id;
						$data['_savePageTime'] = time();
						$processor->saveEntry($data); // $entries->save($data);
					}
				}
			}
			return true;
		}

		return false;
	}

	/**
	 * Build the 'list entries' form
	 *
	 * This includes a form with the current pagination of entries, and a 'delete checked' button at the bottom
	 *
	 * @param FormBuilderForm $form
	 * @param array $entries
	 * @param string $currentUrl
	 * @param array $filters
	 * @return InputfieldForm
	 *
	 */
	protected function ___buildListEntriesForm(FormBuilderForm $form, array $entries, array $filters, $currentUrl) {

		/** @var InputfieldForm $entriesForm */
		$entriesForm = $this->wire('modules')->get('InputfieldForm');
		$entriesForm->attr('action', $currentUrl);
		$entriesForm->attr('method', 'post');
		$entriesForm->attr('id', 'entries_list_form');

		$f = $this->wire('modules')->get('InputfieldMarkup');
		$f->attr('id', 'entries_list_markup'); 
		$f->attr('value', $this->buildListEntries($form, $entries, $filters)->render());
		if($form->entryDays > 0) {
			$f->notes = trim(
				$f->notes . "\n" .
				sprintf('• ' .
					$this->_('Entries are automatically deleted after %s day(s), per form action settings.'),
					$form->entryDays
				)
			);
		}
		$entriesForm->add($f);

		// delete entries button
		if($form->hasPermission('entries-delete')) {
			/** @var InputfieldSubmit $f */
			$f = $this->wire('modules')->get('InputfieldSubmit');
			$f->attr('id+name', 'submit_delete_entries');
			$f->attr('value', $this->labels('delete-checked'));
			$f->icon = 'trash-o';
			$f->showInHeader(true);
			$entriesForm->add($f);
		}

		if($form->saveFlags & FormBuilderProcessor::saveFlagEmail && $form->hasPermission('entries-resend')) {
			$f = $this->wire('modules')->get('InputfieldSubmit');
			$f->attr('id+name', 'submit_resend_entries');
			$f->attr('value', $this->labels('resend-checked'));
			$f->icon = 'envelope-o';
			$f->setSecondary(true);
			$entriesForm->add($f);
		}

		if($form->saveFlags & FormBuilderProcessor::saveFlagPage && $form->hasPermission('entries-page')) {
			$f->attr('class', $f->attr('class') . ' ui-priority-secondary');
			// publish entries button
			$f = $this->wire('modules')->get('InputfieldSubmit');
			$f->attr('id+name', 'submit_page_entries');
			$f->icon = 'sitemap';
			$f->attr('value', $this->labels('send-checked-to-pages'));
			$f->setSecondary(true);
			$entriesForm->add($f);
		}

		return $entriesForm;
	}

	/**
	 * Build the 'list entries: filter' form
	 *
	 * This includes options for starting/ending dates and sorting.
	 *
	 * @param FormBuilderForm $form
	 * @param int $total
	 * @param array $filters
	 * @return InputfieldForm
	 *
	 */
	protected function ___buildListFilterForm(FormBuilderForm $form, $total, array $filters) {
		if($total) {} // ignore

		$modules = $this->wire()->modules;
		$dateFormat = $this->_('Y/m/d'); // Entries listing date input format
		$datePlaceholder = $this->_('yyyy/mm/dd'); // Placeholder for date format (for readability only)
		$splitMarkup = "<div style='background:#777;height:3px;width:100%;'></div>";

		if(empty($filters['cols'])) $filters['cols'] = $form->listFields;
		if($filters['cols'] == $form->listFields) array_unshift($filters['cols'], 'created');
		
		/** @var InputfieldForm $filterForm */
		$filterForm = $modules->get('InputfieldForm');
		$filterForm->attr('id', 'filter_form');
		$filterForm->attr('action', './');
		$filterForm->attr('method', 'get');
		
		/** @var InputfieldFieldset $fieldset */
		$fieldset = $modules->get('InputfieldFieldset');
		$fieldset->attr('id', 'filter_fieldset');
		$fieldset->label = $this->_x('Select columns, search filters and more', 'fieldset-label');
		$fieldset->icon = 'search';
		$fieldset->collapsed = Inputfield::collapsedYes;

		/** @var InputfieldHidden $f */
		$f = $modules->get('InputfieldHidden');
		$f->attr('name', 'id');
		$f->attr('value', $form->id);
		$fieldset->add($f);
		
		$columnsInputs = new InputfieldWrapper();
		$columnsInputs->appendMarkup = $splitMarkup;
		$fieldset->add($columnsInputs);
		
		/** @var InputfieldAsmSelect $f */
		$f = $modules->get('InputfieldAsmSelect');
		$f->attr('id+name', 'cols');
		$f->label = $this->labels('columns-to-show');
		// $f->entityEncodeLabel = Inputfield::textFormatBasic;
		// if(count($filters['cols'])) $f->label .= ' [span.pwfb-entries-detail] (' . implode(', ', $filters['cols']) . ') [/span]';
		$fieldLabels = $this->getFieldLabels($form, array('getSystem' => true, 'getVerbose' => true));
		unset($fieldLabels['limit'], $fieldLabels['cols'], $fieldLabels['sort']); 
		foreach($fieldLabels as $name => $info) {
			$label = $info['label'];
			if($name === 'created' || $name === 'modified') $label .= ' ' . $this->_('(relative)');
			$f->addOption($name, $label, array('data-desc' => $name, 'data-status' => $info['type']));
		}
		$f->val($filters['cols']);
		$columnsInputs->add($f);
		
		/** @var InputfieldButton $btn */
		$btn = $modules->get('InputfieldSubmit');
		$btn->attr('id+name', 'submit_update');
		$btn->val($this->_('Update entries list'));
		$btn->setSmall(true);
		$btn->setSecondary(true);
		$btn->icon = 'refresh';
		$f->appendMarkup .= "<div id='wrap_submit_update'>" . $btn->render() . "</div>";

		// Custom search
		$searchInputs = $this->buildListFilterFormCustomSearch($form, $filters); 
		$searchInputs->appendMarkup = $splitMarkup;
		$fieldset->add($searchInputs);

		/** @var InputfieldDatetime $f */
		$f = $modules->get('InputfieldDatetime');
		$f->attr('id+name', 'dateFrom');
		$f->attr('value', $filters['dateFrom'] ? $filters['dateFrom'] : '');
		$f->datepicker = InputfieldDatetime::datepickerFocus;
		$f->columnWidth = 20;
		$f->dateInputFormat = $dateFormat;
		$f->placeholder = $datePlaceholder;
		$f->label = $this->labels('date-from');
		$f->notes = "*" . $this->labels('modified') . " $f->label";
		$fieldset->add($f);

		$f = $modules->get('InputfieldDatetime');
		$f->attr('id+name', 'dateTo');
		$f->attr('value', $filters['dateTo'] ? $filters['dateTo'] : '');
		$f->datepicker = InputfieldDatetime::datepickerFocus;
		$f->columnWidth = 20;
		$f->dateInputFormat = $dateFormat;
		$f->placeholder = $datePlaceholder;
		$f->label = $this->labels('date-to');
		$f->notes = "*" . $this->labels('modified') . " $f->label";
		$fieldset->add($f);

		/** @var InputfieldSelect $f */
		$f = $modules->get('InputfieldSelect');
		$f->attr('name', 'sort');
		$sorts = $this->getSorts($form);
		asort($sorts);
		$f->addOptions($sorts);
		$f->attr('value', isset($sorts[$filters['sort']]) ? $filters['sort'] : self::defaultSort); 
		$f->label = $this->labels('sort');
		$f->columnWidth = 20;
		$fieldset->add($f);

		$f = $modules->get('InputfieldSelect');
		$f->attr('name', 'partial');
		$f->label = $this->labels('entries');
		$f->addOption(0, $this->labels('completed'));
		$f->addOption(2, $this->labels('partial'));
		$f->addOption(1, $this->labels('all'));
		$f->attr('value', isset($filters['partial']) ? (int) $filters['partial'] : 0); //(int) $this->sessionGet('partial'));
		$f->optionColumns = 1;
		$f->columnWidth = 20;
		$fieldset->add($f);

		$f = $modules->get('InputfieldSelect');
		$f->attr('name', 'limit');
		$f->label = $this->labels('limit-per-page');
		$f->addOption(25);
		$f->addOption(50);
		$f->addOption(100);
		$f->addOption(250);
		$f->addOption(500);
		$f->addOption(0, $this->_('No limit'));
		$f->attr('value', $filters['limit'] ? (int) $filters['limit'] : 25);
		$f->columnWidth = 20;
		$fieldset->add($f);
		
		$exportFields = new InputfieldWrapper();
		$exportFields->prependMarkup = $splitMarkup;
		$fieldset->add($exportFields);
		
		/** @var InputfieldFieldset $fieldset2 */
		$fieldset2 = $modules->get('InputfieldFieldset');
		$fieldset2->label = $this->_('Export Entries');
		$fieldset2->collapsed = Inputfield::collapsedYes;
		$fieldset2->themeColor = 'secondary';
		$exportFields->add($fieldset2);
	
		/** @var InputfieldRadios $f */
		$f = $modules->get('InputfieldRadios');
		$f->attr('name', 'csv_all');
		$f->skipLabel = Inputfield::skipLabelHeader;
		$f->addOption(1, $this->_('Export all rows and columns'));
		$f->addOption(0, $this->_('Export only rows and columns matching my selections above')); 
		$f->attr('value', 1); 
		$f->columnWidth = 50;
		$fieldset2->add($f);
		
		/** @var InputfieldRadios $f */
		$f = $modules->get('InputfieldCheckboxes');
		$f->attr('name', 'csv_options');
		$f->skipLabel = Inputfield::skipLabelHeader;
		$f->addOption('labels', $this->_('Use field labels rather than names in header'));
		$f->addOption('useBOM', $this->_('Use UTF-8 signature (byte order mark) in CSV file'));
		$f->attr('value', 'label');
		$f->columnWidth = 50;
		$value = array();
		if($this->forms->csvUseBOM) $value[] = 'useBOM';
		$f->val($value);
		$fieldset2->add($f);

		/** @var InputfieldButton $f */
		$f = $modules->get('InputfieldSubmit');
		$f->attr('id', 'submit_export_csv');
		$f->attr('name', 'submit_csv');
		$f->attr('value', $this->_('Export to CSV'));
		$f->icon = 'file-excel-o';
		$f->setSmall(true);
		$f->setSecondary(true);
		$fieldset2->add($f);

		/** @var InputfieldSubmit $f */
		$f = $modules->get('InputfieldSubmit');
		$f->attr('id', 'submit_filter_results');
		$f->attr('name', 'submit_filter'); 
		$f->icon = 'search';
		$f->value = $this->_('Search'); 
		$f->showInHeader(true);
		$fieldset->add($f);
		
		$filterForm->add($fieldset);
		return $filterForm;
	}

	/**
	 * Build the custom field search part of the filters form
	 * 
	 * @param FormBuilderForm $form
	 * @param array $filters
	 * @return InputfieldWrapper
	 * 
	 */
	protected function buildListFilterFormCustomSearch(FormBuilderForm $form, array $filters) {

		$searchInputs = new InputfieldWrapper();
		$modules = $this->wire()->modules;
		
		/** @var InputfieldSelect $f */
		$f = $modules->get('InputfieldSelect');
		$f->attr('id+name', 'qf');
		$f->label = '1. ' . $this->_('Search in (field)');
		$f->columnWidth = 40;
		$f->addOption('', $this->labels('any-field')); 
		$fieldLabels = $this->getFieldLabels($form, array('getSystem' => false)); 
		foreach($fieldLabels as $name => $label) {
			$f->addOption($name, $label);
		}
		$f->val(isset($filters['qf']) ? $filters['qf'] : '');
		$searchInputs->add($f);

		/** @var InputfieldSelect $f */
		$f = $modules->get('InputfieldSelect');
		$f->attr('id+name', 'qo');
		$f->label = '2. ' . $this->_('Search type');
		$f->columnWidth = 20;
		foreach($this->operators as $operator => $label) {
			$f->addOption($operator, $label);
		}
		if(empty($filters['qo'])) {
			$f->val(self::defaultOperator);
		} else {
			$f->val($filters['qo']); 
		}
		$searchInputs->add($f);

		/** @var InputfieldText $f */
		$f = $modules->get('InputfieldText');
		$f->attr('id+name', 'qv');
		$f->label = '3. ' . $this->_('Search for (value)');
		$f->columnWidth = 40;
		$f->val(!empty($filters['qv']) ? $filters['qv'] : '');
		$f->addClass('pwfb-entries-qv-main-content', 'contentClass');
		$searchInputs->add($f);

		$inputTypes = array(
			'Page', 'Select', 'SelectMultiple',
			'Checkboxes', 'Checkbox', 'Radios',
			'Toggle', 'Datetime', 'Integer',
		);

		foreach($form->getChildrenFlat() as $field) {
			/** @var FormBuilderField $field */
			if(!in_array($field->type, $inputTypes)) continue;
			$options = array();
			/** @var Inputfield $inputfield */
			$inputfield = $this->wire()->modules->get("Inputfield$field->type");
			if(!$inputfield) continue;

			// populate any other settings to the Inputfield
			foreach($field->getArray() as $key => $value) {
				if($key === 'type' || $key === 'children') continue;
				$inputfield->set($key, $value);
			}

			if($field->type == 'Checkbox') {
				$options = array(
					1 => $this->_('Checked'),
					0 => $this->_('Not Checked')
				);
			} else if($field->type == 'Page') {
				/** @var InputfieldPage $inputfield */
				foreach($inputfield->getSelectablePages(new NullPage()) as $page) {
					$options[$page->id] = $page->getUnformatted('title|name');
				}
				
			} else if($field->type == 'Toggle') {
				/** @var InputfieldToggle $inputfield */
				$options = $inputfield->getOptions();
			} else if($inputfield instanceof InputfieldSelect) {
				/** @var InputfieldSelect $inputfield */
				$options = $inputfield->getOptions();
			}

			if(count($options)) {
				/** @var InputfieldSelect $f */
				$f = $this->wire()->modules->get('InputfieldSelect');
				$f->addOptions($options);
				$f->label = $inputfield->label;
				$searchInputs->add($f);
			} else {
				$f = $inputfield;
				$searchInputs->add($f);
			}

			/** @var Inputfield $f */
			$f->attr('id+name', 'qv_' . $field->name);
			$f->addClass('pwfb-entries-qv-field', 'wrapClass');
			$f->addClass('pwfb-entries-qv-field-content', 'contentClass');
			$f->addClass('pwfb-entries-qv-field-input');
			$f->columnWidth = 100;
		}

		return $searchInputs; 
	}

	/**
	 * Build the 'list entries' output, containing the actual list of form submissions
	 *
	 * Checkboxes are added to each entry for the 'delete' action.
	 *
	 * @param FormBuilderForm $form Form being edited
	 * @param array $entries Entries to display
	 * @param array $filters
	 * @return MarkupAdminDataTable
	 *
	 */
	protected function ___buildListEntries(FormBuilderForm $form, array $entries, array $filters) {
		
		$sanitizer = $this->wire()->sanitizer;

		/** @var MarkupAdminDataTable $table */
		$table = $this->modules->get('MarkupAdminDataTable');
		$table->setEncodeEntities(false);
		$table->setSortable(false);
		$table->setID('entries_list_table');

		$fieldLabels = $this->getFieldLabels($form, array('getSystem' => true));
		
		$listFields = empty($filters['cols']) ? $form->listFields : $filters['cols'];
		if(!in_array('id', $listFields)) array_unshift($listFields, 'id');
		
		$showPages = $form->saveFlags & FormBuilderProcessor::saveFlagPage;
		$inputfields = array();
		$jQueryUI = $this->wire('modules')->get('JqueryUI');
		$jQueryUI->use('modal');
		$jQueryUI->use('vex');

		$adminTheme = $this->wire('adminTheme');
		if(!$adminTheme instanceof AdminThemeFramework) $adminTheme = null;
		$checkboxClass = $adminTheme && method_exists($adminTheme, 'getClass') ? $adminTheme->getClass('input-checkbox') : '';
		$modalClass = 'pw-modal';

		$viewLabel = $this->_x('View', 'entry-action');
		$editLabel = $this->_x('Edit', 'entry-action');
		$diffLabel = $this->_x('Diff', 'entry-action');

		foreach($entries as $row) {
			$a = array();
			$isPartial = $row['entryFlags'] & FormBuilderEntries::flagPartial;

			foreach($listFields as $key) {

				if($key === 'id') {
					$viewURL = "../viewEntry/?id=$form->id.$row[id]";
					$editURL = "../editEntry/?id=$form->id.$row[id]";
					if($editURL) {}
					$paddedID = strlen($row['id']) < 3 ? str_pad($row['id'], 3, '0', STR_PAD_LEFT) : $row['id'];
					$class = "$modalClass pw-tooltip" . ($isPartial ? ' ui-priority-secondary' : '');
					$editText = $isPartial ? wireIconMarkup('commenting-o', 'flip-horizontal fw')  : wireIconMarkup('edit', 'fw');
					$tip = $isPartial ? ' ' . $this->_('(partial entry)') : '';
					list($editTip, $viewTip) = array($editLabel . $tip, $viewLabel . $tip);
					$viewText = $paddedID;
					$links =
						"<a title='$editTip' class='$class pwfb-edit' data-buttons='#content .ui-button' href='$editURL'>$editText</a> " .
						"<a title='$viewTip' class='$class pwfb-view' data-buttons='#content .ui-button' href='$viewURL'>$viewText</a>";
					$a[] = $links;
					continue;
				} else if($key === 'created' || $key === 'modified' || $key === 'created_date' || $key === 'modified_date') {
					$isRelative = strpos($key, '_date') === false;
					$date = $row[str_replace('_date', '', $key)]; 
					$date = $isRelative ? wireRelativeTimeStr($date, true) : $date; 
					$class = ($isRelative ? 'pwfb-relative-date' : 'pwfb-date') . ($isPartial ? ' ui-priority-secondary' : '');
					$a[] = "<span class='$class'>$date</span>";
					continue;
				}

				$value = isset($row[$key]) ? $row[$key] : '';
				
				$field = $form->getFieldByName($key);
				if($field) {
					$listFieldsLabels[$key] = isset($fieldLabels[$key]) ? $fieldLabels[$key] : $field->label;
					if($value === '') {
						$a[] = '';
						continue;
					}

					if(isset($inputfields[$field->type])) {
						$inputfield = $inputfields[$field->type];
					} else {
						$inputfield = $this->modules->get('Inputfield' . $field->type);
						$inputfields[$field->type] = $inputfield;
					}
					if($inputfield) {
						/** @var InputfieldSelect $inputfield */
						$inputfield->attr('name', $field->name);
						if($inputfield instanceof InputfieldSelect) {
							$av = is_array($value) ? $value : array($value);
							foreach($av as $k => $v) {
								$inputfield->addOption($v);
							}
						} else if($inputfield instanceof InputfieldFormBuilderInterface) {
							$inputfield->set('formID', $form->id);
							$inputfield->set('entryID', $row['id']);
						}
						$inputfield->attr('value', $value);
						try {
							$value = $inputfield->renderValue();
						} catch(\Exception $e) {
						}
					}

					if(!is_array($value)) {
						$a[] = (string) $value;
						continue;
					}
				} else if($value === '') {
					$a[] = '';
					continue;
				}

				if(is_array($value)) {
					$value = trim(implode(', ', $value), ', ');

				}
				$a[] = $sanitizer->entities($value);
			}

			if($showPages) {
				$aStr = '';
				$aNote = '';
				if(empty($row['_savePage'])) {
					$aNote = $this->_('Not yet created');
				} else {
					$page_id = (int) $row['_savePage'];
					$page = $this->wire('pages')->get($page_id);
					if($page->id) {
						$actions = array();
						if($page->viewable()) {
							$actions[] = "<a class='$modalClass' href='$page->url'>$viewLabel</a>";
						}
						if($page->editable()) {
							$actions[] = "<a class='$modalClass' href='$page->editUrl'>$editLabel</a>";
						}
						$actions[] =
							"<a class='$modalClass FormBuilderDialog' " .
							"title='$page->path - $row[created]' " .
							"data-buttons='.pw-modal-button' " .
							"href='../viewEntry/?id=$form->id.$row[id]&compare=1&modal=1'" .
							">$diffLabel</a>";

						if(!empty($row['_savePageTime'])) {
							$aNote = wireRelativeTimeStr((int) $row['_savePageTime'], true);
						} else if(isset($row['_savePageTime'])) {
							$aNote = $this->_('Not yet published');
						}

						$aStr = "<span class='PageList'><span class='PageListActions actions'>" . implode('&nbsp;', $actions) . '</span></span>';
					}
				}
				if($aNote) $aStr .= ($aStr ? "<br />" : "") . "<small class='detail'>$aNote</span>";
				$a[] = $aStr;
			}

			$checkbox = "<input type='checkbox' class='$checkboxClass delete' name='checked_entries[]' value='$row[id]' />";
			$a[] = $checkbox;
			$table->row($a);
		}

		if(count($entries)) {
			$headerRow = $listFields;
			$currentSort = $this->getSort($form);
			foreach($headerRow as $key => $name) {
				$sortClass = "pwfb-th-sort";
				$activeClass = " pwfb-th-sort-active";	
				if(isset($fieldLabels[$name])) {
					if($name === $currentSort) {
						$sortClass .= $activeClass;
						$sort = "-$name";
						$icon = wireIconMarkup('caret-right');
					} else if("-$name" === $currentSort) {
						$sortClass .= $activeClass;
						$sort = $name;
						$icon = wireIconMarkup('caret-left'); 
					} else {
						$sortClass = 'pwfb-th-sort';
						$sort = $name;
						$icon = '';
					}
					$sortUrl = "./?id=$form->id&sort=$sort";
					$label = trim("$fieldLabels[$name] $icon");
					$headerRow[$key] = "<span class='$sortClass' data-url='$sortUrl'>$label</span>";
				} else {
					// @todo also find a way to get actual label in this situation
				}
			}
			if($showPages) $headerRow[] = $this->_x('Page', 'list entries table header');
			$headerRow[] = "<input class='$checkboxClass' type='checkbox' id='check_all' />";
			$table->headerRow($headerRow);
		} else {
			$table->row(array($this->_('No entries to display')));
		}

		return $table;
	}

	/**
	 * Return output for the compare entry option
	 *
	 * @param FormBuilderForm $form
	 * @param array $entry
	 * @param int $pageID
	 * @return string
	 * @throws WireException
	 *
	 */
	public function ___compareEntry(FormBuilderForm $form, array $entry, $pageID) {

		$sanitizer = $this->wire()->sanitizer;
		$page = $this->wire()->pages->get($pageID);
		if(!$page->id) throw new WireException("Unknown page");

		$input = $this->wire('input');

		if($input->post('submit_page_entry') && $form->hasPermission('entries-page') && is_array($input->post('fields'))) {
			$fieldNames = array();
			foreach($input->post('fields') as $name) {
				$fieldNames[] = $sanitizer->fieldName($name);
			}
			$processor = $form->processor();
			if(empty($entry['_savePage'])) $entry['_savePage'] = $page->id;
			$entry['_savePageTime'] = time();
			$processor->saveEntry($entry);
			$page = $processor->savePage($entry, null, $fieldNames);
			$this->message(sprintf($this->_('Updated page %d'), $page->id) . ' (' . implode(', ', $fieldNames) . ')');
		}

		$url = $this->config->urls->get('ProcessFormBuilder');
		$this->config->scripts->add($url . "diff/diff_match_patch.js");
		$this->config->scripts->add($url . "diff/jquery.pretty-text-diff.min.js");

		/** @var MarkupAdminDataTable $table */
		$table = $this->wire('modules')->get('MarkupAdminDataTable');
		$table->setEncodeEntities(false);
		$table->setSortable(false);
		$table->headerRow(array(
			$this->_('Name'),
			$this->_('Type'),
			$this->_('Old'),
			$this->_('New'),
			$this->_('Diff'),
			"&nbsp;"
		));
		$n = 0;

		foreach($form->savePageFields as $name => $entryName) {

			if(ctype_digit("$name")) {
				$field = $this->wire('fields')->get((int) $name);
				$fieldName = $field->name;
				$fieldType = str_replace('Fieldtype', '', $field->type->className());
			} else {
				$field = null;
				$fieldName = $name;
				$fieldType = 'System';
			}

			if(!isset($entry[$entryName])) continue;

			$pageValue = $page->getUnformatted($name);
			$entryValue = $entry[$entryName];

			if($name === 'name' && $entryName === 'title') {
				$entryValue = $this->wire('sanitizer')->pageName($entryValue, true);
			}

			$result = $this->compareEntryIsDifferent($entryValue, $pageValue, $fieldType, array(
				'field' => $field,
				'fieldName' => $fieldName,
				'entryName' => $entryName,
				'form' => $form,
				'page' => $page,
			));

			if($result === false) continue; // no changes

			list($entryValue, $pageValue) = $result;

			$entryValue = nl2br($sanitizer->entities($entryValue));
			$pageValue = nl2br($sanitizer->entities($pageValue));

			$n++;
			$table->row(array(
				"<strong>$fieldName</strong>",
				$fieldType,
				"<div class='original'>$pageValue</div>",
				"<div class='changed'>$entryValue</div>",
				"<div class='diff'></div>",
				"<label><input type='checkbox' name='fields[]' checked value='$entryName' /></label>"
			));
		}

		$out = "<h2>$entry[created]</h2>";

		if($n) {
			$script = 'script';
			$func = 'prettyTextDiff';
			$out .= $table->render() . "<$script>";
			$out .= "jQuery('.AdminDataTable tbody tr').$func({});</$script>";
		} else {
			$out = "<h2>" . $this->_('Page and entry are up-to-date (no differences).') . "</h2>";
		}

		if($this->input->get('modal')) {
			$out .= "<p><a href='#' class='pwfb-close-in-modal'>" . $this->_('Return to entries list') . "</a></p>";
		}

		if($n && $form->saveFlags & FormBuilderProcessor::saveFlagPage && $form->hasPermission('entries-page')) {
			$f = $this->wire('modules')->get('InputfieldSubmit');
			$f->attr('id+name', 'submit_page_entry');
			$f->addClass('pw-modal-button');
			$f->icon = 'send';
			$f->attr('value', $this->_('Update page with checked changes'));
			$action = "./?id=$form->id.$entry[id]&compare=1&modal=1";
			$out = "<form action='$action' method='post' class='InputfieldForm'>" . $out . $f->render() . "</form>";
		}

		return $out;
	}

	/**
	 * Given entryValue and pageValue, compare and return false if the same, or return array of both values as text if
	 * different
	 *
	 * @param string $entryValue
	 * @param string $pageValue
	 * @param Fieldtype|string $fieldType
	 * @param array $details Contains extra details if needed:
	 * 	- $field (Field)
	 * 	- $entryName (str)
	 * 	- $fieldName (str)
	 * 	- $form (InputfieldForm)
	 * 	- $page (Page)
	 * @return array|bool If values are different return array($entryValue, $pageValue) where both are text for a diff
	 *
	 */
	protected function ___compareEntryIsDifferent($entryValue, $pageValue, $fieldType, array $details) {

		// if values already match, then they are the same
		if(!is_array($entryValue) && "$pageValue" == "$entryValue") return false;

		if($pageValue instanceof Page) {
			$pageValue = $pageValue->title;

		} else if($pageValue instanceof PageArray) {
			$pageValue = $pageValue->explode('title');
		}

		if($pageValue == $entryValue) return false;

		if($fieldType == 'Page') {

			$pages = $this->wire('pages')->find("include=hidden, id=$entryValue");
			$entryValue = $pages->explode('title');

			if(!is_array($pageValue)) $pageValue = array($pageValue);

			foreach($pageValue as $key => $value) {
				$pageValue[$key] = $this->wire('sanitizer')->entities($value);
			}

			foreach($entryValue as $key => $value) {
				$value = $this->wire('sanitizer')->entities($value);
				if(!in_array($value, $pageValue)) $entryValue[$key] = "<strong>$value</strong>";
				$entryValue[$key] = $value;
			}

		} else if($fieldType == 'File' || $fieldType == 'Image') {

			$pv = '';
			$ev = '';

			if(!is_array($pageValue)) $pageValue = array($pageValue);
			foreach($pageValue as $p) $pv .= "$p\n";

			if(!is_array($entryValue)) $entryValue = array($entryValue);
			foreach($entryValue as $e) $ev .= basename($e) . "\n";

			$pageValue = $pv;
			$entryValue = $details['field']->maxFiles == 1 ? $ev : $pv . $ev;
		}

		if(is_string($entryValue)) $entryValue = $this->wire('sanitizer')->textarea($entryValue);
		if(is_string($pageValue)) $pageValue = $this->wire('sanitizer')->textarea($pageValue);

		if(is_array($entryValue)) $entryValue = implode("\n", $entryValue);
		if(is_array($pageValue)) $pageValue = implode("\n", $pageValue);

		if($pageValue == $entryValue) return false;

		return array($entryValue, $pageValue);
	}

	/**
	 * Execute the 'view entry' action, optionally in edit mode
	 *
	 * @param bool $edit Whether or not we're in edit mode
	 * @return string
	 * @throws WireException
	 *
	 */
	public function executeViewEntry($edit = false) {
	
		$id = $this->input->get('id');
		$forms_id = 0;

		if(strpos($id, '.')) {
			list($forms_id, $id) = explode('.', $id);
		} else if($id) {
			$forms_id = FormBuilderEntries::getFormIdFromEntryId($this, (int) $id);
		}

		$id = (int) $id;
		$forms_id = (int) $forms_id;
		if(!$id || !$forms_id) throw new WireException("Invalid ID");
		$ids = "$forms_id.$id";
		$modal = $this->wire('input')->get('modal') ? "&modal=1" : "";
		$form = $this->process->getForm($forms_id, ($edit ? 'entries-edit' : 'entries-list')); 

		$processor = $form->processor(array('showHidden' => true));
		$processor->framework = 'Unknown'; // forces use of PW $adminTheme for framework

		if($processor->saveFlags & FormBuilderProcessor::saveFlagResponder) {
			// prevent auto-responder from running during edits
			$processor->saveFlags = $processor->saveFlags & ~FormBuilderProcessor::saveFlagResponder;
		}
		if($processor->saveFlags & FormBuilderProcessor::saveFlagEmail) {
			// prevent email from sending during edits
			$processor->saveFlags = $processor->saveFlags & ~FormBuilderProcessor::saveFlagEmail;
		}

		if($this->forms->hasPermission('form-edit', $form)) {
			$this->process->breadcrumb('../editForm/?id=' . $form->id, ucfirst($form->name));
		} else {
			$this->process->breadcrumb('../listEntries/?id=' . $form->id, ucfirst($form->name));
		}
		$this->process->breadcrumb('../listEntries/?id=' . $form->id, $this->labels('entries'));

		if(!$entry = $form->entries()->get($id)) throw new WireException("Unknown form entry");

		if(!empty($entry['_savePage']) && $processor->saveFlags & FormBuilderProcessor::saveFlagPage) {
			// prevent automatic saving changes to page when entry is changed
			$processor->saveFlags = $processor->saveFlags & ~FormBuilderProcessor::saveFlagPage;
		}

		if($this->input->get('compare') && !empty($entry['_savePage'])) {
			return $this->compareEntry($form, $entry, $entry['_savePage']);
		}

		$processor->populate($entry, $id);
		$inputfields = $processor->getInputfieldsForm();
		$adminTheme = $this->wire('adminTheme');
		if($adminTheme != 'AdminThemeDefault' && $adminTheme != 'AdminThemeReno' && $adminTheme != 'AdminThemeUikit') {
			foreach($inputfields->getAll() as $f) {
				$f->columnWidth = 100;
			}
		}

		$submit = $inputfields->getChildByName($form->name . '_submit');
		if($submit) {
			$submit->attr('value', $this->labels('save'));
			$submit->icon = 'save';
		}

		if($form->honeypot) {
			$f = $inputfields->getChildByName($form->honeypot);
			if($f) $f->getParent()->remove($f);
		}

		if($edit) {
			$this->process->breadcrumb("../viewEntry/?id=$ids", $entry['created']);
			$this->process->headline($this->_x('Edit', 'edit-entry-headline'));
		} else {
			$this->process->headline($entry['created']);
		}

		$this->process->browserTitle(sprintf($this->_('Entry: %s'), "#$entry[id] - $entry[created]"));

		if($edit && $form->hasPermission('entries-edit')) {
			$formAction = "../editEntry/?id=$ids$modal";
			$inputfields->attr('action', $formAction);
			$savedLabel = $this->_x('Saved Entry', 'save-entry'); // Message displayed after editing and saving entry in admin
			$processor->successUrl = '';
			$processor->successMessage = $savedLabel;
			$processor->executePluginActions('adminEditEntry');
			$out = $processor->render($id);
			$out .= "<input type='hidden' id='pwfb-entry-id' value='$id' />";
			if(count($_POST) && $processor->isSubmitted() && !$this->wire()->notices->hasErrors()) {
				$this->message($savedLabel);
				$out .= "<p><a href='#' class='pwfb-close-in-modal pwfb-close-now'>" . $this->_('Return to entries list') . '</a></p>';
			}
		} else {
			$showRawData = true; // enable for debugging purposes
			if($showRawData) {
				/** @var InputfieldMarkup $f */
				$f = $this->wire()->modules->get('InputfieldMarkup');
				$f->attr('name', '_raw_entry');
				$f->label = $this->_('Entry raw data');
				$f->icon = 'code';
				$f->collapsed = Inputfield::collapsedYes;
				$f->value = '<pre>' .
					$this->wire()->sanitizer->entities(json_encode($entry, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) .
					'</pre>';
				$inputfields->add($f);
			}
			$processor->executePluginActions('adminViewEntry');
			
			$out = "<div class='ui-helper-clearfix'>" . $inputfields->renderValue() . '</div>';
			if($form->hasPermission('entries-edit')) {
				$out .= $this->actionButton($this->_x('Edit', 'edit-entry-button'), "../editEntry/?id=$ids$modal");
			}
		}

		return $out;
	}

	/**
	 * Return the markup for an action button
	 *
	 * @param string $label Text to appear in the button
	 * @param string $href URL to link to
	 * @return string
	 *
	 */
	public function actionButton($label, $href) {
		return
			"<a href='$href'>" . 
				"<button id='action_button' class='ui-button ui-state-default pw-head-button head_button_clone'>" .
					"<span class='ui-button-text'>" .
						"<i class='fa fa-angle-right'></i> $label" .
					"</span>" .
				"</button>" .
			"</a>";
	}
	
	/**
	 * Reverse given sort
	 *
	 * @param string $sort
	 * @return string
	 *
	 */
	public function getReverseSort($sort) {
		return strpos($sort, '-') === 0 ? ltrim($sort, '-') : "-$sort";
	}

	public function sessionSet($key, $value) {
		$this->wire()->session->setFor($this->sessionNS(), $key, $value);
	}

	public function sessionGet($key, $default = null) {
		$value = $this->wire()->session->getFor($this->sessionNS(), $key);
		if($value === null) $value = $default;
		return $value;
	}

	public function sessionRemove($key) {
		return $this->wire()->session->removeFor($this->sessionNS(), $key);
	}
	
	private function sessionNS() {
		return 'PWFBE' . (int) $this->wire()->input->get('id');
	}

	public function cacheHas($key, $options = null) {
		$key = $this->cacheKey($key, $options);
		return isset($this->caches[$key]); 
	}
	
	public function cacheGet($key, $options = null) {
		$key = $this->cacheKey($key, $options);
		return isset($this->caches[$key]) ? $this->caches[$key] : null;
	}

	public function cacheSet($key, $value, $options = null) {
		$key = $this->cacheKey($key, $options);
		$this->caches[$key] = $value;
	}
	
	private function cacheKey($key, $options = null) {
		$key = $key . '-' .  (int) $this->wire()->input->get('id');
		if($options !== null) $key .= '-' . md5(print_r($options, true));
		return $key;
	}


	
}