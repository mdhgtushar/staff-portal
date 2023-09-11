<?php namespace ProcessWire;

/**
 * ProcessWire Form Builder Entries/Results
 *
 * Copyright (C) 2020 by Ryan Cramer Design, LLC
 * 
 * PLEASE DO NOT DISTRIBUTE
 * 
 * This file is commercially licensed.
 * 
 * @method int|bool save(array $data)
 * @method bool saveField($id, $name, $value)
 * @method int|bool delete(int $id)
 * @method bool deleteAll()
 * @method exportCSV(FormBuilderForm $form, $selectorString, $filename = 'export.csv', $delimiter = ',', $useBOM = false)
 * @method int deleteOlderThan($age, $ageType = 'DAYS', $dateColumn = 'created', $flags = 0)
 * @method void deleted(array $entryIDs) Hook called after one or more entries are deleted
 * @method string getFilesPath($entryID = 0, $create = true, $formID = 0)
 * 
 */

class FormBuilderEntries extends Wire {

	/**
	 * Name of DB table created/used by this class
	 *
	 */
	const entriesTable = 'forms_entries';

	/**
	 * Flag indicates entry is a partial entry
	 * 
	 */
	const flagPartial = 1;

	/**
	 * Flag indicates entry is spam (@todo needs implementation)
	 * 
	 */
	const flagSpam = 16; 

	/**
	 * Required length for entryStr property
	 * 
	 */
	const entryStrLength = 30;

	/**
	 * ID of form these entries are for
	 *
	 */
	protected $forms_id = 0;

	/**
	 * Total entries found (sans pagination) from the last find() call, for getLastTotal() method.
	 *
	 */
	protected $lastTotal = 0;

	/**
	 * Default date format used for entry dates
	 *
	 * 
	 */
	protected $dateFormat = '';

	/**
	 * Database reference
	 * 
	 * @var WireDatabasePDO
	 *
	 */
	protected $database = null;

	/**
	 * MySQL version
	 * 
	 * @var int
	 * 
	 */
	protected $mySqlVersion = 0;

	/**
	 * @var FormBuilderForm|null
	 * 
	 */
	protected $form = null;

	/**
	 * Reserved property names in entries
	 * 
	 * @var array
	 * 
	 */
	protected $reservedProperties = array(
		'id', 
		'entryID',
		'entryFlags',
		'entryStr',
		'entryName',
		'created',
		'modified',
		'_savePage',
		'_savePageTime',
	);

	/**
	 * Construct the Form entries
	 * 
	 * @param int|FormBuilderForm $form
	 * @param WireDatabasePDO $database
	 *
	 */
	public function __construct($form, $database = null) {
		if(is_object($form)) {
			$this->forms_id = (int) $form->id;
			$this->form = $form;
		} else {
			$this->forms_id = (int) $form;
		}
		$this->database = $database; 
		$this->dateFormat = $this->_('Y-m-d H:i:s'); // date format for entries
	}
	
	/**
	 * @return WireDatabasePDO
	 * @since 0.4.2
	 * 
	 */
	public function database() {
		if(!$this->database) $this->database = $this->wire('database');
		return $this->database;
	}

	/**
	 * Convert a DB entry row to a FormBuilder entry
	 *
	 * @param array $row Database row that represents entry
	 * @param string $getCol 
	 * @return array
	 *
	 */
	protected function wakeupEntry(array $row, $getCol = '') {
		
		$data = json_decode($row['data'], true);
		
		if(!empty($row['forms_id']) && $row['forms_id'] != $this->forms_id) {
			$form = $this->wire()->forms->load((int) $row['forms_id']); 
		} else {
			$form = $this->getForm();
		}

		$entry = array(
			'id' => (int) $row['id'], 
			'forms_id' => (int) $row['forms_id'],
			'created' => date($this->dateFormat, strtotime($row['created'])),
			'modified' => isset($row['modified']) ? date($this->dateFormat, strtotime($row['modified'])) : $data['created'],
			'entryFlags' => isset($row['flags']) ? (int) $row['flags'] : 0,
			'entryStr' => isset($row['str']) ? $row['str'] : '',
		);
		
		if($getCol && isset($entry[$getCol])) return $entry;
		
		foreach($data as $fieldName => $value) {
			if($getCol && $fieldName !== $getCol) continue;
			if(is_array($value)) {
				// wakeup array value
				$field = $form->find($fieldName);
				if($field && $field->type == 'FormBuilderFile') {
					// ensure file field paths are up-to-date with current FormBuilder setting
					$value = $this->wakeupEntryFiles($value, $entry['id'], $form->id);
				}
			}
			$entry[$fieldName] = $value;
		}
		
		return $entry;
	}

	/**
	 * Initialize paths for InputfieldFormBuilderFile fields in an entry 
	 * 
	 * @param array $files
	 * @param int $entryID
	 * @param int $formID
	 * @return array
	 * 
	 */
	protected function wakeupEntryFiles(array $files, $entryID, $formID) {
		
		$entrySegments = "/form-$formID/entry-$entryID/";
		$entryFilesPath = $this->getFilesPath($entryID, false, $formID);
		
		if(!is_dir($entryFilesPath)) return $files;
		
		foreach($files as $key => $pathname) {
			
			if(strpos($pathname, '/') === false) {
				// just a basename, convert to pathname 
				// this is the case for all entries saved in FB 0.4.4 and newer
				$file = $pathname; 
				
			} else {
				// if path is already correct, leave it alone
				if(strpos($pathname, $entryFilesPath) === 0) continue;

				// if something we do not recognize, leave it alone
				if(strpos($pathname, $entrySegments) === false) continue;

				list(/*$path*/, $file) = explode($entrySegments, $pathname);
			}

			// ensure file uses correct path
			$files[$key] = $entryFilesPath . $file;
		}
		
		return $files;
	}
	
	/**
	 * Wakeup entry but get only a specific column/field from it
	 *
	 * @param array $row
	 * @param string $getCol
	 * @return array|bool|int|string|float Returns boolean false if col not found
	 *
	 */
	protected function wakeupEntryCol(array $row, $getCol = '') {
		$entry = $this->wakeupEntry($row, $getCol);
		if(!$getCol) return $entry;
		return isset($entry[$getCol]) ? $entry[$getCol] : false;
	}

