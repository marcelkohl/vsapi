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

    header('Access-Control-Allow-Origin: *');

    require_once('includes/global-settings.php');
    require_once(SRC_INCLUDES.'/autoload.php');

    require_once(SRC_INCLUDES.'/header-status.php');
    require_once(SRC_INCLUDES.'/exception-thrower.php');
	require_once(SRC_INCLUDES.'/sanitize.php');
	require_once(SRC_INCLUDES.'/error-log.php');

    ExceptionThrower::Start();

    $vsapiversion = (isset($_REQUEST['vsapiversion']) ? $_REQUEST['vsapiversion'] : '');
    $vsapiservice = (isset($_REQUEST['vsapiservice']) ? $_REQUEST['vsapiservice'] : '');
    $vsapiuid = (isset($_REQUEST['vsapiuid']) ? $_REQUEST['vsapiuid'] : '');

    try{
        if (file_exists(SRC_SERVICES.'/'.$vsapiversion.'/'.$vsapiservice.'.php')) {
            $vsapiservicename = 'services\\'.$vsapiversion.'\\'.$vsapiservice;
        } else {
            $vsapiservicename = 'services\\Undefined';
        }

        $serviceToRun = new $vsapiservicename();
        $serviceToRun->execute();
    } catch(Exception $e) {
        saveErrorLog($vsapiservice, $e);
    }

    ExceptionThrower::Stop();
