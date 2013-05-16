<?php
namespace Infra\Utils;

class RestRequest {
  protected $url;
	protected $verb;
	protected $requestBody;
	protected $requestLength;
	protected $username;
	protected $password;
	protected $acceptType;
	protected $responseBody;
	protected $responseInfo;
	protected $headers = array();
	protected $upload=false;
	protected $proxyInfo;
	
	public function __construct ($url = null, $verb = 'GET', $requestBody = null){
		$this->url = $url;
		$this->verb = $verb;
		$this->requestBody = $requestBody;
		$this->requestLength = 0;
		$this->username = null;
		$this->password = null;
		$this->acceptType = 'text/html';//application/soap+xml';//'application/json';
		$this->responseBody = null;
		$this->responseInfo = null;
		//$this->headers = array ("type"=>'Accept: ' . $this->acceptType);
		
		if ($this->requestBody !== null) {
			$this->buildPostBody();
		}
	}
	
	function addHeader($key,$value) {
		$this->headers[] = "{$key}: {$value}";
	}
	
	function setProxyInfo( $dsn ) {
		$this->proxyInfo = parse_url($dsn);
	}
	
	public function flush (){
		$this->requestBody		= null;
		$this->requestLength	= 0;
		$this->verb				= 'GET';
		$this->responseBody		= null;
		$this->responseInfo		= null;
	}
	
	public function execute (){
		$ch = curl_init();
		$this->setAuth($ch);
		try {
			switch ( strtoupper($this->verb) ) {
				case 'GET':
					$this->executeGet($ch);
					break;
				case 'POST':
					$this->executePost($ch);
					break;
				case 'PUT':
					$this->executePut($ch);
					break;
				case 'DELETE':
					$this->executeDelete($ch);
					break;
				default:
					throw new InvalidArgumentException('Current verb (' . $this->verb . ') is an invalid');
			}
		}
		catch (InvalidArgumentException $e) {
			curl_close($ch);
			throw $e;
		}
		catch (Exception $e) {
			curl_close($ch);
			throw $e;
		}
	}
	
	public function buildPostBody ($data = null){
		$data = ($data !== null) ? $data : $this->requestBody;
		if (!is_array($data)) {
			//throw new InvalidArgumentException('Invalid data input for postBody. Array expected');
		}
		$tmp = ( is_array( $data ) )
			? (implode("",$data))
			: $data;
		if ( strpos("@",$tmp) > -1 ) {
			$this->upload = true;
		} else {
			$data = http_build_query($data, '', '&');
		}
		unset($tmp);
		$this->requestBody = $data;
				
	}
	
	protected function executeGet ($ch) {
		$this->doExecute($ch);
	}
	
	protected function executePost ($ch) {
		if ( !is_string($this->requestBody) ) {
			$this->buildPostBody();
		}
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->requestBody);
		if ( !$this->upload )
			curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		$this->doExecute($ch);
	}
	
	protected function executePut ($ch) {
		if (!is_string($this->requestBody)) {
			$this->buildPostBody();
		}
		$this->requestLength = strlen($this->requestBody);
		$fh = fopen('php://memory', 'rw');
		fwrite($fh, $this->requestBody);
		rewind($fh);
		curl_setopt($ch, CURLOPT_INFILE, $fh);
		curl_setopt($ch, CURLOPT_INFILESIZE, $this->requestLength);
		curl_setopt($ch, CURLOPT_PUT, true);
		$this->doExecute($ch);
		fclose($fh);
	}
	
	protected function executeDelete ($ch) {
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		$this->doExecute($ch);
	}
	
	protected function doExecute (&$ch) {
		$this->setCurlOpts($ch);
		$this->responseBody = curl_exec($ch);
		$this->responseInfo = curl_getinfo($ch);
		curl_close($ch);
	}
	
	protected function setCurlOpts (&$ch) {
		curl_setopt($ch, CURLOPT_TIMEOUT, 100);
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers );
		
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'GET');
		
		if ( count($this->proxyInfo) > 0 ) {
			$p = $this->proxyInfo;
			if ( $p['scheme'] == "http" ) {
				curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
			}
			
			$proxy_server = "{$p['scheme']}://{$p['host']}:{$p['port']}";
			$proxy_user = "{$p['user']}:{$p['pass']}";
			curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 0);
			curl_setopt($ch, CURLOPT_PROXYPORT, $p['port']);
			curl_setopt($ch, CURLOPT_PROXY, $proxy_server);
			curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy_user);
		}
	}
	
	protected function setAuth (&$ch) {
		if ($this->username !== null && $this->password !== null) {
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
			curl_setopt($ch, CURLOPT_USERPWD, $this->username . ':' . $this->password);
		}
	}

	function setAcceptType( $type = 'application/soap+xml' ) {
		echo $this->acceptType = $type;
	}
	
	function getResponseBody() { return $this->responseBody; }
	function getResponseInfo() { return $this->responseInfo; }
}
?>
