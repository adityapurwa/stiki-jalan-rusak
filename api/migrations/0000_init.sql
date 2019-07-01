DROP DATABASE IF EXISTS laporjalan;
CREATE DATABASE laporjalan;
USE laporjalan;
CREATE TABLE users(
                      id varchar(36) not null primary key,
                      email varchar(512) not null unique,
                      name varchar(256) not null,
                      password varchar(512) not null
);

