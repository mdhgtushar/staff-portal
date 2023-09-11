<?php

namespace ProcessWire;

/**
 * ProcessWire Form Builder
 *
 * Provides the capability to build, edit and embed forms 
 * on your ProcessWire-powered web site. 
 *
 * Copyright (C) 2020 by Ryan Cramer Design, LLC
 * 
 * PLEASE DO NOT DISTRIBUTE
 * 
 * This file is commercially licensed and distributed.
 * 
 * 
 */

class FormBuilderMain implements \IteratorAggregate, \Countable
{

	/**
	 * Name used by our tables, pages and templates
	 *
	 * Also serves as the default embed tag (though user may change that)
	 *
	 */
	const name = 'form-builder';

	/**
	 * Name of table used for form schema
	 *
	 */
	const formsTable = 'forms';

	/**
	 * Default embed code used by the iframe embed options
	 *
	 * Tag {url} is replaced with the form's URL
	 *
	 */
	const embedCode = "<iframe src='{httpUrl}' id='FormBuilderViewport_{name}' class='FormBuilderViewport' data-form='{name}' title='{name}' frameborder='0' allowTransparency='true' style='width: 100%; height: 900px;'></iframe>";

	/**
	 * Copyright line, do not change or remove
	 *
	 */
	const RCD = 'ProcessWire Form Builder - Copyright 2020 by Ryan Cramer Design, LLC';

	/**
	 * User agent when submitting http requests
	 *
	 */
	const userAgent = 'ProcessWire/3 | FormBuilder/4';

	/**
	 * An array that holds just id (key) and name (value) for each form in the system
	 *
	 * We use this to quickly determine if a given id/name is used by a form.
	 *
	 */
	protected $formNames = array();

	/**
	 * Individual FormBuilderForm objects loaded during this request and indexed by ID (excluding those from loadAll)
	 * 
	 */
	protected $formsLoaded = array();

	/**
	 * Reference to PDO or WireDatabasePDO database instance
	 * 
	 * @var WireDatabasePDO|\PDO
	 *
	 */
	protected $database;

	/**
	 * Writable path where Form Builder files may be stored
	 *
	 */
	protected $filesPath;

	/**
	 * @var Config
	 * 
	 */
	protected $config;

	/**
	 * Names that may not be used for forms or fields
	 *
	 * Only necessary to include lowercase, as form field names can't contain uppercase
	 *
	 */
	protected $reservedNames = array(
		'name',
		'value',
		'field',
		'key',
		'id',
		'class',
		'style',
		'processor',
		'framework',
		'entries',
		'form',
		'input',
		'forms',
		'action',
		'action2',
		'action2_add',
		'action2_remove',
		'action2_rename',
		'method',
		'get',
		'post',
		'target',
		'honeypot',
		'type',
		'label',
		'description',
		'notes',
		'head',
		'parent',
		'required',
		'level',
		'children',
		'processor',
		'entries',
		'akismet',
		'created',
		'modified',
		'data',
	);

	/**
	 * @var ProcessWire
	 * 
	 */
	protected $wire;

	/**
	 * Construct FormBuilderMain and include related files
	 *
	 * @param ProcessWire $wire
	 * @param string $filesPath Path where form builder files can be stored
	 *
	 */
	public function __construct($wire, $filesPath)
	{

		$this->wire = $wire;
		$this->database = $wire->database;
		$this->config = $wire->config;
		$this->filesPath = self::parseFilesPath($filesPath);

		$dirname = dirname(__FILE__) . '/';
		require_once($dirname . 'FormBuilderException.php');
		require_once($dirname . 'FormBuilderData.php');
		require_once($dirname . 'FormBuilderField.php');
		require_once($dirname . 'FormBuilderForm.php');
		require_once($dirname . 'FormBuilderEntries.php');
		require_once($dirname . 'FormBuilderFramework.php');
		require_once($dirname . 'FormBuilderRender.php');
		require_once($dirname . 'FormBuilderEmail.php');
		require_once($dirname . 'InputfieldFormBuilder.php');
	}


