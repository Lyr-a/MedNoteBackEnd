<?php 

//sintomas 

$response = array();

//conferir os campos requisitados
if (isset($_POST['sintoma_title']) && isset($_POST['sintoma_desc']) && isset($_POST['sintoma_data'])&& isset($_FILES['sintoma_photo'])){

	
	
	$SINTOMA_TITLE = $_POST['sintoma_title'];
	$SINTOMA_DESC = $_POST['sintoma_desc'];
	$SINTOMA_DATA = $_POST['sintoma_data'];
	$imageFileType = strtolower(pathinfo(basename($_FILES["sintoma_photo"]["name"]), PATHINFO_EXTENSION));
	$image_base64 = base64_encode(file_get_contents($_FILES['sintoma_photo']['tmp_name']));
	$SINTOMA_PHOTO = 'data:image/'.$imageFileType';base64,'.$image_base64;
	
	//conectar ao banco de dados
	$con = pg_connect("postgres://rfvpbzdy:Viurc8sZ2VdqcnPCsFCOd9j9a-qFAOMG@chunee.db.elephantsql.com/rfvpbzdy");
	
	$result = pg_query($con, "INSERT INTO Sintoma(sintoma_title, sintoma_desc, sintoma_data, sintoma_photo)
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
	
	
	
