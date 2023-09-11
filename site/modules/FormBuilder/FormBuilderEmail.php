<?php namespace ProcessWire;

/**
 * ProcessWire Form Builder Email
 *
 * Handles the emailing of Inputfields 
 *
 * Copyright (C) 2019 by Ryan Cramer Design, LLC
 *
 * PLEASE DO NOT DISTRIBUTE
 *
 * @todo: add option for text-based email
 * 
 * @property string $to
 * @property string $from
 * @property string $fromName
 * @property string $replyTo
 * @property string $subject
 * @property string $body
 *
 */

class FormBuilderEmail extends FormBuilderData {

	/**
	 * Instance of InputfieldForm
	 * 
	 * @var InputfieldForm
	 *
	 */
	protected $form = null;

	/**
	 * List of field names that should not be included in the email
	 * 
	 * @var array
	 *
	 */
	protected $skipFieldNames = array();

	/**
	 * List of field types that should not be included in the email
	 * 
	 * @var array
	 *
	 */
	protected $skipFieldTypes = array(
		'InputfieldSubmit',
		);

	/**
	 * Raw processed form data
	 * 
	 * @var array
	 * 
	 */
	protected $rawFormData = array();

	/**
	 * Additional variables to provide to email template
	 * 
	 * @var array
	 * 
	 */
	protected $templateVars = array();

	/**
	 * File attachments
	 * 
	 * @var array
	 * 
	 */
	protected $attachments = array();

	/**
	 * Whether or not to use file attachments in email
	 * 
	 * @var bool
	 * 
	 */
	protected $useFileAttachments = false;

	/**
	 * WireMail module name or 'WireMail' for native PHP mail() or blank for auto-detect
	 * 
	 * @var string
	 * 
	 */
	protected $mailerName = '';
	
	protected $values = array();
	
	protected $labels = array();

	/**
	 * Construct the FormBuilderEmail
	 *
	 * @param InputfieldForm $form
	 *
	 */
	public function __construct(InputfieldForm $form) {
		$this->form = $form;
		$this->set('to', ''); // required, may contain multiple lines/emails or conditions
		$this->set('from', ''); // optional, email address or field name to pull it from
		$this->set('replyTo', ''); 
		$this->set('subject', ''); // optional
		$this->set('body', ''); // optional, appears above form data
	}
	
	public function wire($key = '') {
		return $this->form->wire($key);
	}
	
	public function setRawFormData(array $data) {
		$this->rawFormData = $data; 
	}

	/**
	 * @return array
	 * 
	 */
	public function getRawFormData() {
		return $this->rawFormData;
	}

	/**
	 * Enable file attachments when an InputfieldFormBuilderFile field is detected during email body rendering
	 * 
	 * @param $useFileAttachments
	 * 
	 */
	public function setUseFileAttachments($useFileAttachments) {
		$this->useFileAttachments = (bool) $useFileAttachments;
	}

	/**
	 * Set name of mailer (WireMail) module to use, 'WireMail' for native PHP mail() or blank for auto-detect
	 * @param string $mailerName
	 * 
	 */
	public function setMailer($mailerName) {
		$this->mailerName = $mailerName;
	}

	/**
	 * Add a file attachment
	 * 
	 * @param $filename
	 * @return bool True if added, false if file does not exist
	 * 
	 */
	public function addFileAttachment($filename) {
		if(is_file($filename)) {
			$this->setUseFileAttachments(true);
			$this->attachments[$filename] = $filename;
			return true;
		}
		return false;
	}

	protected function matches($value1, $operator, $value2) {
		$matches = false;

		$values = $value1; 
		if(!is_array($values)) $values = array($values); 

		foreach($values as $value1) {
			switch($operator) {
				case '==':
				case '=': if($value1 == $value2) $matches = true; break;
				case '>': if($value1 > $value2) $matches = true; break;
				case '<': if($value1 < $value2) $matches = true; break;
				case '>=': if($value1 >= $value2) $matches = true; break;
				case '<=': if($value1 <= $value2) $matches = true; break;
				case '*=': if(strpos($value2, $value1) !== false) $matches = true; break;
				case '!=': if($value1 != $value2) $matches = true; break;
			}
			if($matches) break;
		}
		return $matches; 
	}

