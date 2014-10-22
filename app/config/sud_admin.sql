-- database sud_administrator

drop table if exists sa_usuario_permiso;
create table if not exists sa_usuario_permiso(
	id varchar(11) not null primary key,
	permiso varchar(140) not null,
	codigo varchar (4) not null
);

insert into sa_usuario_permiso values
	('1414006201', 'Administrador', 'ADM'),
	('1414006202', 'Reportes Generales', 'RPG'),
	('1414006203', 'Reportes Clientes', 'RPC');

drop table if exists sa_departamento;
create table if not exists sa_departamento(
	id varchar(11) not null primary key,
	departamento varchar(140) not null,
	codigo varchar(4) not null
);

insert into sa_departamento values
	('1414006201', 'La Paz', 'LP'),
	('1414006202', 'Oruro', 'OR'),
	('1414006203', 'Potosi', 'PT'),
	('1414006204', 'Cochabamba', 'CB'),
	('1414006205', 'Chuquisaca', 'CH'),
	('1414006206', 'Tarija', 'TJ'),
	('1414006207', 'Santa Cruz', 'SC'),
	('1414006208', 'Beni', 'BE'),
	('1414006209', 'Pando', 'PA');

drop table if exists sa_usuario;
create table if not exists sa_usuario(
	id int(255) not null primary key,
	usuario varchar(30) not null unique key,
	password varchar(255) not null,
	nombre varchar(140) not null,
	email varchar(140) not null,
	departamento varchar(11) not null,
	permiso varchar(11) not null,
	fechsa_creacion date not null,
	activado boolean default false,
	actualizacion_password boolean default false,

	foreign key (departamento) references sa_departamento(id),
	foreign key (permiso) references sa_usuario_permiso(id)
);