<?php
  
// array que guarda a resposta da requisicao
$response = array();
 


$con = pg_connect("postgres://rfvpbzdy:Viurc8sZ2VdqcnPCsFCOd9j9a-qFAOMG@chunee.db.elephantsql.com/rfvpbzdy");


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
	 
	// Realiza uma consulta ao BD e obtem todos os produtos.
	$result = pg_query($con, "SELECT *FROM Tfotos");
	 

	if (pg_num_rows($result) > 0) {
	   
		$response["TFotos"] = array();
	 
		while ($row = pg_fetch_array($result)) {
		 
			$tfotos = array();
			$tfotos["Foto"] = $row["Foto"];

	 
			// Adiciona o produto no array de produtos.
			array_push($response["Tfotos"], $tfotos);
		}
	   
		$response["success"] = 1;
		
		
		
	} else {
		
		$response["success"] = 0;
		$response["message"] = "Nao ha fotos";
		
		
	}
}
// Fecha a conexao com o BD
pg_close($con);
	 
// Converte a resposta para o formato JSON.
echo json_encode($response);
?>
