/*create table named cashflow_db*/

create sequence sid_user;
create table "user"(
	id integer not null default nextval('sid_user'),
	name varchar(50) not null,
	gender char(1) not null,
	email varchar(30) not null,
	password text not null,
	status char(1) not null,
	type char(1) not null,
	photo text,	
	constraint pk_user primary key (id),
	constraint unq_user_email unique(email)
);

create sequence sid_category;
create table category(
	id integer not null default nextval('sid_category'),
	name varchar(30),
	constraint pk_category primary key (id)
);

create sequence sid_flow;
create table flow(
	id integer not null default nextval('sid_flow'),
	"date" date not null,
	description varchar(50) not null,
	type char(1),
	value numeric(9,2) not null,
	id_category integer not null,	
	constraint pk_flow primary key (id),
	constraint fk_flow_category foreign key (id_category) references category (id)
);