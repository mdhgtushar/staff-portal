<?php namespace ProcessWire;
/**
 * ProcessWire Form Maker
 *
 * Makes Inputfields and related types for FormBuilderProcessor
 *
 * Copyright (C) 2019 by Ryan Cramer Design, LLC
 *
 * DO NOT DISTRIBUTE
 * 
 * @property string $formName
 *
 */ 

class FormBuilderMaker extends Wire {

	// submitType: invalid submission
	const submitTypeInvalid = 0;
	
	// submitType: next button submit
	const submitTypeNext = 1;
	
	// submitType: prev button submit
	const submitTypePrev = -1;

	// submitType: other pagination requested
	const submitTypeJump = 2;
	
	// submitType: final or non-paginated submit
	const submitTypeFinal = true;
	
	// submitType: not submitted
	const submitTypeNone = false;

	/**
	 * @var FormBuilderProcessor
	 * 
	 */
	protected $processor;

	/**
	 * @var string|null
	 * 
	 */
	protected $submitKey = null;

	/**
	 * Cached markup from InputfieldWrapper::getMarkup()
	 * 
	 * @var array
	 * 
	 */
	protected $markup = array();

	/**
	 * Number of paginations detected in form (0=not yet determined)
	 * 
	 * @var int
	 * 
	 */
	protected $numPaginations = 0;

	/**
	 * Pagination number to render
	 * 
	 * @var int
	 * 
	 */
	protected $pageNumToRender = 0;

	/**
	 * Pagination number to process
	 * 
	 * @var int
	 * 
	 */
	protected $pageNumToProcess = 0;

	/**
	 * Pagination labels indexed by page number
	 * 
	 * @var array
	 * 
	 */
	protected $pageNumLabels = array();
	

	/**
	 * Construct
	 * 
	 * @param FormBuilderProcessor $processor
	 * 
	 */
	public function __construct(FormBuilderProcessor $processor) {
		$this->processor = $processor;
		$processor->wire($this);
		parent::__construct();
	}

	/**
	 * Get property
	 * 
	 * @param string $key
	 * @return mixed
	 * 
	 */
	public function __get($key) {
		if($key === 'formName') return $this->processor->formName;
		return parent::__get($key);
	}
	
	/**
	 * @param string $property Name of property to retrieve or blank for all
	 * @param string $type Optional Inputfield type ('InputfieldTypeName' or just 'TypeName')
	 * @param array $vars Placeholder vars to populate, i.e. ['out' => 'Value'] or ['{out}' => 'Value']
	 * @return array|mixed|null
	 * 
	 */
	public function getMarkup($property = '', $type = '', $vars = array()) {
		if(empty($this->markup)) {
			$this->markup = InputfieldWrapper::getMarkup();
		}
		if($type && strpos($type, 'Inputfield') !== 0) {
			$type = "Inputfield$type";
		}
		if($type && empty($property)) {
			// return all for type
			$value = isset($this->markup[$type]) ? $this->markup[$type] : $this->markup;
			
		} else if($property) { 
			// specific property requested
			if($type && isset($this->markup[$type][$property])) {
				$value = $this->markup[$type][$property];
			} else if(isset($this->markup[$property])) {
				$value = $this->markup[$property];
			} else {
				$value = '';
			}
			// check if there are any placeholder variables to replace
			if(!empty($vars) && strpos($value, '{') !== false) {
				foreach($vars as $k => $v) {
					if(strpos($k, '{') !== 0) $k = '{' . $k . '}';
					if(strpos($value, $k) !== false) $value = str_replace($k, $v, $value); 
				}
			}
		} else {
			$value = $this->markup;
		}
		return $value;
	}

	/**
	 * Given a FormBuilderForm return an InputfieldForm
	 * 
	 * @param FormBuilderForm $fbForm
	 * @param int $requestPageNum
	 * @return InputfieldForm
	 * 
	 */
	public function makeInputfieldForm(FormBuilderForm $fbForm, $requestPageNum = 0) {
		$form = $this->arrayToInputfields($fbForm->getArray(), $requestPageNum);
		$form->attr('name', $fbForm->name);
		return $form;
	}
	
