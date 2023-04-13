<?php

namespace Lquintana\Sendinblue;

use GuzzleHttp\Client;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Api\AccountApi;
use SendinBlue\Client\Api\SendersApi;
use SendinBlue\Client\Api\ContactsApi;
use SendinBlue\Client\Api\EmailCampaignsApi;

class Sendinblue
{
    /**
	 * This is an instance of class Sendinblue
	 *
	 * @var apiInstance
	 */
	protected $apiInstance;

	/**
	 * Configuration to connect to sendinblue
	 *
	 * @var config
	 */
	protected $config;

	/**
	 * Constructor
	 * 
	 * @param Configuration $config
	 * @return void
	 */
	public function __construct(Configuration $config)
	{
		$this->config = $config;
	}

    /**
	 * Proxies call to the underlying Sendinblue API
	 *
	 * @param $method
	 * @param array $args
	 * @return mixed
	 */
	public function __call($method, array $args)
	{
		//Calling endpoint if exist
		if(method_exists($this->apiInstance, $method))
		{
			return call_user_func_array(array($this->apiInstance, $method), $args);
		}

		//Or treat it as a property
		return $this->apiInstance->{$method};
	}

	/**
	 * Sendinblue Contacts API Instance
	 * @return mixed
	 */
	public function contacts()
	{
		$this->apiInstance = new ContactsApi(
			new Client(),
			$this->config
		);
		return $this;
	}

	/**
	 * Sendinblue Account API Instance
	 * @return mixed
	 */
	public function account()
	{
		$this->apiInstance= new AccountApi(
			new Client(),
			$this->config
		);
		return $this;
	}

	/**
	 * Sendinblue Sender API Instance
	 * @return mixed
	 */
	public function sender()
	{
		$this->apiInstance= new SendersApi(
			new Client(),
			$this->config
		);
		return $this;
	}
}