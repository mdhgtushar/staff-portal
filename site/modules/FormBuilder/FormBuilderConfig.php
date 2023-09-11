<?php namespace ProcessWire;

/**
 * Implementation class for FormBuilder::getModuleConfigInputfields
 *
 * Provides the module configuration fields. This is delegated to it's own class 
 * since there is a lot here and didn't see any reason for it to take up space
 * in the FormBuilder class when it's only needed during config time. 
 *
 * Copyright (C) 2019 by Ryan Cramer Design, LLC
 * 
 * PLEASE DO NOT DISTRIBUTE
 * 
 */

class FormBuilderConfig extends Wire {

	/**
	 * Minimum ProcessWire version required to run Form Builder
	 *
	 */
	const requiredVersion = '3.0.62';

	/**
	 * @var InputfieldWrapper
	 * 
	 */
	protected $inputfields;

	/**
	 * @var array
	 * 
	 */
	protected $data = array();

	/**
	 * Markup used for form rendering
	 *
	 */
	protected $markup = array(
		'list' => "\n<div {attrs}>{out}\n</div>\n",
		'item' => "\n\t<div {attrs}>{out}\n\t</div>",   
		'item_label' => "\n\t\t<label class='ui-widget-header' for='{for}'>{out}</label>",   
		'item_content' => "\n\t\t<div class='ui-widget-content'>{out}</div>",   
		'item_error' => "\n<p><span class='ui-state-error'>{out}</span></p>",
		'item_description' => "\n<p class='description'>{out}</p>",   
		'success' => "\n<p class='ui-state-highlight'>{out}</p>",
		'error' => "\n<p class='ui-state-error'>{out}</p>", 
		//'item_head' => "\n<h2>{out}</h2>",   
		//'item_notes' => "\n<p class='notes'>{out}</p>",
		);

	/**
	 * Classes that are populated in markup (in some cases with others)
	 *
	 */
	protected $classes = array(
		'form' => '', 
		'list' => 'Inputfields',
		'list_clearfix' => 'ui-helper-clearfix',
		'item' => 'Inputfield Inputfield_{name} ui-widget {class}',
		'item_required' => 'InputfieldStateRequired',
		'item_error' => 'InputfieldStateError ui-state-error',
		'item_collapsed' => 'InputfieldStateCollapsed',
		'item_column_width' => 'InputfieldColumnWidth',
		'item_column_width_first' => 'InputfieldColumnWidthFirst',
		); 


	public function __construct(array $data) {

		// check for existance of required form-builder template
		if(!is_file($this->config->paths->templates . FormBuilderMain::name . '.php')) {
			$out = "Please copy " . $this->config->urls('FormBuilder') . FormBuilderMain::name . ".php to " . 
				wire('config')->urls->templates . FormBuilderMain::name . '.php'; 
			$this->error($out);
		}

		$this->data = $data; 
		$this->inputfields = new InputfieldWrapper();
		$this->upgradeChecks();
	}

	public function getConfig() {

		// check that they have the required PW version
		if(version_compare(wire('config')->version, self::requiredVersion, '<')) {
			$this->error("Form Builder requires ProcessWire " . self::requiredVersion . " or newer. You need to update your ProcessWire version before using Form Builder."); 
		}

		$this->configLicense();
		$this->configEmbeds();
		$this->configEmails();
		$this->configForm();
		$this->configSpam();
		$this->configCsv();
		$this->configFiles();
		$this->configMarkup(); 

		return $this->inputfields;
	}

