--replica do modelo fisico do banco de dados usado
CREATE TABLE Pessoa (
	 CPF VARCHAR(50) PRIMARY KEY,
	 SENHA VARCHAR(50) NOT NULL,
	 NOME VARCHAR(50) NOT NULL,
	 GENERO VARCHAR(20) NOT NULL,
	 TIPO_SANG VARCHAR(20) NOT NULL,
	 DATA_NASC VARCHAR(50) NOT NULL,
	 NUM_EMER VARCHAR(20) NOT NULL,
	 created_at timestamp default now());

CREATE TABLE Sintoma (

	 ID_SINTOMA serial PRIMARY KEY,
	 CPF VARCHAR(50) NOT NULL,
	 SINTOMA_TITLE VARCHAR(30) DEFAULT NULL,
	 SINTOMA_DESC text NOT NULL ,
	 SINTOMA_DATA VARCHAR(50) NOT NULL ,
	 SINTOMA_PHOTO text DEFAULT NULL ,
	 CONSTRAINT fk_Sintoma_Pessoa1 FOREIGN KEY (CPF) REFERENCES Pessoa (CPF) ON DELETE NO ACTION ON UPDATE NO ACTION);

CREATE TABLE Tratamento (

	 ID_TRATAMENTO serial PRIMARY KEY,
	 CPF VARCHAR(50) NOT NULL,
	 TRATAMENTO_TITLE VARCHAR(30) DEFAULT NULL ,
	 TRATAMENTO_DESC text NOT NULL ,
	 TRATAMENTO_DATA VARCHAR(50) NOT NULL ,

	 CONSTRAINT fk_Tratamento_Pessoa1 FOREIGN KEY (CPF) REFERENCES Pessoa (CPF) ON DELETE NO ACTION ON UPDATE NO ACTION);
	 

CREATE TABLE TFotos (
	 ID_TFOTO serial PRIMARY KEY,
	 ID_TRATAMENTO INT NOT NULL,
	 FOTO text DEFAULT NULL,
	 CONSTRAINT fk_TFotos_Tratamento1 FOREIGN KEY (ID_TRATAMENTO) REFERENCES Tratamento (ID_TRATAMENTO) ON DELETE NO ACTION ON UPDATE NO ACTION



);