	/**
	 * Takes a list of email addresses, one per line and optionally including conditions, and converts them to an array of email addresses
	 *
	 * Conditional example:
	 * 	frontdesk@company.com (always gets emailed)
	 * 	inquiry_type=Sales? sales@company.com (gets emailed only when inquiry_type is 'Sales')
	 * 	inquiry_type=Support? help@company.com (gets emailed only when inquiry_type is 'Support')
	 *
	 * @param string $str Email addresses in a line separated string
	 * @return array
	 *
	 */
	public function emailsToArray($str) {

		$emails = array();

		foreach(explode("\n", $str) as $line) {

			$line = trim($line);

			if(strpos($line, '?') !== false) {
				// conditional address
				// VARIABLES:     1:field name        2:operator         3:value    4:email
				if(!preg_match('/^([-_.a-zA-Z0-9]+)\s*(=|==|>|<|>=|<=|\*=|!=)([^\?]*)\?\s*(.*)$/', $line, $matches)) continue; 

				$field = $matches[1];
				$subfield = '';
				if(strpos($field, '.') !== false) list($field, $subfield) = explode('.', $field);
				$operator = $matches[2];
				$requireValue = $matches[3];
				$addrs = explode(',', $matches[4]); // one email or optional multiple CSV string of emails
				if(!count($addrs)) continue; // invalid email address
				$inputfield = $this->form->get($field);
				if(!$inputfield) continue; // inputfield does not exist
				$inputValue = $inputfield->attr('value'); 

				// pull subfield value from an object, typically a $page
				if(is_object($inputValue) && $subfield) $inputValue = $inputValue->$subfield;

				if(!$this->matches($inputValue, $operator, $requireValue)) continue; // condition does not match

				// condition matches
				foreach($addrs as $email) $emails[] = $email;

			} else if(strpos($line, ',') !== false) {
				// multiple addresses on 1 line
				foreach(explode(',', $line) as $email) $emails[] = $email;

			} else {
				// just an email address
				$emails[] = $line;
			}
		}

		// sanitize and validate all found emails
		foreach($emails as $key => $email) {
			$email = $this->wire('sanitizer')->email($email);
			if(!strlen($email)) unset($emails[$key]); 
				else $emails[$key] = $email;
		}

		return $emails; 
	}

	/**
	 * Send the given $form to the email address
	 *
	 * @param string $template Name of email template to use
	 * @return bool|int
	 *
	 */
	public function send($template = 'email') {

		$to = $this->emailsToArray($this->to);

		// no addresses to send to
		if(!count($to)) return false; 
		
		$from = $this->getFromEmail();
		$replyTo = $this->getReplyToEmail();
		$subject = $this->wire('sanitizer')->text($this->subject);
		$bodyHTML = $this->renderBody($template);
		$result = false;
		$wireMail = null;
		$failedAttachmentMethod = '';
		
		// autogenerate an email subject if not provided
		if(!strlen($subject)) $subject = sprintf('%s form submission', $this->form->name); 

		/** @var WireMailTools $mail */
		$mail = $this->wire('mail');
		
		if($mail && method_exists($mail, '___new')) {
			// should cover almost all cases by now
			if($this->mailerName) {
				$wireMail = $mail->new(array('module' => $this->mailerName)); 
			} else {
				$wireMail = $mail->new();
			}
		} else if(function_exists('wireMail')) {
			$wireMail = wireMail();
		}
		/** @var WireMail $wireMail */
		
		if(count($this->attachments)) {
			// add attachments
			if(!$wireMail) {
				// using regular PHP mail method, attachments not supported
				$failedAttachmentMethod = 'old PW core version';
				
			} if($wireMail->className() != 'WireMail' && method_exists($wireMail, 'addAttachment')) {
				// 3rd party WireMail modules sometimes use an addAttachment() method
				// WireMailPHPMailer, WireMailMailgun
				foreach($this->attachments as $filename) {
					$wireMail->addAttachment($filename);
				}
			} else if(method_exists($wireMail, 'attachment')) {
				// core WireMail or 3rd party module that might implement attachments
				// WireMail, WireMailMandrill, WireMailSMTP
				foreach($this->attachments as $filename) {
					$wireMail->attachment($filename);
				}
			} else {
				// attachments not supported here
				// older core WireMail, WireMailMailChimp, WireMailSwiftMailer
				$failedAttachmentMethod = $wireMail->className();
			}
		} 
	
		if($failedAttachmentMethod) {
			$bodyHTML = $this->renderAttachmentFail($bodyHTML, $failedAttachmentMethod);
		}
		
		if($wireMail) {
			// WireMail	
			$wireMail->to($to);
			$wireMail->from($from);
			$wireMail->subject($subject);
			
			if($this->fromName) $wireMail->fromName($this->fromName);

			if(!empty($replyTo)) {
				if(method_exists($wireMail, 'replyTo')) {
					$wireMail->replyTo($replyTo);
				} else {
					$wireMail->header('Reply-to', $replyTo);
				}
			}

			$wireMail->body($this->markupToText($bodyHTML));
			$wireMail->bodyHTML($bodyHTML);
		
			// send message(s)
			$result = $wireMail->send();
			
		} else {
			// using PHP mail (deprecated, no longer possible to reach in PW 3.x versions)
			$headers = array('MIME-Version: 1.0', 'Content-Type: text/html; charset=utf-8');
			if(strlen($replyTo)) $headers[] = "Reply-to: $replyTo";
			if(strlen($from)) $headers[] = "From: $from";
			$params = $this->wire('config')->phpMailAdditionalParameters; 
			if(!$params) $params = '';
			
			foreach($to as $email) {
				$result = @mail($email, $subject, $bodyHTML, implode("\r\n", $headers), $params); 
			}
		}
		
		return $result;	
	}

