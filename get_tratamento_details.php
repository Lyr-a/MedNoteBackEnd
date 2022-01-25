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

	if (isset($_GET["Num_tratamento"])) {
		
		$Num_tratamento = $_GET['Num_tratamento'];
		
	 
		$result = pg_query($con, "SELECT *FROM Tratamento WHERE Num_tratamento = $Num_tratamento");
	 
		if (!empty($result)) {
			if (pg_num_rows($result) > 0) {
	 
				// Se o produto existe, os dados de detalhe do produto 
				// sao adicionados no array de resposta.
				$result = pg_fetch_array($result);
	 
				$tratamento = array();
				$tratamento["TRATAMENTO_TITLE"] = $result["TRATAMENTO_TITLE"];
				$tratamento["TRATAMENTO_DESC"] = $result["TRATAMENTO_DESC"];
				$tratamento["TRATAMENTO_DATA"] = $result["TRATAMENTO_DATA"];
				$tratamento["EXAME_PHOTO"] = $result["EXAME_PHOTO"];
				$tratamento["RECEITA_PHOTO"] = $result["RECEITA_PHOTO"];
				$tratamento["PRESCRICAO_PHOTO"] = $result["PRESCRICAO_PHOTO"];
			   
			   
				
				// Caso o produto exista no BD, o cliente 
				// recebe a chave "success" com valor 1.
				$response["success"] = 1;
	 
				$response["tratamento"] = array();
	 
				// Converte a resposta para o formato JSON.
				array_push($response["tratamento"], $tratamento);
				
			
			} else {
				// Caso o produto nao exista no BD, o cliente 
				// recebe a chave "success" com valor 0. A chave "message" indica o 
				// motivo da falha.
				$response["success"] = 0;
				$response["message"] = "Tratamento não encontrado";
			
			}
		} else {
			// Caso o produto nao exista no BD, o cliente 
			// recebe a chave "success" com valor 0. A chave "message" indica o 
			// motivo da falha.
			$response["success"] = 0;
			$response["message"] = "Tratamento não encontrado";
	 
			
		}
	} else {
		// Se a requisicao foi feita incorretamente, ou seja, os parametros 
		// nao foram enviados corretamente para o servidor, o cliente 
		// recebe a chave "success" com valor 0. A chave "message" indica o 
		// motivo da falha.
		$response["success"] = 0;
		$response["message"] = "Campo requerido não preenchido";
	 
		// Converte a resposta para o formato JSON.
		
	}
}
// Fecha a conexao com o BD
pg_close($con);
	 
// Converte a resposta para o formato JSON.
echo json_encode($response);
?>
