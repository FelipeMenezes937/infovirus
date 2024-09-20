create database infoVirus;
use infoVirus;
create table usuario(
	nome varchar(50) not null,
	email varchar(50)not null,
	senha char(32) not null,
	idUsuario int auto_increment not null primary key
);

 
create table Consulta(
	idConsulta int not null auto_increment primary key,
	hashArquivo char(32) not null,
    dataConsulta  date not null,
	resultado varchar(30) not null,
	fk_idUsuario int not null,
     fk_idTipo int not null
);

create table Tipo (
	idTipo int not null auto_increment primary key,
    tipoConsulta varchar(20)

);

alter table Consulta add foreign key
(fk_idUsuario) references usuario(idUsuario);

alter table Consulta add foreign key
(fk_idTipo) references Tipo(idTipo);