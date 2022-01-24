<?php 

//usuarios 

$response = array();

//conferir os campos requisitados
if (isset($_POST['CPF']) && isset($_POST['SENHA']) && isset($_POST['NOME']) && isset($_POST['GENERO']) && isset($_POST['TIPO_SANG']) && isset($_POST['NUM_EMER'])){


	$CPF = trim($_POST['CPF']);
	$SENHA = trim($_POST['SENHA']);
	$NOME = $_POST['NOME'];
	$GENERO = $_POST['GENERO'];
	$TIPO_SANG = $_POST['TIPO_SANG'];
	$DATA_NASC = $_POST['DATA_NASC'];
	$NUM_EMER = $_POST['NUM_EMER'];
	
	//conectar ao banco de dados
	//$con = pg_connext();
	
	$usuario_existe = pg_query($con, "SELECT CPF FROM Pessoa WHERE CPF='$CPF'");
	//ver se ja ha usuario com esse cpf
	if (pg_num_rows($usuario_existe) > 0){
		$response["success"] = 0;
		$response["error"] = "usuario ja cadastrado";
	}
	
	else{	
		$result = pg_query($con, "INSERT INTO Pessoa(CPF, SENHA, NOME, GENERO, TIPO_SANG, NUM_EMER)
		VALUES('$CPF', '$SENHA','$NOME','$GENERO', '$TIPO_SANG','$NUM_EMER')");
	
		if ($result){
			$response["success"] = 1;
			$response["message"] = "Usuario criado com sucesso";
	
	pg_close($con);
	
	echo json_encode($response); }
	
	else{
	$response["success"] = 0;
	$response["message"] = "Erro ao criar usuario no bd".pg_last_error($con);
	
	pg_close($con);
	
	echo json_encode($response);
	
	}}
}
else {
	$response["success"] = 0;
	$response["message"] = "Campo(s) requerido(s) nao preenchido";
	
	echo json_encode($response);
	
}
?>
	