<?php namespace ProcessWire;

/**
 * Form Builder Processor: Partial Entries
 * 
 * Handles the management of partial entries for FormBuilderProcessor. 
 *
 * Copyright (C) 2019 by Ryan Cramer Design, LLC
 *
 * PLEASE DO NOT DISTRIBUTE
 *
 * @property-read string $formName
 * @property-read FormBuilderEntries $entries
 * @property-read FormBuilderMaker $maker
 * @property-read bool $active
 * 
 */
abstract class FormBuilderPartialEntries extends WireData {

	/**
	 * Debug mode makes it render a print_r() dump of the partial entry data under the form
	 * 
	 */
	const debug = false;

	/**
	 * @var FormBuilderProcessor
	 * 
	 */
	protected $processor;

	/**
	 * Is pagination active and initialized?
	 * 
	 * @var bool
	 * 
	 */
	protected $active = false;

	/**
	 * Entry ID
	 * 
	 * @var int
	 * 
	 */
	protected $entryID = 0;

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
	 * @return mixed|null|string
	 * 
	 */
	public function get($key) {
		if($key === 'formName') return $this->processor->formName;
		if($key === 'entries') return $this->processor->entries();
		if($key === 'active') return $this->active;
		if($key === 'maker') return $this->processor->maker();
		return parent::get($key);
	}

	/**
	 * Detect if there is a particular entry requested in input and populate it if so
	 * 
	 * @throws FormBuilderException
	 * 
	 */
	public function init() {
		$this->active = true;
		if(!$this->active) throw new FormBuilderException('For static analysis only');
	}
	
	/**
	 * Save a submitted pagination to a partial entry
	 * 
	 * @param InputfieldForm $form
	 * @param array $data Entry data if already known, or omit to pull from form automatically
	 * @param bool $finish Submission of final pagination?
	 * @return bool|array Returns full entry data or boolean false on fail
	 * 
	 */
	public function save(InputfieldForm $form, array $data = array(), $finish = false) {
		if(!$this->processor->saveFlags & FormBuilderProcessor::saveFlagDB) return false;
		if(!$this->active) return false;
		if(empty($data)) $data = $this->processor->formToEntry($form, $this->entryID);
		if($finish) {} // ignore
		return $data;
	}

	/**
	 * Update form URL for any additional data needed for partial entries
	 * 
	 * @param string $url
	 * @param array $options
	 * @return string
	 * 
	 */
	public function updateFormUrl($url, array $options = array()) {
		
		$defaults = array(
			'pageNum' => 0,
		);
		
		$options = array_merge($defaults, $options);
		
		if($options['pageNum'] > 0) {
			$url .= (strpos($url, '?') !== false ? '&' : '?') . "page_num=" . (int) $options['pageNum'];
		}
		
		return $url;
	}
	
	/**
	 * Render form ready
	 *
	 * @param InputfieldForm $form
	 *
	 */
	public function renderReady(InputfieldForm $form) {
		if(self::debug) $form->appendMarkup .= 
			"<div style='clear:both;font-size:12px;line-height:1'>" . 
				"<h2>Partial entry data (debug mode):</h2>" . 
				"<pre>" . htmlentities(print_r($this->processor->getEntry(), true)) . "</pre>" . 
			"</div>";
	
		if(FormBuilder::allowSummaryPage) {
			// noshows are names of fields that were identified as hidden due to Inputfield dependencies
			// they are only applicable if an InputfieldFormBuilderPageBreak field has its 'showSummary' option enabled
			// this hidden input is populate by JS when applicable
			$form->appendMarkup .= "<input type='hidden' name='_noshows' id='_pwfb_noshows' value='' />";
		}
	}