	/**
	 * Given a form configuration array, create an InputfieldForm from it
	 *
	 * @param array $a Form configuration array
	 * @param int $requestPageNum Requested pagination number, or -1 to disregard any found pagination (0=auto detect)
	 * @param int $currentPageNum Current pagination number, for internal/recursive use only
	 * @param InputfieldWrapper $inputfields For internal/recursive use only
	 * @param bool|int $submitType For internal/recursive use only
	 * @return InputfieldForm|InputfieldWrapper
	 *
	 */
	public function arrayToInputfields(array $a, $requestPageNum = 0, $currentPageNum = 1, $inputfields = null, $submitType = null) {

		$language = null;
		$isForm = false; // are we rendering the main <form> rather than a recursive fieldset within it?
		$numFields = 0;
		$noPagination = $requestPageNum == -1 || $this->wire('page')->process === 'ProcessFormBuilder'; 
		$notes = '';
		$cnt = 0;
		
		// submitType: true=final submit, 1=next page, -1=prev page, false=fail
		$submitType = $submitType === null ? $this->getSubmitType() : $submitType;
		
		/** @var Language|null $language */
		if($this->wire('languages')) {
			$language = $this->wire('user')->language;
			if($language && $language->isDefault()) $language = null;
		}

		if($inputfields === null) {
			// start a new form
			$isForm = true;
			$inputfields = $this->makeForm($a, $language);
			$items = isset($a['children']) ? $a['children'] : array();
		} else {
			$items = $a;
		}
		
		if(!$requestPageNum) {
			// get requested pagination number
			if($submitType === self::submitTypeNext || $submitType === self::submitTypePrev || $submitType === self::submitTypeJump) {
				$requestPageNum = $this->getPageNumToProcess();
			} else {
				$requestPageNum = $this->getPageNumToRender();
			}
		}

		foreach($items as $name => $data) {

			if(!is_array($data) || empty($data['type'])) continue;
			$cnt++;

			// type of input to use for this field
			$inputType = $data['type'];

			// when specified, show hidden inputs as text (for admin visibility)
			if($inputType === 'Hidden' && $this->processor->showHidden) $inputType = 'Text';

			// if field is a pageBreak...
			if($inputType === 'FormBuilderPageBreak' && $isForm && !$noPagination && $requestPageNum > 0) { 
				// increment current pagination num if we have at least one field so far, or requested pagination > 1
				//if($numFields > 0 || $requestPageNum > 1) $currentPageNum++;
				if($cnt > 1) $currentPageNum++;
				if($requestPageNum === $currentPageNum) { 
					if(isset($data['notes'])) {
						$notes = isset($data["notes$language"]) ? $data["notes$language"] : $data["notes"];
					}
				}
				if(isset($data['label'])) {
					$label = isset($data["label$language"]) ? $data["label$language"] : $data["label"];
					$this->pageNumLabels[$currentPageNum] = $label;
				}
			}

			// check if requested pagination differs from the current one
			// if($requestPageNum != $currentPageNum && !$isFinalSubmit) {
			if($requestPageNum > 0 && $requestPageNum != $currentPageNum) {
				// this is an inactive pagination
				// except during final submit, we'll include the entire form
				/*
				if($inputType === 'FormBuilderFile') {
					// @todo need to figure out how to handle FormBuilderFile inputs on paginations
				}
				*/
				continue;
			}

			// get the Inputfield object
			$f = $this->makeInputfield($inputType, $name, $data, $language);

			// specify form or InputfieldWrapper that is the parent of this Inputfield
			$f->setParent($inputfields);
		
			// if the field is an InputfieldWrapper that contains children, go recursive and add them
			if(!empty($data['children']) && $f instanceof InputfieldWrapper) {
				$this->arrayToInputfields($data['children'], $requestPageNum, $currentPageNum, $f, $submitType);
			}

			if($f) {
				$inputfields->add($f);
				$numFields++;
			}
		}

		if($isForm && $requestPageNum > 0) {
			
			$totalPageNum = $currentPageNum;
			$this->setNumPaginations($totalPageNum);
			
			foreach($this->makeSubmitButtons($a['name'], $requestPageNum) as $button) {
				$inputfields->add($button);
			}
			
			if($totalPageNum > 1) {
				$inputfields->appendMarkup .= "<input type='hidden' name='_submitPageNum' value='$requestPageNum' />";
				
				if($notes) {
					$inputfields->appendMarkup .= $this->getMarkup('item_notes', 'FormBuilderPageBreak', array(
						'out' => $inputfields->entityEncode($notes, Inputfield::textFormatMarkdown)
					)); 
				}
			}
		}

		return $inputfields;
	}

