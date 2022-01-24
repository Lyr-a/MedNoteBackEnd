<?php
 
// array for JSON response
$response = array();

// conecta ao BD
$con = pg_connect(getenv("DATABASE_URL"));

$CPF = NULL;
$SENHA = NULL;

$isAuth = false;

// Método para mod_php (Apache)
if(isset( $_SERVER['PHP_AUTH_USER'])) {
    $CPF = $_SERVER['PHP_AUTH_USER'];
    $SENHA = $_SERVER['PHP_AUTH_PW'];
} // Método para demais servers
elseif(isset( $_SERVER['HTTP_AUTHORIZATION'])) {
    if(preg_match( '/^basic/i', $_SERVER['HTTP_AUTHORIZATION']))
		list($CPF, $SENHA) = explode(':', base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
}

// Se a autenticação não foi enviada
if(!is_null($CPF)){
    $query = pg_query($con, "SELECT SENHA FROM Pessoa WHERE CPF='$CPF'");

	if(pg_num_rows($query) > 0){
		$row = pg_fetch_array($query);
		if($SENHA == $row['SENHA']){
			$isAuth = true;
		}
	}
}
 
if($isAuth) {
	include("get_all_sintomas.php");
	include("get_all_tratamentos.php");
	$response["success"] = 1;
	//mudar aqui
	// codigo sql da sua consulta
	$response["data"] = "Dados da app";
}
else {
	$response["success"] = 0;
	$response["error"] = "falha de autenticação";
}

pg_close($con);
echo json_encode($response);
?>