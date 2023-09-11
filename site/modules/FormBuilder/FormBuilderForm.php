<?php namespace ProcessWire;

/**
 * ProcessWire Form Builder Form
 *
 * Serves as container form for FormBuilderField objects. 
 * It is an intermediary between the JSON/array form and Inputfields.
 *
 * Copyright (C) 2020 by Ryan Cramer Design, LLC
 * 
 * PLEASE DO NOT DISTRIBUTE
 * 
 * This file is commercially licensed, distributed and supported.
 * 
 * @property-read FormBuilderMain $forms
 * @property-read FormBuilderRender|null $fbRender
 * @property string $_styles Runtime property for frameworks to populate inline styles. 
 * @property int $mobilePx Mobile responsive breakpoint.
 * @property int $id
 * @property string $name
 * @property string $type
 * @property int $flags 2=pagination, 4=partial
 * @property string $action
 * @property string $method
 * @property string $target
 * @property array $roles
 * @property string $theme
 * @property string $framework
 * @property int $numEntries
 * @property string $lastEntryDate
 * @property string $firstEntryDate
 * @property int $numFields
 * @property array $pluginActions
 * 
 * @property int $saveFlags Bitwise flags for save actions
 * @property bool|int $allowPreset Preset field values from GET variables?
 * @property bool|int $skipSessionKey Disable session tracking and CSRF protection?
 * @property bool|int $useCookies Remember form values in cookies?
 * 
 * @property string $honeypot Name of honeypot field
 * @property string $turingTest
 * @property string $akismet CSV data for Akismet
 * @property array $listFields Field names to show in entries list
 * @property int $entryDays Maximum days an entry is allowed to be saved in the system
 * 
 * @property string $emailTo Email address, addresses, or format string to send form results to
 * @property string $emailFrom Email reply-to address (also used as from address if emailFrom2 not specified)
 * @property string $emailFrom2 Email from address (if different from emailFrom)
 * @property string $emailSubject Email subject line
 * @property int|bool $emailFiles Email files as attachments?
 * 
 * @property string $responderTo Field that will contain submitters email address (CSV string for multiple)
 * @property string $responderFrom Responder from address
 * @property string $responderFromName Responder from "name"
 * @property string $responderReplyTo Reply-to email address for auto-responder
 * @property string $responderSubject Subject of auto-responder
 * @property string $responderBody Body of auto-responder
 * 
 * @property string $action2 Duplicate submission URL
 * @property string $action2_add Add fields to duplicate submission (textarea format string)
 * @property string $action2_remove Newline separated field names to remove from duplicate submission
 * @property string $action2_rename Key=value format string of fields to rename in duplicate submission, one per line. 
 * 
 * @property string $submitText Default submit button text
 * @property string $nextText Default “next” button text
 * @property string $backText Default “back” button text
 * @property string $successMessage
 * @property string $errorMessage
 * 
 * @property int $savePageTemplate
 * @property int $savePageParent
 * @property array $savePageFields
 * @property int $savePageStatus
 * 
 * @property string|null $googleSpreadsheetUrl
 * @property array|null $googleSpreadsheetFields
 * @property string $googleSheetsResponseField
 * 
 * @property bool|int submitNotify Notify user if they attempt to leave the form without submitting after making changes to it? (default=0)
 * @property int $hLevel Headline level (used above forms with pagination, 0=off)
 * @property int $showNav Use select nav above paginations? 0=off, 1=before headline, 2=after healdline, 3=after description
 * @property int $partialEntryType Storage type to use for partial entries (0=session, 1=database)
 * @property int $partialEntryDays Maximum days to allow an incomplete/partial entry to exist in the system (default=14)
 * 
 * 
 */

class FormBuilderForm extends FormBuilderField {

	/**
	 * Reference to FormBuilderMain
	 * 
	 * @var FormBuilderMain|null
	 *
	 */
	protected $forms = null;

	/**
	 * Reference to FormBuilderEntries instance, when cached. 
	 * 
	 * @var null|FormBuilderEntries
	 *
	 */
	protected $entries = null;

	/**
	 * Reference to FormBuilderProcessor instance, when cached. 
	 * 
	 * @var null|FormBuilderProcessor
	 *
	 */
	protected $processor = null;

	/**
	 * Reference to FormBuilderRender, when applicable
	 * 
	 * @var null|FormBuilderRender
	 * 
	 */
	protected $fbRender = null;

