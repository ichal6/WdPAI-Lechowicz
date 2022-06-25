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
    title       VARCHAR(255) not null
);

create unique index IF NOT EXISTS lists_id_uindex
    on lists (id);

alter table lists
    add type_id int not null;

alter table lists
    add constraint lists___fk_type_id
        foreign key (type_id) references types
            on update cascade on delete cascade;

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
    quantity      numeric(10,2)          not null,
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

alter table products
    rename column available to available_on_market_id;

alter table products
    alter column available_on_market_id type integer using available_on_market_id::integer;

alter table products
    alter column available_on_market_id set not null;

alter table products
    alter column available_on_market_id drop not null;

alter table products
    add constraint products___fk_available_market
        foreign key (available_on_market_id) references priorities
            on update cascade on delete cascade;

alter table last_prices
    drop constraint last_prices___fk_lasts_prices;

alter table last_prices
    add constraint last_prices___fk_lasts_prices
        foreign key (currency_id) references currencies
            on update cascade on delete cascade;

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

CREATE OR REPLACE VIEW get_lists AS
SELECT owner_id as user_id ,lists.id, category_id, type_id, priority_id, title, types.name as type_name, c.name as category, p.name as priority, ud.name as owner
FROM lists
         JOIN types ON lists.type_id = types.id
         JOIN users u ON lists.owner_id = u.id
         JOIN user_details ud ON u.id_user_details = ud.id
         LEFT OUTER JOIN categories c on lists.category_id = c.id
         LEFT OUTER JOIN priorities p on lists.priority_id = p.id;

INSERT INTO user_details (id, name, surname) VALUES (1, 'John', 'Snow');
SELECT setval('public.user_details_id_seq', 2);
INSERT INTO users (id_user_details, email, password, created_at) VALUES (1, 'user@user.pl', '$2y$10$Z0nnQx/k9c7seMEsn/gPiOHbXXvhtGh9hOAEt2b/cZThjrl8WRreG', '2022-06-17');

INSERT INTO categories (id, user_id, name) VALUES (1, 1, 'Grosery');
INSERT INTO categories (id, user_id, name) VALUES (2, 1, 'Chemists');
INSERT INTO categories (id, user_id, name) VALUES (3, 1, 'Presents');
INSERT INTO categories (id, user_id, name) VALUES (4, 1, 'For bathroom');
INSERT INTO categories (id, user_id, name) VALUES (5, 1, 'Vegetables');
INSERT INTO categories (id, user_id, name) VALUES (6, 1, 'Meat');
SELECT setval('public.categories_id_seq', 7);

INSERT INTO types (id, user_id, name) VALUES (1, 1, 'Cyclic');
INSERT INTO types (id, user_id, name) VALUES (2, 1, 'Normal');
SELECT setval('public.types_id_seq', 3);

INSERT INTO priorities (id, name) VALUES (1, 'Low');
INSERT INTO priorities (id, name) VALUES (2, 'Medium');
INSERT INTO priorities (id, name) VALUES (3, 'High');
SELECT setval('public.priorities_id_seq', 4);

INSERT INTO statuses (id, name) VALUES (1, 'to buy');
INSERT INTO statuses (id, name) VALUES (2, 'bought');
SELECT setval('public.statuses_id_seq', 3);

INSERT INTO units (id, name) VALUES (1, 'Kg');
INSERT INTO units (id, name) VALUES (2, 'piece');
INSERT INTO units (id, name) VALUES (3, 'g');
INSERT INTO units (id, name) VALUES (4, 'cube');
SELECT setval('public.units_id_seq', 5);

INSERT INTO lists (id, title, owner_id, type_id) VALUES (1, 'Chemist', 1, 2);
INSERT INTO lists (id, title, owner_id, type_id) VALUES (2, 'Foods', 1, 1);
INSERT INTO lists (id, title, owner_id, type_id, priority_id, category_id) VALUES (3, 'New RTV', 1, 1, 1, 2);
INSERT INTO lists (id, title, owner_id, type_id, priority_id, category_id) VALUES (4, 'New AGD', 1, 1, 2, 4);
INSERT INTO lists (id, title, owner_id, type_id, priority_id, category_id) VALUES (5, 'Repair Websites', 1, 1, 3, 1);
SELECT setval('public.lists_id_seq', 6);

INSERT INTO products(id, name, available_on_market_id, quantity, list_id, status_id, unit_id) VALUES (1, 'soap', 1, 2, 1, 1, 2);
INSERT INTO products(id, name, available_on_market_id, quantity, list_id, status_id, unit_id) VALUES (2, 'washing liquid', 2, 1, 1, 2, 1);

INSERT INTO products(id, name, available_on_market_id, quantity, list_id, status_id, unit_id) VALUES (3, 'bread', 3, 500, 2, 2, 3);
INSERT INTO products(id, name, available_on_market_id, quantity, list_id, status_id, unit_id) VALUES (4, 'butter', 2, 1, 2, 1, 4);
SELECT setval('public.products_id_seq', 5);

INSERT INTO currencies(id, name) VALUES (1, 'PLN');
INSERT INTO currencies(id, name) VALUES (2, 'USD');
INSERT INTO currencies(id, name) VALUES (3, 'EUR');
SELECT setval('public.currencies_id_seq', 4);

alter table lists
    add created_at date;

alter table types
    drop column user_id;
