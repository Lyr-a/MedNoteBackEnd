<?php
  
// array que guarda a resposta da requisicao
$response = array();
 

//$con = pg_connect(getenv("DATABASE_URL"));
 
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
	
	pg_close($con);
 
    // Converte a resposta para o formato JSON.
    echo json_encode($response);
	
} else {
    
    $response["success"] = 0;
    $response["message"] = "Nao ha fotos";
	
	// Fecha a conexao com o BD
	pg_close($con);
 
    // Converte a resposta para o formato JSON.
    echo json_encode($response);
}
?>