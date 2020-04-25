<?php
if (function_exists('saveErrorLog') == false){
	function saveErrorLog($pContent, $pErrorObj) {
		$dataHora = new DateTime('now');
		$fileName = $dataHora->format('Ymd-His').'-'.rand(111111111,999999999);
		$content = '['.$dataHora->format('Y-m-d H:i:s').']'.PHP_EOL;
		$content .= ''.$pErrorObj->getMessage().PHP_EOL.''.PHP_EOL;

		$trace = $pErrorObj->getTrace();
		foreach($trace as $item){
			if (isset($item['file'])){
				$content .= $item['file'].' on line '.$item['line'].PHP_EOL;
			}
		}

		if (isset($_SESSION)){
			$content .= ''.PHP_EOL.'Session: '.PHP_EOL;
			$content .= print_r($_SESSION, TRUE).PHP_EOL;
		}
		if (isset($_POST)){
			$content .= ''.PHP_EOL.'Parameters POST: '.PHP_EOL;
			$content .= print_r($_POST, TRUE).PHP_EOL;
		}
		if (isset($_GET)){
			$content .= ''.PHP_EOL.'Parameters GET: '.PHP_EOL;
			$content .= print_r($_GET, TRUE).PHP_EOL;
		}

		error_log($content, 3, SRC_TEMPFILES."/err-".$fileName.".log");
	}
}
?>