	/**
	 * ProcessWire API access
	 * 
	 * @param string|Wire $key API variable name or Wire-derived object to dependency inject
	 * @return ProcessWire|Wire|null
	 *
	 */
	public function wire($key = '')
	{
		if (empty($key)) {
			return $this->wire;
		} else if (is_object($key) && $key instanceof Wire) {
			$key->setWire($this->wire);
			return $key;
		} else {
			return $this->wire->wire($key);
		}
	}

	/**
	 * Given a path with a potential {config.paths.$key} in it, parse it to an actual runtime path
	 * 
	 * @param string $path
	 * @return string
	 *
	 */
	static public function parseFilesPath($path)
	{

		if (strpos($path, '{') !== false && preg_match('/\{config\.paths\.([a-z]+)\}/', $path, $matches)) {
			$key = $matches[1];
			$path = str_replace($matches[0], wire('config')->paths->$key, $path);
		}

		// normalize trailing slash
		$path = rtrim($path, '/') . '/';

		// go to a default path if the specified one doesn't exist
		if (!is_dir($path)) $path = wire('config')->paths->cache . self::name . '/';

		return $path;
	}

	/**
	 * Get names for all forms indexed by id
	 * 
	 * @param int $id Optionally get name for only this form ID
	 * @return array|string
	 *
	 */
	public function getFormNames($id = 0)
	{
		if (!count($this->formNames)) {
			$query = $this->database->prepare("SELECT id, name FROM " . self::formsTable . " ORDER BY name");
			$query->execute();
			if ($query->rowCount()) {
				while ($row = $query->fetch(\PDO::FETCH_NUM)) {
					list($formID, $formName) = $row;
					$this->formNames[$formID] = $formName;
				}
			}
			$query->closeCursor();
		}
		if ($id) {
			return isset($this->formNames[$id]) ? $this->formNames[$id] : '';
		}
		return $this->formNames;
	}

	/**
	 * Given a form ID or name, returns true if is used by a form, false if not
	 *
	 * @param int|string $id May be form ID or form name
	 * @return bool
	 *
	 */
	public function isForm($id)
	{
		$name = '';
		if (strpos($id, ':')) list($id, $name) = explode(':', $id, 2);
		$formNames = $this->getFormNames();
		if (ctype_digit("$id")) return isset($formNames[(int)$id]);
		if (strlen($name) && in_array($name, $formNames)) return true;
		if (strlen($id)) return in_array($id, $formNames);
		return false;
	}

	/**
	 * Retrieve a form by $id or $name or boolean true to return all forms
	 *
	 * @param int|string|bool May be form ID or form name or specify boolean true to load all and return in name indexed array
	 * @return FormBuilderForm|array|null Returns $form on success, array if loading all, or NULL on failure to load
	 *
	 */
	public function load($id)
	{

		$loadAll = $id === true;
		$isIdName = is_string($id) && strpos($id, ':') !== false;

		if (!$loadAll) {
			// check if available in cache first
			if (ctype_digit("$id")) {
				$id = (int) $id;
				if (isset($this->formsLoaded[$id])) return $this->formsLoaded[$id];
			} else {
				$form = null;
				foreach ($this->formsLoaded as $fbForm) {
					if ($isIdName && $id === "$fbForm->id:$fbForm->name") {
						$form = $fbForm;
					} else if ($fbForm->name === $id) {
						$form = $fbForm;
					}
					if ($form) break;
				}
				if ($form) return $form;
			}
			if (!$this->isForm($id)) return null;
		}

		$bindValues = array();
		$forms = array();
		$form = null;

		$sql = "SELECT id, name, data FROM " . self::formsTable . ' ';

		if ($loadAll) {
			// all forms will be loaded

		} else if ($isIdName) {
			// ID and name, i.e. 123:form_name
			list($id, $name) = explode(':', $id);
			$bindValues['id'] = (int) $id;
			$bindValues['name'] = $name;
			$sql .= "WHERE name=:name OR id=:id";
		} else if (ctype_digit("$id")) {
			$id = (int) $id;
			if (!$id) return null;
			$bindValues['id'] = $id;
			$sql .= "WHERE id=:id";
		} else if (strlen($id)) {
			$name = preg_replace('/[^-_.a-z0-9]/i', '-', $id); // sanitize name
			$sql .= "WHERE name=:name";
			$bindValues['name'] = $name;
		} else {
			// no form specified
			return null;
		}

		$query = $this->database->prepare($sql);

		foreach ($bindValues as $key => $value) {
			$query->bindValue(":$key", $value);
		}

		$query->execute();

		if ($query->rowCount()) {
			while ($row = $query->fetch(\PDO::FETCH_NUM)) {
				list($id, $name, $data) = $row;
				$data = json_decode($data, true);
				if (!is_array($data)) $data = array();
				if (!isset($data['children'])) $data['children'] = array();
				$form = new FormBuilderForm($this);
				$form->set('id', $id);
				$form->set('name', $name);
				$form->setArray($data);
				if (!$loadAll) break;
				$forms[$name] = $form;
				// replace in cache, only if it was already present (avoiding multiple instances)
				if (isset($this->formsLoaded[$form->id])) $this->formsLoaded[$form->id] = $form;
			}
		}

		$query->closeCursor();

		if ($loadAll) return $forms;

		if ($form) $this->formsLoaded[$form->id] = $form;

		return $form;
	}

