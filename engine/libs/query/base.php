<?php
/*
* @LitePanel
* @Version: 1.1 [dev]
* @Developed by QuickDevel
*/
class QueryBase {
	protected $ip;
	protected $port;
	
	protected $socket;

  public function connect( $ip, $port ) {
    $this->ip = $ip;
    $this->port = $port;

    $this->socket = fsockopen('udp://' . $this->ip, $this->port, $sockError, $sockErrorNum, 2);
    socket_set_timeout($this->socket, 1);
  }

  public function disconnect() {
		fclose($this->socket);
	}

	protected function write($bytes) {
		return fwrite($this->socket, $bytes);
	}
	
	protected function readInt8() {
		return ord($this->read(1));
	}
	
	protected function readInt16() {
		$int = unpack('Sint', $this->read(2));
		return $int['int'];
	}
	
	protected function readString() {
		$string = null;
		while(($char = $this->read(1)) != "\x00") {
			$string .= $char;
		}
		return $string;
	}
	
	protected function read($len) {
		return fread($this->socket, $len);
	}
}
?>
