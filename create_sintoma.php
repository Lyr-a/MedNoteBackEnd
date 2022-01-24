<?php 

//sintomas 

$response = array();

//conferir os campos requisitados
if (isset($_POST['SINTOMA_TITLE']) && isset($_POST['SINTOMA_DESC']) && isset($_POST['SINTOMA_DATA']) && isset($_POST['SINTOMA_HORA'])&& isset($_FILES['SINTOMA_PHOTO'])){

	
	
	$SINTOMA_TITLE = $_POST['SINTOMA_TITLE'];
	$SINTOMA_DESC = $_POST['SINTOMA_DESC'];
	$SINTOMA_DATA = $_POST['SINTOMA_DATA'];
	$SINTOMA_HORA = $_POST['SINTOMA_HORA'];
	$imageFileType = strtolower(pathinfo(basename($_FILES["SINTOMA_PHOTO"]["name"]), PATHINFO_EXTENSION));
	$image_base64 = base64_encode(file_get_contents($_FILES['SINTOMA_PHOTO']['tmp_name']));
	$SINTOMA_PHOTO = 'data:image/'.$imageFileType';base64,'.$image_base64;
	
	//conectar ao banco de dados
	//$con = pg_connext();
	
	$result = pg_query($con, "INSERT INTO Sintoma(SINTOMA_TITLE, SINTOMA_DESC, SINTOMA_DATA, SINTOMA_HORA, SINTOMA_PHOTO)
	VALUES('$SINTOMA_TITLE', '$SINTOMA_DESC','$SINTOMA_DATA','$SINTOMA_HORA','$SINTOMA_PHOTO')");
	
	if ($result){
	$response["success"] = 1;
	$response["message"] = "Sintoma criado com sucesso";
	
	pg_close($con);
	
	echo json_encode($response); }
	
	else{
	$response["success"] = 0;
	$response["message"] = "Erro ao criar sintoma no bd";
	
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
	
	
	