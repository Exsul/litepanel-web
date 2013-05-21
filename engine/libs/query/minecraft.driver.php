<?php

// http://mc.kev009.com/Server_List_Ping
class MinecraftQuery extends QueryBase
{
  public function Connect($ip, $port)
  {
    parent::Connect($ip, $port, false);
    $this->TCPConnect();
  }

  private function SendPacket()
  {
    $this->Write("\xFE\x01");
  }

  public function getInfo()
  {
    $this->SendPacket();

    if ($this->Read(1) != '\xFF')
      return false;
    $str = $this->ReadString();

    try
    {
      $this->Check($str);
    } catch (Exception $e)
    {
      return false;
    }

    return $data;
  }

  private function Check($str)
  {
    $a = $this->Pop($str, 4);
    EqualAssert($a, '$1'."\x00\x00");
    $this->PassString($str); // version
    $this->PassString($str); // MOTD
    $ret = array();
    $ret['players'] = (int)$this->PassString($str); // players
    $ret['maxplayers'] = (int)$this->PassString($str); // max
    return $ret;
  }

  private function Pop( &$str, $count)
  {
    $ret = substr($str, 0, $count);
    $str = substr($str, $count);
    return $ret;
  }

  private function EqualAssert( $a, $b )
  {
    if ($a != $b)
      throw new Exception();
  }

  private function PassString( &$str )
  {
    $ret = '';
    while (($a = $this->Pop($str, 1) != 0))
      $ret .= $a;
    $this->Pop($str, 1); // next zero
    return $ret;
  }

  protected function ReadString()
  {
    $len = $this->ReadInt16();
    $str = $this->Read($len);
    return utf8_encode($str);
  }
}
?>