	/**
	 * Render error message about attachment fail
	 * 
	 * @param string $bodyHTML
	 * @param string $culprit
	 * @return string
	 * 
	 */
	protected function renderAttachmentFail($bodyHTML, $culprit) {
		$files = array();
		
		foreach($this->attachments as $file) {
			$files[] = $this->wire('sanitizer')->entities(basename($file));
		}
		
		$warning = 
			"<p style='color:crimson; font-weight:bold; margin:20px 0;'>" .
			"WARNING: File attachments excluded because $culprit does not support them: " .
			implode(', ', $files)  .
			"</p>";
		
		if(stripos($bodyHTML, '</body>')) {
			$bodyHTML = str_ireplace('</body>', "$warning</body>", $bodyHTML);
		} else {
			$bodyHTML .= $warning;
		}
		
		return $bodyHTML;
	}

	/**
	 * Get the email 'from' address
	 * 
	 * @return string
	 * 
	 */
	protected function getFromEmail() {
		if($this->from) {
			$from = $this->wire('sanitizer')->email($this->from);
		} else {
			$from = $this->getReplyToEmail();
		}
		//if(!strlen($from)) $from = 'noreply@' . $this->wire('config')->httpHost;
		return $from;
	}

	/**
	 * Get the email 'reply-to' address, which may be pulled from a field name
	 *
	 * @return string
	 *
	 */
	protected function getReplyToEmail() {
		$replyTo = '';
		if(strpos($this->replyTo, '@')) {
			// email address
			$replyTo = $this->wire('sanitizer')->email($this->replyTo);
		} else if($this->replyTo) {
			// field name
			$field = $this->form->getChildByName($this->wire('sanitizer')->fieldName($this->replyTo));
			if($field) $replyTo = $this->wire('sanitizer')->email($field->attr('value'));
		}
		return $replyTo;
	}

	/**
	 * Render the body/message portion of an email with the form results
	 *
	 * Note: inline styles are used since many email clients (like gmail) won't work without them.
	 *
	 * @param string $template Name of email template to use
	 * @return string
	 *
	 */
	protected function renderBody($template) {

		$values = $this->values;
		$labels = $this->labels;

		foreach($this->form->getAll() as $f) {

			$skip = false;
			foreach($this->skipFieldTypes as $type) {
				if(class_exists("\\ProcessWire\\WireData")) $type = "\\ProcessWire\\$type";
				if($f instanceof $type) $skip = true;
			}
			
			if($skip) continue;
			if(in_array($f->name, $this->skipFieldNames)) continue;

			if($this->useFileAttachments && $f instanceof InputfieldFormBuilderFile) {
				$value = array();
				foreach($f->attr('value') as $filename) {
					$this->attachments[$filename] = $filename;
					$value[] = basename($filename); 
				}
				$value = implode("\n", $value); 
			} else {
				$parent = $f->getParent();
				if(!$parent) $parent = $this->form;
				$value = $parent->renderInputfield($f, true); 
			}

			// now we convert lists to newlines if the value changes when we do a replacement
			$len = strlen($value);
			$value = str_replace(array('<ul>', '<li>', '</ul>', '</li>'), array('', '', '', "\n"), $value);
			$value = preg_replace('!<(ul|ol)\s+[^>]*>!i', '', $value); // i.e. <ul class='PageArray'>
			if($len !== strlen($value)) $value = nl2br($value);
			
			$label = $f->label;

			// avoid showing label for PageBreak fields
			if($f->className() == 'InputfieldFormBuilderPageBreak') $label = ' ';

			$values[$f->name] = trim($value); 
			$labels[$f->name] = htmlentities($label, ENT_QUOTES, 'UTF-8');
		}

		// 1. first try /site/templates/FormBuilder/[template]-[form].php
		$filename = $this->wire('config')->paths->templates . "FormBuilder/$template-{$this->form->name}.php"; 

		// 2. next try /site/templates/FormBuilder/[template].php
		if(!is_file($filename)) $filename = $this->wire('config')->paths->templates . "FormBuilder/$template.php"; 

		// 3. otherwise, use the predefined one in /site/modules/FormBuilder/[template].php
		if(!is_file($filename)) $filename = dirname(__FILE__) . "/$template.php"; 

		$t = new TemplateFile($filename);
		foreach($this->templateVars as $name => $value) {
			$t->set($name, $value);
		}
		$t->set('values', $values); 
		$t->set('labels', $labels); 
		$t->set('body', $this->populateTags($this->body)); 
		$t->set('subject', $this->subject); 
		$t->set('form', $this->form);
		$t->set('formData', $this->rawFormData); 
		$t->set('formBuilderEmail', $this); 
		
		return $t->render();
	}

