<?php
/*
* @LitePanel
* @Version: 1.1 [dev]
* @Developed by QuickDevel
*/
class sampQuery extends QueryBase {

	public function getInfo() {
		$this->sendPacket("SAMP");
		
		if($this->read(4) != "SAMP") return false;
		
		$this->read(7);
		$data['password'] = (bool)$this->readInt8();
		$data['players'] = (int)$this->readInt16();
		$data['maxplayers'] = (int)$this->readInt16();
		$len = ord($this->read(4));
		$data['hostname'] = (string)$this->read($len);
		$len = ord($this->read(4));
		$data['gamemode'] = (string)$this->read($len);
		$len = ord($this->read(4));
		$data['mapname'] = (string)$this->read($len);
		
		return $data;
	}
}
?>
