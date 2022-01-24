<?php 

//tratamento fotos

$response = array();

//conferir os campos requisitados
if (isset($_POST['FOTO'])){

   
	$imageFileType = strtolower(pathinfo(basename($_FILES["FOTO"]["name"]), PATHINFO_EXTENSION));
	$image_base64 = base64_encode(file_get_contents($_FILES['FOTO']['tmp_name']));
	$FOTO = 'data:image/'.$imageFileType';base64,'.$image_base64;



//conectar ao banco de dados
	//$con = pg_connext();
	
	$result = pg_query($con, "INSERT INTO TFotos(FOTO) VALUES('$FOTO')");
	
	if ($result){
	$response["success"] = 1;
	$response["message"] = "foto criada com sucesso";
	
	pg_close($con);
	
	echo json_encode($response); }
	
	else{
	$response["success"] = 0;
	$response["message"] = "Erro ao criar foto no bd";
	
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