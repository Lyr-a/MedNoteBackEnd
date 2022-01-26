<?php 

//usuarios 

$response = array();

//conferir os campos requisitados
if (isset($_POST['cpf']) && isset($_POST['senha']) && isset($_POST['nome']) && isset($_POST['genero']) && isset($_POST['tipo_sang']) && isset($_POST['num_emer'])){


	$CPF = trim($_POST['cpf']);
	$SENHA = trim($_POST['senha']);
	$NOME = trim($_POST['nome']);
	$GENERO = trim($_POST['genero']);
	$TIPO_SANG = trim($_POST['tipo_sang']);
	$DATA_NASC = trim($_POST['data_nasc']);
	$NUM_EMER = trim($_POST['num_emer']);
	
	//conectar ao banco de dados
	$con = pg_connect("postgres://rfvpbzdy:Viurc8sZ2VdqcnPCsFCOd9j9a-qFAOMG@chunee.db.elephantsql.com/rfvpbzdy");
	
	$usuario_existe = pg_query($con, "SELECT cpf FROM Pessoa WHERE cpf='$CPF'");
	//ver se ja ha usuario com esse cpf
	if (pg_num_rows($usuario_existe) > 0){
		$response["success"] = 0;
		$response["error"] = "usuario ja cadastrado";
	}
	
	else{	
		$result = pg_query($con, "INSERT INTO Pessoa(cpf, senha, nome, genero, tipo_sang, data_nasc, num_emer)
		VALUES('$CPF', '$SENHA','$NOME','$GENERO', '$TIPO_SANG', $DATA_NASC, '$NUM_EMER')");
	
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
	