	/**
	 * Sleep/clean/prepare an entry for saving
	 *
	 * @param array $entry
	 * @return array
	 *
	 */
	protected function sleepEntry(array $entry) {

		$form = $this->getForm();
		$id = isset($entry['id']) ? abs((int) $entry['id']) : 0;
		$flags = isset($entry['entryFlags']) ? (int) $entry['entryFlags'] : 0;
		$str = isset($entry['entryStr']) ? $entry['entryStr'] : '';
		
		if($id) {
			if(!empty($entry['created'])) {
				$created = ctype_digit("$entry[created]") ? (int) $entry['created'] : strtotime($entry['created']);
			} else {
				$created = 0; // no update
			}
		} else {
			$created = time();
		}

		$created = $created ? date('Y-m-d H:i:s', $created) : '';
		
		$row = array(
			'id' => $id, 
			'flags' => $flags, 
			'str' => $str, 
			'created' => $created, 
			'data' => '',
		);

		$data = $entry;
		
		// note: 'created' is typically not present here
		unset(
			$data['id'],
			$data['created'],
			$data['modified'],
			$data['forms_id'],
			$data['entryStr'],
			$data['entryFlags'],
			$data['_jumpPageNum']
		);

		foreach($data as $key => $value) {
			if(strpos($key, '_errors') === 0 && empty($value) && preg_match('/^_errors\d+$/', $key)) {
				unset($data[$key]);
			} else if(strpos($key, '_submit_') && preg_match('/_submit_(jump|next|prev)$/', $key)) {
				unset($data[$key]);
			} else if(is_array($value)) {
				// wakeup array value
				$field = $form->find($key);
				if($field && $field->type == 'FormBuilderFile') {
					foreach($value as $k => $file) {
						// reduce files to just basename
						if(is_file($file)) $data[$key][$k] = basename($file);
					}
				}
			}
		}
		
		$row['data'] = json_encode($data);

		return $row;
	}
	
	/**
	 * Build an SQL query to find entries by translating a selector string
	 *
	 * @param string $selectorString
	 * @param bool $allForms Search all forms rather than current? (default=false)
	 * @return DatabaseQuerySelect
	 *
	 */
	protected function buildFindQuery($selectorString, $allForms = false) {
		
		$systemFields = array(
			'id', 'entryID', 'str', 'entryStr', 'flags', 'entryFlags', 
			'created', 'modified', 'sort', 'data', 'start', 'limit',
		);

		$selectors = new Selectors($selectorString);
		$limit = 0; 
		$start = 0;
		$database = $this->wire()->database;
		$sorts = array();
		$n = 0;
		
		$query = new DatabaseQuerySelect();
		$this->wire($query);
		$query->select('*');
		$query->from(self::entriesTable);
		
		if(!$allForms) {
			$query->where('forms_id=?', (int) $this->forms_id);
		}

		foreach($selectors as $selector) {	

			$field = $selector->field();
			$operator = $selector->operator();
			$value = $selector->value();
			$n++;

			if($field === 'data') {
				// search all fields
				$this->buildFindQueryData($query, $operator, $value);
				continue;
			} else if(!in_array($field, $systemFields)) {
				// handle custom field encoded within data
				$this->buildFindQueryField($query, $field, $operator, $value, $allForms);
				continue;
			} else if(!$database->isOperator($operator)) {
				// check that a valid operator was used
				$this->error("Operator '$operator' is not valid for querying '$field'");
				continue;
			}
		
			// system field
			switch($field) {
				case 'id':
				case 'entryID':
					$query->where("id$operator?", (int) $value);
					break;

				case 'str':
				case 'entryStr':
					$query->where("str$operator?", $value);
					break;

				case 'flags':
				case 'entryFlags':
					$value = (int) $value;
					if($operator === '!=') {
						$query->where('NOT(flags & ?)', $value);
					} else if($operator === '=') {
						$query->where('(flags & ?)', $value);
					} else {
						$this->error("Operator '$operator' not supported for flags");
					}
					break;

				case 'created':
				case 'modified':
					if(!ctype_digit($value)) $value = strtotime($value);
					if(!ctype_alpha($field)) $field = $field = 'created';
					$value = date('Y-m-d H:i:s', $value);
					$query->where("$field$operator?", $value);
					break;

				case 'sort':
					$this->buildFindQuerySort($query, $value, $sorts); 
					break;
					
				case 'start':
					$start = (int) $value;
					break;

				case 'limit':
					$limit = (int) $value;
					break;
			}
		}

		if($limit) {
			$start = (int) $start;
			$limit = (int) $limit;
			$query->limit("$start,$limit");
		}
	
		if(!isset($sorts['created']) && !isset($sorts['modified']) && !isset($sorts['id'])) {
			$query->orderby('created DESC');
		}
		
		return $query;
	}

	/**
	 * Handles the 'sort' property for buildFindQuery() method
	 *
	 * @param DatabaseQuerySelect $query
	 * @param string value 
	 * @param array $sorts modified directly
	 *
	 */
	protected function buildFindQuerySort(DatabaseQuerySelect $query, $value, array &$sorts) {
		
		$database = $this->wire()->database;
		$desc = strpos($value, '-') === 0;
		$value = $this->wire()->sanitizer->fieldName(ltrim($value, '-'));
		
		if(in_array($value, array('id', 'created', 'modified', 'flags'))) {
			// sort by system field
			$col = $database->escapeCol($value);
			$query->orderby($desc ? "$col DESC" : "$col ASC");
			$sorts[$value] = $value;
			return;
		}
		
		$f = $this->getForm()->find($value);
			
		if(!$f) {
			$this->error("Unrecognized field for sorting: $value");
			return;
		}
		
		// sort by custom field in encoded JSON
		$value = $database->escapeCol($value);
		$value = 'data->"$.' . $value . '"';
		
		$inputfield = $this->wire()->modules->getModule('Inputfield' . $f->type);
		if($inputfield instanceof InputfieldText || $inputfield instanceof InputfieldHidden) {
			$value = "LOWER($value)";
		} 
		
		$query->orderby($desc ? "$value DESC" : "$value ASC");
		$sorts[$value] = $value;
	}