	/**
	 * Called by the render() method when pagination submitted, after input has been processed
	 *
	 * @param InputfieldForm $form
	 * @param int|bool $submitType Next (1), prev (-1), or jump (2) clicked, or final submit (true) clicked but with errors.
	 *
	 */
	public function processPagination(InputfieldForm $form, &$submitType) {

		$processor = $this->processor;
		$maker = $processor->maker();
		$pageNumToRender = $maker->getPageNumToRender();
		$pageNumToProcess = $maker->getPageNumToProcess();
		$errors = $processor->getErrors();
		$entry = $processor->getEntry();
		$input = $this->wire('input'); /** @var WireInput $input */
		$sanitizer = $this->wire('sanitizer');
		
		if($entry === null) $entry = array(); 
		$entry = array_merge($entry, $processor->formToEntry($form, $this->entryID));

		if(FormBuilder::allowSummaryPage) {
			// noshows are names of fields that were identified as hidden due to Inputfield dependencies
			// they are only applicable if an InputfieldFormBuilderPageBreak field has its 'showSummary' option enabled
			$noShows = $input->post('_noshows');
			$key = '_noshows' . $pageNumToProcess;
			if(empty($noShows)) {
				if(isset($entry[$key])) unset($entry[$key]);
			} else {
				$names = explode(',', $noShows);
				$a = array();
				foreach($names as $name) {
					$name = $sanitizer->fieldName($name);
					if(empty($name) || !$form->getChildByName($name)) continue;
					$a[] = $name;
				}
				$entry[$key] = $a;
			}
		}

		if(count($errors)) { 
			// one or more errors present
			if($submitType !== FormBuilderMaker::submitTypeJump) {
				// if there were errors, stay on the same pagination rather than advancing next or prev
				// unless user is jumping to another pagination (where we will silently remember the errors instead)
				$maker->setPageNumToRender($pageNumToProcess);
				$pageNumToRender = $pageNumToProcess;
				// make the pageNum to be rendered the same as the pageNum to be processed
				$submitType = FormBuilderMaker::submitTypeJump;
				$processor->setSubmitType($submitType);
			}
		} else {
			// no errors present
			// record page numbers that have been processed and completed without errors
			if(!isset($entry['_completed'])) $entry['_completed'] = array();
			if(!in_array($pageNumToProcess, $entry['_completed'])) $entry['_completed'][] = $pageNumToProcess;
			if(!empty($entry["_errors$pageNumToProcess"])) $entry["_errors$pageNumToProcess"] = array();
		}

		// if page to render is same as page to process, we do not need to do anything else
		if($pageNumToRender === $pageNumToProcess) return;

		// if user is jumping to another pagination, remember any errors with the entry (rather than reporting them)
		if($submitType === FormBuilderMaker::submitTypeJump) {
			if(count($errors)) {
				// submitTypeJump with errors on processed pagination, remember for later
				$entry["_errors$pageNumToProcess"] = $errors;
			} else if(!empty($entry["_errors$pageNumToProcess"])) {
				// remove reference to errors
				$entry["_errors$pageNumToProcess"] = array();
			}
		} else {
			// next or prev clicked: if errors present, they will be displayed now so we do not need to remember them
			/*
			if(!empty($entry["_errors$pageNumToProcess"])) {
				$entry["_errors$pageNumToProcess"] = array();
			}
			*/
		}
	
		if(!empty($entry)) {
			$entry = $this->save($form, $entry);
			$processor->setEntry($entry);
		}

		// advance the page num forward or backward (or jump) 
		// render new inputfields since fields to render differ from the fields we processed
		/*
		$class = $form->attr('class');
		$form = $maker->makeInputfieldForm($processor->getFbForm(), $pageNumToRender);
		$processor->setInputfieldsForm($form);
		$maker->populateForm($form, $entry, $processor->getEntryID());
		$form->addClass($class);
		*/
		
		// optional redirect so pagination URL in-tact
		if($pageNumToRender != $pageNumToProcess) {
			$formUrl = $this->processor->getFormUrl(array('pageNum' => $pageNumToRender));
			$this->wire('session')->redirect($formUrl, false);
		}
	}

	/**
	 * Called on last pagination when entry may be ready for final save (or not, if errors)
	 * 
	 * This method clears out any pagination-specific keys out of the entry when no more errors are present. 
	 * 
	 * @param InputfieldForm $form
	 * @return bool
	 * 
	 */
	public function finishPagination(InputfieldForm $form) {
		
		$processor = $this->processor; 
		$entry = $processor->getEntry();
		if(!is_array($entry)) $entry = array();
		$maker = $this->maker;
		$numErrors = count($processor->getErrors());
		$numPaginations = $maker->getNumPaginations();
		$removeKeys = array('_completed');
		$completedPageNums = isset($entry['_completed']) ? $entry['_completed'] : array();
		$pageNumText = ' ' . $this->_('(page %d)');
		
		// check that all paginations have been processed and none skipped over
		// this can happen when submitTypeJump enabled, or user modifies page_num in the URL
		for($pageNum = $numPaginations-1; $pageNum > 0; $pageNum--) {
			if(in_array($pageNum, $completedPageNums)) continue;
			$pageLabel = $maker->getPageNumLabel($pageNum);
			$error = $this->_('Not yet submitted');
			$processor->addError("$pageLabel - $error " . sprintf($pageNumText, $pageNum));
		}
		
		// add in any existing errors in other paginations
		for($pageNum = 1; $pageNum <= $numPaginations-1; $pageNum++) {
			if(!isset($entry["_errors$pageNum"])) continue;
			$key = "_errors$pageNum";
			$removeKeys[] = $key;
			foreach($entry[$key] as $error) {
				$pageLabel = $maker->getPageNumLabel($pageNum);
				$processor->addError("$pageLabel - $error " . sprintf($pageNumText, $pageNum));
				$numErrors++;
			}
		}
		
		// remove any “_noshows…” properties they are no longer needed in entry
		if(!$numErrors && FormBuilder::allowSummaryPage) {
			for($pageNum = 1; $pageNum <= $numPaginations - 1; $pageNum++) {
				$key = "_noshows$pageNum";
				if(isset($entry[$key])) $removeKeys[] = $key;
			}
		}
		
		if(!$numErrors && count($removeKeys)) {
			foreach($removeKeys as $key) {
				unset($entry[$key]);
			}
			$processor->setEntry($entry);
		}
		
		if($numErrors) {
			// save the entry since this is no longer a final as there were errors
			$entry = array_merge($entry, $processor->formToEntry($form, $this->entryID));
			$this->save($form, $entry);
		}
		
		return $numErrors === 0;
	}

	/**
	 * Method called when form’s input is ready to be processed
	 * 
	 * @param InputfieldForm $form
	 *
	public function processInputReady(InputfieldForm $form) { }
	 */

	/**
	 * Method called when form’s input is done being processed
	 * 
	 * @param InputfieldForm $form
	 * 
	public function processInputDone(InputfieldForm $form) { }
	 */
}


