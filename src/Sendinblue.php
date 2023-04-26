<?php

namespace Lquintana\Sendinblue;

use GuzzleHttp\Client;
use SendinBlue\Client\ApiException;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Api\AccountApi;
use SendinBlue\Client\Api\SendersApi;
use SendinBlue\Client\Api\ContactsApi;
use SendinBlue\Client\Model\CreateContact;
use SendinBlue\Client\Model\UpdateContact;
use SendinBlue\Client\Api\EmailCampaignsApi;
use SendinBlue\Client\Model\AddContactToList;
use SendinBlue\Client\Model\RemoveContactFromList;

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
		try {
			//Calling endpoint if exist
			if(method_exists($this->apiInstance, $method))
			{
				return call_user_func_array(array($this->apiInstance, $method), $args);
			}

			//Or treat it as a property
			return $this->apiInstance->{$method};
		} catch (ApiException $e) {
			return $e;
		}
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

	public function updateOrCreate(string $email, array $contact, array $lists = [])
	{
		$createContact = new CreateContact([
            'email' => $email,
			'updateEnabled' => true,
			'attributes' => (object) $contact, 
			'listIds' => $lists,
       ]);
		try {
			$this->apiInstance->createContact($createContact);
		} catch (ApiException $e) {
			return $e;
		}
	}

	public function addToList(int $listId, array $emails)
	{
		$contactIdentifiers = new AddContactToList();
		$contactIdentifiers['emails'] = $emails;
		try {
			$this->apiInstance->addContactToList($listId, $contactIdentifiers);
		} catch (ApiException $e) {
			return $e;
		}
	}

	public function removeFromList(int $listId, array $emails)
	{
		$contactIdentifiers = new RemoveContactFromList();
		$contactIdentifiers['emails'] = $emails;
		try {
			$this->apiInstance->removeContactFromList($listId, $contactIdentifiers);
		} catch (ApiException $e) {
			return $e;
		}
	}

	public function update($identifier, $contactDetails)
	{
		$updateContact = new UpdateContact();
		$updateContact['attributes'] = $contactDetails;

		try {
			$this->apiInstance->updateContact($identifier, $updateContact);
		} catch (ApiException $e) {
			return $e;
		}
	}
}