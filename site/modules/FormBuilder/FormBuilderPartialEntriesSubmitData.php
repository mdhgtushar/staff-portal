<?php namespace ProcessWire;

/**
 * FormBuilder Partial Entries: Submit Data (not currently used)
 * 
 * Stores partial entry in JSON encoded hidden input.
 *
 *
 */
class FormBuilderPartialEntriesSubmitData extends FormBuilderPartialEntries {

	/**
	 * Submit data when pagination is active (NOT-sanitized)
	 *
	 * @var array
	 *
	 */
	protected $submitData = array();


	public function init() {
		parent::init();
		// needs implementation
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

		// store partial entry in JSON encoded submitData (not currenty used)
		$data['id'] = 0;
		$entry = array_merge($this->submitData, $data);

		if($finish) {
			$this->entryID = $this->processor->saveEntry($entry);
			$entry['id'] = $this->entryID;
		} else {
			$this->submitData = $entry;
		}

		return $entry;
	}

	/**
	 * Method called when form’s input is ready to be processed
	 *
	 * @param InputfieldForm $form
	 *
	 */
	public function processInputReady(InputfieldForm $form) {
		if($form) {} // ignore
		// parent::processInputReady($form);
		$this->processSubmitData();
	}

	/**
	 * Method called when form’s input is done being processed
	 *
	 * @param InputfieldForm $form
	 *
	 */
	public function processInputDone(InputfieldForm $form) {
		// parent::processInputDone($form);
		// populate processed form field values to pagination submitData
		foreach($form->getAll() as $f) {
			if($f instanceof InputfieldWrapper || $f instanceof InputfieldSubmit) continue;
			$this->submitData($f->name, $f->value);
		}
	}

	/**
	 * Render additional JSON encoded data in hidden field (_submitData) to accompany form fields
	 *
	 * @return string
	 * @throws WireException
	 *
	 */
	public function renderSubmitData() {

		if(!count($this->submitData)) return '';

		$value = json_encode($this->submitData);
		$key = 'submitDataHashes';
		$hashes = $this->processor->sessionGet($key);
		if(!is_array($hashes)) $hashes = array();
		if(count($hashes) >= 100) $hashes = array_slice($hashes, -99);
		$hashes[] = sha1($value);
		$this->processor->sessionSet($key, $hashes);
		$value = $this->wire('sanitizer')->entities($value);

		return "<input type='hidden' name='_submitData' value='$value' />";
	}

	/**
	 * Process validate submitData in post request
	 *
	 * @param bool $validate Validate submit data with server side hash of previously known value?
	 * @return bool
	 *
	 */
	protected function processSubmitData($validate = false) {

		/** @var WireInput $input */
		$input = $this->wire('input');
		$submitData = $input->post('_submitData');
		if(empty($submitData)) return false;
		$this->submitData = array();

		if($validate) {
			$submitHash = sha1($submitData);
			$submitHashes = $this->processor->sessionGet('submitDataHashes');
			if(!is_array($submitHashes) || !in_array($submitHash, $submitHashes)) {
				$this->processor->adminError("Invalid _submitData (appears to have been modified)");
				return false;
			}
		}

		// populate submitData to POST data
		$submitData = json_decode($submitData, true);
		if(!is_array($submitData)) return false;

		$this->submitData = $submitData;

		foreach($submitData as $key => $value) {
			if($value !== null && $input->post($key) === null) {
				$input->post->$key = $value;
			}
		}

		return true;
	}

	/**
	 * Get or set submitData that is used for holding values in paginations
	 *
	 * @param string|bool|array|null $key
	 * @param string|bool|int|array|null $value
	 * @return array|bool|string|int|null
	 *
	 */
	public function submitData($key = null, $value = null) {

		if(is_array($key)) {
			// set all
			$this->submitData = $key;

		} else if(empty($key)) {
			// get all
			return $this->submitData;

		} else if($key === true && is_bool($value)) {
			// reset all
			$this->submitData = array();
			return true;

		} else if($key === true) {
			// reset property
			if(isset($this->submitData[$value])) {
				unset($this->submitData[$value]);
				return true;
			} else {
				return false;
			}
		} else if($value !== null) {
			// set property
			$this->submitData[$key] = $value;
			return true;

		} else if(isset($this->submitData[$key])) {
			// get property
			return $this->submitData[$key];
		}

		return null;
	}

}

