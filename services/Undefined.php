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

	namespace services;

	class Undefined extends \classes\AbstractService
	{
		public function execute()
		{
			$this->answer(['type' => API_DEFAULT_ERROR_REFERENCE,
						   'detail' => 'The requested service does not exist in this API',
						   'status' => '400',
						   'title' => 'Bad Request',
					   ], 400);
		}
	}
