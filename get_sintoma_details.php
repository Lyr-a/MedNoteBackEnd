<?php
 
 
// array que guarda a resposta da requisicao
$response = array();

//$con = pg_connect();

if (isset($_GET["ID_SINTOMA"])) {
	
    $ID_SINTOMA = $_GET['ID_SINTOMA'];
	
 
    $result = pg_query($con, "SELECT *FROM Sintoma WHERE ID_SINTOMA = $ID_SINTOMA");
 
    if (!empty($result)) {
        if (pg_num_rows($result) > 0) {
 
			// Se o produto existe, os dados de detalhe do produto 
			// sao adicionados no array de resposta.
            $result = pg_fetch_array($result);
 
            $sintoma = array();
            $sintoma["SINTOMA_TITLE"] = $result[" SINTOMA_TITLE"];
            $sintoma["SINTOMA_DESC"] = $result["SINTOMA_DESC"];
            $sintoma["SINTOMA_DATA"] = $result["SINTOMA_DATA"];
			$sintoma["SINTOMA_PHOTO"] = $result["SINTOMA_PHOTO"];
           
            
            // Caso o produto exista no BD, o cliente 
			// recebe a chave "success" com valor 1.
            $response["success"] = 1;
 
            $response["sintoma"] = array();
 
			// Converte a resposta para o formato JSON.
            array_push($response["sintoma"], $sintoma);
			
			// Fecha a conexao com o BD
			pg_close($con);
 
            // Converte a resposta para o formato JSON.
            echo json_encode($response);
        } else {
            // Caso o produto nao exista no BD, o cliente 
			// recebe a chave "success" com valor 0. A chave "message" indica o 
			// motivo da falha.
            $response["success"] = 0;
            $response["message"] = "Sintoma não encontrado";
			
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
        $response["message"] = "Sintoma não encontrado";
 
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