	/**
	 * Save the given $form 
	 *
	 * @param FormBuilderForm $form
	 * @return bool Returns true on success, false on failure
	 * @throws WireException
	 *
	 */
	public function save(FormBuilderForm $form)
	{
		if (!preg_match('/[-_a-z]/i', $form->name)) {
			throw new WireException(__('Form name must have at least one a-z letter in it.'));
		}
		$id = (int) $form->id;
		$data = $form->getArray();
		unset($data['name'], $data['type'], $data['id']);
		$sql = ($id ? "UPDATE" : "INSERT INTO") . " " . self::formsTable . " SET name=:name, data=:data " . ($id ? "WHERE id=:id" : '');
		$query = $this->database->prepare($sql);
		$query->bindValue(':name', $form->name, \PDO::PARAM_STR);
		$query->bindValue(':data', json_encode($data), \PDO::PARAM_STR);
		if ($id) $query->bindValue(':id', $id, \PDO::PARAM_INT);
		$query->execute();
		if (!$id) $form->id = $this->database->lastInsertId();
		$this->getFormNames();
		$this->formNames[$form->id] = $form->name;
		return true;
	}

	/**
	 * Add a new form with the given name
	 *
	 * @param string $formName Using characters: -_a-z0-9
	 * @return FormBuilderForm
	 * @throws WireException
	 *
	 */
	public function addNew($formName)
	{
		$formName = preg_replace('/[^-_.a-z0-9]/i', '-', $formName); // sanitize name
		if (!$formName) throw new WireException("No form name specified");
		$query = $this->database->prepare("INSERT INTO " . self::formsTable . " SET name=:name, data=''");
		$query->bindValue(':name', $formName, \PDO::PARAM_STR);
		$query->execute();
		$form = new FormBuilderForm($this);
		$form->id = $this->database->lastInsertId();
		$form->name = $formName;
		return $form;
	}

	/**
	 * Delete the given form
	 *
	 * @param int|string|FormBuilderForm $form May be a $form instance, an ID or a name
	 * @return bool Returns true on success, false on fail
	 * @throws \PDOException on failure
	 *
	 */
	public function delete(FormBuilderForm $form)
	{

		$id = $form->id;
		if (!$id) return false;

		try {
			$entries = new FormBuilderEntries($form, $this->database);
			$success = $entries->deleteAll();
			if (!$success) return false;

			$query = $this->database->prepare("DELETE FROM " . self::formsTable . " WHERE id=:id LIMIT 1");
			$query->bindValue(':id', $id, \PDO::PARAM_INT);
			$success = $query->execute();
		} catch (\Exception $e) {
			throw new FormBuilderException($e->getMessage(), $e->getCode(), $e);
		}

		if ($success) {
			$this->getFormNames();
			unset($this->formNames[$id]);
		}

		return $success;
	}

	/**
	 * Retrieve a form (alias of load)
	 * 
	 * @param string|int $key
	 * @return FormBuilderForm|null
	 *
	 */
	public function get($key)
	{
		if ($this->isForm($key)) $value = $this->load($key);
		else $value = null;
		return $value;
	}

