<?php
/*
* @LitePanel
* @Version: 1.1 [dev]
* @Developed by QuickDevel
*/
class sampQuery extends QueryBase {

 public function sendPacket($packet) {
    $ipParts = explode('.', $this->ip);

    $packet = "SAMP";
    $packet .= chr($ipParts[0]);
    $packet .= chr($ipParts[1]);
    $packet .= chr($ipParts[2]);
    $packet .= chr($ipParts[3]);

    $packet .= chr($this->port & 0xFF);
    $packet .= chr($this->port >> 8 & 0xFF);

    $packet .= 'i';

    if (isset($data))
      $packet .= $data;
    $this->write($packet);
  }


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
