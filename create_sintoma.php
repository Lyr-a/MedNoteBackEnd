<?php 

//cria sintomas 

$response = array();

//conectar ao banco de dados
$con = pg_connect("postgres://rfvpbzdy:Viurc8sZ2VdqcnPCsFCOd9j9a-qFAOMG@chunee.db.elephantsql.com/rfvpbzdy");	

//conferir os campos requisitados
if (isset($_POST['cpf']) && isset($_POST['sintoma_title']) && isset($_POST['sintoma_desc']) && isset($_POST['sintoma_data']) && isset($_POST['sintoma_hora'])){

	
	$CPF = trim($_POST['cpf']);
	$SINTOMA_TITLE = $_POST['sintoma_title'];
	$SINTOMA_DESC = $_POST['sintoma_desc'];
	$SINTOMA_DATA = $_POST['sintoma_data'];
	$SINTOMA_HORA = $_POST['sintoma_hora'];
	
	/*
	$imageFileType = strtolower(pathinfo(basename($_FILES["sintoma_photo"]['name']), PATHINFO_EXTENSION));
	$image_base64 = base64_encode(file_get_contents($_FILES['sintoma_photo']['tmp_name']));
	$SINTOMA_PHOTO = 'data:image/'.$imageFileType';base64,'.$image_base64;
*/
	
	$result = pg_query($con, "INSERT INTO Sintoma(cpf, sintoma_title, sintoma_desc, sintoma_data, sintoma_hora)
	VALUES('$CPF', '$SINTOMA_TITLE', '$SINTOMA_DESC','$SINTOMA_DATA','$SINTOMA_HORA')");
	
	if ($result){
	$response["success"] = 1;
	$response["message"] = "Sintoma criado com sucesso";
	
	}
	else{
	$response["success"] = 0;
	$response["message"] = "Erro ao criar usuario no bd".pg_last_error($con);
	

	
	}
}
else {
	$response["success"] = 0;
	$response["message"] = "Campo requerido nao preenchido";
	

	
}
    
pg_close($con);
echo json_encode($response);
?>
	
	
	