	/**
	 * Convert given value to FormBuilderForm if it isn’t already
	 * 
	 * Throws FormBuilderException if given value cannot be converted to a FormBuilderForm
	 * 
	 * @param FormBuilderForm|InputfieldForm|string|int $form
	 * @param bool $throw Throw exception if form not found? If false, method returns false rather than throwing Exception (default=true)
	 * @return FormBuilderForm|bool
	 * @throws FormBuilderException
	 * 
	 */
	public function form($form, $throw = true)
	{
		$key = $form;
		if ($form instanceof InputfieldForm) $form = $form->name;
		if (!$form instanceof FormBuilderForm) $form = $this->load($form);
		if (!$form && $throw) throw new FormBuilderException("Unable to find form: $key");
		return $form ? $form : false;
	}

	/**
	 * Convert given value to form ID if is isn’t already
	 * 
	 * @param int|string|FormBuilderForm|InputfieldForm $formID
	 * @param bool $throw Throw exception if cannot resolve to form ID or does not exist? (default=true)
	 * @return int
	 * 
	 */
	public function formID($formID, $throw = true)
	{
		if ($formID instanceof FormBuilderForm) return $formID->id;
		if ($formID instanceof InputfieldForm) $formID = $formID->name;
		$formNames = $this->getFormNames();
		$id = 0;
		if (is_int($formID) || (is_string($formID) && ctype_digit($formID))) {
			if (isset($formNames[(int) $formID])) $id = (int) $formID;
		} else if ($formID && is_string($formID)) {
			$id = (int) array_search($formID, $formNames);
		}
		if (!$id && $throw) throw new FormBuilderException("Unable to find form ID: $formID");
		return $id;
	}

	/**
	 * Convert given value to form name if is isn’t already
	 *
	 * @param int|string|FormBuilderForm|InputfieldForm $formName
	 * @param bool $throw Throw exception if cannot resolve to form name or does not exist? (default=true)
	 * @return int
	 *
	 */
	public function formName($formName, $throw = true)
	{
		$name = '';
		$formNames = $this->getFormNames();

		if ($formName instanceof FormBuilderForm || $formName instanceof InputfieldForm) {
			if (array_search($formName->name, $formNames) !== false) $name = $formName->name;
		} else if (ctype_digit("$formName")) {
			$formID = (int) $formName;
			$name = isset($formNames[$formID]) ? $formNames[$formID] : '';
		} else {
			if (array_search($formName, $formNames) !== false) $name = $formName;
		}

		if ($name === '' && $throw) throw new FormBuilderException("Unable to find form name: $formName");

		return $name;
	}

	/**
	 * Given an entry array or ID return the FormBuilderForm object that it belongs to 
	 * 
	 * @param array|int $entry Entry array or ID (int)
	 * @return bool|FormBuilderForm Returns FormBuilderForm object or boolean false if not found
	 * 
	 */
	public function entryToForm($entry)
	{
		if (is_array($entry)) {
			if (!empty($entry['forms_id'])) return $this->form((int) $entry['forms_id']);
			if (empty($entry['id'])) return false;
			$entryID = (int) $entry['id'];
		} else if (is_int($entry) || ctype_digit($entry)) {
			$entryID = (int) $entry;
		} else {
			return false;
		}
		$query = $this->getDatabase()->prepare('SELECT forms_id FROM forms_entries WHERE id=:id');
		$query->bindValue(':id', $entryID, \PDO::PARAM_INT);
		$query->execute();
		if (!$query->rowCount()) return false;
		$formID = (int) $query->fetchColumn();
		$query->closeCursor();
		return $formID ? $this->form((int) $formID) : false;
	}

	/**
	 * Get a form entry by ID
	 * 
	 * @param int $entryID The ID of the entry you want to get
	 * @param FormBuilderForm|string|int $form Form object, name or ID, or omit to detect automatically from entry ID
	 * @return array|bool Returns entry array on success or boolean false if not found
	 * @since 0.4.4
	 * 
	 */
	public function getEntry($entryID, $form = 0)
	{
		$form = $form ? $this->form($form) : $this->entryToForm($entryID);
		if (!$form) return false;
		return $form->entries()->getById((int) $entryID);
	}