	/**
	 * Get array of InputfieldSubmit buttons to add to the form
	 *
	 * @param string $formName
	 * @param int $requestPageNum
	 * @return array of InputfieldSubmit objects
	 *
	 */
	protected function makeSubmitButtons($formName, $requestPageNum = 1) {

		$buttons = array();

		/** @var Language|null $language */
		$language = $this->wire('user')->language;
		if($language && $language->isDefault()) $language = null;

		/** @var Modules $modules */
		$modules = $this->wire('modules');

		/** @var InputfieldSubmit $submit */
		$submit = $modules->get('InputfieldSubmit');
		$submit->attr('id+name', $formName . '_submit');
		$submit->attr('value', $this->processor->submitText);

		if($language) {
			$value = $this->processor->get("submitText$language");
			if(strlen($value)) $submit->attr('value', $value);
		}
		
		if($this->numPaginations > 1) {
			if($requestPageNum > 1) {
				/** @var InputfieldSubmit $prev */
				$prev = $modules->get('InputfieldSubmit');
				$prev->attr('name', $formName . '_submit_prev');
				$prev->addClass('InputfieldSubmitPrev', 'wrapClass');
				$value = $this->processor->fbForm->get("backText$language"); 
				if(empty($value) && $language) $value = $this->processor->fbForm->get("backText"); 
				if(empty($value)) $value = $this->_('Back'); 
				$prev->attr('value', $value); 
				$buttons['prev'] = $prev;
			}
			if($requestPageNum < $this->numPaginations) {
				/** @var InputfieldSubmit $next */
				$next = $modules->get('InputfieldSubmit');
				$next->attr('name', $formName . '_submit_next');
				$next->attr('value', $this->_('Next'));
				$next->addClass('InputfieldSubmitNext', 'wrapClass');
				$value = $this->processor->fbForm->get("nextText$language");
				if(empty($value) && $language) $value = $this->processor->fbForm->get("nextText"); 
				if(empty($value)) $value = $this->_('Next');
				$next->attr('value', $value); 
				$buttons['next'] = $next;
			} else {
				$buttons['submit'] = $submit;
			}
		} else {
			$buttons['submit'] = $submit;
		}

		return $buttons;
	}

	/**
	 * Make an InputfieldForm object (for arrayToInputfields method)
	 *
	 * @param array $data
	 * @param Language|null $language
	 * @return InputfieldForm
	 *
	 */
	protected function makeForm(array $data, $language) {

		/** @var InputfieldForm $inputfields */
		$form = $this->wire('modules')->get('InputfieldForm');

		foreach(array('method', 'action', 'target') as $name) {
			if(empty($data[$name])) continue;
			$form->attr($name, $data[$name]);
		}

		if($data['type'] != 'Form') return $form;

		$form->attr('id+name', $data['name']);

		foreach($data as $k => $v) {
			// if the form has properties that match those in the processor, set them to the processor	
			if($this->processor->$k !== null) {
				$this->processor->set($k, $v);
			}
			if($language) {
				// swap language value with default, when applicable
				if(!empty($data["$k$language"])) {
					$this->processor->set($k, $data["$k$language"]);
				}
			}
		}

		return $form;
	}