	/**
	 * Find within fulltext-indexed 'data' column
	 * 
	 * @param DatabaseQuerySelect $query
	 * @param $operator
	 * @param $value
	 * @param bool $not
	 *
	 */
	protected function buildFindQueryData(DatabaseQuerySelect $query, $operator, $value, $not = false) {
		if($not) $operator = "!$operator";
		$ft = new DatabaseQuerySelectFulltext($query);
		$this->wire($ft);
		$ft->allowOrder(false);
		$ft->match(self::entriesTable, 'data', $operator, $value);
	}

	/**
	 * Find within JSON-encoded field in 'data' column
	 * 
	 * Requires MySQL 5.7 or newer
	 * 
	 * @param DatabaseQuerySelect $query
	 * @param string $field
	 * @param string $operator
	 * @param string|int $value
	 * @param bool $allForms
	 * @throws WireException
	 * 
	 */
	protected function buildFindQueryField(DatabaseQuerySelect $query, $field, $operator, $value, $allForms = false) {

		$database = $this->wire()->database;
		if(!$allForms) {
			$formField = $this->getForm()->find($field);
			if(!$formField) throw new WireException("Unknown form field: $field");
			$inputfield = $this->wire()->modules->getModule('Inputfield' . $formField->type);
		} else {
			$inputfield = null;
		}
		
		$field = $this->wire()->sanitizer->fieldName($field);
		// $col = "data->\"$.$field\""; // syntax requires MySQL 5.7.9 or newer
		$col = "JSON_EXTRACT(data, \"$.$field\")";
		$mb = function_exists('mb_strtolower');
		$not = $operator === '!=';
		
		if($inputfield && $inputfield instanceof InputfieldPage) $operator = '~=';

		if($operator === '=' || $operator === '!=') {
			if(!strlen($value)) {
				// find empty or not-empty
				if($operator === '=') {
					$where = "$col IS NULL OR $col='' OR JSON_CONTAINS(data, '{\"$field\": null}')=1"; 
				} else {
					$where = "$col IS NOT NULL AND $col !='' AND JSON_CONTAINS(data, '{\"$field\": null}')!=1";
				}
				$query->where("($where)");
				return;
			} else if($inputfield && $inputfield instanceof InputfieldHasArrayValue) {
				if($inputfield instanceof InputfieldPage) $value = (int) $value; 
				$query->where("JSON_CONTAINS(data, ?, '$.$field') $operator 1", json_encode(array($value))); 
				// $this->warning("JSON_CONTAINS(data, '" . json_encode(array($value)) . "', '$.$field') $operator 1"); 
				return;
			}
		}
		
		if($database->isOperator($operator)) {
			// standard database operator
			if(ctype_digit("$value")) {
				$value = (int) $value; 
				if($inputfield instanceof InputfieldInteger) {
					$bindKey = $query->bindValueGetKey($value, \PDO::PARAM_INT);
					$query->where("$col$operator$bindKey");
				} else {
					$bindKeyInt = $query->bindValueGetKey($value, \PDO::PARAM_INT);
					$bindKeyStr = $query->bindValueGetKey($value, \PDO::PARAM_STR);
					$query->where("($col$operator$bindKeyInt OR $col$operator$bindKeyStr)");
				}
			} else {
				$value = $mb ? mb_strtolower($value) : strtolower($value);
				$bindKey = $query->bindValueGetKey($value);
				// $query->where("$col$operator$bindKey");
				$query->where("JSON_UNQUOTE(LOWER($col))$operator$bindKey");
			}
			return;
		} 
		
		if($operator === '*=') {
			// start by using fulltext index and confirm within encoded field using %=
			$this->buildFindQueryData($query, $operator, $value);
			$operator = '%=';
		}
		
		if(in_array($operator, array('%=', '^=', '$'))) {
			$value = $mb ? mb_strtolower($value) : strtolower($value);
			$value = addcslashes($value, '%_');
			switch($operator) {
				case '%=':
					$value = "%$value%";
					break;
				case '^=':
					$value = "$value%";
					break;
				case '$=':
					$value = "%$value";
					break;
			}
			$like = $not ? 'NOT LIKE' : 'LIKE';
			$query->where("LOWER($col) $like ?", $value);
			return;
		}

		if($operator === '~=' || $operator === '~|=') {
			// find any or all words
			$rlike = $not ? 'NOT RLIKE' : 'RLIKE';
			$this->buildFindQueryData($query, $operator, $value, $not); // fulltext pre-filter
			$wheres = array();
			foreach(explode(' ', $value) as $word) {
				$word = $mb ? mb_strtolower($word) : strtolower($word);
				$word = preg_quote($word);
				$word = "([[:blank:]]|[[:punct:]]|[[:space:]]|>|^)$word([[:blank:]]|[[:punct:]]|[[:space:]]|<|$)";
				$bindKey = $query->bindValueGetKey($word);
				$wheres[] = "(LOWER($col) $rlike $bindKey)";
			}
			$whereType = $operator === '~=' ? ' AND ' : ' OR ';
			$query->where('(' . implode($whereType, $wheres) . ')');
			return;
		}
		
		throw new FormBuilderException("Unimplemented operator: $operator");
	}

	/**
	 * Get an array of form entries
	 *
	 * @param int|string $selectorString
	 * @param array $options
	 *  - `allForms` (bool): Search all forms rather than current? (default=false)
	 * @return array
	 *
	 */
	public function find($selectorString, array $options = array()) {
		
		$defaults = array(
			'allForms' => false, 
		);

		$options = array_merge($defaults, $options);
		$entries = array();
		
		/** @var \PDOStatement $query */
		$selectQuery = $this->buildFindQuery($selectorString, $options['allForms']);
		
		$countQuery = clone $selectQuery;
		$countQuery->set('select', array('COUNT(*)'));
		$countQuery->set('limit', array()); 
		$stmt = $countQuery->execute();
		$this->lastTotal = (int) $stmt->fetchColumn();
		$stmt->closeCursor();

		try {
			$stmt = $selectQuery->execute();
		} catch(\Exception $e) {
			$msg = $e->getMessage();
			if(strpos($msg, 'JSON') === false) throw $e;
			if(version_compare($this->mySqlVersion(), '5.7.0', '>=')) throw $e;
			$this->error($this->_('Searching within specific form entry fields requires MySQL 5.7 or newer')); 
		}
		
		while($row = $stmt->fetch(\PDO::FETCH_ASSOC)) { 
			$entries[] = $this->wakeupEntry($row); 
		}

		return $entries; 
	}