	/**
	 * Save a form entry
	 * 
	 * This is the same as $form->entries()->save($entry); except that the $form object can be 
	 * determined automatically when saving existing entries. 
	 * 
	 * @param array $entry
	 * @param int|string|FormBuilderForm $form Form or omit to determine automatically from entry
	 * @return bool|int Returns saved entry ID on success, boolean false on fail
	 * @throws FormBuilderException|\Exception
	 * @since 0.4.4
	 * 
	 */
	public function saveEntry(array $entry, $form = 0)
	{
		if (empty($entry)) return false;
		$form = $form ? $this->form($form) : $this->entryToForm($entry);
		if (empty($form)) return false;
		return $form->entries()->save($entry);
	}

	/**
	 * Find form entries across all forms (or on specific form if specified)
	 * 
	 * For more specific searches use `$form->entries()->find('selector string');`
	 * 
	 * @param string $keywords Phrase or keywords to find
	 * @param string $operator Operator to use for search (default='*=')
	 * @param int|string|FormBuilderForm $form Optionally limit search to given form id, name or object
	 * @return array
	 * @throws FormBuilderException
	 * 
	 */
	public function findEntries($keywords, $operator = '*=', $form = 0)
	{
		$form = $form ? $this->form($form) : null;
		$keywords = $this->wire()->sanitizer->selectorValue($keywords);
		if ($form) return $form->entries()->find("data$operator$keywords");
		$names = $this->getFormNames();
		$form = $this->form(reset($names));
		return $form->entries()->find("data$operator$keywords", array('allForms' => true));
	}

	/**
	 * Make this module iterable, as required by the IteratorAggregate interface
	 * 
	 * @return \ArrayObject
	 *
	 */
	public function getIterator(): \Traversable
	{
		return new \ArrayObject($this->getFormNames());
	}

	/**
	 * Return number of forms here, per Countable interface
	 *
	 */
	public function count(): int
	{
		return count($this->getFormNames());
	}

	/**
	 * Return the number of entries for the given form ID
	 * 
	 * @param int|string|FormBuilderForm $form
	 * @return int
	 *
	 */
	public function countEntries($form)
	{
		$form = $this->form($form);
		return $form->entries()->getTotal();
	}

	/**
	 * Return the JSON schema for the given form ID
	 * 
	 * @param int|string|FormBuilderForm $id
	 * @return string
	 *
	 */
	public function exportJSON($id)
	{
		$id = $this->formID($id);
		$query = $this->database->prepare("SELECT data FROM " . self::formsTable . " WHERE id=:id");
		$query->bindValue(':id', $id, \PDO::PARAM_INT);
		$query->execute();
		if (!$query->rowCount()) return '';
		list($data) = $query->fetch(\PDO::FETCH_NUM);

		if (defined("JSON_PRETTY_PRINT")) {
			$data = json_decode($data, true);
			$data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		}

		return $data;
	}

	/**
	 * Import the given JSON schema for the given form 
	 * 
	 * @param FormBuilderForm|string|int $id
	 * @param string $json
	 * @return bool
	 *
	 */
	public function importJSON($id, $json)
	{
		$id = $this->formID($id);
		$data = json_decode($json, true);
		$result = false;
		if ($data && array_key_exists('children', $data)) {
			// JSON is valid
			$query = $this->database->prepare("UPDATE " . self::formsTable . " SET data=:json WHERE id=:id");
			$query->bindValue(':json', $json, \PDO::PARAM_STR);
			$query->bindValue(':id', $id, \PDO::PARAM_INT);
			$result = $query->execute();
		}
		return $result;
	}

	/**
	 * Returns whether the given license key is valid for the domain its running on
	 *
	 * @param string $k
	 * @return bool
	 *
	 */
	public function isValidLicense($k = '')
	{
		return preg_match('/^[ADPSVEOR]\d{2,}$/', $this->getEmbedVersion($k));
	}