	protected function configFiles() {
		
		/** @var InputfieldFieldset $fs */
		$fs = $this->wire('modules')->get('InputfieldFieldset');
		$fs->label = $this->_('Files settings');
		$fs->description = $this->_('These settings are used for form submissions that include file uploads.'); 
		$fs->icon = 'files-o';
		$fs->set('themeOffset', 1);
		$fs->collapsed = Inputfield::collapsedYes; 
		$this->inputfields->add($fs);

		$value = !empty($this->data['filesPath']) ? $this->data['filesPath'] : '{config.paths.cache}' . FormBuilderMain::name . '/'; 

		$f = $this->wire('modules')->get('InputfieldText');
		$f->attr('name', 'filesPath');
		$f->attr('value', $value);
		$f->label = "Files Path";
		$f->description = "This is the directory where form builder will store files for forms that have file/upload fields. This directory must be writable by Apache. For security, this directory must NOT be web accessible!";
		$f->required = true; 
		$f->icon = 'floppy-o';

		$value = FormBuilderMain::parseFilesPath($value);

		$f->notes = 
			"The default location: `{config.paths.cache}form-builder/`, is safe if your htaccess file is working correctly. " . 
			"The placeholder `{config.paths.cache}` refers to `/site/assets/cache/`.\n\nShould you want to use it, there is also " . 
			"`{config.paths.assets}` which refers to just `/site/assets/`. For instance, you might specify " . 
			"`{config.paths.assets}.form-builder/` " . 
			"which would make it use the location `/site/assets/.form-builder/`. Because the directory is prefixed with a period, " . 
			"this ensures it is not http accessible.\n\nYou might also choose not to use any placeholders and instead specify a full server path " .
			"to a directory, perhaps outside of the web root. But the benefit of using a path with a placeholder is that it will continue to " . 
			"work even if the server changes (like between development and production). \n\n" . 
			"The current value translates to this at runtime: `$value`";

		if(!is_dir($value)) wireMkdir($value); 
		if(!is_dir($value)) $f->error("Specified path does not exist, please create it and make it writable."); 
		if(!is_writable($value)) $f->error("Specified path is not writable, please correct this.");

		$fs->add($f);
	}

	protected function configSpam() {
		
		/** @var InputfieldFieldset $fs */
		$fs = $this->wire('modules')->get('InputfieldFieldset');
		$fs->label = $this->_('Spam prevention settings');
		$fs->icon = 'fire-extinguisher';
		$fs->set('themeOffset', 1);
		$fs->collapsed = Inputfield::collapsedBlank;
		$this->inputfields->add($fs);

		$akismetKey = isset($this->data['akismetKey']) ? $this->data['akismetKey'] : '';

		$f = $this->wire('modules')->get('InputfieldText');
		$f->attr('name', 'akismetKey');
		$f->attr('value', $akismetKey);
		$f->label = 'Akismet API Key'; 
		$f->description = 'If you want to use the Akismet service to prevent spam, enter your API key here.';
		$f->notes = 'Get an [Akismet API key](https://akismet.com/signup/).';
		//$f->collapsed = Inputfield::collapsedBlank;
		$f->icon = 'wordpress';

		if(strlen($akismetKey)) {
			require_once(dirname(__FILE__) . '/FormBuilderAkismet.php');
			$akismet = new FormBuilderAkismet($akismetKey);
			if(!$akismet->verifyKey()) {
				$f->error('Akismet key does not verify'); 
			} else {
				$f->notes = 'Akismet key verified!';
				$f->label .= " (verified)";
				$f->collapsed = Inputfield::collapsedYes; 
			}
		}

		$fs->add($f);
	}

	protected function configForm() {

		$defaultInputfieldClasses = array(
			'AsmSelect',
			'Checkbox',
			'Checkboxes',
			'Datetime',
			'Email',
			'Fieldset',
			'Float',
			'FormBuilderFile',
			'FormBuilderStripe',
			'Integer',
			'Hidden',
			'Page',
			'Radios',
			'Select',
			'SelectMultiple',
			'Text',
			'Textarea',
			'URL', 
			);

		// Inputfields that we already know are not FormBuilder compatible
		$excludeInputfieldClasses = array(
			'Name',
			'File',
			'Image',
			'Form',
			'Button',
			'Submit',
			'TinyMCE',
			'Repeater',
			'Table',
			'PageTable',
			'Selector',
			);
		
		/** @var InputfieldFieldset $fs */
		$fs = $this->wire('modules')->get('InputfieldFieldset');
		$fs->label = $this->_('Form and field settings');
		$fs->icon = 'sliders';
		$fs->set('themeOffset', 1);
		$this->inputfields->add($fs);

		/** @var InputfieldCheckboxes $f */
		$f = $this->wire('modules')->get('InputfieldCheckboxes'); 
		$f->label = $this->_('Allowed Input Types'); 
		$f->description = 
			$this->_('Select the Inputfield types that you want to allow for fields in Form Builder.') . ' ' . 
			$this->_('Not all Inputfield types can be used with FormBuilder.') . ' ' .
			$this->_('If you add additional types, be sure to test them thoroughly in your forms on the front-end (while not logged in).');
		$f->attr('name', 'inputfieldClasses'); 
		$f->icon = 'list';
		$f->optionColumns = 2;

		foreach($this->wire('modules')->findByPrefix('Inputfield') as $moduleName) {
			$name = str_replace('Inputfield', '', $moduleName);
			if(in_array($name, $excludeInputfieldClasses)) continue; 
			if($name != 'Page' && substr($name, 0, 4) == 'Page') continue; 
			$f->addOption($name);
		}

		$f->attr('value', empty($this->data['inputfieldClasses']) ? $defaultInputfieldClasses : $this->data['inputfieldClasses']); 
		$fs->add($f);
	
		/** @var InputfieldCheckbox $f */
		$f = $this->wire('modules')->get('InputfieldCheckbox');
		$f->attr('name', 'useRoles');
		$f->attr('value', 1);
		$f->attr('checked', empty($this->data['useRoles']) ? '' : 'checked');
		$f->label = "Enable Access Control?";
		$f->description = "When checked, several form-level permissions will be provided to control access for submission, administration and entry management. These permissions can be managed from the 'access' tab of each form.";
		$f->icon = 'lock';
		if(empty($this->data['useRoles'])) $f->collapsed = Inputfield::collapsedYes;
		$fs->add($f);
	}

