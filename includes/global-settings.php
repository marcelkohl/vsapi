<?php
	define('API_ROOT', $_SERVER['DOCUMENT_ROOT']);
	define('API_LOCALPATH', "/vsapi"); // subfolder on your root
	define('API_FULLPATH', API_ROOT.API_LOCALPATH);

	define('API_NAME', 'My Sample API');
	define('API_DEFAULT_ERROR_REFERENCE', 'http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html');

	define('SRC_TEMPFILES', API_FULLPATH."/tempfiles");
	define('SRC_CLASSES', API_FULLPATH."/classes");
	define('SRC_INCLUDES', API_FULLPATH."/includes");
	define('SRC_SERVICES', API_FULLPATH."/services");

	define('VERSION_MAJOR', '1');
	define('VERSION_MIDDLE', '0');
	define('VERSION_MINOR', '0');

	// Allowed Service Methods
	const AMT_GET="GET", AMT_POST="POST", AMT_PUT="PUT", AMT_PATCH="PATCH", AMT_DELETE="DELETE", AMT_OPTIONS="OPTIONS";
	// Answer Types
	const AST_AUTO=-1, AST_JSON=0, AST_XML=1;
