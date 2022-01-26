<?php 

//tratamento

$response = array();

//conferir os campos requisitados
if (isset($_POST['tratamento_title']) && isset($_POST['tratamento_desc'])  && isset($_POST['tratamento_data']) && isset($_FILES['tratamento_hora'])){

   
	$TRATAMENTO_TITLE = $_POST['tratamento_title'];
	$TRATAMENTO_DESC = $_POST['tratamento_desc'];
	$TRATAMENTO_DATA = $_POST['tratamento_data'];
	$TRATAMENTO_HORA = $_POST['tratamento_hora'];
	







//conectar ao banco de dados
	$con = pg_connect("postgres://rfvpbzdy:Viurc8sZ2VdqcnPCsFCOd9j9a-qFAOMG@chunee.db.elephantsql.com/rfvpbzdy");
	
	$result = pg_query($con, "INSERT INTO Tratamento(tratamento_title, tratamento_desc, tratamento_data, tratamento_hora )
	VALUES('$TRATAMENTO_TITLE', '$TRATAMENTO_DESC','$TRATAMENTO_DATA')");
	
	if ($result){
	$response["success"] = 1;
	$response["message"] = "tratamento criado com sucesso";
	
	pg_close($con);
	
	echo json_encode($response); }
	
	else{
	$response["success"] = 0;
	$response["message"] = "Erro ao criar tratamento no bd";
	
	pg_close($con);
	
	echo json_encode($response);
	
	}
}
else {
	$response["success"] = 0;
	$response["message"] = "Campo requerido nao preenchido";
	
	echo json_encode($response);
	
}
?>