	protected function configEmbeds() {
	
		/** @var InputfieldFieldset $fs */
		$fs = $this->wire('modules')->get('InputfieldFieldset');
		$fs->label = $this->_('Form embed settings');
		$fs->icon = 'paperclip';
		$fs->set('themeOffset', 1);
		$this->inputfields->add($fs);

		/** @var InputfieldCheckboxes $f */
		$f = $this->wire('modules')->get('InputfieldCheckboxes'); 
		$f->attr('name', 'embedFields');
		$f->label = $this->_('Allowed Embed Fields');
		$f->description = $this->_("Check all fields that are allowed to have forms embedded in them using the easy-embedding method. Easy embedding enables you to type a special \"embed tag\" on it's own line and have the form automatically inserted there when the page is viewed. We highly recommend that you use easy embedding, however if you won't be using it, you may leave all unchecked.");
		$f->notes = $this->_("Tip: Choose your main 'body copy' field for easy embedding.");
		$f->optionColumns = 2;
		$f->icon = 'cube';

		foreach($this->wire('fields') as $field) {
			if($field->rows !== null) $f->addOption($field->id, $field->name); 
		}

		$f->attr('value', isset($this->data['embedFields']) ? $this->data['embedFields'] : array()); 
		$fs->add($f);

		/** @var InputfieldName $f */
		$f = $this->wire('modules')->get('InputfieldName');
		$f->attr('name', 'embedTag');
		$f->attr('value', !empty($this->data['embedTag']) ? $this->data['embedTag'] : FormBuilderMain::name);
		$f->label = "Easy Embed Tag";
		$f->description = "A short tag or word (a-z 0-9) that Form Builder should look for in your text when determining when and where to embed a form. This should be something reasonably unique, not likely to appear in other contexts.";
		$f->notes = "Form Builder will look for this tag combined with your form name when performing embeds.";
		$f->collapsed = Inputfield::collapsedYes;
		$f->icon = 'tag';
		$fs->add($f);
		
		$this->inputfields->add($fs);
	}
	
