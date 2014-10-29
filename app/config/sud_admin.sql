-- database sud_administrator

drop table if exists sa_usuario_permiso;
create table if not exists sa_usuario_permiso(
	id int(21) not null primary key,
	permiso varchar(140) not null,
	codigo varchar (4) not null unique key
);

insert into sa_usuario_permiso values
	(1414006201, 'Administrador', 'ADM'),
	(1414006202, 'Reportes Generales', 'RPG'),
	(1414006203, 'Reportes Clientes', 'RPC');

drop table if exists sa_departamento;
create table if not exists sa_departamento(
	id int(21) not null primary key,
	departamento varchar(140) not null,
	codigo varchar(4) not null unique key
);

insert into sa_departamento values
	(1414006201, 'La Paz', 'LP'),
	(1414006202, 'Oruro', 'OR'),
	(1414006203, 'Potosi', 'PT'),
	(1414006204, 'Cochabamba', 'CB'),
	(1414006205, 'Chuquisaca', 'CH'),
	(1414006206, 'Tarija', 'TJ'),
	(1414006207, 'Santa Cruz', 'SC'),
	(1414006208, 'Beni', 'BE'),
	(1414006209, 'Pando', 'PA');

drop table if exists sa_usuario;
create table if not exists sa_usuario(
	id int(21) not null primary key,
	usuario varchar(30) not null unique key,
	password varchar(255) not null,
	nombre varchar(140) not null,
	email varchar(140) not null,
	departamento int(21) not null,
	permiso int(21) not null,
	fechsa_creacion date not null,
	activado boolean default false,
	actualizacion_password boolean default false,

	foreign key (departamento) references sa_departamento(id),
	foreign key (permiso) references sa_usuario_permiso(id)
);

insert into sa_usuario values
	(1414006201, 'admin', '$2x$07$zcfSZ2.sE.jOSZdcCGK0geXOjt98pv2iUM22AIdJl.gcjgwYMd44S', 
		'Administrador', 'mmamani@coboser.com', 1414006201, 1414006201, '2014-10-23', true, true);

drop table if exists sa_producto;
create table if not exists sa_producto(
	id int(21) not null primary key,
	nombre varchar(140) not null,
	codigo varchar(6) not null unique key,
	activado boolean default false
);

insert into sa_producto values
	(1414006201, 'Desgravamen', 'DE', true),
	(1414006202, 'Automotores', 'AU', true),
	(1414006203, 'Todo Riesgo', 'TRD', true),
	(1414006204, 'Ramos Tecnicos', 'TRM', true);

drop table if exists sa_entidad_financiera;
create table if not exists sa_entidad_financiera(
	id int(21) not null primary key,
	nombre varchar(140) not null,
	codigo varchar(10) not null unique key,
	db_host varchar(140) not null,
	db_database varchar(140) not null,
	db_user varchar(140) not null,
	db_password varchar(140) not null,
	activado boolean default false
);

insert into sa_entidad_financiera values
	(1414006201, 'Ecofuturo', 'EC', 'localhost', 'ecofuturo', 'root', '', true),
	(1414006202, 'Sembrar Sartawi', 'SS', 'localhost', 'sartawi', 'root', '', true),
	(1414006203, 'Bisa Leasing', 'BL', 'localhost', 'bisaleasing', 'root', '', true),
	(1414006204, 'Emprender', 'EM', 'localhost', 'empreder', 'root', '', true),
	(1414006205, 'Paulo VI', 'PV', 'localhost', 'paulo', 'root', '', true),
	(1414006206, 'Idepro', 'ID', 'localhost', 'idepro', 'root', '', true),
	(1414006207, 'Crecer', 'CR', 'localhost', 'crecer', 'root', '', true);

drop table if exists sa_ef_producto;
create table if not exists sa_ef_producto(
	id int(21) not null primary key,
	entidad_financiera int(21) not null,
	producto int(21) not null,

	foreign key (entidad_financiera) references sa_entidad_financiera(id),
	foreign key (producto) references sa_producto(id)
);

insert into sa_ef_producto values
	(1414006201, 1414006201, 1414006201),
	(1414006202, 1414006201, 1414006202),
	(1414006203, 1414006201, 1414006203),
	(1414006204, 1414006207, 1414006201),
	(1414006205, 1414006203, 1414006202),
	(1414006206, 1414006203, 1414006203),
	(1414006207, 1414006206, 1414006201),
	(1414006208, 1414006202, 1414006201);

drop table if exists sa_aseguradora;
create table if not exists sa_aseguradora(
	id int(21) not null primary key,
	nombre varchar(140) not null,
	codigo varchar(10) not null unique key,
	activado boolean default false
);

insert into sa_aseguradora values
	(1414006201, 'Alianza', 'AL', true),
	(1414006202, 'Credinform', 'CR', true),
	(1414006203, 'Bisa Seguros', 'BS', true),
	(1414006204, 'Nacional Vida', 'NV', true),
	(1414006205, 'Crediseguro', 'CS', true);

drop table if exists sa_ef_aseguradora;
create table if not exists sa_ef_aseguradora(
	id int(21) not null primary key,
	entidad_financiera int(21) not null,
	aseguradora int(21) not null,

	foreign key (entidad_financiera) references sa_entidad_financiera(id), 
	foreign key (aseguradora) references sa_aseguradora(id)
);

insert into sa_ef_aseguradora values
	(1414006201, 1414006207, 1414006205),
	(1414006202, 1414006201, 1414006201),
	(1414006203, 1414006201, 1414006202),
	(1414006204, 1414006201, 1414006205);

drop table if exists sa_ef_usuario;
create table if not exists sa_ef_usuario(
	id int(21) not null primary key,
	usuario int(21) not null,
	entidad_financiera int(21) not null,

	foreign key (usuario) references sa_usuario(id),
	foreign key (entidad_financiera) references sa_entidad_financiera(id)
);

insert into sa_ef_usuario values
	(1414006201, 1414006201, 1414006201),
	(1414006202, 1414006201, 1414006201),
	(1414006203, 1414006201, 1414006201),
	(1414006204, 1414006201, 1414006201),
	(1414006205, 1414006201, 1414006202);