	/**
	 * Returns whether or not the given $name may be used or a form or field name
	 *
	 * @param string $name
	 * @return bool
	 *
	 */
	public function isReservedName($name)
	{
		return in_array($name, $this->reservedNames);
	}

	/**
	 * Return path that FormBuilder uses for storing files
	 *
	 * @param bool $tmp Whether to return the tmp path (default=false)
	 * @param bool $create Create if not exists? (default=true)
	 * @return string 
	 * @throws FormBuilderException
	 *
	 */
	public function getFilesPath($tmp = false, $create = true)
	{

		$path = $this->filesPath;
		if ($create && !is_dir($path)) wireMkdir($path);
		if ($tmp) {
			$path .= 'tmp/';
			if ($create && !is_dir($path)) wireMkdir($path);
		}

		if ($create && !is_dir($path)) throw new FormBuilderException("Unable to create: $path");
		if ($create && !is_writable($path)) throw new FormBuilderException("Unable to write to: $path");

		return $path;
	}

	/**
	 * Generate a transportable key for the given filename within a form and entry
	 *
	 * @param int|string|FormBuilderForm $formID
	 * @param int $entryID Or specify 0 if not yet an active entry
	 * @param string $filename
	 * @return bool|string Returns false on failure or string on success
	 *
	 */
	public function getFileKey($formID, $entryID, $filename)
	{
		$formID = $this->formID($formID);
		if (!is_file($filename)) return false;
		$key = "$formID,$entryID," . basename($filename) . "," . sha1_file($filename);
		return $key;
	}

	/**
	 * Retrieve a filename from a transportable key
	 *
	 * @param string $key Must be in the format given by getFileKey
	 * @return bool|string Returns boolean false on failure or full path+filename on success
	 *
	 */
	public function getFileFromKey($key)
	{

		if (!preg_match('/^(\d+),(\d+),([-_.a-zA-Z0-9]+),(.+)$/', trim($key), $matches)) return false;

		$formID = (int) $matches[1];
		if (!$formID) return false;

		$entryID = (int) $matches[2];
		$basename = $matches[3];
		$hash = $matches[4];
		$form = $this->load((int) $formID);

		if (!$form) return false;

		if ($form->emailFiles) {
			/** @var User $user */
			$user = $this->wire('user');
			if (!$user->isLoggedin() || !$user->hasPermission('form-builder')) {
				// form-builder permission required when emailFiles mode in use
				return false;
			}
		}

		if ($entryID) {
			$path = $form->entries()->getFilesPath($entryID);
			$filename = $path . $basename;
		} else {
			// $path = $this->getTempFilesPath();
			return false;
		}

		if (!is_file($filename)) return false;
		if (sha1_file($filename) !== $hash) return false;

		return $filename;
	}

	/**
	 * Return a URL where the given file can be viewed
	 *
	 * @param int|string|FormBuilderForm $formID
	 * @param int $entryID Or specify 0 if not yet an active entry
	 * @param string $filename
	 * @return bool|string Returns false on failure or URL on success
	 *
	 */
	public function getFileURL($formID, $entryID, $filename)
	{
		$key = $this->getFileKey($formID, $entryID, $filename);
		if (!$key) return false;
		$page = $this->wire()->pages->get("template=" . self::name);
		if (!$page->id) return false;
		return $page->httpUrl() . "?view_file=$key";
	}

	public function getEmbedVersion($v = '')
	{
		/** @var FormBuilder $forms */
		$forms = $this->wire('forms');
		return $forms->getEmbedVersion($v);
	}

