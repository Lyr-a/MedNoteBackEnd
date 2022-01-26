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

	if (isset($_GET["ID_SINTOMA"])) {
		
		$ID_SINTOMA = $_GET['ID_SINTOMA'];
		
	 
		$result = pg_query($con, "SELECT * FROM Sintoma WHERE ID_SINTOMA = $ID_SINTOMA");
	 
		if (!empty($result)) {
			if (pg_num_rows($result) > 0) {
	 
				// Se o produto existe, os dados de detalhe do produto 
				// sao adicionados no array de resposta.
				$result = pg_fetch_array($result);
	 
				$sintoma = array();
				$sintoma["SINTOMA_TITLE"] = $result[" SINTOMA_TITLE"];
				$sintoma["SINTOMA_DESC"] = $result["SINTOMA_DESC"];
				$sintoma["SINTOMA_DATA"] = $result["SINTOMA_DATA"];
				$sintoma["SINTOMA_HORA"] = $result["SINTOMA_HORA"];
				$sintoma["SINTOMA_PHOTO"] = $result["SINTOMA_PHOTO"];
			   
				
				// Caso o produto exista no BD, o cliente 
				// recebe a chave "success" com valor 1.
				$response["success"] = 1;
	 
				$response["sintoma"] = array();
	 
				// Converte a resposta para o formato JSON.
				array_push($response["sintoma"], $sintoma);
				
				
	 
				// Converte a resposta para o formato JSON.
				echo json_encode($response);
			} else {
				// Caso o produto nao exista no BD, o cliente 
				// recebe a chave "success" com valor 0. A chave "message" indica o 
				// motivo da falha.
				$response["success"] = 0;
				$response["message"] = "Sintoma não encontrado";
				
				
			}
		} else {
			// Caso o produto nao exista no BD, o cliente 
			// recebe a chave "success" com valor 0. A chave "message" indica o 
			// motivo da falha.
			$response["success"] = 0;
			$response["message"] = "Sintoma não encontrado";
	 
			
		}
	} else {
		// Se a requisicao foi feita incorretamente, ou seja, os parametros 
		// nao foram enviados corretamente para o servidor, o cliente 
		// recebe a chave "success" com valor 0. A chave "message" indica o 
		// motivo da falha.
		$response["success"] = 0;
		$response["message"] = "Campo requerido não preenchido";
	 
		// Converte a resposta para o formato JSON.
		echo json_encode($response);
	}
}
// Fecha a conexao com o BD
pg_close($con);
	 
// Converte a resposta para o formato JSON.
echo json_encode($response);
?>
