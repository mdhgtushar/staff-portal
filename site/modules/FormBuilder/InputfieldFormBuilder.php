<?php namespace ProcessWire;

/**
 * Interface for an Inputfield module specific to use with Form Builder
 *
 * Inputfields that implement this interface will have the following values 
 * set to their set() method: 
 *
 * formID - ID of the FormBuilderForm
 * entryID - ID of the associated entry, if applicable
 * processor - Instance of FormBuilderProcessor that is processing the form.
 *
 */

interface InputfieldFormBuilderInterface {
	public function __construct();
}

/**
 * Optional starter class that implements the above interface
 * 
 * @property int $formID
 * @property int $entryID
 * @property FormBuilderProcessor|null $processor
 * 
 *
 */
abstract class InputfieldFormBuilder extends Inputfield implements InputfieldFormBuilderInterface {

	/**
	 * @var null|FormBuilderForm
	 * 
	 */
	protected $fbForm = null;

	/**
	 * Construct
	 * 
	 */
	public function __construct() {
		parent::__construct();
		$this->set('formID', 0);
		$this->set('entryID', 0);
		$this->set('processor', null);
	}

	/**
	 * @return FormBuilderForm|null
	 * 
	 */
	public function getFbForm() {
		$fbForm = null;
		if($this->fbForm) {
			// ok 
		} else if($this->processor) {
			$this->fbForm = $this->processor->getFbForm();
		} else if($this->formID) {
			$forms = $this->wire()->forms; /** @var FormBuilder $forms */
			if($forms) $this->fbForm = $forms->load($this->formID);
		}
		return $this->fbForm;
	}

	/**
	 * @return null|FormBuilderProcessor
	 * 
	 */
	public function getProcessor() {
		if(!$this->processor) {
			$form = $this->getFbForm();
			if($form) $this->processor = $form->processor();
		}
		return $this->processor;
	}
	
}