	/**
	 * Outputs the given file, must be located under getFilesPath()
	 *
	 * @param string $key Key representing the file to view (generated by getFileKey) 
	 * @return bool Returns false on failure. On success, it exists program execution.
	 *
	 */
	public function viewFile($key)
	{

		$filename = $this->getFileFromKey($key);
		if (!$filename || !is_file($filename)) return false;

		$filesize = filesize($filename);
		$info = pathinfo($filename);
		$ext = $info['extension'];

		$contentTypes = array(
			'pdf' => 'application/pdf',
			'doc' => 'application/msword',
			'docx' => 'application/msword',
			'xls' => 'application/excel',
			'xlsx' => 'application/excel',
			'rtf' => 'application/rtf',
			'gif' => 'image/gif',
			'jpg' => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'png' => 'image/x-png',
		);

		// types that won't trigger a 'save' dialog and instead will just display
		// @todo make this configurable in module settings
		$nonDownloadTypes = array('gif', 'jpg', 'jpeg', 'png', 'svg');

		if (isset($contentTypes[$ext])) $contentType = $contentTypes[$ext];
		else $contentType = 'application/octet-stream';

		if (ini_get('zlib.output_compression')) ini_set('zlib.output_compression', 'Off');

		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: $contentType");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: $filesize");

		if (!in_array($ext, $nonDownloadTypes)) {
			header("Content-Disposition: attachment; filename=\"$info[basename]\"");
		}

		ob_clean();
		flush();
		readfile($filename);

