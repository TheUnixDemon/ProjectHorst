DROP TABLE IF EXISTS scores;
DROP TABLE IF EXISTS rounds;
DROP TABLE IF EXISTS user;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE user (
    user_id BIGINT NOT NULL AUTO_INCREMENT,                                   
    user_picture VARCHAR(255),
    password VARCHAR(255),
    user_email VARCHAR(50),
    username VARCHAR(50),
    superRights BOOLEAN,
    rights BOOLEAN,
    full_score FLOAT, 
    PRIMARY KEY (user_id)
);

CREATE TABLE rounds (
    round_id BIGINT NOT NULL AUTO_INCREMENT,
    user_id BIGINT REFERENCES user(user_id),
    guest_id BIGINT REFERENCES user(user_id),
    role BOOLEAN,
    round_create_date DATE,
    round_duration TIME,
    PRIMARY KEY (round_id)
);

CREATE TABLE scores (
    score_id BIGINT NOT NULL AUTO_INCREMENT,
    round_id BIGINT REFERENCES rounds(round_id),
    score BOOLEAN,
    PRIMARY KEY (score_id)
);

ROLLBACK;
--COMMIT;