	/**
	 * Get a form entry by ID 
	 * 
	 * @param int $id
	 * @param string $col Specify a specific DB column to get or omit for entire entry
	 * @return bool|array Returns form entry (array) on success or boolean false on fail
	 * @since 0.3.8
	 * 
	 */
	public function getById($id, $col = '') {
		$sql = "SELECT * FROM " . self::entriesTable . " WHERE id=:id AND forms_id=:forms_id";
		$query = $this->database()->prepare($sql);
		$query->bindValue(':id', (int) $id, \PDO::PARAM_INT);
		$query->bindValue(':forms_id', (int) $this->forms_id, \PDO::PARAM_INT); 
		$query->execute();
		if(!$query->rowCount()) return false;
		$row = $query->fetch(\PDO::FETCH_ASSOC);
		$query->closeCursor();
		return $this->wakeupEntryCol($row, $col); 
	}

	/**
	 * Get a form entry by name 
	 * 
	 * @param string $name Entry name in format "id:str" where "id" is integer ID and "str" is 30-character entry string
	 * @param string $col Optional DB column name or omit for entire entry
	 * @return bool|array Returns form entry (array) on success or boolean false on fail
	 * @since 0.4.0
	 * 
	 */
	public function getByName($name, $col = '') {
		
		if(!strpos($name, ':')) return false;
		list($id, $str) = explode(':', $name, 2);
		if(!ctype_digit("$id")) return false;
		if(!ctype_alnum($str) || strlen($str) != self::entryStrLength) return false;
		
		$table = self::entriesTable;
		$sql = "SELECT * FROM $table WHERE id=:id AND str=:str AND forms_id=:forms_id";
		
		$query = $this->database()->prepare($sql);
		$query->bindValue(':id', (int) $id, \PDO::PARAM_INT);
		$query->bindValue(':str', $str, \PDO::PARAM_STR);
		$query->bindValue(':forms_id', $this->forms_id, \PDO::PARAM_INT);
		$query->execute();
		
		if($query->rowCount()) {
			$row = $query->fetch(\PDO::FETCH_ASSOC);
			$query->closeCursor();
		} else {
			$row = false;
		}
		
		$query->closeCursor();
		
		if($row === false) return false;
	
		return $this->wakeupEntryCol($row, $col); 
	}

	/**
	 * Get a single form result array by selector string, or null if not found
	 *
	 * @param int|string $selectorString
	 * @return null|array
	 * @since 0.4.2
	 *
	 */
	public function getBySelector($selectorString) {
		$selectorString .= ", limit=1";
		$result = $this->find($selectorString);
		$result = reset($result);
		return empty($result) ? null : $result;
	}

	/**
	 * Get entry by ID or selector string
	 * 
	 * @param int|string $key
	 * @return null|array|string|int
	 *
	 */
	public function get($key) {
		if(ctype_digit("$key")) return $this->getById((int) $key);
		return $this->getBySelector($key);
	}

