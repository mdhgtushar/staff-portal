<?php namespace ProcessWire;

/**
 * FormBuilder Processor Partial Entries: Database 
 * 
 * Stores partial entries in forms_entries table with partial flag. 
 *
 */
class FormBuilderPartialEntriesDatabase extends FormBuilderPartialEntries {

	/**
	 * Entry confirmation string (alphanumeric, 30 chars)
	 *
	 * @var string
	 *
	 */
	protected $entryStr = '';

	/**
	 * Find/detect the current entry name from session and/or input variables
	 *
	 * @return string|bool
	 *
	 */
	protected function findEntryName() {

		// first try from session
		$entryName = $this->processor->sessionGet('entryName');
		if(!empty($entryName)) return $entryName;

		/** @var WireInput $input */
		$input = $this->wire('input');

		if(empty($entryName)) {
			$entryName = $input->post('_entryName');
		}

		if(empty($entryName)) {
			$entryName = $input->get('entry');
		}

		if($entryName !== '' && $entryName !== null) {
			$entryName = $this->entries->validEntryName($entryName);
			if($entryName === '') return false;
		}

		return $entryName;
	}

	/**
	 * Detect if there is a particular entry requested in input and populate it if so
	 * 
	 * @throws FormBuilderException
	 *
	 */
	public function init() {
		parent::init();

		/** @var FormBuilderEntries $entries */
		$entries = $this->processor->entries();
		$error = $this->_('Requested entry already submitted or not found');
		$entryName = $this->findEntryName();
		$entry = null;

		if($entryName === false) throw new FormBuilderException($error);

		if(!strlen($entryName) || !strpos($entryName, ':')) {
			// does not look like a valid entry name
			$pageNum = $this->maker->getPageNumToRender();
			$isPost = $this->wire('input')->requestMethod('POST');
			// redirect to page 1 if a page > 1 requested but no entry yet associated
			if(!$isPost && $pageNum > 1) $this->wire('session')->redirect($this->processor->getFormUrl());
			return;
		}
			
		// entry name looks potentially valid
		list($entryID,) = explode(':', $entryName, 2);
		$entryID = (int) $entryID;

		if($entryID > 0 && strlen($entryName)) {
			// existing entry
			$entry = $entries->getByName($entryName);
			$entryFlags = isset($entry['entryFlags']) ? $entry['entryFlags'] : 0;

			if(empty($entry) || $entry['id'] != $entryID) {
				// entry does not exist for this form
				throw new FormBuilderException($error);

			} else if(!$entryFlags & FormBuilderEntries::flagPartial) {
				throw new FormBuilderException($error);

			} else {
				// entry details matches entryName in input, so populate to the form
				$this->entryStr = $entry['entryStr'];
				$this->entryID = $entry['id'];
				$this->processor->populate($entry, $entry['id']);
			}

		} else if($entryID > 0) {
			throw new FormBuilderException($error);

		} else if(strlen($entryName)) {
			// throw new FormBuilderException($error);

		} else {
			// new entry
		}
	
		if(!$entryID) {
			// entry name was not in input or it didn't look valid so create a new entry name
			$this->entryID = 0;
			$this->entryStr = $entries->makeEntryStr();
		}
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

		$data = parent::save($form, $data, $finish);
		if($data === false) return false;

		/** @var FormBuilderEntries $entries */
		$entries = $this->processor->entries();

		if($this->entryID > 0) {
			// there is an entry ID present with the entryStr, i.e. 123:eafja393fjlajez
			$entry = $entries->getByName($this->entryName());
			if(empty($entry)) return 0;
		} else {
			// no entry ID yet, just an entryStr, i.e. 0:3ja93u93ia3
			$entry = array();
		}

		$entry = array_merge($entry, $data);

		// unique identity for entry, to confirm from input
		$entry['entryStr'] = $this->entryStr;

		// save the form to the DB
		if($finish) {
			$entry = $entries->removeEntryFlag($entry, 'partial');
			$this->processor->sessionRemove('entryName');
		} else {
			$entry = $entries->addEntryFlag($entry, 'partial');
		}

		$this->entryID = $this->processor->saveEntry($entry);
		$entry['id'] = $this->entryID;

		return $entry;
	}
	
	/**
	 * Render form ready, add entry name to query string and hidden input
	 *
	 * @param InputfieldForm $form
	 *
	 */
	public function renderReady(InputfieldForm $form) {
		parent::renderReady($form);
		$form->attr('action', $this->processor->getFormUrl());
		$value = $this->wire('sanitizer')->entities($this->entryName());
		$form->appendMarkup .= "<input type='hidden' name='_entryName' value='$value' />";
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

		$url = parent::updateFormUrl($url, $options);
		$entryName = $this->entryName();

		if($entryName && strpos($url, $entryName) === false) {
			$url .= (strpos($url, '?') !== false ? '&' : '?') . "entry=" . $this->wire('sanitizer')->entities($entryName);
		}

		return $url;
	}

	/**
	 * Get the entry name (combination of entryID and entryStr)
	 *
	 * @return string
	 *
	 */
	public function entryName() {
		if(empty($this->entryStr)) $this->entryStr = $this->processor->entries()->makeEntryStr();
		$entryName = "$this->entryID:$this->entryStr";
		return $entryName;
	}

}

