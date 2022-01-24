<?php
 
 
// array que guarda a resposta da requisicao
$response = array();

//$con = pg_connect();

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
			
			// Fecha a conexao com o BD
			pg_close($con);
 
            // Converte a resposta para o formato JSON.
            echo json_encode($response);
        } else {
            // Caso o produto nao exista no BD, o cliente 
			// recebe a chave "success" com valor 0. A chave "message" indica o 
			// motivo da falha.
            $response["success"] = 0;
            $response["message"] = "Tratamento não encontrado";
			
			// Fecha a conexao com o BD
			pg_close($con);
 
            // Converte a resposta para o formato JSON.
            echo json_encode($response);
        }
    } else {
        // Caso o produto nao exista no BD, o cliente 
		// recebe a chave "success" com valor 0. A chave "message" indica o 
		// motivo da falha.
        $response["success"] = 0;
        $response["message"] = "Tratamento não encontrado";
 
		// Fecha a conexao com o BD
		pg_close($con);
 
        // Converte a resposta para o formato JSON.
        echo json_encode($response);
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
?>