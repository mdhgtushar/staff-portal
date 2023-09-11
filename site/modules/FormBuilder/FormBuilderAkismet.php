<?php namespace ProcessWire;

/**
 * ProcessWire Form Builder Akismet Spam Filter
 *
 * Enables Form Builder to check a Form Builder submission for spam.
 *
 * Copyright (C) 2019 by Ryan Cramer Design, LLC
 *
 * PLEASE DO NOT DISTRIBUTE
 * 
 * @property string $apiKey
 * @property array $headers
 *
 */

class FormBuilderAkismet extends WireData {

	/**
	 * Initialize
	 *
	 * @param string $apiKey Akismet API key
	 * @throws FormBuilderException
	 *
	 */
	public function __construct($apiKey) {
		$this->set('apiKey', $apiKey);
		$this->set('headers', array('user-agent' => 'ProcessWire/3 | FormBuilderAkismet/2'));
		if(!$this->apiKey) throw new FormBuilderException("No Akismet API key is set");
	}

	/**
	 * Verify that provided API key is valid
	 *
	 * @return bool
	 *
	 */
	public function verifyKey() {
		$response = $this->httpPostAkismet('https://rest.akismet.com/1.1/verify-key', array('key' => $this->apiKey));
		if($response == 'valid') return true;
		if($response == 'invalid' && $this->user->isSuperuser()) {
			$this->error("Invalid Akismet Key {$this->apiKey}, " . print_r($response, true));
		}
		return false;
	}

	/**
	 * Check if the provided author, email, content is spam
	 *
	 * @param string $author Author name
	 * @param string $email Email address
	 * @param string $content Text of message
	 * @return bool True if spam, false if not
	 *
	 */
	public function isSpam($author, $email, $content) {

		if(!$this->verifyKey()) return false;

		$data = array(
			'user_ip' => $this->wire('session')->getIP(),
			'user_agent' => $this->wire('sanitizer')->text($_SERVER['HTTP_USER_AGENT']), 
			'permalink' => $this->wire('page')->httpUrl(), 
			'comment_type' => 'contact-form',
			'comment_author' => $author,
			'comment_author_email' => $email,
			'comment_content' => $content, 
			); 

		$response = $this->httpPostAkismet("https://{$this->apiKey}.rest.akismet.com/1.1/comment-check", $data); 
		
		return $response == 'true';
	}

	/**
	 * Issue an Akismet-specific HTTP post
	 *
	 * @param string $url URL to post to
	 * @param array $data Array of data to post
	 * @return string Akismet response
	 *
	 */
	protected function httpPostAkismet($url, array $data) {

		$defaults = array('blog' => ($this->config->https ? 'https://' : 'http://') . $this->config->httpHost);
		$data = array_merge($defaults, $data);

		$http = new WireHttp();
		$http->setHeaders($this->headers);
		$response = $http->post($url, $data); 

		return $response;
	}

}
