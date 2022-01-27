<?php 

//tratamento fotos

$response = array();

//conferir os campos requisitados
if (isset($_POST['foto'])){

   
	$imageFileType = strtolower(pathinfo(basename($_FILES["foto"]["name"]), PATHINFO_EXTENSION));
	$image_base64 = base64_encode(file_get_contents($_FILES['foto']['tmp_name']));
	$FOTO = 'data:image/'.$imageFileType';base64,'.$image_base64;



//conectar ao banco de dados
	$con = pg_connect("postgres://rfvpbzdy:Viurc8sZ2VdqcnPCsFCOd9j9a-qFAOMG@chunee.db.elephantsql.com/rfvpbzdy");
	
	$result = pg_query($con, "INSERT INTO TFotos(foto) VALUES('$FOTO')");
	
	if ($result){
	$response["success"] = 1;
	$response["message"] = "foto criada com sucesso";
	
	
	else{
	$response["success"] = 0;
	$response["message"] = "Erro ao criar foto no bd";

	
	}
}
else {
	$response["success"] = 0;
	$response["message"] = "Campo requerido nao preenchido";
	

	
}
pg_close($con);
	
echo json_encode($response); }
?>
