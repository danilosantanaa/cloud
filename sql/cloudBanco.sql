-- Criando banco de dado
create database db_cloud1
default character set utf8
default collate utf8_general_ci;

-- Usando o banco de dados
use db_cloud1;

-- Criando a tabela
create table tb_cliente (
id int not null auto_increment,
nome varchar(60) not null,
email varchar(45) not null unique,
telefone varchar(15) not null,
primary key(id)
);

-- Criando a tabela de usuário
create table tb_usuario(
id int not null auto_increment,
usuario varchar(45) not null unique,
senha varchar(255) not null,
is_admin enum('0', '1') not null default '0',
primary key(id)
);