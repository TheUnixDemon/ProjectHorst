DROP TABLE IF EXISTS release;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE game (
    release_id BIGINT NOT NULL AUTO_INCREMENT,
    createDate DATE,
    releaseTitle VARCHAR(255),
    gameFile VARCHAR(255),
    markdownFile VARCHAR(255),
    PRIMARY KEY (release_id)
);

ROLLBACK;
--COMMIT;
