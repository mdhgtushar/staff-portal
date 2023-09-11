<?php namespace ProcessWire;

/**
 * FormBuilder Partial Entries: Session Storage
 * 
 * Stores partial entries in session data. 
 *
 */
class FormBuilderPartialEntriesSession extends FormBuilderPartialEntries {

	/**
	 * Session key to use for partial entry data
	 *
	 */
	const sessionEntryKey = 'partialEntry';
	
	/**
	 * Init
	 *
	 */
	public function init() {
		parent::init();
		$entry = $this->processor->sessionGet(self::sessionEntryKey);
		if(is_array($entry)) {
			$entry['id'] = 0;
			$this->processor->setEntry($entry);
			$this->processor->populate($entry, 0);
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

		$entry = $this->processor->sessionGet(self::sessionEntryKey);
		if(!is_array($entry)) $entry = array();
		$entry = array_merge($entry, $data);

		if($finish) {
			$this->entryID = $this->processor->saveEntry($entry);
			$entry['id'] = $this->entryID;
			$this->processor->sessionRemove(self::sessionEntryKey);
		} else {
			$this->processor->sessionSet(self::sessionEntryKey, $entry);
		}
		
		return $entry;
	}
	
	/**
	 * Called by the render() method when pagination submitted, after input has been processed
	 *
	 * @param InputfieldForm $form
	 * @param int|bool $submitType Next (1), prev (-1), or jump (2) clicked, or final submit (true) clicked but with errors.
	 *
	 */
	public function processPagination(InputfieldForm $form, &$submitType) {
		parent::processPagination($form, $submitType);
	}

}

