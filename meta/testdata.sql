SET autocommit=0;
START TRANSACTION;

-- Drop everything from all tables
DELETE FROM `UserType`;
DELETE FROM `User`;
DELETE FROM `Login`;
DELETE FROM `RoomType`;
DELETE FROM `Room`;
DELETE FROM `Course`;
DELETE FROM `ProfessorCourse`;
DELETE FROM `Section`;
DELETE FROM `SectionCourse`;
DELETE FROM `Schedule`;
DELETE FROM `CourseType`;
DELETE FROM `ScheduleCourse`;

-- Reset auto-increment counters
ALTER TABLE `UserType`        AUTO_INCREMENT=0;
ALTER TABLE `User`            AUTO_INCREMENT=0;
ALTER TABLE `Login`           AUTO_INCREMENT=0;
ALTER TABLE `RoomType`        AUTO_INCREMENT=0;
ALTER TABLE `Room`            AUTO_INCREMENT=0;
ALTER TABLE `Course`          AUTO_INCREMENT=0;
ALTER TABLE `ProfessorCourse` AUTO_INCREMENT=0;
ALTER TABLE `Section`         AUTO_INCREMENT=0;
ALTER TABLE `SectionCourse`   AUTO_INCREMENT=0;
ALTER TABLE `Schedule`        AUTO_INCREMENT=0;
ALTER TABLE `CourseType`      AUTO_INCREMENT=0;
ALTER TABLE `ScheduleCourse`  AUTO_INCREMENT=0;

-- The actual data
INSERT INTO `UserType` (`type_desc`) VALUES
    ('Professor'),
    ('Administrator');
    
INSERT INTO `RoomType` (`name`) VALUES
    ('Lab'),
    ('Classroom');

INSERT INTO `CourseType` (`type_desc`) VALUES
    ('Lab'),
    ('Lecture');

INSERT INTO `User` (`first_name`,`last_name`,`u_type`) VALUES
    ('John',       'Smith',   2),
    ('Rajib',      'Verma',   1),
    ('Abid',       'Rana',    1),
    ('Przemyslaw', 'Pawluk',  1),
    ('Biljana',    'Vucetic', 1);

-- Passwords are all '123456', hashed with hash('sha256', $password)
INSERT INTO `Login` VALUES
    (1, 'jsmith',   '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92'),
    (2, 'rverma',   '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92'),
    (3, 'arana',    '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92'),
    (4, 'ppawluk',  '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92'),
    (5, 'bvucetic', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92');
    
INSERT INTO `Room` (`rm_size`,`rm_number`,`rm_type`) VALUES
    (50,  'C418', 1),
    (50,  'C416', 1),
    (50,  'C422', 1),
    (100, 'E322', 2),
    (100, 'E218', 2);

INSERT INTO `Course` (`c_code`,`c_description`,`c_crn`) VALUES
    ('COMP3072', 'Open Source Application Development',             '00001'),
    ('COMP3064', 'PC Game Development',                             '00002'),
    ('COMP3071', 'Designing and Implementing Database',             '00003'),
    ('COMP3073', 'System Implementation, Testing, and Maintenance', '00004');

INSERT INTO `ProfessorCourse` (`u_id`,`c_id`) VALUES
    (2, 1),
    (3, 2),
    (4, 3),
    (5, 4);

INSERT INTO `Section` (`s_name`,`s_desc`,`s_size`) VALUES
    ('T127-A', 'Computer Programmer/Analyst', 50);

INSERT INTO `SectionCourse` (`s_id`,`c_id`) VALUES
    (1, 1),
    (1, 2),
    (1, 3),
    (1, 4);

INSERT INTO `Schedule` (`u_id`) VALUES
    (2), -- rverma
    (3), -- arana
    (4), -- ppawluk
    (5); -- bvucetic

INSERT INTO `ScheduleCourse` (`s_id`,`c_id`,`type_id`,`start_time`,`finish_time`) VALUES
    (1, 1, 2, 1600, 1800), -- rverma,   COMP3072, Lecture,  4PM,  6PM
    (1, 1, 1, 1600, 1800), -- rverma,   COMP3072, Lab,      4PM,  6PM
    (2, 3, 2, 1000, 1200), -- arana,    COMP3071, Lecture, 10AM, 12PM
    (2, 3, 1, 1200, 1400), -- arana,    COMP3071, Lab,     12PM,  2PM
    (3, 2, 2, 1200, 1400), -- ppawluk,  COMP3064, Lecture, 12PM,  2PM
    (3, 2, 1, 1400, 1600), -- ppawluk,  COMP3064, Lab,      2PM,  4PM
    (4, 4, 2,  800, 1000), -- bvucetic, COMP3073, Lecture,  8AM, 10AM
    (4, 4, 1, 1000, 1200); -- bvucetic, COMP3073, Lab,     10AM, 12PM
UPDATE `ScheduleCourse` SET `monday`   = 1 WHERE `c_id` = 4; -- COMP3073 on Mondays
UPDATE `ScheduleCourse` SET `thursday` = 1 WHERE `c_id` = 2; -- COMP3064 on Thursdays
UPDATE `ScheduleCourse` SET `friday`   = 1 WHERE `c_id` = 3; -- COMP3071 on Fridays
UPDATE `ScheduleCourse` SET `thursday` = 1 WHERE `c_id` = 1 AND `type_id` = 2; -- COMP3072 lecture on Thursday
UPDATE `ScheduleCourse` SET `friday`   = 1 WHERE `c_id` = 1 AND `type_id` = 1; -- COMP3072 lab on Friday

COMMIT;