	/**
	 * Works like find() except that it exports a CSV file
	 *
	 * This function also halts execution of the request after the CSV has been delivered
	 * 
	 * Note: to set the content-type header do the following in your /site/config.php file:
	 * ~~~~~
	 * $config->contentTypes('csv', 'text/csv'); 
	 * ~~~~~
	 * Replace the 'text/csv' above with the content-type header you want to use. Note that 
	 * the default used in this method is 'application/force-download'. 
	 *
	 * @param FormBuilderForm $form
	 * @param string $selectorString 
	 * @param array $options 
	 *  - `filename` (string): CSV file name or omit for "form-name.csv"
	 *  - `delimiter` (string|null): CSV delimiter or omit to use FormBuilder configured default. Also recognizes 'T' to mean tab-delimited.
	 *  - `useBOM` (bool|null): Include UTF-8 BOM at beginning? Or omit to use FormBuilder configured default.
	 *  - `columns` (array): Names of columsn to include, or omit (blank) for all columns. 
	 *  - `headerType` (string): One of 'name', 'label' or 'both' (default=name)
	 * 
	 */
	public function ___exportCSV(FormBuilderForm $form, $selectorString, array $options = array()) {
		
		$forms = $this->wire('forms'); /** @var FormBuilder $forms */
		
		$defaults = array(
			'headerType' => 'name', // name, label, or both
			'columns' => array(), 
			'filename' => "form-$form->name.csv", 
			'delimiter' => $forms->csvDelimiter, 
			'useBOM' => $forms->csvUseBOM, 
			'contentType' => '',
		);
		
		$options = array_merge($defaults, $options);
		
		$systemColumns = array(
			'id' => $this->_x('ID', 'csv'),
			'created' => $this->_x('Date created', 'csv'),
			'modified' => $this->_x('Date modified', 'csv'), 
			'flags' => $this->_x('Flags', 'csv'), 
		);
		
		if(strtoupper($options['delimiter']) === 'T') {
			$options['delimiter'] = "\t";
		} else if(empty($options['delimiter'])) {
			$options['delimiter'] = ',';
		}
		
		if(empty($options['filename'])) {
			$options['filename'] = "form-$form->name.csv";
		}
		
		if(empty($options['contentType'])) {
			$contentTypes = $this->wire()->config->contentTypes; // i.e. "text/csv; charset=utf-8", "application/csv", etc. 
			$options['contentType'] = isset($contentTypes['csv']) ? $contentTypes['csv'] : 'application/force-download';
		}

		header("Content-type: $options[contentType]");
		header("Content-transfer-encoding: Binary");
		header("Content-disposition: attachment; filename=$options[filename]");

		$fp = fopen('php://output', 'w');
		if($options['useBOM']) fwrite($fp, "\xEF\xBB\xBF"); // UTF-8 BOM: needed for some software to recognize UTF-8

		$pages = $this->wire()->pages;
		$selectQuery = $this->buildFindQuery($selectorString);
		$query = $selectQuery->execute();
		$fields = array();
		$formBuilderFields = array(); 
		$honeypot = $form->honeypot;
		$submitName = $form->name . '_submit';
		$hasPagesPath = method_exists($pages, 'getPath'); 
		$rootURL = rtrim($pages->get('/')->httpUrl(), '/');
		$formFieldsFlat = $form->getChildrenFlat(array(
			'includeNestedForms' => true,
			'skipTypes' => array('Fieldset', 'FormBuilderPageBreak'),
		));
		
		if(empty($options['columns'])) {
			$options['columns']['id'] = 'id';
			foreach($formFieldsFlat as $name => $formField) {
				$options['columns'][$name] = $name;
			}
			$options['columns']['created'] = 'created';
			$options['columns']['modified'] = 'modified';
			$options['columns']['flags'] = 'flags';
		}
		
		while($row = $query->fetch(\PDO::FETCH_ASSOC)) { 
			
			$flags = array();
			if($row['flags'] & self::flagPartial) $flags[] = 'partial';

			$data = json_decode($row['data'], true); 	
			$data['id'] = (int) $row['id']; 
			$data['created'] = date('Y-m-d H:i:s', strtotime($row['created']));
			$data['modified'] = date('Y-m-d H:i:s', strtotime($row['modified'])); 
			$data['flags'] = implode(', ', $flags);
			
			if($honeypot && isset($data[$honeypot])) unset($data[$honeypot]);
			unset($data[$submitName]); 
			
			$a = array();
			foreach($options['columns'] as $col) {
				$a[$col] = isset($data[$col]) ? $data[$col] : '';
			}
			$data = $a;

			if(empty($fields)) {
				// write out the first row with column names
				$headerRow = array();
				$fields = array_keys($data);
				foreach($fields as $name) {
					$field = null;
					if($options['headerType'] === 'name') {
						$label = $name;
					} else if(isset($systemColumns[$name])) {
						$label = $systemColumns[$name];
					} else if(isset($formFieldsFlat[$name])) {
						$field = $formFieldsFlat[$name];
						$label = $field ? $field->label : $name;
						if($field->parent && $field->parent->type == 'FormBuilderForm') {
							$label = $field->parent->label . ' > ' . $label;
						}
					} else {
						$field = $form->getFieldByName($name);
						$label = $field ? $field->label : $name;
					}
					if($field) $formBuilderFields[$name] = $field;
					if($options['headerType'] === 'name' || $label === $name) {
						$headerRow[] = $name;
					} else if($options['headerType'] === 'label') {
						$headerRow[] = $label;
					} else {
						$headerRow[] = "$label [$name]";
					}
				}
				// $fields = array_keys($data);
				@fputcsv($fp, $headerRow, $options['delimiter']);
			}
			
			// this makes sure that all the data is in the same order 
			// as the CSV fields from the first row, in case format ever changed
			$a = array();
			foreach($fields as $name) {

				$value = array_key_exists($name, $data) ? $data[$name] : '';

				if(isset($formBuilderFields[$name])) {
					$formBuilderField = $formBuilderFields[$name]; 
				} else {
					$formBuilderField = $form->getFieldByName($name); 
					$formBuilderFields[$name] = $formBuilderField; 
				}

				if($formBuilderField) {
					$value = $this->exportCSV_formatValue($form, $formBuilderField, $value, $data);
				} else if($name == '_savePage' && $hasPagesPath) {
					if(empty($value)) {
						$value = '';
					} else {
						$value = $rootURL . $pages->getPath($value);
					}
				}

				if(is_array($value)) {
					$value = implode("\n", $value);
				}

				// $value = utf8_decode($value); // support for latin1 (make conditional)
				$a[$name] = $value; 
			}

			// send the row
			@fputcsv($fp, $a, $options['delimiter']);
		}

		$query->closeCursor();
		fclose($fp); 
		exit();
	}

	/**
	 * 
	 * Format value for CSV exportj
	 * @param FormBuilderForm $form
	 * @param FormBuilderField $field
	 * @param string|int|float|array|Page|PageArray|Wire $value
	 * @param $entry
	 * @return array|false|NullPage|Page|PageArray|string
	 * @throws WireException
	 * 
	 */
	protected function exportCSV_formatValue(FormBuilderForm $form, FormBuilderField $field, $value, &$entry) {
		
		if($field->type == 'Datetime' && $value) {
			$value = date('Y-m-d H:i:s', $value);	
			
		} else if($field->type == 'Page') {
			if(is_int($value) || (is_string($value) && ctype_digit($value))) {
				$value = $this->wire()->pages->get((int) $value);
			} else if(is_string($value) && ctype_digit(str_replace('|', '', $value))) {
				$value = $this->wire()->pages->getById(explode('|', $value)); 
			}
			if(is_object($value)) {
				$a = array();
				if($value instanceof Page) $value = array($value); 
				foreach($value as $v) {
					if($v->id) $a[] = $v->get('title|name');
				}
				$value = $a;
			}
			
		} else if($field->type == 'FormBuilderFile' && !empty($value)) {
			if(!is_array($value)) $value = array($value); 
			foreach($value as $k => $v) {
				$fileURL = $this->wire('forms')->getFileURL($form->id, $entry['id'], $v);
				if($fileURL === false) {
					unset($value[$k]); // file not found
				} else {
					$value[$k] = $fileURL;
				}
			}
			
		} else if(is_object($value)) {
			$inputfield = $field->getInputfield();
			$inputfield->val($value);
			$value = strip_tags($this->wire()->sanitizer->unentities($inputfield->renderValue()));
		}
		
		if(is_array($value)) {
			$value = implode(" \n", $value); 
		}
		
		return $value; 
	}

