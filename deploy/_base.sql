create table action (
	id int primary key not null auto_increment,
	name varchar(255) not null,
  phrase varchar(255) not null,
	description varchar(255),
	type varchar(255) not null,
	scope varchar(255) not null,
	effect_modifier varchar(255),
--   Tenho ver se vai ser mais de um.
--   Também tem que colocar a resistência envolvida com a ação.
	effect_base int,
	effect_variation int,
	critical boolean,
	created_at datetime not null,
	updated_at datetime,
	deleted_at datetime
) engine = innodb;

insert action ( name, phrase, type, scope, effect_modifier, effect_base, effect_variation, critical, created_at )
 values ( 'attack', 'attacks', 'Offensive', 'Single Enemy', 'Strenght', '0', '0', '1', now() );

insert action ( name, phrase, type, scope, effect_modifier, effect_base, effect_variation, critical, created_at )
 values ( 'Kame Hame Ha', 'shoots a Kame Hame Ha against', 'Offensive', 'Single Enemy', 'Power', '20', '15', '1', now() );

