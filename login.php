<?php

//conectar ao bd
$con = pg_connect("postgres://rfvpbzdy:Viurc8sZ2VdqcnPCsFCOd9j9a-qFAOMG@chunee.db.elephantsql.com/rfvpbzdy");

//array para resposta json
$response = array();
$CPF = NULL;
$SENHA= NULL;

// Método para mod_php (Apache)
if ( isset( $_SERVER['PHP_AUTH_USER'] ) ) {
    $CPF = $_SERVER['PHP_AUTH_USER'];
    $SENHA = $_SERVER['PHP_AUTH_PW'];
}
// Método para demais servers
elseif(isset( $_SERVER['HTTP_AUTHORIZATION'])) {
    if(preg_match( '/^basic/i', $_SERVER['HTTP_AUTHORIZATION']))
		list($CPF, $SENHA) = explode(':', base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
}

// Se a autenticação não foi enviada
if(is_null($CPF)) {
    $response["success"] = 0;
	$response["error"] = "faltam parametros";
}
// Se houve envio dos dados
else {
    $query = pg_query($con, "SELECT senha FROM Pessoa WHERE cpf='$CPF'");

	if(pg_num_rows($query) > 0){
		$row = pg_fetch_array($query);
		if($SENHA == $row['senha']){
			$response["success"] = 1;
		}
		else {
			// senha ou usuario nao confere
			$response["success"] = 0;
			$response["error"] = "usuario ou senha não confere";
		}
	}
	else {
		// senha ou usuario nao confere
		$response["success"] = 0;
		$response["error"] = "usuario ou senha não conferem";
	}
}

pg_close($con);
echo json_encode($response);
?>
