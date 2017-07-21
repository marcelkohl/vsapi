<?php
if (function_exists('sanitizeParam') == false){
	function sanitizeParam($pContents){
		$retorno = '';

		if (is_array($pContents)){
			$tArray = array();

			foreach($pContents as $index=>$item){
				$tArray[$index] = sanitizeParam($item);
			}

			$retorno = $tArray;
		} else {
			$content = trim(addslashes(strip_tags($pContents)));

			$lValue = preg_replace('/[^a-zA-Z0-9\.\@\-\/\:\,\_]/', " ", $content );
			$lValue = removeKeywords($lValue);

			$retorno = $lValue;
		}

		return $retorno;
	}
}

if (function_exists('removeKeywords') == false){
	function removeKeywords($pString){
		$retorno = $pString;
		$removes = array(' OR ', 'AND ', 'REGEXP', 'LIKE ', 'BENCHMARK', 'WHERE ', 'SUBSTRING', 'SELECT', 'SCHEMA', 'TABLE', 'FROM ', 'WAITFOR', 'DELAY', 'ARRAY', '.ini', 'SCRIPT', 'vbscript', 'javascript', 'alert(', 'onload', 'IFRAME');

		foreach($removes as $value){
			$retorno = str_ireplace($value, " ", $retorno);
		}

		return $retorno;
	}
}