	/**
	 * Make an Inputfield object (for arrayToInputfields method)
	 *
	 * @param string $type Type of Inputfield, i.e. "Text" or "InputfieldText", etc.
	 * @param string $name Name attribute for field
	 * @param array $data Settings to populate to field
	 * @param Language|null $language Language (if not default)
	 * @return Inputfield|InputfieldWrapper
	 *
	 */
	protected function makeInputfield($type, $name, array $data, $language = null) {

		/** @var Modules $modules */
		$modules = $this->wire('modules');
		
		/** @var WireInput $input */
		$input = $this->wire('input');

		if(strpos($type, 'Inputfield') !== 0) $type = 'Inputfield' . ucfirst($type);

		/** @var Inputfield|InputfieldWrapper $f */
		$f = $modules->get($type);
		if(!$f) $f = $modules->get('InputfieldText');

		$f->attr('name', $name);
		$f->attr('id', 'Inputfield_' . $name);
		$f->set('formBuilder', true); // in case any Inputfields need to know this context
		$f->set('hasFieldtype', false); // in case any Inputfields need to know this context
		
		// if value is available in submitData, populate it now
		// $value = $this->submitData($name);
		// if($value !== null) $f->attr('value', $value);

		// set extra values to InputfieldFormBuilder derived Inputfields
		if($f instanceof InputfieldFormBuilderInterface) {
			$f->set('processor', $this->processor);
			$f->set('formID', $this->processor->id);
			$fbInterface = true;
		} else {
			$fbInterface = false;
		}

		// populate any other settings to the Inputfield
		foreach($data as $key => $value) {
			if($key === 'type' || $key === 'children') continue;
			$f->$key = $data[$key];
		}

		// if multi-language, populate the other language properties
		if($language) {
			foreach(array('label', 'description', 'notes', 'placeholder', 'detail') as $key) {
				$langKey = $key . $language->id;
				$langVal = $f->$langKey;
				if(strlen($langVal)) $f->$key = $langVal;
			}
		}
		
		if($fbInterface && wireInstanceOf($f, 'InputfieldFormBuilderForm')) {
			/** @var InputfieldFormBuilderForm $f */
			$f->setup($this->processor); 
		}

		if(!$f instanceof InputfieldWrapper && $this->processor->allowPreset && $input->get($name) !== null) {
			// a value is being pre-set from a GET var
			$f->processInput($input->get);
		}

		return $f;
	}

	/**
	 * Populate the given $form with the given $data
	 * 
	 * @param InputfieldForm $form
	 * @param array $data
	 * @param int $entryID
	 * 
	 */
	public function populateForm(InputfieldForm $form, array $data, $entryID = 0) {
	
		// fields that we do not populate into the form
		$skippers = array(
			'id', '_savePage', 'created', 'modified', 'data', 
			'entryID', 'entryStr', 'entryFlags', 'entryName',
			'_submitPageNum', '_submitKey',
		);
	
		foreach($data as $key => $value) {

			if(in_array($key, $skippers)) continue;

			$field = $form->getChildByName($key);

			if(!$field || !$field instanceof Inputfield) {
				// if field is not present in the form (or pagination of the form) 
				// remember it to populate to the form later
				// $this->submitData($key, $value);
				continue;
			}
			
			$this->populateInputfield($field, $value, $entryID); 
		}

		// ensure the _savePage value is retained, but not manipulatable	
		if(isset($data['_savePage'])) {
			$field = $this->wire('modules')->get('InputfieldHidden');
			$field->attr('name', '_savePage');
			$field->attr('value', (int) $data['_savePage']);
			$field->collapsed = Inputfield::collapsedHidden; // makes it non-manipulatable
			$form->prepend($field);
		}
	}

	/**
	 * Populate an individual Inputfield
	 * 
	 * @param Inputfield $field
	 * @param string|int|array $value
	 * @param int $entryID
	 * 
	 */
	public function populateInputfield(Inputfield $field, $value, $entryID = 0) {
		$field->attr('value', $value);
		if($field instanceof InputfieldFormBuilderInterface) {
			// populate extra values for InputfieldFormBuilder derived Inputfields
			/** @var Inputfield $field */
			if($entryID) $field->set('entryID', $entryID);
			$field->set('formID', $this->processor->id);
		}
	}
	