	/**
	 * Number of page breaks (paginations) present on this form
	 * 
	 * @var int
	 * 
	 */
	protected $numPaginations = 1;
	
	/**	
	 * Form specific permission definitions
	 *
	 */
	protected $defaultRoles = array(
		'form-submit' => array('guest'),
		'form-list' => array(),
		'form-edit' => array(),
		'form-delete' => array(),
		'entries-list' => array(),
		'entries-edit' => array(),
		'entries-delete' => array(),
		'entries-page' => array(),
		'entries-resend' => array()
	);

	/**
	 * Construct the form and set initial values
	 * 
	 * @param FormBuilderMain $forms
	 *
	 */
	public function __construct(FormBuilderMain $forms) {
		$this->forms = $forms; 
		parent::__construct();

		$this->setWire($forms->wire());
		$this->set('id', 0); 
		$this->set('type', 'Form'); 
		$this->set('action', './');
		$this->set('method', 'post');
		$this->set('roles', $this->defaultRoles);
		$this->set('flags', 0);
		$this->set('pluginActions', array());

		// note that several other values may be set to the Form
		// like submitText, successMessage, etc. 
		// that are ultimately passed through to the FormBuilderProcessor
	}
	
	/**
	 * Set form name
	 *
	 * @param string $name
	 * @return FormBuilderData
	 *
	 */
	public function setName($name) {
		parent::setName($name);
		parent::allFields($this);
		return $this;
	}
	
	/**
	 * Add a new child to this form/field
	 *
	 * @param FormBuilderField $child
	 * @return FormBuilderForm|FormBuilderField
	 *
	 */
	public function add(FormBuilderField $child) {
		if($child->type == 'FormBuilderPageBreak') $this->numPaginations++;
		return parent::add($child);
	}

	/**
	 * Save this form
	 *
	 */
	public function save() {
		return $this->forms->save($this);
	}

	/**
	 * Render this form's output and/or process if it has been posted.
	 *
	 * @return string
	 *
	 */ 
	public function render() {
		return $this->processor()->render();
	}

	/**
	 * Get processor for this form
	 *
	 * @param array|bool $options Specify array of options or boolean for $reset option. Available options:
	 *  - `reset` (bool): Set to true to return a new instance, otherwise uses existing instance, if present (default=false). 
	 *  - `[any]` (mixed): Any option you want sent to processor (see phpdoc properties at top of FormBuilderProcessor class).
	 * @return FormBuilderProcessor
	 *
	 */
	public function processor($options = array()) {
		$defaults = array(
			'reset' => is_bool($options) ? $options : false, 
		);
		$options = is_array($options) ? array_merge($defaults, $options) : $defaults;
		if(!$this->processor || $options['reset']) {
			require_once(dirname(__FILE__) . '/FormBuilderProcessor.php');
			unset($options['reset']);
			$this->processor = new FormBuilderProcessor($this, $options); 
		}
		if($this->fbRender) {
			$this->processor->setFbRender($this->fbRender);
		}
		return $this->processor;
	}

	/**
	 * Get this form's FormBuilderEntries instance
	 *
	 * @return FormBuilderEntries
	 *
	 */
	public function entries() {
		if($this->entries) return $this->entries; 
		require_once(dirname(__FILE__) . '/FormBuilderEntries.php'); 
		/** @var WireDatabasePDO $database */
		$database = $this->forms->getDatabase();
		$this->entries = new FormBuilderEntries($this, $database);
		return $this->entries; 
	}

	/**
	 * Was the form submitted?
	 *
	 * @return bool
	 *
	 */
	public function isSubmitted() {
		return $this->processor()->isSubmitted();
	}

	/**
	 * Return a list of errors that occurred, if submitted.
	 *
	 * @return array
	 *
	 */
	public function getErrors() {
		return $this->processor()->getErrors();
	}

	/**
	 * Ensure that direct access to 'processor' or 'entries' goes to the right place
	 * 
	 * @param string $key
	 * @return mixed
	 *
	 */
	public function get($key) {
		switch($key) {
			case 'form':
			case 'fbForm':	
				$value = $this;
				break;
			case 'forms':
				$value = $this->forms;
				break;
			case 'fbRender':	
				$value = $this->fbRender;
				break;
			case 'processor':
				$value = $this->processor();
				break;
			case 'entries':
				$value = $this->entries();
				break;
			case 'numEntries':
				$value = $this->entries()->getTotal();
				break;
			case 'numFields':
				$value = count($this->getChildrenFlat());
				break;
			case 'lastEntryDate':
				$value = $this->entries()->getLastEntryDate();
				break;
			case 'firstEntryDate':
				$value = $this->entries()->getLastEntryDate(true);
				break;
			case 'allFieldsQty':
				$value = count(parent::allFields());
				break;
				
			default:
				$value = parent::get($key);
		}
		return $value;
	}

