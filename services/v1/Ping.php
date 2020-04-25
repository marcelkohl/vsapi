<?php

namespace services\v1;

class Ping extends \classes\AbstractService
{
	public function execute()
	{
		$this->initialize(['allowedMethods'=>[AMT_GET, AMT_POST, AMT_PATCH, AMT_DELETE, AMT_OPTIONS],
						   'answerType'=>AST_AUTO //AST_JSON, AST_XML, AST_AUTO
						  ]);
	}

	public function onGet()
	{
		$this->answer([
			'message' => 'On GET method, you cannot send fields. Use POST instead.',
			'fields' => $this->getFields()
		]);
	}

	public function onPost()
	{
		$this->answer([
			'message' => 'Here are the fields that the API received',
			'fields' => $this->getFields()
		]);
	}

	public function onDelete()
	{
		if (!$this->getValue('vsapiuid')) {
			// default failed validation, without message
			// $this->answerAsFailedValidation();

			$this->answerAsFailedValidation([
				'validation_messages' => ['uniqueId'=>'Unique ID is a required field']
			]);
		} else {
			$this->answer([
				'message' => 'Item '.$this->getValue('vsapiuid').' deleted!'
			]);
		}
	}
}