	/**
	 * Save the given entry 
	 *
	 * If it is an existing entry that should be updated, then it should have a populated 'id' property
	 * otherwise it will be inserted as a new entry. 
	 *
	 * @param array $entry
	 * @return int|bool entry ID on success, false if not
	 * @throws \Exception on failure
	 *
	 */
	public function ___save(array $entry) {
		
		$row = $this->sleepEntry($entry);
		$id = $row['id'];
		$created = $row['created'] ? $row['created'] : '';

		$sql = ($id ? "UPDATE " : "INSERT INTO "); 
		$sql .=	self::entriesTable . " SET forms_id=:forms_id, data=:data, str=:str, flags=:flags, modified=NOW()";
		$sql .= $created ? ", created=:created " : " ";
		
		if($id) $sql .= "WHERE id=:id";
		
		$query = $this->database()->prepare($sql); 
		$query->bindValue(':forms_id', $this->forms_id, \PDO::PARAM_INT);
		$query->bindValue(':flags', $row['flags'], \PDO::PARAM_INT);
		$query->bindValue(':str', $row['str'], \PDO::PARAM_STR); 
		$query->bindValue(':data', $row['data'], \PDO::PARAM_STR);
		
		if($created) $query->bindValue(':created', $created);
		if($id) $query->bindValue(':id', $id, \PDO::PARAM_INT);
		
		$query->execute();
		
		if(!$id) $id = $this->database()->lastInsertId();

		return $id; 
	}
	
	/**
	 * Update a single form field value for an existing entry
	 *
	 * @param int $id Entry ID
	 * @param string $name
	 * @param mixed $value
	 * @return bool
	 * @since 0.3.8
	 *
	 */
	public function ___saveField($id, $name, $value) {
		$entry = $this->getById($id);
		if(!$entry) return false;
		if(isset($entry[$name]) && $entry[$name] === $value) return true; // no update necessary
		$entry[$name] = $value;
		$row = $this->sleepEntry($entry); 
		$sql = "UPDATE " . self::entriesTable . " SET data=:data WHERE id=:id";
		$query = $this->database()->prepare($sql);
		$query->bindValue(':data', $row['data']);
		$query->bindValue(':id', (int) $id, \PDO::PARAM_INT);
		return $query->execute() ? true : false;
	}

	/**
	 * Delete a form entry
	 *
	 * @param int $id
	 * @return int|bool ID of entry that was deleted or false on failure
	 *
	 */
	public function ___delete($id) {
		$id = (int) $id; 
		$path = $this->getFilesPath($id);
		$query = $this->database()->prepare("DELETE FROM " . self::entriesTable . " WHERE forms_id=:forms_id AND id=:id LIMIT 1"); 
		$query->bindValue(':forms_id', $this->forms_id, \PDO::PARAM_INT); 
		$query->bindValue(':id', $id, \PDO::PARAM_INT); 
		$result = $query->execute();
		$query->closeCursor();
		if($result && is_dir($path)) wireRmdir($path, true);
		if($result) $this->deleted(array($id));
		return $result ? $id : false;
	}

	/**
	 * Re-send (email) for the given entry ID
	 * 
	 * @param $id
	 * 
	 */
	public function ___resend($id) {
		// $id = (int) $id; 
	}

	/**
	 * Delete all entries for this form
	 *
	 * @return bool
	 *
	 */
	public function ___deleteAll() {
		$query = $this->database()->prepare("DELETE FROM " . self::entriesTable . " WHERE forms_id=:forms_id"); 
		$query->bindValue(':forms_id', $this->forms_id, \PDO::PARAM_INT); 
		$result = $query->execute();
		$path = $this->getFilesPath(0, false);
		if($result && is_dir($path)) $result = wireRmdir($path, true);
		return $result ? true : false;
	}
	
	/**
	 * Find entries older than a given number of days
	 *
	 * @param int $age Age of entries (in DAYS by default)
	 * @param string $ageType Age type of YEARS, MONTHS, WEEKS, DAYS, HOURS, MINUTES or SECONDS (default=DAYS)
	 * @param string $dateColumn Column to examine: 'created' or 'modified' (default='created')
	 * @param int|null $flags Any flag that is required to match as well (negative flag to perform NOT match or 0 to match no flags set), see flag constants in this class (default=null)
	 * @return array Returns array of entry IDs
	 * @throws WireException If given invalid age type
	 *
	 */
	public function findIdsOlderThan($age, $ageType = 'DAYS', $dateColumn = 'created', $flags = null) {
		
		$age = (int) $age;
		if($age < 1) return array();

		$ageTypes = array('YEARS', 'MONTHS', 'WEEKS', 'DAYS', 'HOURS', 'MINUTES', 'SECONDS');
		$ageType = strtoupper($ageType);
		if(substr($ageType, -1) !== 'S') $ageType .= 'S';
		if(!in_array($ageType, $ageTypes)) throw new WireException("Unrecognized ageType: $ageType");
		
		$table = self::entriesTable;
		$date = date('Y-m-d H:i:s', strtotime("-$age $ageType"));
		$col = $dateColumn === 'modified' ? 'modified' : 'created';
		$ids = array();
		$sql = "SELECT id FROM $table WHERE forms_id=:forms_id AND $col<:date ";
		if($flags === null) {
			// ignore flags
		} else if($flags === 0) {
			// match no flags set
			$sql .= "AND flags=0 ";
		} else if($flags < 0) {
			$sql .= "AND NOT(flags & :flags) ";
			$flags = abs($flags);
		} else if($flags > 0) {
			$sql .= "AND flags & :flags ";
		}
		$sql .= "ORDER BY $col ASC";

		$query = $this->database()->prepare($sql);
		$query->bindValue(':forms_id', $this->forms_id, \PDO::PARAM_INT);
		$query->bindValue(':date', $date);
		if($flags) $query->bindValue(':flags', (int) $flags, \PDO::PARAM_INT);
		$query->execute();

		while($row = $query->fetch(\PDO::FETCH_ASSOC)) {
			$id = (int) $row['id'];
			$ids[$id] = (int) $id;
		}

		$query->closeCursor();
		
		return $ids;
	}