	/**
	 * Create a new submitKey containing number of fields, random component and session key
	 *
	 * @param InputfieldForm $form
	 * @param array $options
	 * @return string|array
	 *
	 */
	public function makeSubmitKey(InputfieldForm $form, array $options = array()) {
		
		$defaults = array(
			'numFields' => 0,
			'formName' => $this->processor->formName,
			'sessionKey' => '',
			'submitVal' => '',
			'getArray' => false,
		);
		
		if($this->submitKey && empty($options)) return $this->submitKey;
		
		$options = array_merge($defaults, $options);
		$numFields = empty($options['numFields']) ? count($form->children) : $options['numFields'];
		
		if(!$this->processor->skipSessionKey) {
			// if we're also using a sessionKey, then append it to the submitKey and remember in session
			if(!empty($options['sessionKey'])) {
				$sessionKey = $options['sessionKey'];
			} else if(wireClassExists('WireRandom')) {
				$random = new WireRandom();
				$sessionKey = $random->alphanumeric(0, array(
					'minLength' => 21,
					'maxLength' => 32,
					'fast' => true
				));
			} else {
				$sessionKey = md5(mt_rand() . microtime() . mt_rand());
			}
			$this->processor->sessionSet('sessionKey', $sessionKey);
		} else {
			$form->protectCSRF = false;
			$sessionKey = '0';
		}
		
		$formName = empty($options['formName']) ? $this->processor->formName : $options['formName'];
		$submitVal = empty($options['submitVal']) ? $this->makeSubmitVal($sessionKey, $numFields) : $options['submitVal'];
		$submitKey = "$numFields:$formName:$sessionKey:$submitVal";
		
		$this->submitKey = $submitKey;
		
		if($options['getArray']) return array(
			'numFields' => $numFields,
			'formName' => $formName, 
			'sessionKey' => $sessionKey,
			'submitVal' => $submitVal,
			'submitKey' => $submitKey
		);
		
		return $submitKey;
	}

	/**
	 * @param $sessionKey
	 * @param $numFields
	 * @return string
	 * 
	 */
	public function makeSubmitVal($sessionKey, $numFields) {
		$pfx = preg_match('/^[01a-zA-Z]*([2-9])/', $sessionKey, $m) ? $m[1] : $numFields;
		$as = strpos('SPDA', substr($this->processor->embedVer, 0, 1));
		$as = $as === false ? 0 : $as+1;
		$ev = $as . (($pfx * (int) substr($this->processor->embedVer, 1)) - ($this->processor->id * $numFields));
		return $ev;
	}
	
	/**
	 * Parse a submitKey into its component parts
	 *
	 * @param string $submitKey
	 * @return array
	 *
	 */
	public function parseSubmitKey($submitKey) {
		$sanitizer = $this->wire('sanitizer');
		$parts = explode(':', $submitKey);
		return array(
			'qty' => count($parts),
			'numFields' => isset($parts[0]) ? (int) $parts[0] : 0,
			'formName' => isset($parts[1]) ? $sanitizer->name($parts[1]) : '',
			'sessionKey' => isset($parts[2]) ? $sanitizer->text($parts[2]) : '',
			'submitVal' => isset($parts[3]) ? $sanitizer->alphanumeric($parts[3]) : '',
		);
	}
	
	/**
	 * Is this a form or pagination submit request for this form?
	 *
	 * - Returns boolean true if entire form submitted (or final pagination).
	 * - Returns integer 1 if "Next" button clicked for pagination.
	 * - Returns integer -1 of "Prev" button clicked for pagination.
	 * - Returns integer 0 if form was submitted but did not validate session/security checks.
	 * - Returns boolean false if this form was NOT submitted.
	 *
	 * @return bool|int
	 *
	 */
	public function getSubmitType() {
		/** @var WireInput $input */
		$input = $this->wire('input');
		$formName = $this->processor->formName;
		if(!$input->requestMethod('POST')) {
			$valid = self::submitTypeNone;
		} else if($input->post($formName . "_submit_next")) {
			$valid = self::submitTypeNext;
		} else if($input->post($formName . "_submit_prev")) {
			$valid = self::submitTypePrev;
		} else if($input->post($formName . "_submit_jump")) {
			$valid = self::submitTypeJump;
		} else if($input->post($formName . "_submit")) {
			$valid = self::submitTypeFinal; // true
		} else {
			$valid = self::submitTypeNone;
		}
		if($valid === true && !$this->processor->validSubmitKey()) {
			// validate submit key only at final submit (submit===true)
			$valid = self::submitTypeInvalid;
		}
		
		return $valid;
	}
	