	protected function configEmails() {
		
		$fs = $this->wire('modules')->get('InputfieldFieldset');
		$fs->label = $this->_('Email settings');
		$fs->icon = 'envelope-o';
		$fs->description = $this->_('These settings are used when sending administrator or autoresponder emails.');
		$fs->set('themeOffset', 1);
		$this->inputfields->add($fs);
		
		$f = $this->wire('modules')->get('InputfieldEmail');
		$f->attr('name', 'fromEmail');
		$f->label = $this->_('Default from email address'); 
		$f->description = 
			$this->_('If possible, please enter an email address that this server would be allowed to send with (per DNS settings).') . ' ' . 
		$f->notes = 
			$this->_('This setting can be overridden for each form. The value entered here will be used as the default.') . ' ' . 
			$this->_('Note that each form also lets you specify a separate “Reply-To” address as well.'); 
		$f->attr('value', isset($this->data['fromEmail']) ? $this->data['fromEmail'] : '');
		$fs->add($f);
		
		$mailers = array(
			'WireMail' => $this->_('Native PHP mail()')
		);
		foreach($this->wire('modules')->findByPrefix('WireMail') as $moduleName) {
			$mailers[$moduleName] = str_replace('WireMail', '', $moduleName);
		}
		$f = $this->wire('modules')->get('InputfieldRadios');
		$f->attr('name', 'mailer');
		$f->label = $this->_('Email sending method (WireMail module)');
		$f->description = sprintf(
			$this->_('For more sending options, you can install [WireMail modules](%s).'),
			'https://modules.processwire.com/categories/email/'
		);
		$mailer = wireMail();
		$mailerName = $mailer ? $mailer->className() : '';
		if(isset($mailers[$mailerName])) $mailerName = $mailers[$mailerName];
		if(!empty($mailerName)) $mailerName = "(currently: $mailerName)";
		$f->addOption('', $this->_('Auto-detect') . ' ' . " [span.detail] $mailerName [/span]"); 
		foreach($mailers as $name => $label) {
			$f->addOption($name, $label);
		}
		$f->attr('value', isset($this->data['mailer']) ? $this->data['mailer'] : ''); 
		$fs->add($f);
	}

	protected function configCsv() {
		
		$fs = $this->wire('modules')->get('InputfieldFieldset');
		$fs->label = $this->_('CSV export settings');
		$fs->description = $this->_('These settings are used when exporting form entries to CSV files.'); 
		$fs->icon = 'file-excel-o';
		$fs->set('themeOffset', 1);
		$fs->collapsed = Inputfield::collapsedYes;
		$fs->appendMarkup = "<p>" . 
			"CSV files are sent with a <code>content-type</code> header of <code>application/force-download</code>. " . 
			"If you want to use a different header you can do so from your <u>/site/config.php</u> file: " . 
			'<code>$config->contentTypes("csv", "text/csv");</code>';
		$this->inputfields->add($fs);

		$f = $this->wire('modules')->get('InputfieldText');
		$f->attr('name', 'csvDelimiter');
		$f->attr('value', !empty($this->data['csvDelimiter']) ? $this->data['csvDelimiter'] : ','); 
		$f->label = "CSV Delimiter";
		$f->description = "The delimiter to use when exporting CSV/spreadsheet files. Typically a comma, semicolon or tab.";
		$f->notes = "To use [tab] as a delimiter, just enter the letter: T"; 
		$f->attr('size', 3); 
		$f->attr('maxlength', 3);
		$f->columnWidth = 50;
		$fs->add($f);
		
		/** @var InputfieldCheckbox $f */
		$f = $this->wire('modules')->get('InputfieldCheckbox');
		$f->attr('name', 'csvUseBOM');
		$f->attr('value', 1);
		$f->attr('checked', empty($this->data['csvUseBOM']) ? '' : 'checked');
		$f->label = "Prepend CSV file with UTF-8 byte order mark (BOM)?";
		$f->description = 
			"This helps some versions of Excel understand that the CSV data is UTF-8 encoded. " . 
			"You should check this box if you are having issues importing to Excel.";
		$f->columnWidth = 50;
		$fs->add($f);
	}

	protected function configLicense() {
	
		/** @var WireInput $input */
		$input = $this->wire('input');
		/** @var Session $session */
		$session = $this->wire('session');

		/** @var InputfieldText $f */
		$f = $this->wire('modules')->get('InputfieldText');
		$f->attr('id+name', 'licenseKey');

		$licenseKey = isset($this->data['licenseKey']) ? $this->data['licenseKey'] : '';

		if($input->post('licenseKey') && $input->post('licenseKey') != $session->get('FormBuilderLicenseKey')) {
			// validate 
			$http = new WireHttp();
			$license = $this->wire('sanitizer')->text($input->post('licenseKey'));
			$result = $http->post('https://processwire.com/FormBuilder/license.php', 
				array(
					'action' => 'validate', 
					'license' => $license,
					'host' => $this->wire('config')->httpHost
					));

			if($result === 'valid') {
				$licenseKey = $license; 
				$f->notes = "Validated!";
				$this->message("Product key has been validated!");

			} else if($result === 'invalid') {
				$licenseKey = '';
				$f->error("Invalid product key");

			} else {
				$licenseKey = '';
				$f->error("Unable to validate product key"); 
			}
		}

		if(empty($licenseKey)) {
			$input->post->__unset('licenseKey'); 
			$input->post->__unset('licenseKeyPrev'); 
		}

		$f->attr('value', $licenseKey);
		$f->required = true; 
		$f->label = "Product Key";
		$f->attr('value', $licenseKey);
		$f->description = "Paste in your Form Builder product key.";
		$f->notes = "If you did not purchase Form Builder for this site, please [purchase a license here](https://processwire.com/FormBuilder/).";
		$f->icon = 'key';
		$f->set('themeOffset', 1); 
		
		/** @var FormBuilder $forms */
		$forms = $this->wire('forms');
		if($forms && $forms->isValidLicense()) $f->collapsed = Inputfield::collapsedYes;
		$this->inputfields->add($f);

		$session->set('FormBuilderLicenseKey', $licenseKey);
	}

