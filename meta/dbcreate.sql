CREATE DATABASE IF NOT EXISTS bohhls;

USE bohhls;

SET autocommit=0;
START TRANSACTION;

DROP TABLE IF EXISTS `ScheduleCourse`;
DROP TABLE IF EXISTS `CourseType`;
DROP TABLE IF EXISTS `Schedule`;
DROP TABLE IF EXISTS `SectionCourse`;
DROP TABLE IF EXISTS `Section`;
DROP TABLE IF EXISTS `ProfessorCourse`;
DROP TABLE IF EXISTS `Course`;
DROP TABLE IF EXISTS `Room`;
DROP TABLE IF EXISTS `RoomType`;
DROP TABLE IF EXISTS `Login`;
DROP TABLE IF EXISTS `TimeOff`;
DROP TABLE IF EXISTS `TimeOffStatus`;
DROP TABLE IF EXISTS `User`;
DROP TABLE IF EXISTS `Department`;
DROP TABLE IF EXISTS `UserType`;

-- Professor or Administrator
CREATE TABLE `UserType`(
type_id     TINYINT PRIMARY KEY,
type_desc   VARCHAR(128)
);

-- Lab or Lecture
CREATE TABLE `CourseType`(
type_id     TINYINT PRIMARY KEY,
type_desc   TEXT
);

-- Lab or Classroom
CREATE TABLE `RoomType`(
type_id     TINYINT PRIMARY KEY,
name        TEXT
);

CREATE TABLE `Department`(
dept_id     INT PRIMARY KEY,
name        VARCHAR(64)
);

CREATE TABLE `User`(
u_id        BIGINT PRIMARY KEY AUTO_INCREMENT,
first_name  VARCHAR(64),
last_name   VARCHAR(64),
u_type      TINYINT,
email       VARCHAR(64),
dept_id     INT,
contact     CHAR(10),
FOREIGN KEY (u_type) REFERENCES `UserType`(type_id),
FOREIGN KEY (dept_id) REFERENCES `Department`(dept_id)
);

CREATE TABLE `Login`(
u_id            BIGINT PRIMARY KEY NOT NULL,
login_name      VARCHAR(32),
login_password  CHAR(64),
FOREIGN KEY (u_id) REFERENCES `User`(u_id)
);

CREATE TABLE `Course`(
c_id            BIGINT PRIMARY KEY AUTO_INCREMENT,
c_code          VARCHAR(16),
c_description   VARCHAR(256),
c_crn           CHAR(5) NOT NULL
);

CREATE TABLE `ProfessorCourse`(
u_id    BIGINT,
c_id    BIGINT,
PRIMARY KEY (u_id, c_id),
FOREIGN KEY (u_id) REFERENCES `User`(u_id),
FOREIGN KEY (c_id) REFERENCES `Course`(c_id)
);

CREATE TABLE `Section`(
s_id    BIGINT PRIMARY KEY AUTO_INCREMENT,
s_name  VARCHAR(16),
s_desc  VARCHAR(256),
s_size  INTEGER
);

CREATE TABLE `SectionCourse`(
s_id    BIGINT NOT NULL,
c_id    BIGINT NOT NULL,
FOREIGN KEY (s_id) REFERENCES `Section`(s_id),
FOREIGN KEY (c_id) REFERENCES `Course`(c_id)
);

CREATE TABLE `Schedule`(
s_id    BIGINT PRIMARY KEY AUTO_INCREMENT,
u_id    BIGINT,
FOREIGN KEY (u_id) REFERENCES `User`(u_id)
);

CREATE TABLE `Room`(
rm_id       BIGINT PRIMARY KEY AUTO_INCREMENT,
rm_number   CHAR(4),
rm_size     INTEGER,
rm_type     TINYINT,
FOREIGN KEY (rm_type) REFERENCES `RoomType`(type_id)
);

CREATE TABLE `ScheduleCourse`(
s_id        BIGINT,
c_id        BIGINT,
room        BIGINT,
type_id     TINYINT,
monday      BOOLEAN DEFAULT 0 NOT NULL,
tuesday     BOOLEAN DEFAULT 0 NOT NULL,
wednesday   BOOLEAN DEFAULT 0 NOT NULL,
thursday    BOOLEAN DEFAULT 0 NOT NULL,
friday      BOOLEAN DEFAULT 0 NOT NULL,
start_time  INTEGER NOT NULL,
finish_time INTEGER NOT NULL,
FOREIGN KEY (s_id) REFERENCES `Schedule`(s_id),
FOREIGN KEY (c_id) REFERENCES `Course`(c_id),
FOREIGN KEY (room) REFERENCES `Room`(rm_id),
FOREIGN KEY (type_id) REFERENCES `CourseType`(type_id)
);

CREATE TABLE `TimeOffStatus`(
status_id   INT PRIMARY KEY,
name        VARCHAR(32) NOT NULL
);

CREATE TABLE `TimeOff`(
t_id            BIGINT PRIMARY KEY AUTO_INCREMENT,
u_id            BIGINT, -- User ID of the professor that requested this time off
start_date      DATE,
finish_date     DATE,
reason          TEXT,
status_id       INT, -- Current status of this time off (i.e., Under Review, Accepted, Rejected)
date_requested  DATETIME,
FOREIGN KEY (u_id) REFERENCES `User`(u_id),
FOREIGN KEY (status_id) REFERENCES `TimeOffStatus`(status_id)
);

COMMIT;