		exit;
	}

	/**
	 * Get path for 'themes' or 'frameworks' helpers
	 * 
	 * @param string $for Either 'themes' or 'frameworks'
	 * @param string $item Optionaly framework or theme
	 * @return string
	 * 
	 */
	public function helperPath($for, $item = '')
	{
		// attempt to locate in /site/templates/FormBuilder/themes/
		$path = $this->config->paths->templates . "FormBuilder/$for/";
		if ($item) $path .= "$item/";
		if (is_dir($path)) return $path;

		// attempt to locate in /site/modules/FormBuilder/themes/	
		$path = $this->config->paths->get('FormBuilder') . "$for/";
		$_path = $path;
		if ($item) $path .= "$item/";
		if (is_dir($path)) return $path;

		if ($item) {
			// directory for theme was not found, substitute default
			$this->error("Unable to locate directory for theme '$item'");
			return $_path . "$item/";
		}

		return $_path;
	}

	/**
	 * Get URL for 'themes' or 'frameworks' helpers
	 *
	 * @param string $for Either 'themes' or 'frameworks'
	 * @param string $item Optionaly framework or theme
	 * @return string
	 *
	 */
	public function helperURL($for, $item = '')
	{
		// attempt to locate in /site/templates/FormBuilder/themes/
		$path = $this->config->paths->templates . "FormBuilder/$for/";
		if ($item) $path .= "$item/";
		if (is_dir($path)) {
			$url = $this->config->urls->templates . "FormBuilder/$for/";
			if ($item) $url .= "$item/";
			return $url;
		}

		// attempt to locate in /site/modules/FormBuilder/themes/
		if ($item) {
			$path = $this->config->paths->get('FormBuilder') . "$for/$item/";
			if (is_dir($path)) {
				return $this->config->urls->get('FormBuilder') . "$for/$item/";
			} else {
				// if theme can't be found even here, substitute default theme
				$this->error("Unable to locate directory for '$item'");
				return $this->config->urls->get('FormBuilder') . "$for/$item/";
			}
		}

		return $this->config->urls->get('FormBuilder') . "$for/";
	}

	/**
	 * Get all 'themes' or 'frameworks' files
	 * 
	 * @param $for string Specify 'themes' or 'frameworks'
	 * @param bool $getDirs Specify true to return directories, or false to return files
	 *
	 * @return array
	 * 
	 */
	public function getHelpers($for, $getDirs = true)
	{
		$dir = new \DirectoryIterator($this->helperPath($for));
		$files = array();
		foreach ($dir as $file) {
			$basename = $file->getBasename();
			if ($file->isDot()) continue;
			if ($getDirs && !$file->isDir()) continue;
			if (!$getDirs && $file->isDir()) continue;
			if (substr($basename, 0, 1) !== '.') {
				$files[] = $basename;
			}
		}
		sort($files);
		return $files;
	}

	/**
	 * Return the path where themes are stored
	 *
	 * If the dir /site/templates/FormBuilder/themes/ exists, it will use that.
	 * Otherwise it uses /site/modules/FormBuilder/themes/
	 *
	 * @param string $theme Optionally specify the theme and it will be included in the path
	 * @return string
	 *
	 */
	public function themesPath($theme = '')
	{
		return $this->helperPath('themes', $theme);
	}

	/**
	 * Return the path where frameworks are stored
	 *
	 * If the dir /site/templates/FormBuilder/frameworks/ exists, it will use that.
	 * Otherwise it uses /site/modules/FormBuilder/frameworks/
	 *
	 * @return string
	 *
	 */
	public function frameworksPath()
	{
		return $this->helperPath('frameworks');
	}

	/**
	 * Return the URL where themes are stored
	 *
	 * If the dir /site/templates/FormBuilder/themes/ exists, it will use that.
	 * Otherwise it uses /site/modules/FormBuilder/themes/
	 *
	 * @param string $theme Optionally specify the theme and it will be included in the url
	 * @return string
	 *
	 */
	public function themesURL($theme = '')
	{
		return $this->helperURL('themes', $theme);
	}

	/**
	 * Return the URL where frameworks are stored
	 *
	 * If the dir /site/templates/FormBuilder/frameworks/ exists, it will use that.
	 * Otherwise it uses /site/modules/FormBuilder/frameworks/
	 *
	 * @return string
	 *
	 */
	public function frameworksURL()
	{
		return $this->helperURL('frameworks');
	}

	/**
	 * Get the framework used by the given $form
	 *
	 * Also prepares the framework with it's config values populated
	 *
	 * @param FormBuilderForm|int|string $form
	 * @return FormBuilderFramework|null
	 *
	 */
	public function getFramework($form)
	{
		static $frameworks = array();
		$form = $this->form($form);
		if (!$form->framework) $form->framework = 'Legacy';
		$name = $form->name ? $form->name : $form->framework;
		if (isset($frameworks[$name])) return $frameworks[$name];
		$class = "FormBuilderFramework$form->framework";
		$nsClass = wireClassName($class, true);
		$file = $this->frameworksPath() . "$class.php";
		if (!file_exists($file)) return null;
		/** @noinspection PhpIncludeInspection */
		include_once($file);
		/** @var FormBuilderFramework $framework */
		$framework = new $nsClass($form);
		$prefix = $framework->getPrefix();
		foreach ($framework->getConfigDefaults() as $key => $unused) {
			$property = $prefix . $key;
			$value = $form->$property;
			if ($value !== null) $framework->set($key, $value);
		}
		$frameworks[$name] = $framework;
		return $framework;
	}

	/**
	 * Error message
	 * 
	 * @param string $str
	 * 
	 */
	public function error($str)
	{
		wire('modules')->get('FormBuilder')->error($str);
	}

	/**
	 * Direct access properties
	 *
	 * @param string $key
	 * @return WireDatabasePDO|null
	 * 
	 */
	public function __get($key)
	{
		if ($key == 'database') return $this->database;
		return null;
	}

	/**
	 * Get the $database API var
	 * 
	 * @return \PDO||WireDatabasePDO
	 * 
	 */
	public function getDatabase()
	{
		return $this->database;
	}

	/**
	 * Get any FormBuilderForm object that were loaded during this request
	 * 
	 * @return array
	 * @since 0.4.0
	 * 
	 */
	public function _getFormsLoaded()
	{
		return $this->formsLoaded;
	}

	/**
	 * Install the tables
	 *
	 */
	public function _install()
	{

		$engine = $this->wire()->config->dbEngine;
		$charset = $this->wire()->config->dbCharset;

		$sql =
			"CREATE TABLE " . self::formsTable . " (" .
			"id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, " .
			"name VARCHAR(128) NOT NULL, " .
			"data MEDIUMTEXT NOT NULL, " .
			"UNIQUE name (name)" .
			") ENGINE=$engine DEFAULT CHARSET=$charset ";

		try {
			$this->database->exec($sql);
		} catch (\Exception $e) {
			wire('modules')->error($e->getMessage());
		}

		FormBuilderEntries::_install($this->database);
	}

	/**
	 * Uninstall the tables
	 *
	 */
	public function _uninstall()
	{
		try {
			$this->database->exec("DROP TABLE " . self::formsTable);
			FormBuilderEntries::_uninstall(wire('database'));
		} catch (\Exception $e) {
			// just catch, no need to do anything else
		}
	}
}
