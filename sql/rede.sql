DROP SCHEMA IF EXISTS rede;
CREATE SCHEMA IF NOT EXISTS rede;
CREATE TABLE IF NOT EXISTS rede.conta(
	id INT(100) PRIMARY KEY AUTO_INCREMENT,
	nome VARCHAR(100) NOT NULL,
	sobrenome VARCHAR(100) NOT NULL,
	email VARCHAR(100) NOT NULL UNIQUE,
	senha VARCHAR(100) NOT NULL,
	adm VARCHAR(5) DEFAULT "false",
	foto LONGBLOB,
	sexo VARCHAR(1)
);
CREATE TABLE IF NOT EXISTS rede.amigos(
	id 	INT(100) PRIMARY KEY AUTO_INCREMENT,
	data_amizade VARCHAR(8) NOT NULL,
	id_conta INT(100) NOT NULL,
	id_amigo INT(100) NOT NULL,
	FOREIGN KEY (id_conta) REFERENCES rede.conta(id)
);

CREATE TABLE IF NOT EXISTS rede.posts(
	id INT(100) PRIMARY KEY AUTO_INCREMENT,
	data_post VARCHAR(8) NOT NULL,
	hora_post VARCHAR(5) NOT NULL,
	id_conta INT(100) NOT NULL,
	img_post LONGBLOB,
	legenda_post VARCHAR(1000),
	FOREIGN KEY (id_conta) REFERENCES rede.conta(id)
);
CREATE TABLE IF NOT EXISTS rede.likes(
	id INT(100) PRIMARY KEY AUTO_INCREMENT,
	id_post INT(100) NOT NULL,
	id_conta INT(100) NOT NULL,
	id_amizade INT(100) NOT NULL,
	qtd_likes INT(100) NOT NULL DEFAULT 0,
	FOREIGN KEY(id_post) REFERENCES rede.posts(id),
	FOREIGN KEY(id_conta) REFERENCES rede.conta(id),
	FOREIGN KEY(id_amizade) REFERENCES rede.amigos(id)
);
CREATE TABLE IF NOT EXISTS rede.personalizacao(
	id INT(100) PRIMARY KEY AUTO_INCREMENT,
	id_conta INT(100) NOT NULL UNIQUE,
	background LONGBLOB,
	cor VARCHAR(7) DEFAULT "#0000AA",
	FOREIGN KEY (id_conta) REFERENCES rede.conta(id)
);
CREATE TABLE IF NOT EXISTS rede.pensamentos(
	id INT(100) PRIMARY KEY AUTO_INCREMENT,
	id_conta INT(100) UNIQUE NOT NULL,
	pensamento VARCHAR(300) NOT NULL,
	FOREIGN KEY(id_conta) REFERENCES rede.conta(id)
);