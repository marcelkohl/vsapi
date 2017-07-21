# Very Simple API Pack

The very simple API pack is an effort to make a pack with the very basic stuff to those developers who needs to make an API but doen't want to start from the very beggining.

The vsapi pack now in on the level 2 [maturity level](https://martinfowler.com/articles/richardsonMaturityModel.html) (and I hope to soon be on Level 3), it covers the following basic resources of an API:
* REST or XML-RPC Calls (Automatic detection or Restricted by the developer)
* Run specific methods according to the method call (POST, GET, PUT, PATCH, DELETE, OPTIONS or Restricted by the developer)
* Answering on standards [REST](https://www.w3.org/2001/sw/wiki/REST) and [XML-RPC](http://xmlrpc.scripting.com/spec.html)
* Exception Handler
* Sanitization to avoid injection
* Transparent Log Error (write internal errors to file)
* Versioning services control

## Setting up
The Very Simple API Pack is ready to go, just unpack the files, set-up the global settings with your server path, API name and version and it will be working.

* Unpack the files on a folder on your server;
* Edit the ```include/global-settings.php``` file and edit your path, api name, version, and default page for error reference;
* Edit the ```.htaccess``` to fit your server path

If everything goes right, the sample service (Ping) should work:
```html
http://your-server-name/vsapi/v1/Ping
```

More samples can be found at the examples folder.

## How does it works
### URL
The vsapi API URL is interpreted by the htaccess file as:
```html
http://[server/path/to/api]/[version]/[service-to-call]/[optional-unique-id]
```

### Folders
The vsapi pack is structured as the following:
* /classes
  * The core classes that makes the API work;
* /includes
  * Configuration files, additional resources and libs to deal with headers, exceptions, sanitization and errors;
* /services
  * where the files of your services should be added. the structure is based on versioning and should be like: /services/v1, /services/v2, /services/v...
* /tempfiles
  * folder to use for temporary files. Also used by the exception logger;
* index.php
  * manages the requests, check the existence of the services and redirects to the right ways;


## Reference
### Constants
The constants declarated on the API are:
* ```API_ROOT```: Root path to the API
* ```API_LOCALPATH```: Folder path to the API
* ```API_FULLPATH```: Complete path to the API
* ```API_NAME```: Name description for the API
* ```API_DEFAULT_ERROR_REFERENCE```: Default reference page mentioned on answers when some error occurs
* ```SRC_TEMPFILES```: tempfiles folder
* ```SRC_CLASSES```: classes folder
* ```SRC_INCLUDES```: includes folder
* ```SRC_SERVICES```: services folder
* ```VERSION_MAJOR```: version major number
* ```VERSION_MIDDLE```: version middle number
* ```VERSION_MINOR```: version minor number

* Allowed methods: ```AMT_GET, AMT_POST, AMT_PUT, AMT_PATCH, AMT_DELETE, AMT_OPTIONS```
* Answer types: ```AST_AUTO, AST_JSON, AST_XML```

### Classes
Public Methods of ```AbstractService```
  * ```initialize(arrayOfArguments)```: Initializes the service enviroment. Should be called with an array of arguments that specifies the allowed methods and the answer types;
```php
    $this->initialize([
    	'allowedMethods'=>[AMT_GET, AMT_POST, AMT_OPTIONS],
        'answerType'=>AST_AUTO
        ]);
   ```
  * ```execute()```: Called automatically when the API is called. Must include the initialization settings and the of the service and the ```initialize``` method.
  * ```onGet()```: Called when the method used is a GET type
  * ```onPost()```:  Called when the method used is a POST type
  * ```onPut()```:  Called when the method used is a PUT type
  * ```onPatch()```:  Called when the method used is a PATCH type
  * ```onDelete()```:  Called when the method used is a DELETE type
  * ```onOptions()```:  Called when the method used is a OPTIONS type. This method dont need to be overwritten because it alread answers as it should be.
  * ```getFields()```: returns an array with the fields that came on the request;
  * ```getValue(fieldName)```: returns the value of a specific field that came on the request;
```php
    $this->getValue('userId');
   ```
   * ```answer(arrayOfValues)```: Returns a formated answer according to the answerType defined on the initialization.
```php
    $this->answer([
				'message' => 'Here are the fields that the API received',
				'fields' => $this->getFields(),
                'nameOfTheField' => 'the Value here'
			]);
   ```
   * ```answerAsFailedValidation(optionalArrayOfValues)```: Returns a formated error/fail message answer according to the answerType defined on the initialization. The array of values to return is optional and if is not provided, a generic message will be returned.
   ```php
$this->answerAsFailedValidation([
	'validation_messages' => [
                              'uniqueId'=>'Unique ID is a required field',
                              'email'=>'your email is not valid',
                              'mySpecificField'=>'Message for the field'
                             ]]);
   ```

## How to use
### Calling a REST service through AJAX
```javascript
function postItem() {
    $.ajax({
        type : 'POST',
        url : "http://api-server-name/v1/Ping",
        data : JSON.stringify({
                    "message": "sample message here",
                    "user": "the-best-user-ever",
                    "list": ["first", "second", "third"]
                }),
        contentType: "application/json",
        success : function(data){
            // use your code here to process data content returned
        }
    });
}
```
### Calling a XML-RPC service through PHP
```php
$method = "POST";
    $request = xmlrpc_encode_request("methodName", array("methodParam"=>"param1", "otherMethodParam"=>"param2 with spaces"));
    $context = stream_context_create(array('http' => array(
        'method' => $method,
        'header' => "Content-Type: text/xml",
        'content' => $request
    )));

    $file = file_get_contents("http://localhost/vsapi/api/v1/Ping", false, $context);
    $response = xmlrpc_decode($file);

    if (xmlrpc_is_fault($response)) {
        trigger_error("xmlrpc: $response[faultString] ($response[faultCode])");
    } else {
        print_r($response);
    }

```

## To-do
Here are some resources that still need to be implemented on the pack:

* Unique ID transaction: Automatically control/manage and generate the unique id for each transaction, as defined on the REST standards;
* Fields permission: The hability to define which fields are required, optional, or free on the request;
* Filtering and Validation: To automatically filter or validate the fields of request (less than, lower than, not blank, remove spaces, etc);
* Returning types: as a register or  collection;
* htaccess limits: Adjust the htaccess to avoid setting up it on every new project/domain;
* Error codes returned by the API: Need to review if all the codes fits the specification and cover other error codes;
* Documentation: Define ways to automatically generate documentation;

## License
vsapi API Pack is a free project: you can redistribute it and/or modify it under the terms of the Apache License as published by the Apache.org.
The vsapi is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the Apache License for more details.
