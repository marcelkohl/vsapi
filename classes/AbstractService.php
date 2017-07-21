<?php
	/**
	*    This file is part of the VSAPI (Very Simple API).
	*
	*    VSAPI is a free project: you can redistribute it and/or modify it under the terms of the Apache License as published by the Apache.org.
	*    The VSAPI is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the Apache License for more details.
	*    You should have received a copy of the Apache License along with VSAPI. If not, see http://www.apache.org/licenses/.
	*
	*    @author      Marcel Kohls (cerealmx@gmail.com)
	*    @license     http://www.apache.org/licenses/ or/and https://choosealicense.com/licenses/apache-2.0/
	*    @link        https://github.com/marcelkohl
	*/

	namespace classes;

	class AbstractService
    {
        private $requestedFields;
		private $allowedFields;
		private $allowedMethods;
		private $answerType;
		private $requestedMethod;

		protected function initialize($pSettings)
		{
			$this->requestedMethod = $_SERVER['REQUEST_METHOD'];
			$this->loadSettings($pSettings);
			$this->loadRequestedFields();
			$this->runRequestedMethod();
		}

		protected function loadSettings($pSettings)
		{
			$this->allowedMethods = (isset($pSettings['allowedMethods']) ? $pSettings['allowedMethods'] : []);
			$this->allowedFields = (isset($pSettings['allowedFields']) ? $pSettings['allowedFields'] : []);
			$this->answerType = (isset($pSettings['answerType']) ? $pSettings['answerType'] : AST_AUTO);
		}

		protected function runRequestedMethod()
		{
			$callOnMethods = ['GET'=>'onGet', 'POST'=>'onPost', 'PUT'=>'onPut', 'PATCH'=>'onPatch', 'DELETE'=>'onDelete', 'OPTIONS'=>'onOptions'];

			if (in_array($this->requestedMethod, $this->allowedMethods)) {
				$this->$callOnMethods[$this->requestedMethod]();
			} else {
				$this->answer(['type' => API_DEFAULT_ERROR_REFERENCE,
							   'detail' => 'Method not acceptable',
							   'status' => '406',
							   'title' => 'Not Acceptable',
						   	  ], 406);
			}
		}

		protected function changeAutoAnswerTypeTo($pAnswerType)
		{
			if ($this->answerType == AST_AUTO) {
				$this->answerType = $pAnswerType;
			}
		}

		protected function loadRequestedFields()
		{
			$requestContents = file_get_contents('php://input');

			if (count(xmlrpc_decode($requestContents)) > 0) {
				$this->changeAutoAnswerTypeTo(AST_XML);
				$rowData = xmlrpc_decode($requestContents, 'utf-8')[0];
			} else {
				$this->changeAutoAnswerTypeTo(AST_JSON);
				$rowData = json_decode(urldecode($requestContents), true);
			}

			foreach($_REQUEST as $pField => $pValue){ $this->requestedFields[$pField] = sanitizeParam($pValue); }

			if (isset($rowData)){
				foreach($rowData as $pField => $pValue){ $this->requestedFields[$pField] = sanitizeParam($pValue); }
			}
		}

		protected function answer($pContent, $pStatus=200)
		{
			\classes\ServiceAnswer::send($pContent, $pStatus, $this->answerType);
		}

		protected function answerAsFailedValidation($pContent=[])
		{
			$answerType = (isset($pContent['type']) ? $pContent['type'] : API_DEFAULT_ERROR_REFERENCE);
			$answerMessages = (isset($pContent['validation_messages']) ? $pContent['validation_messages'] : ['default' => 'Cannot validate field(s)']);

			$this->answer(['type' => $answerType,
						   'detail' => 'Failed Validation',
						   'status' => '422',
						   'title' => 'Unprocessable Entity',
						   'validation_messages' => $answerMessages
					   ], 422);
		}

		protected function getFields()
		{
			return $this->requestedFields;
		}

		protected function getValue($pFieldName)
		{
			return (isset($this->requestedFields[$pFieldName]) ? $this->requestedFields[$pFieldName] : null);
		}

		public function execute()
		{
			$this->initialize(['allowedMethods'=>[AMT_GET, AMT_OPTIONS],
							   'allowedFields'=>[],
							   'answerType'=>AST_JSON
							  ]);
		}

		public function onGet()
		{

		}

		public function onPost()
		{

		}

		public function onPut()
		{

		}

		public function onPatch()
		{

		}

		public function onDelete()
		{

		}

		public function onOptions()
		{
			$this->answer(['Allow' => $this->allowedMethods]);
		}
    }