	protected function configMarkup() {
	
		/** @var InputfieldFieldset $parentFieldset */
		$parentFieldset = $this->wire('modules')->get('InputfieldFieldset');
		$parentFieldset->label = $this->_('Advanced Output Settings');
		$parentFieldset->description = $this->_('We suggest leaving all these settings as they are, unless you have a specific need to change them.');
		$parentFieldset->collapsed = Inputfield::collapsedYes;
		$parentFieldset->icon = 'code';
		$parentFieldset->set('themeOffset', 1);
		
		$f = wire('modules')->get('InputfieldText');
		$f->attr('name', 'embedCode');
		$f->label = $this->_('Embed Iframe Markup');
		$f->description = $this->_('This is the iframe markup used by embed methods A and B.');
		$f->attr('value', !empty($this->data['embedCode']) ? $this->data['embedCode'] : FormBuilderMain::embedCode);
		$f->notes = 
			"We do not recommend modifying this unless you have a specific need to. " . 
			"Supported placeholders are:\n" . 
			"`{httpUrl}` Full http or https URL (matches request scheme).\n" .
			"`{httpsUrl}` Full https URL only, regardless of request scheme.\n" . 
			"`{url}` URL without scheme/host.\n" . 
			"`{name}` Form name.";
		$f->collapsed = Inputfield::collapsedYes;
		$parentFieldset->add($f);

		$fieldsets = array(
			'markup' => 'Form Markup', 
			'classes' => 'Form Classes'
			); 

		foreach($fieldsets as $fieldsetName => $fieldsetLabel) {

			$fieldset = wire('modules')->get('InputfieldFieldset'); 
			$fieldset->label = $fieldsetLabel . ' (Legacy Framework)';
			$fieldset->description = $this->_('Please note: these configuration settings apply only to forms using the "Legacy" framework. We suggest leaving these settings as is.');
			$fieldset->collapsed = Inputfield::collapsedYes; 

			$values = $this->$fieldsetName; 

			foreach($values as $key => $value) {

				$originalValue = $value; 
				$label = ucwords(str_replace('_', ' ', $key));
				$key2 = $fieldsetName . '_' . $key;

				preg_match_all('/(\{[^}]+\})/', $value, $matches); 
				$notes = '';
				foreach($matches[1] as $varName) $notes .= " $varName";
				if($notes) $notes = __('Possible variables:') . $notes; 

				if(strpos($value, "\n") !== false) $f = wire('modules')->get('InputfieldTextarea'); 
					else $f = wire('modules')->get('InputfieldText'); 

				if(array_key_exists($key2, $this->data)) $value = $this->data[$key2]; 
				if(empty($value)) $value = $originalValue; 
				

				$f->attr('name', $key2);
				$f->label = $label;
				$f->notes = $notes; 
				$value = str_replace("\t", '', $value); 
				$f->attr('value', trim($value)); 
				$fieldset->add($f); 
			}

			$parentFieldset->add($fieldset);
		}
		
		$this->inputfields->add($parentFieldset);
	}

	/**
	 * Install upgrades as needed
	 *
	 */
	protected function upgradeChecks() {
		// 0.1.8 check if we need to perform upgrade to install permissions
		$permission = $this->permissions->get('form-builder-add');
		if(!$permission || !$permission->id) {
			$this->message("Installing Form Builder permissions upgrade. Your forms are now access protected. Please check the new 'access' tab for each of your forms and confirm the settings are how you want them."); 
			include_once(dirname(__FILE__) . '/FormBuilderInstall.php'); 
			$install = new FormBuilderInstall();
			$install->installPermissions();
		}
	}

}