	/**
	 * Convert HTML email body to text email body
	 * 
	 * @param string $html
	 * @return string
	 * 
	 */
	protected function markupToText($html) {
		/** @var Sanitizer $sanitizer */
		$sanitizer = $this->wire('sanitizer');
		if(method_exists($sanitizer, 'getTextTools')) {
			$textTools = $sanitizer->getTextTools(); 
			$text = $textTools->markupToText($html);
		} else if(method_exists($sanitizer, 'markupToText')) {
			$text = $sanitizer->markupToText($html);
		}  else {
			$text = $sanitizer->unentities(strip_tags($html));
		}	
		$text = trim($text);
		$text = str_replace("\n", "\r\n", $text);
		while(strpos($text, "\r\r") !== false) {
			$text = str_replace("\r\r", "\r", $text); 
		}
		return $text;
	}

	/**
	 * Convert form field [field_name] tags to values in body
	 * 
	 * @param string $body
	 * @return string
	 *
	 */
	protected function populateTags($body) {
		if(strpos($body, '[') === false) return $body;
		if(!preg_match_all('/\[([_.a-zA-Z0-9]+)\]/', $body, $matches)) return $body;
		foreach($matches[1] as $key => $fieldName) {
			$field = $this->form->get($fieldName); 	
			if(!$field || !$field instanceof Inputfield) continue; 
			$parent = $field->getParent();
			if(!$parent) $parent = $this->form;
			$value = $parent->renderInputfield($field, true); 
			$value = str_replace("</li>", ", ", $value); 
			$value = trim(strip_tags($value), ", "); 
			$body = str_replace($matches[0][$key], $value, $body); 
		}
		return $body; 
	}

	/**
	 * Set a field name that should be skipped
	 * 
	 * @param string $fieldName
	 * @return $this
	 *
	 */
	public function setSkipFieldName($fieldName) {
		$this->skipFieldNames[] = $fieldName;
		return $this;
	}

	/**
	 * Set a field type that should be skipped
	 * 
	 * @param string $fieldType
	 * @return $this
	 *
 	 */
	public function setSkipFieldType($fieldType) {
		$this->skipFieldTypes[] = $fieldType;
		return $this;
	}

	/**
	 * Set a variable to be provided to the rendering template
	 *
	 * @param string $name
	 * @param mixed $value
	 * @return $this
	 *
	 */
	public function setTemplateVar($name, $value) {
		$this->templateVars[$name] = $value; 
		return $this; 
	}

	/**
	 * Add additional values to appear in email, indexed by field/property name
	 * 
	 * For any values you add, be sure to also call setLabels() for them as well. 
	 * 
	 * @param array $values
	 * @param bool $entityEncode Specify false to prevent values from being entity encoded
	 * 
	 */
	public function setValues(array $values, $entityEncode = true) {
		if($entityEncode) {
			foreach($values as $k => $v) {
				$values[$k] = htmlentities($v, ENT_QUOTES, 'UTF-8');
			}
		}
		$this->values = array_merge($this->values, $values); 
	}

	/**
	 * Add additional labels to appear in email, indexed by field/property name
	 * 
	 * @param array $labels
	 * @param bool $entityEncode Specify false to prevent values from being entity encoded
	 * 
	 */
	public function setLabels(array $labels, $entityEncode = true) {
		if($entityEncode) {
			foreach($labels as $k => $v) {
				$labels[$k] = htmlentities($v, ENT_QUOTES, 'UTF-8');
			}
		}
		$this->labels = array_merge($this->labels, $labels); 
	}

}