	/**
	 * Delete entries older than a given number of days
	 * 
	 * @param int $age Age of entries (in DAYS by default)
	 * @param string $ageType Age type of YEARS, MONTHS, WEEKS, DAYS, HOURS, MINUTES or SECONDS (default=DAYS)
	 * @param string $dateColumn Column to examine: 'created' or 'modified' (default='created')
	 * @param int|null $flags Any flag that is required to match as well (negative flag to perform NOT match or 0 to match no flags set), see flag constants in this class (default=null) 
	 * @return int Number of entries deleted
	 * @throws WireException If given invalid age type
	 * 
	 */
	public function ___deleteOlderThan($age, $ageType = 'DAYS', $dateColumn = 'created', $flags = null) {
		
		$qty = 0;
		$qtyFiles = 0;
		$ids = $this->findIdsOlderThan($age, $ageType, $dateColumn, $flags);
		$idsFiles = array();
		
		if(!count($ids)) return 0;
		
		if($this->hasFilesPath()) {
			foreach($ids as $id) {
				if($this->hasFilesPath($id)) {
					$idsFiles[$id] = $id;
					unset($ids[$id]);
				}
			}
		}
		
		if(count($ids)) {
			// fast delete entries that have no files/dirs
			$table = self::entriesTable;
			$sql = "DELETE FROM $table WHERE forms_id=:forms_id AND id IN(" . implode(',', $ids) . ")";
			$query = $this->database()->prepare($sql);
			$query->bindValue(':forms_id', $this->forms_id, \PDO::PARAM_INT);
			$query->execute();
			$qty += $query->rowCount();
			$query->closeCursor();
			if($qty) $this->deleted($ids);
		}
	
		foreach($idsFiles as $id) {
			if($this->delete($id)) $qtyFiles++;
		}
		if($qtyFiles) $this->deleted($idsFiles);
		
		$qty += $qtyFiles;
		
		if($qty) {
			$this->wire('forms')->formLog($this->forms_id, "Deleted $qty entries older than $age $ageType old ($qtyFiles had files)"); 
		}
		
		return $qty;
	}

	/**
	 * Hook called after one or more entry IDs have been deleted
	 * 
	 * @param array $entryIDs Array of entry IDs that were deleted
	 * @since 0.4.0
	 * 
	 */
	protected function ___deleted(array $entryIDs) {
		// for hooks to implement whatever they want
	}
	
	/**
	 * Return total number of entries
	 *
	 * @return int
	 *
	 */
	public function getTotal() {
	
		$query = $this->database()->prepare("SELECT COUNT(*) FROM " . self::entriesTable . " WHERE forms_id=:forms_id"); 
		$query->bindValue(':forms_id', $this->forms_id, \PDO::PARAM_INT); 
		$query->execute();
		list($count) = $query->fetch(\PDO::FETCH_NUM); 
		$query->closeCursor();
		return $count; 
	}


	/**
	 * Get a form ID from an entry ID
	 *
	 * @param Wire $wire Any ProcessWire object
	 * @param int $entryID
	 * @return int
	 *
	 */
	public static function getFormIdFromEntryId(Wire $wire, $entryID) {
		$sql = "SELECT forms_id FROM " . self::entriesTable . " WHERE id=:id";
		$query = $wire->wire('database')->prepare($sql);
		$query->bindValue(':id', (int) $entryID, \PDO::PARAM_INT);
		$query->execute();
		if(!$query->rowCount()) return 0;
		$formsId = $query->fetchColumn();
		$query->closeCursor();
		return $formsId;
	}

	/**
	 * Get date of last entry
	 * 
	 * @param bool $reverse Specify true to get date of first entry rather than last entry
	 * @return string
	 * 
	 */
	public function getLastEntryDate($reverse = false) {
		$desc = $reverse ? "ASC" : "DESC";
		$query = $this->database()->prepare(
			"SELECT created FROM " . self::entriesTable . " " . 
			"WHERE forms_id=:forms_id " . 
			"ORDER BY created $desc LIMIT 1"
		);
		$query->bindValue(':forms_id', $this->forms_id, \PDO::PARAM_INT);
		$query->execute();
		if($query->rowCount()) {
			list($date) = $query->fetch(\PDO::FETCH_NUM); 
		} else {
			$date = '';
		}
		$query->closeCursor();
		return $date;
	}

	/**
	 * Return the total known from the last find() query
	 *
	 */
	public function getLastTotal() {
		return $this->lastTotal;
	}

	/**
	 * Return the path that may be used by entries
	 *
	 * @param int $entryID When specified, will return the path for a specific entry's files
	 * @param bool $create Create path if it does not exist?
	 * @param int $formID Optional form ID, if different from the one for this FormBuilderEntries class
	 * @return string
	 *
	 */
	public function ___getFilesPath($entryID = 0, $create = true, $formID = 0) { 
		if(!$formID) $formID = $this->forms_id; 
		/** @var FormBuilder $forms */
		$forms = $this->wire('forms');
		$path = $forms->getFilesPath(false, $create) . 'form-' . $formID . '/';
		if($create && !is_dir($path)) wireMkdir($path);
		$entryID = (int) $entryID;
		if($entryID) {
			$path .= "entry-$entryID/";
			if($create && !is_dir($path)) wireMkdir($path);
		}
		return $path;
	}

	/**
	 * Does a files path exist for form/entry?
	 * 
	 * @param int $entryID Specify entry ID to check if files path exists for entry
	 * @param int $formID Optional form ID, if different from the one for this FormBuilderEntries class
	 * @return bool
	 * 
	 */
	public function hasFilesPath($entryID = 0, $formID = 0) {
		$path = $this->getFilesPath($entryID, false, $formID);
		return is_dir($path);
	}

	/**
	 * Get the current form ID
	 * 
	 * @return int
	 * 
	 */
	public function getFormID() {
		return $this->forms_id; 
	}

	/**
	 * @return FormBuilderForm
	 * @since 0.4.2
	 * 
	 */
	public function getForm() {
		if($this->form !== null) return $this->form;
		$forms = $this->wire('forms'); /** @var FormBuilder forms */
		$this->form = $forms->load($this->forms_id); 
		return $this->form;
	}

	/**
	 * Make an entry string (entryStr property)
	 * 
	 * @return string
	 * 
	 */
	public function makeEntryStr() {
		$rand = new WireRandom();
		$entryStr = $rand->alphanumeric(self::entryStrLength);
		return $entryStr;
	}

	/**
	 * Add flag to entry (in memory only) and return entry 
	 * 
	 * @param array $entry
	 * @param int|string $flag Flag or flag name
	 * @return array
	 * 
	 */
	public function addEntryFlag(array $entry, $flag) {
		$flag = $this->flag($flag);
		$flags = isset($entry['entryFlags']) ? $entry['entryFlags'] : 0;
		$flags = $flags | $flag;
		$entry['entryFlags'] = $flags;
		return $entry;
	}

