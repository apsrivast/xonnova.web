<?
//Libreria para el manejo de SOAP
require_once('nusoap.php');

//Funciones auxiliares
require_once('tool.php');

/**
 * Funcion que solicita y gestiona la consulta del resultado de la venta
 *
 * @param int e_COMPANIA: Compañia asociada a la cuenta
 * @param double e_TELEFONO: Telefono a recargar
 * @param double e_MONTO: Monto a recargar
 *
 * @return array: Arreglo con los valores resultantes de la recarga
 */
function pyxter_venta($e_COMPANIA, $e_TELEFONO, $e_MONTO)
{
  $e_TIMEOUT = 180;
  $e_TIEMPO_INICIAL = time();
  $e_TRANSACCION = pyxter_solicitar_venta($e_COMPANIA, $e_TELEFONO, $e_MONTO);

  do
  {
    sleep(1);
    $m_RESPUESTA = pyxter_consultar_solicitud($e_TRANSACCION);
    $e_TIEMPO_TRANSCURRIDO = time() - $e_TIEMPO_INICIAL;
  }
  while($m_RESPUESTA['ESTADO'] == 'PROCESANDO' && $e_TIEMPO_TRANSCURRIDO < $e_TIMEOUT);

  if(!$m_RESPUESTA['FOLIO_OPERADOR'])
  {
    throw new Exception("Timeout");
  }

  return $m_RESPUESTA;
}

/**
 * Funcion que solicita la venta
 *
 * @param int e_COMPANIA: Compañia asociada a la cuenta
 * @param double e_TELEFONO: Telefono a recargar
 * @param double e_MONTO: Monto a recargar
 * 
 * @return string: Transaccion enviada
 */
function pyxter_solicitar_venta($e_COMPANIA, $e_TELEFONO, $e_MONTO)
{
  //URL asignado por el proveedor
  $e_URL = 'http://ext.kioskotae.com/index.php?ACTION=WEBSERVICE:LOAD_NUSOAP&NUSOAP=PYXTER:C5A.GTW.SHARED.WS_AVANZADO';
  $e_URL = 'http://ext.kioskotae.com/index.php?ACTION=WEBSERVICE:LOAD_NUSOAP&NUSOAP=PYXTER:C5A.GTW.SHARED.WS_AVANZADO&wsdl';
  //Instancia asignada por el proveedor
  $e_INSTANCIA = 'KIOSKOTAE_GTW1';

  //Id de entidad asignado por el proveedor
  $e_ENTIDAD_ID = '036';
  
  //Usuario de la entidad asignado por el proveedor
  $e_ENTIDAD_USUARIO = 'JUAN_ANTONIO';

  //Contraseña de la entidad asignado por el proveedor
  $e_ENTIDAD_CONTRASENA = 'BftRSQOnWWmRptkqtkA6';

  //Numero de usuario asignado por el proveedor
  $e_USUARIO_NUMERO = '3320099503';
  
  //Nip del usuario asignado por el proveedor
  $e_USUARIO_NIP = '0832';
  
  //Timeout para el soap
  $e_TIMEOUT = 60;
  
  $e_TRANSACCION = 'EXT' . str_pad($e_ENTIDAD_ID, 3, '0', STR_PAD_LEFT) . date('YmdHis') . get_random_string(10);
  
  $o_WEBSERVICE = new nusoap_client($e_URL, false, false, false, false, false, 0, $e_TIMEOUT);
  
  //Se preparan los parametros a enviar
  $m_PARAMS_WEBSERVICE = array
  (
    'instancia' => $e_INSTANCIA,
    'entidad' => json_encode(array('USUARIO' => $e_ENTIDAD_USUARIO, 'CONTRASENA' => $e_ENTIDAD_CONTRASENA)),
    'usuario' => json_encode(array('TIPO_USUARIO' => 'PYXTER', 'NUMERO' => $e_USUARIO_NUMERO, 'NIP' => $e_USUARIO_NIP)),
    'transaccion' => $e_TRANSACCION,
    'nodo' => $e_USUARIO_NUMERO,
    'destino' => $e_TELEFONO,
    'monto' => $e_MONTO,
    'operador' => $e_COMPANIA
  );
  
  $o_WEBSERVICE->call('venta_solicitar', $m_PARAMS_WEBSERVICE);
  
  //Se evalua si hubo errores
  if($o_WEBSERVICE->fault)
  {
    throw new Exception("{$o_WEBSERVICE->faultcode}, {$o_WEBSERVICE->faultstring}");
  }
  elseif($o_WEBSERVICE->error_str)
  {
    throw new Exception("{$o_WEBSERVICE->error_str}, {$o_WEBSERVICE->responseData}");
  }
  
  return $e_TRANSACCION;
}

