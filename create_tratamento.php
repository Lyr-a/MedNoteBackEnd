<?php 

//tratamento

$response = array();

//conferir os campos requisitados
if (isset($_POST['TRATAMENTO_TITLE']) && isset($_POST['TRATAMENTO_DESC'])  && isset($_POST['TRATAMENTO_DATA']) && isset($_FILES['TRATAMENTO_HORA'])){

   
	$TRATAMENTO_TITLE = $_POST['TRATAMENTO_TITLE'];
	$TRATAMENTO_DESC = $_POST['TRATAMENTO_DESC'];
	$TRATAMENTO_DATA = $_POST['TRATAMENTO_DATA'];
	







//conectar ao banco de dados
	$con = pg_connect("postgres://rfvpbzdy:Viurc8sZ2VdqcnPCsFCOd9j9a-qFAOMG@chunee.db.elephantsql.com/rfvpbzdy");
	
	$result = pg_query($con, "INSERT INTO Tratamento(TRATAMENTO_TITLE, TRATAMENTO_DESC, TRATAMENTO_DATA)
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