	public function set($key, $value) {
		if($key == 'roles') {
			if(!is_array($value)) $value = array();	
			$value = array_merge($this->defaultRoles, $value);
		}
		return parent::set($key, $value);
	}

	/**
	 * Does current user have requested permission to this form? 
	 * 
	 * @param string $name
	 * @return bool
	 * 
	 */
	public function hasPermission($name) {
		$forms = wire('forms');
		/** @var FormBuilder $forms */
		return $forms->hasPermission($name, $this); 
	}
	
	public function getFramework() {
		return $this->forms->getFramework($this);
	}

	/**
	 * Set the FormBuilderRender
	 *
	 * @param FormBuilderRender $fbRender
	 *
	 */
	public function setFbRender(FormBuilderRender $fbRender) {
		$this->fbRender = $fbRender;
	}

	/**
	 * Get the FormBuilderRender used by this form (when available)
	 *
	 * @return FormBuilderRender|null
	 *
	 */
	public function getFbRender() {
		return $this->fbRender;
	}

	/**
	 * Get array of fields having type FormBuilderPageBreak, indexed by page number
	 * 
	 * Returns empty array if there are no page breaks
	 * 
	 * @return array
	 * @since 0.4.0
	 * 
	 */
	public function getPageBreakFields() {
		if($this->numPaginations < 2) return array();
		$items = array();
		$pageNum = 0;
		foreach($this->children() as $child) {
			if($child->type != 'FormBuilderPageBreak') continue;
			$items[++$pageNum] = $child;
		}
		return $items;
	}

	/**
	 * Return quantity of paginations found in form
	 * 
	 * @return int
	 * @since 0.4.0
	 * 
	 */
	public function getNumPaginations() {
		return $this->numPaginations;
	}

	/**
	 * Does form having a field with given nane?
	 * 
	 * @param string $name
	 * @return bool
	 * @since 0.4.4
	 * 
	 */
	public function hasField($name) {
		$field = $this->getFieldByName($name);
		return $field ? true : false;
	}

	/**
	 * Does this form have the given flag?
	 * 
	 * @param int $flag
	 * @param string $property
	 * @return int
	 * @since 0.4.0
	 * 
	 */
	public function hasFlag($flag, $property = 'flags') {
		$flag = (int) $flag;
		$flags = (int) $this->getSetting($property);
		return $flags & $flag;
	}

	/**
	 * Add flag to form
	 * 
	 * @param $flag
	 * @param string $property
	 * @since 0.4.0
	 * 
	 */
	public function addFlag($flag, $property = 'flags') {
		$flag = (int) $flag;
		if($this->hasFlag($flag, $property)) return;
		$flags = (int) $this->getSetting($property);
		$this->set($property, $flags | $flag);
	}

	/**
	 * Remove flag from form 
	 * 
	 * @param $flag
	 * @param string $property
	 * @since 0.4.0
	 * 
	 */
	public function removeFlag($flag, $property = 'flags') {
		if(!$this->hasFlag($flag)) return;
		$flags = (int) $this->getSetting($property);
		$this->set($property, $flags & ~$flag);
	}

	/**
	 * Get new InputfieldForm for this FormBuilderForm
	 *
	 * Please note:
	 *  - Returns a new InputfieldForm instance on every call.
	 *  - This method is very similar to FormBuilderMaker::makeInputfieldForm() and should mirror most of what it does,
	 *    but the context is different enough that they need to be separate methods. The context of this method
	 *    is more specific to public API usage or other cases where an InputfieldForm is needed, but we are not in a
	 *    case where an entire form will be rendered or processed.
	 *
	 * @param array $options
	 *  - `language` (Language|int|string): Optionally get for this non-default language
	 * @return InputfieldForm|Inputfield
	 * @since 0.4.4
	 *
	 */
	public function getInputfield(array $options = array()) {
		// $options['type'] = 'InputfieldForm';
		$f = parent::getInputfield($options);
		return $f;
	}

}

