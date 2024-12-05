 create database infovirus;
 use infovirus;
 CREATE TABLE Usuario 
( 
 idUsuario INT PRIMARY KEY AUTO_INCREMENT,
 nome VARCHAR(80) NOT NULL,    
 email VARCHAR(80) NOT NULL,  
 senha CHAR(32) NOT NULL
); 

CREATE TABLE Tipo 
( 
 idTipo INT PRIMARY KEY AUTO_INCREMENT,  
 tipoConsulta VARCHAR(50) NOT NULL 
); 

CREATE TABLE ConsSValor 
( 
 idConsSValor INT PRIMARY KEY AUTO_INCREMENT,  
 dataConsulta DATE NOT NULL,  
 FKidTipo INT,  
 FKidUsuario INT,
 valorS int
); 

CREATE TABLE ConsSRetorno 
( 
 idConsSRetorno INT PRIMARY KEY AUTO_INCREMENT,
 fkidUsuario int,
 FKidTipo INT, 
 dataConsulta date
); 



ALTER TABLE ConsSValor ADD FOREIGN KEY(FKidTipo) REFERENCES Tipo (idTipo);
ALTER TABLE ConsSValor ADD FOREIGN KEY(FKidUsuario) REFERENCES Usuario (idUsuario);
ALTER TABLE ConsSRetorno ADD FOREIGN KEY(FKidTipo) REFERENCES Tipo (idTipo);
ALTER TABLE ConsSRetorno ADD foreign key(FKidUsuario) references Usuario (idUsuario);


insert into Tipo(idTipo, tipoConsulta)
	Values(null, 'arquivo'),
    (null, 'senha'),
    (null, 'url'),
    (null, 'compArq'),
    (null, 'email'),
    (null, 'porta');


select * from ConsSRetorno;	

alter table consSRetorno add dataConsulta int;