/**
 * Funcion que revisa el estado de la solicitud
 *
 * @param string e_TRANSACCION: Compañia asociada a la cuenta
 * @return array: Estado de la transaccion
 *
 * Creación 01 de Septiembre del 2012
 * @author Roberto Palos
 */
function pyxter_consultar_solicitud($e_TRANSACCION)
{
	$e_URL = 'http://ext.kioskotae.com/index.php?ACTION=WEBSERVICE:LOAD_NUSOAP&NUSOAP=PYXTER:C5A.GTW.SHARED.WS_AVANZADO&wsdl';
  //Instancia asignada por el proveedor
  $e_INSTANCIA = 'KIOSKOTAE_GTW1';

  //Id de entidad asignado por el proveedor
  $e_ENTIDAD_ID = '036';
  
  //Usuario de la entidad asignado por el proveedor
  $e_ENTIDAD_USUARIO = 'JUAN_ANTONIO';

  //Contraseña de la entidad asignado por el proveedor
  $e_ENTIDAD_CONTRASENA = 'BftRSQOnWWmRptkqtkA6';

  //Numero de usuario asignado por el proveedor
  $e_USUARIO_NUMERO = '3320099503';
  
  //Nip del usuario asignado por el proveedor
  $e_USUARIO_NIP = '0832';
  
  //Timeout para el soap
  $e_TIMEOUT = 60;

  $o_WEBSERVICE = new nusoap_client($e_URL, false, false, false, false, false, 0, $e_TIMEOUT);
  
  //Se preparan los parametros a enviar
  $m_PARAMS_WEBSERVICE = array
  (
    'instancia' => $e_INSTANCIA,
    'entidad' => json_encode(array('USUARIO' => $e_ENTIDAD_USUARIO, 'CONTRASENA' => $e_ENTIDAD_CONTRASENA)),
    'usuario' => json_encode(array('TIPO_USUARIO' => 'PYXTER', 'NUMERO' => $e_USUARIO_NUMERO, 'NIP' => $e_USUARIO_NIP)),
    'operacion' => 'VENTA',
    'transaccion' => $e_TRANSACCION,
    'nodo' => $e_USUARIO_NUMERO
  );
  
  // call($operation,$params=array(),$namespace='http://tempuri.org',$soapAction='',$headers=false,$rpcParams=null,$style='rpc',$use='encoded'){
  
  $m_RETURN = $o_WEBSERVICE->call('consultar_solicitud', $m_PARAMS_WEBSERVICE);
  
  $m_RETURN['idtransaction'] = $e_TRANSACCION;
  //Se evalua si hubo errores
  if($o_WEBSERVICE->fault)
  {
    throw new Exception("{$e_TRANSACCION}:{$o_WEBSERVICE->faultcode}, {$o_WEBSERVICE->faultstring}");
  }
  elseif($o_WEBSERVICE->error_str)
  {
    throw new Exception("{$e_TRANSACCION}:{$o_WEBSERVICE->error_str}, {$o_WEBSERVICE->responseData}");
  }
  elseif($m_RETURN['ESTADO'] == 'CANCELADO')
  {
    throw new Exception($m_RETURN['MOTIVO']);
  }
  
  return $m_RETURN;
}
?>