	/**
	 * Get the page/pagination number to render
	 *
	 * @return int
	 *
	 */
	public function getPageNumToRender() {

		if($this->pageNumToRender) return $this->pageNumToRender;

		/** @var WireInput $input */
		$input = $this->wire('input');
		$formName = $this->formName;
		$isPost = $input->requestMethod('POST');
		$pageNum = $isPost ? (int) $input->post("{$formName}_submit_jump") : 0;

		if($pageNum) {
			// pageNum from jump navigation
		} else if($isPost) {
			// pageNum derived from next/prev buttons
			$pageNum = (int) $input->post('_submitPageNum');
			if($input->post("{$formName}_submit_next")) {
				// go to next pagination
				$pageNum++;
			} else if($pageNum > 1 && $input->post("{$formName}_submit_prev")) {
				// go to previous pagination
				$pageNum--;
			}
		} else {
			// pageNum derived from query string
			$pageNum = (int) $input->get('page_num');
		}

		if($pageNum < 1) $pageNum = 1;

		if($this->numPaginations && $pageNum > $this->numPaginations) {
			$pageNum = $this->numPaginations;
		}

		$this->pageNumToRender = $pageNum;
		
		return $this->pageNumToRender;
	}

	/**
	 * Get the page/pagination number to process input for
	 *
	 * @return int
	 *
	 */
	public function getPageNumToProcess() {
		if($this->pageNumToProcess) return $this->pageNumToProcess;
		/** @var WireInput $input */
		$input = $this->wire('input');
		$pageNum = $input->requestMethod('POST') ? (int) $input->post('_submitPageNum') : 0;
		if($pageNum < 1) $pageNum = 1;
		if($this->numPaginations && $pageNum > $this->numPaginations) $pageNum = $this->numPaginations;
		$this->pageNumToProcess = $pageNum;
		return $this->pageNumToProcess;
	}
	
	public function setPageNumToRender($num) {
		$this->pageNumToRender = $num;
	}
	
	public function setPageNumToProcess($num) {
		$this->pageNumToProcess = $num;
	}

	/**
	 * Set number of paginations (internal)
	 * 
	 * @param int $qty
	 * 
	 */
	protected function setNumPaginations($qty) {
		$this->numPaginations = $qty;
		// $this->pagination()->setNumPaginations($qty);
	}

	/**
	 * Get number of paginations found
	 * 
	 * @return int
	 * 
	 */
	public function getNumPaginations() {
		return $this->numPaginations;
	}

	/**
	 * Does the current form appear to have more than 1 pagination?
	 * 
	 * Known only after a makeInputfieldForm() call
	 * 
	 * @return int
	 * 
	 */
	public function hasPagination() {
		return $this->numPaginations > 1;
	}

	/**
	 * Get defined label for given pagination number
	 * 
	 * @param int $pageNum
	 * @return string
	 * 
	 */
	public function getPageNumLabel($pageNum) {
		return isset($this->pageNumLabels[$pageNum]) ? $this->pageNumLabels[$pageNum] : '';
	}

	// protected $submitData = array();
	/**
	 * Get or set submitData
	 * 
	 * @param string|bool|null $key
	 * @param mixed $value
	 * @return $this|array|mixed|null
	 * 
	public function submitData($key = null, $value = null) {
		if($key === true) {
			// return current submit data and clear it after
			$value = $this->submitData;
			$this->submitData = array();
			return $value;
		}
		if($key === null) {
			// return current submit data
			return $this->submitData;
		}
		if($value === null) {
			// return property from submit data
			return isset($this->submitData[$key]) ? $this->submitData[$key] : null;
		}
		// set submit data
		$this->submitData[$key] = $value;
		return $this;
	}
	 */
	
}