	/**
	 * Remove flag to entry (in memory only) and return entry
	 *
	 * @param array $entry
	 * @param int|string $flag Flag or flag name
	 * @return array
	 *
	 */
	public function removeEntryFlag(array $entry, $flag) {
		$flag = $this->flag($flag);
		$flags = isset($entry['entryFlags']) ? $entry['entryFlags'] : 0;
		if($flags && ($flags & $flag)) $flags = $flags & ~$flag;
		$entry['entryFlags'] = $flags;
		return $entry;
	}

	/**
	 * Sanitize a flag or flag name to the flag integer
	 * 
	 * @param int|string $flag
	 * @return int
	 * 
	 */
	protected function flag($flag) {
		if(is_int($flag) || ctype_digit("$flag")) return (int) $flag;
		if($flag === 'partial') return self::flagPartial;
		return 0;
	}

	/**
	 * Given an entry name, validate it, returning blank string if not valid or given entry name if valid
	 * 
	 * @param string $name
	 * @return string
	 * 
	 */
	public function validEntryName($name) {
		if(!strpos($name, ':')) return '';
		list($id, $str) = explode(':', $name, 2);
		if(!ctype_digit("$id")) return '';
		if(!ctype_alnum($str) || strlen($str) != self::entryStrLength) return '';
		return $name;
	}
	
	/**
	 * Install the forms_entries table
	 * 
	 * @param WireDatabasePDO $database
	 *
	 */
	public static function _install($database) {

		$engine = $database->wire()->config->dbEngine;
		$charset = $database->wire()->config->dbCharset;

		$sql =  
			"CREATE TABLE " . self::entriesTable . " (" . 
				"id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, " . 
				"forms_id INT UNSIGNED NOT NULL, " . 
				"flags INT UNSIGNED NOT NULL DEFAULT 0, " .
				"str VARCHAR(128) NOT NULL DEFAULT '', " . 
				"data MEDIUMTEXT NOT NULL, " .
				"created DATETIME NOT NULL, " . 
				"modified TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, " .  
				"INDEX forms_id (forms_id, flags), " . 
				"INDEX created_forms_id (created, forms_id, flags), " . 
				"INDEX modified_forms_id (modified, forms_id, flags), " . 
				"INDEX id_str (id, str), " . 
				"FULLTEXT `data` (`data`)" . 
			") ENGINE=$engine DEFAULT CHARSET=$charset ";

		try {
			$query = $database->prepare($sql);
			$query->execute();
		} catch(\Exception $e) {
			$database->error($e->getMessage());
		}
	}

	/**
	 * Uninstall the forms_entries table
	 * 
	 * @param WireDatabasePDO $database
	 *
	 */
	public static function _uninstall($database) {
		$database->exec("DROP TABLE " . self::entriesTable);
	}

	/**
	 * @param WireDatabasePDO $database
	 * @param string $column
	 * @return bool
	 * 
	 */
	protected static function _hasColumn($database, $column) {
		$table = self::entriesTable;
		$query = $database->prepare("SHOW COLUMNS FROM $table LIKE :column");
		$query->bindValue(':column', $column); 
		$query->execute();
		$numRows = $query->rowCount();
		$query->closeCursor();
		return $numRows > 0;
	}
	
	/**
	 * @param WireDatabasePDO $database
	 * @param string $name
	 * @return bool
	 *
	 */
	protected static function _hasIndex($database, $name) {
		$table = self::entriesTable;
		$query = $database->prepare("SHOW INDEX FROM $table WHERE Key_name=:name");
		$query->bindValue(':name', $name); 
		$query->execute();
		$numRows = $query->rowCount();
		$query->closeCursor();
		return $numRows > 0;
	}

	/**
	 * @param WireDatabasePDO $database
	 * @param bool $verbose
	 * 
	 */
	public static function _upgrade($database, $verbose) {
		
		$table = self::entriesTable;
	
		if(!self::_hasColumn($database, 'str')) {
			$database->exec("ALTER TABLE $table ADD `str` VARCHAR(128) NOT NULL DEFAULT ''");
			$database->exec("ALTER TABLE $table ADD INDEX id_str (id, str)");
			if($verbose) $database->message("Added FormBuilder column $table.str"); 
		}

		if(!self::_hasColumn($database, 'flags')) {
			$database->exec("ALTER TABLE $table ADD `flags` INT UNSIGNED NOT NULL DEFAULT 0");
			$database->exec("ALTER TABLE $table ADD INDEX forms_id_flags_created (forms_id, flags, created)");
			if($verbose) $database->message("Added FormBuilder column $table.flags"); 
		}
		
		if(!self::_hasColumn($database, 'modified')) {
			$database->exec("ALTER TABLE $table ADD `modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
			$database->exec("ALTER TABLE $table ADD INDEX modified_forms_id (modified, forms_id, flags)");
			if($verbose) $database->message("Added FormBuilder column $table.modified");
		}
		
		if(!self::_hasIndex($database, 'data')) {
			$database->exec("ALTER TABLE $table ADD FULLTEXT `data` (`data`)");
			if($verbose) $database->message("Added FormBuilder fulltext index $table.data");
		}

	}

	/**
	 * Is the given property name reserved for system use in entries?
	 * 
	 * @param string $property
	 * @return bool
	 * 
	 */
	public function isReservedProperty($property) {
		if(isset($this->reservedProperties[$property])) return true;
		if(strpos($property, '_') === 0) return true;
		return false;
	}

	/**
	 * Get current MySQL version
	 * 
	 * @return string
	 * 
	 */
	public function mySqlVersion() {
		if($this->mySqlVersion === 0) {
			$query = $this->database()->query("SELECT VERSION()");
			$query->execute();
			$this->mySqlVersion = $query->fetchColumn();
			if(!ctype_digit(str_replace('.', '', $this->mySqlVersion))) {
				$this->mySqlVersion = preg_replace('/[^0-9\.]/', '', $this->mySqlVersion); 
			}
		}
		return $this->mySqlVersion;		
	}


}
