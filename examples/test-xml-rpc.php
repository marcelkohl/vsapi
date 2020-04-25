<?php
$method = "POST"; // DELETE, GET, PATCH, POST,
$request = xmlrpc_encode_request("methodName", array("methodParam"=>"param1", "otherMethodParam"=>"param2 with spaces"));
$context = stream_context_create(array('http' => array(
    'method' => $method,
    'header' => "Content-Type: text/xml",
    'content' => $request
)));

// sample using unique Id on URL (PATCH, DELETE)
// $file = file_get_contents("http://localhost/vsapi/api/v1/Ping/12345", false, $context);

$file = file_get_contents("http://localhost/vsapi/api/v1/Ping", false, $context);
$response = xmlrpc_decode($file);

if (xmlrpc_is_fault($response)) {
    trigger_error("xmlrpc: $response[faultString] ($response[faultCode])");
} else {
    print_r($response);
}
