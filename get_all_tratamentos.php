<?php
 

 
// array que guarda a resposta da requisicao
$response = array();
 

//$con = pg_connect(getenv("DATABASE_URL"));
 
// Realiza uma consulta ao BD e obtem todos os produtos.
$result = pg_query($con, "SELECT *FROM Tratamento");
 

if (pg_num_rows($result) > 0) {
   
    $response["Tratamento"] = array();
 
    while ($row = pg_fetch_array($result)) {
     
        $tratamentos = array();
        $tratamentos["ID_TRATAMENTO"] = $row["ID_TRATAMENTO"];
        $tratamentos["TRATAMENTO_TITLE"] = $row["TRATAMENTO_TITLE"];
 
        // Adiciona o produto no array de produtos.
        array_push($response["Tratamento"], $tratamentos);
    }
   
    $response["success"] = 1;
	
	pg_close($con);
 
    // Converte a resposta para o formato JSON.
    echo json_encode($response);
	
} else {
    
    $response["success"] = 0;
    $response["message"] = "Nao ha tratamentos";
	
	// Fecha a conexao com o BD
	pg_close($con);
 
    // Converte a resposta para o formato JSON.
    echo json_encode($response);
}
?>