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
    use \Datetime;

    class ServiceAnswer
    {
        public static function send($pContent=null, $pStatus=200, $pAnswerType=AST_JSON)
        {
            $contentResult = array();

            foreach ($pContent as $key => $value) {
                $contentResult[$key] = $value;
            }

            header_status((AST_JSON ? $pStatus : 200));

            if ($pAnswerType == AST_JSON) {
                header('Content-Type: application/json');
                echo json_encode($contentResult);
            } else if ($pAnswerType == AST_XML) {
                header("Content-type: text/xml");

                if ($pStatus >= 400 && $pStatus <= 599) {
                    $detail = (isset($contentResult['detail']) && strlen($contentResult['detail']) > 0 ? ' ('.$contentResult['detail'].')' : '');
                    $title = (isset($contentResult['title']) && strlen($contentResult['title']) > 0 ? $contentResult['title'] : 'Undefined Fault');
                    $faultString = $title.$detail;
                    $todayNow = (new DateTime('now'))->format('Ymd\\TH:i:s');

                    echo xmlrpc_encode(array("faultCode"=>$pStatus, "faultString"=>$faultString, "timestamp"=>$todayNow));
                } else {
                    echo xmlrpc_encode($contentResult);
                }
            }
        }
    }
