<?PHP
require_once('JSON.php');
require_once("$base/antispam/util/Object.class.php");

class RequestSpamApi extends Object{
	var $api_url='antispam.spamcop.or.kr';
	var $plugin = 'Gnuboard';

	function _request($body){

		$header = sprintf(
				"POST / HTTP/1.1\r\n".
				"Host: %s\r\n".
				"Connection: close\r\n".
				"Content-Type: text/json; charset=UTF-8\r\n".
				"Content-Length: %s\r\n\r\n".
				"%s\r\n"
				,$this->api_url
				,strlen($body)
				,$body);  

		$fp = @fsockopen($this->api_url, '8405', $errno, $errstr, 5); 
		if(!$fp) return false;

		fputs($fp, $header);

		//while(trim($buffer = fgets($fp,1024)) != ""); 

		$data = "";
		while(!feof($fp)) {
			$data .= trim(fgets($fp, 4096));
		}   
		fclose($fp);

		return $data;
	}

	function _getRequestBody(){
		if(!$this->get('method')) return false;
		$obj = $this->getObjectVars();

		$req = new stdClass;
		$req->methodcall = new stdClass;
		$req->methodcall->params = $obj;
		$str = json_encode2($req);
		$str = str_replace(array("\r\n","\n","\t"),array('\n','\n','\t'),$str);
		//$str = str_replace(array("\r\n","\n","\t"),array('','',''),$str);

		return $str;
	}

	function _parse($str){
		$obj = json_decode2($str);

		if(!is_object($obj) || !$obj->response) return false;
		
		$response = $obj->response;
		if($response->error != 0) return false;

		return $response;
	}

	function request(){
		$body = $this->_getRequestBody();
		$str = $this->_request($body);
		$obj = $this->_parse($str);

		return $obj;
	}
}
?>
