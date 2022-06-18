create table IF NOT EXISTS user_details
(
    id      serial
        constraint user_details_pk
            primary key,
    name    VARCHAR(255) not null,
    surname VARCHAR(255) not null
);

create unique index IF NOT EXISTS user_details_id_uindex
    on user_details (id);
	
create table IF NOT EXISTS roles
(
    id   serial
        constraint roles_pk
            primary key,
    name VARCHAR(255) not null
);

create unique index IF NOT EXISTS roles_id_uindex
    on roles (id);

create unique index IF NOT EXISTS roles_name_uindex
    on roles (name);

create table IF NOT EXISTS users
(
    id              serial
        constraint users_pk
            primary key,
    id_user_details int               not null,
    email           VARCHAR(255)      not null,
    password        VARCHAR(255)      not null,
    enabled         bool default true not null,
    created_at      date              not null,
    roles_id        int default 1     not null
);

create unique index IF NOT EXISTS users_email_uindex
    on users (email);

create unique index IF NOT EXISTS users_id_uindex
    on users (id);

create unique index IF NOT EXISTS users_id_user_details_uindex
    on users (id_user_details);

ALTER TABLE users DROP CONSTRAINT IF EXISTS users___fk_user_details;
	
alter table users
    add constraint users___fk_user_details 
        foreign key (id_user_details) references user_details
            on update cascade on delete cascade;

ALTER TABLE users DROP CONSTRAINT IF EXISTS users___fk_roles;

alter table users
    add constraint users___fk_roles
        foreign key (roles_id) references roles
            on update cascade on delete cascade;

create table IF NOT EXISTS categories
(
    id      serial
        constraint categories_pk
            primary key,
    user_id int not null
        constraint categories___fk_user
            references users
            on update cascade on delete cascade,
    name    VARCHAR(255) not null
);

create unique index IF NOT EXISTS categories_id_uindex
    on categories (id);
	
create table IF NOT EXISTS lists
(
    id          serial
        constraint lists_pk
            primary key,
    owner_id    int not null
        constraint lists___fk_owner_id
            references users
            on update cascade on delete cascade,
    category_id int
        constraint lists___fk_category_id
            references categories (id)
            on update cascade on delete cascade,
    priority_id int,
    title       int
);

create unique index IF NOT EXISTS lists_id_uindex
    on lists (id);

create table IF NOT EXISTS user_lists
(
    id_user int not null
        constraint user_lists_users_id_fk
            references users
            on update cascade on delete cascade,
    id_list int not null
        constraint user_lists___fk_lists_id
            references lists
            on update cascade on delete cascade
);

create table IF NOT EXISTS priorities
(
    id   serial
        constraint priorities_pk
            primary key,
    name VARCHAR(255) not null
);

create unique index IF NOT EXISTS priorities_id_uindex
    on priorities (id);
	
ALTER TABLE lists DROP CONSTRAINT IF EXISTS lists___fk_priority;
	
alter table lists
    add constraint lists___fk_priority
        foreign key (priority_id) references priorities
            on update cascade on delete cascade;

create table IF NOT EXISTS units
(
    id   serial
        constraint units_pk
            primary key,
    name VARCHAR(255) not null
);

create unique index IF NOT EXISTS units_id_uindex
    on units (id);

create table IF NOT EXISTS currencies
(
    id   serial
        constraint currencies_pk
            primary key,
    name VARCHAR(255) not null
);

create unique index IF NOT EXISTS currencies_id_uindex
    on currencies (id);

create table IF NOT EXISTS last_prices
(
    id          serial
        constraint last_prices_pk
            primary key,
    currency_id int,
    value       double precision
);

ALTER TABLE last_prices DROP CONSTRAINT IF EXISTS last_prices___fk_lasts_prices;

alter table last_prices
    add constraint last_prices___fk_lasts_prices
        foreign key (currency_id) references last_prices
            on update cascade on delete cascade;
			
create table IF NOT EXISTS locations
(
    id   serial
        constraint locations_pk
            primary key,
    name VARCHAR(255) not null
);

create unique index IF NOT EXISTS locations_id_uindex
    on locations (id);

create table IF NOT EXISTS statuses
(
    id   serial
        constraint statuses_pk
            primary key,
    name VARCHAR(255) not null
);

create table IF NOT EXISTS products
(
    id            serial
        constraint products_pk
            primary key,
    location_id   int
        constraint products___fk_location
            references locations
            on update cascade on delete cascade,
    priority_id   int
        constraint products___fk_priority
            references priorities
            on update cascade on delete cascade,
    available     VARCHAR(255),
    status_id     int          not null
        constraint products___fk_status
            references statuses
            on update cascade on delete cascade,
    quantity      int          not null,
    last_price_id int
        constraint products___fk_last_price
            references last_prices
            on update cascade on delete cascade,
    list_id       int          not null,
    category_id   int
        constraint products___fk_category
            references categories
            on update cascade on delete cascade,
    unit_id       int          not null
        constraint products___fk_unit
            references units
            on update cascade on delete cascade,
    name          VARCHAR(255) not null
);

create unique index IF NOT EXISTS products_id_uindex
    on products (id);

create unique index IF NOT EXISTS products_name_uindex
    on products (name);
	
ALTER TABLE products DROP CONSTRAINT IF EXISTS products___fk_lists;

alter table products
    add constraint products___fk_lists
        foreign key (list_id) references lists
            on update cascade on delete cascade;

create table IF NOT EXISTS types
(
    id      serial
        constraint types_pk
            primary key,
    user_id integer      not null,
    name    varchar(255) not null
);

create unique index IF NOT EXISTS types_id_uindex
    on types (id);

INSERT INTO roles VALUES(1, 'user');

CREATE OR REPLACE FUNCTION trigger_function_delete_user_details()
    RETURNS TRIGGER
    LANGUAGE PLPGSQL
AS $$
BEGIN
    DELETE FROM user_details WHERE id=old.id_user_details;
    RETURN NULL;
END;
$$
;

CREATE OR REPLACE TRIGGER delete_user_trigger AFTER DELETE ON users FOR EACH ROW
EXECUTE PROCEDURE trigger_function_delete_user_details();


INSERT INTO user_details (id, name, surname) VALUES (1, 'John', 'Snow');
INSERT INTO users (id_user_details, email, password, created_at) VALUES (1, 'user@user.pl', '$2y$10$Z0nnQx/k9c7seMEsn/gPiOHbXXvhtGh9hOAEt2b/cZThjrl8WRreG', '2022-06-17');

INSERT INTO categories (id, user_id, name) VALUES (1, 1, 'Grosery');
INSERT INTO categories (id, user_id, name) VALUES (2, 1, 'Chemists');
INSERT INTO categories (id, user_id, name) VALUES (3, 1, 'Presents');
INSERT INTO categories (id, user_id, name) VALUES (4, 1, 'For bathroom');
INSERT INTO categories (id, user_id, name) VALUES (5, 1, 'Vegetables');
INSERT INTO categories (id, user_id, name) VALUES (6, 1, 'Meat');

INSERT INTO types (id, user_id, name) VALUES (1, 1, 'Cyclic');
INSERT INTO types (id, user_id, name) VALUES (2, 1, 'Normal');

INSERT INTO priorities (id, name) VALUES (1, 'Low');
INSERT INTO priorities (id, name) VALUES (2, 'Medium');
INSERT INTO priorities (id, name) VALUES (3, 'High');
