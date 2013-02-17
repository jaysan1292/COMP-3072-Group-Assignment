SET autocommit=0;
START TRANSACTION;

DROP TABLE IF EXISTS `UserType`;
DROP TABLE IF EXISTS `User`;
DROP TABLE IF EXISTS `Login`;
DROP TABLE IF EXISTS `Course`;
DROP TABLE IF EXISTS `ProfessorCourse`;
DROP TABLE IF EXISTS `Section`;
DROP TABLE IF EXISTS `SectionCourse`;
DROP TABLE IF EXISTS `Schedule`;
DROP TABLE IF EXISTS `CourseType`;
DROP TABLE IF EXISTS `ScheduleCourse`;
DROP TABLE IF EXISTS `RoomType`;
DROP TABLE IF EXISTS `Room`;

CREATE TABLE `UserType`(
type_id int PRIMARY KEY AUTO_INCREMENT,
type_desc text
);

CREATE TABLE `User`(
u_id bigint PRIMARY KEY AUTO_INCREMENT,
first_name text,
last_name text,
u_type int,
FOREIGN KEY (u_type) REFERENCES `UserType`(type_id)
);

CREATE TABLE `Login`(
u_id BIGINT PRIMARY KEY NOT NULL,
login_name TEXT,
login_password CHAR(64),
FOREIGN KEY (u_id) REFERENCES `User`(u_id)
);

CREATE TABLE `Course`(
c_id bigint PRIMARY KEY AUTO_INCREMENT,
c_code text,
c_description text,
c_crn char(5) NOT NULL
);

CREATE TABLE `ProfessorCourse`(
u_id BIGINT,
c_id BIGINT,
PRIMARY KEY (u_id, c_id),
FOREIGN KEY (u_id) REFERENCES `User`(u_id),
FOREIGN KEY (c_id) REFERENCES `Course`(c_id)
);

CREATE TABLE `Section`(
s_id bigint PRIMARY KEY AUTO_INCREMENT,
s_name text,
s_desc text,
s_size int
);

CREATE TABLE `SectionCourse`(
s_id bigint NOT NULL,
c_id bigint NOT NULL,
FOREIGN KEY (s_id) REFERENCES `Section`(s_id),
FOREIGN KEY (c_id) REFERENCES `Course`(c_id)
);

CREATE TABLE `Schedule`(
s_id bigint NOT NULL
);

-- Lab or Lecture
CREATE TABLE `CourseType`(
type_id tinyint NOT NULL,
type_desc text
);

CREATE TABLE `ScheduleCourse`(
s_id bigint,
c_id bigint,
type_id tinyint,
start_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
finish_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
FOREIGN KEY (type_id) REFERENCES `CourseType`(type_id),
FOREIGN KEY (s_id) REFERENCES `Schedule`(s_id),
FOREIGN KEY (c_id) REFERENCES `Course`(c_id)
);

-- Lab or Classroom
CREATE TABLE `RoomType`(
type_id tinyint PRIMARY KEY AUTO_INCREMENT,
name text
);

CREATE TABLE `Room`(
rm_id bigint PRIMARY KEY AUTO_INCREMENT,
rm_number char(4),
rm_size int,
rm_type int,
FOREIGN KEY (rm_type) REFERENCES `RoomType`(type_id)
);

COMMIT;