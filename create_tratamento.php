<?php 

//conectar ao banco de dados
$con = pg_connect("postgres://rfvpbzdy:Viurc8sZ2VdqcnPCsFCOd9j9a-qFAOMG@chunee.db.elephantsql.com/rfvpbzdy");

// criar tratamento
$response = array();

//conferir os campos requisitados
if (isset($_POST['cpf']) && isset($_POST['tratamento_title']) && isset($_POST['tratamento_desc'])  && isset($_POST['tratamento_data']) && isset($_FILES['tratamento_hora'])){

	
   	$CPF = trim($_POST['cpf']);
	$TRATAMENTO_TITLE = $_POST['tratamento_title'];
	$TRATAMENTO_DESC = $_POST['tratamento_desc'];
	$TRATAMENTO_DATA = $_POST['tratamento_data'];
	$TRATAMENTO_HORA = $_POST['tratamento_hora'];
	








	
	$result = pg_query($con, "INSERT INTO Tratamento(cpf, tratamento_title, tratamento_desc, tratamento_data, tratamento_hora )
	VALUES('$CPF', '$TRATAMENTO_TITLE', '$TRATAMENTO_DESC','$TRATAMENTO_DATA', '$TRATAMENTO_HORA')");
	
	if ($result){
	$response["success"] = 1;
	$response["message"] = "tratamento criado com sucesso";
	
	}
	
	else{
	$response["success"] = 0;
	$response["message"] = "Erro ao criar tratamento no bd";
	

	
	}
}
else {
	$response["success"] = 0;
	$response["message"] = "Campo requerido nao preenchido";
	
	
	
}
pg_close($con);
	
echo json_encode($response);
?>
