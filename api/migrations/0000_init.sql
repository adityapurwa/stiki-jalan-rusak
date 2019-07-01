DROP DATABASE IF EXISTS laporjalan;
CREATE DATABASE laporjalan;
USE laporjalan;
CREATE TABLE users
(
    id       varchar(36)               not null primary key,
    email    varchar(512)              not null unique,
    name     varchar(256)              not null,
    password varchar(512)              not null,
    type     enum ('official', 'user') not null default 'user'
);

CREATE TABLE reports
(
    id      varchar(36)  not null primary key,
    address varchar(512) not null,
    photo   varchar(512) not null,
    user_id varchar(36)  not null references users (id) on update cascade on delete cascade,
    created_at timestamp not null default CURRENT_TIMESTAMP
);

create table report_votes
(
    id        varchar(36)                   not null primary key,
    user_id   varchar(36)                   not null references users (id) on update cascade on delete cascade,
    report_id varchar(36)                   not null references reports (id) on update cascade on delete cascade,
    type      enum ('positive', 'negative') not null
);


