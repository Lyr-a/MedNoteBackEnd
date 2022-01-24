<?php
 

 
// array que guarda a resposta da requisicao
$response = array();
 

//$con = pg_connect(getenv("DATABASE_URL"));
 
// Realiza uma consulta ao BD e obtem todos os produtos.
$result = pg_query($con, "SELECT *FROM Sintoma");
 

if (pg_num_rows($result) > 0) {
   
    $response["Sintoma"] = array();
 
    while ($row = pg_fetch_array($result)) {
     
        $sintomas = array();
        $sintomas["ID_SINTOMA"] = $row["ID_SINTOMA"];
        $sintomas["SINTOMA_TITLE"] = $row["SINTOMA_TITLE"];
 
        // Adiciona o produto no array de produtos.
        array_push($response["Sintoma"], $sintomas);
    }
   
    $response["success"] = 1;
	
	pg_close($con);
 
    // Converte a resposta para o formato JSON.
    echo json_encode($response);
	
} else {
    
    $response["success"] = 0;
    $response["message"] = "Nao ha sintomas";
	
	// Fecha a conexao com o BD
	pg_close($con);
 
    // Converte a resposta para o formato JSON.
    echo json_encode($response);
}
?>