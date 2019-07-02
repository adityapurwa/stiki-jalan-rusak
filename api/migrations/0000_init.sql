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
    id          varchar(36)  not null primary key,
    address     varchar(512) not null,
    photo       varchar(512) not null,
    user_id     varchar(36)  not null references users (id) on update cascade on delete cascade,
    created_at  timestamp    not null default CURRENT_TIMESTAMP,
    cache_votes int                   default 0
);

create table report_votes
(
    id        varchar(36)                   not null primary key,
    user_id   varchar(36)                   not null references users (id) on update cascade on delete cascade,
    report_id varchar(36)                   not null references reports (id) on update cascade on delete cascade,
    type      enum ('positive', 'negative') not null
);

CREATE TRIGGER update_report_cache_votes_on_insert
    AFTER INSERT
    ON report_votes
    FOR EACH ROW
BEGIN
    SET @positiveCount = 0;
    SET @negativeCount = 0;
    SELECT COUNT(*) INTO @positiveCount FROM report_votes WHERE type = 'positive' AND report_id = NEW.report_id;
    SELECT COUNT(*) INTO @negativeCount FROM report_votes WHERE type = 'negative' AND report_id = NEW.report_id;
    UPDATE reports SET cache_votes = @positiveCount - @negativeCount WHERE reports.id = NEW.report_id;
end;
CREATE TRIGGER update_report_cache_votes_on_update
    AFTER UPDATE
    ON report_votes
    FOR EACH ROW
BEGIN
    SET @positiveCount = 0;
    SET @negativeCount = 0;
    SELECT COUNT(*) INTO @positiveCount FROM report_votes WHERE type = 'positive' AND report_id = NEW.report_id;
    SELECT COUNT(*) INTO @negativeCount FROM report_votes WHERE type = 'negative' AND report_id = NEW.report_id;
    UPDATE reports SET cache_votes = @positiveCount - @negativeCount WHERE reports.id = NEW.report_id;
end;

CREATE TRIGGER update_report_cache_votes_on_delete
    AFTER DELETE
    ON report_votes
    FOR EACH ROW
BEGIN
    SET @positiveCount = 0;
    SET @negativeCount = 0;
    SELECT COUNT(*) INTO @positiveCount FROM report_votes WHERE type = 'positive' AND report_id = OLD.report_id;
    SELECT COUNT(*) INTO @negativeCount FROM report_votes WHERE type = 'negative' AND report_id = OLD.report_id;
    UPDATE reports SET cache_votes = @positiveCount - @negativeCount WHERE reports.id = OLD.report_id;
end;
