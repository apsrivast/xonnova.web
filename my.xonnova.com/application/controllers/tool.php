<?
function get_random_string($LENGHT = 40, $CHARSET = 'A-Z0-9')
{
  $ID = "";
  mt_srand ((double) microtime() * 1000000);
  while(strlen($ID) < $LENGHT)
  {
    $CH = chr(mt_rand(48, 122));
    if(preg_match("/[$CHARSET]/", $CH))
      $ID .= $CH;
  }
  
  return $ID;
}
?>