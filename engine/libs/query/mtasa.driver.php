<?php
/*
* @LitePanel
* @Version: 1.1 [dev]
* @Developed by QuickDevel
*/
class mtasaQuery extends QueryBase {

	public function disconnect() {
		fclose($this->socket);
	}
	
	private function sendPacket() {
		$packet = "s";
		
		$this->write($packet);
	}
	
	public function getInfo() {
		$this->sendPacket();
		
		if($this->read(4) != "EYE1") return false;
		
		$this->readStringLen();
		$this->readStringLen();
		$data['hostname'] = (string)$this->readStringLen();
		$data['gamemode'] = (string)$this->readStringLen();
		$data['mapname'] = (string)$this->readStringLen();
		$this->readStringLen();
		$data['password'] = (bool)$this->readStringLen();
		$data['players'] = (int)$this->readStringLen();
		$data['maxplayers'] = (int)$this->readStringLen();
		
		return $data;
	}
	
	function readStringLen() {
		$len = $this->readInt8();
		return $this->read($len-1);
	}
}
?>
