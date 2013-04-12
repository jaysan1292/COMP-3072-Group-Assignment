SET autocommit=0;
START TRANSACTION;

-- Drop everything from all tables
DELETE FROM `ScheduleCourse`;
DELETE FROM `CourseType`;
DELETE FROM `Schedule`;
DELETE FROM `SectionCourse`;
DELETE FROM `Section`;
DELETE FROM `ProfessorCourse`;
DELETE FROM `Course`;
DELETE FROM `Room`;
DELETE FROM `RoomType`;
DELETE FROM `Login`;
DELETE FROM `User`;
DELETE FROM `Department`;
DELETE FROM `UserType`;

-- Reset auto-increment counters
ALTER TABLE `User`            AUTO_INCREMENT=0;
ALTER TABLE `Login`           AUTO_INCREMENT=0;
ALTER TABLE `Room`            AUTO_INCREMENT=0;
ALTER TABLE `Course`          AUTO_INCREMENT=0;
ALTER TABLE `ProfessorCourse` AUTO_INCREMENT=0;
ALTER TABLE `Section`         AUTO_INCREMENT=0;
ALTER TABLE `SectionCourse`   AUTO_INCREMENT=0;
ALTER TABLE `Schedule`        AUTO_INCREMENT=0;
ALTER TABLE `ScheduleCourse`  AUTO_INCREMENT=0;

-- The actual data
INSERT INTO `UserType` VALUES
    (1, 'Professor'),
    (2, 'Administrator');

INSERT INTO `RoomType` VALUES
    (1, 'Lab'),
    (2, 'Classroom');

INSERT INTO `CourseType` VALUES
    (1, 'Lab'),
    (2, 'Lecture');

INSERT INTO `Department` VALUES
    (1, 'None'),
    (2, 'Technology'),
    (3, 'Construction'),
    (4, 'Fashion');

INSERT INTO `TimeOffStatus` VALUES
    (1, 'Under Review'),
    (2, 'Approved'),
    (3, 'Rejected');

INSERT INTO `User` (`first_name`,`last_name`,`u_type`,`email`,`dept_id`,`contact`) VALUES
    ('John',       'Smith',   2, 'jsmith@example.com',   1, '6475551234'),
    ('Rajib',      'Verma',   1, 'rverma@example.com',   2, '6475551234'),
    ('Abid',       'Rana',    1, 'arana@example.com',    2, '6475551234'),
    ('Przemyslaw', 'Pawluk',  1, 'ppawluk@example.com',  2, '6475551234'),
    ('Biljana',    'Vucetic', 1, 'bvucetic@example.com', 2, '6475551234');

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
    ('COMP3072', 'Open Source Application Development',             '60001'),
    ('COMP3064', 'PC Game Development',                             '60002'),
    ('COMP3071', 'Designing and Implementing Database',             '60003'),
    ('COMP3073', 'System Implementation, Testing, and Maintenance', '60004');

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

INSERT INTO `ScheduleCourse` (`s_id`,`c_id`,`room`,`type_id`,`start_time`,`finish_time`) VALUES
    (1, 1, 1, 2, 1600, 1800), -- rverma,   C418, COMP3072, Lecture,  4PM,  6PM
    (1, 1, 2, 1, 1600, 1800), -- rverma,   C416, COMP3072, Lab,      4PM,  6PM
    (2, 3, 1, 2, 1000, 1200), -- arana,    C418, COMP3071, Lecture, 10AM, 12PM
    (2, 3, 1, 1, 1200, 1400), -- arana,    C418, COMP3071, Lab,     12PM,  2PM
    (3, 2, 3, 2, 1200, 1400), -- ppawluk,  C422, COMP3064, Lecture, 12PM,  2PM
    (3, 2, 3, 1, 1400, 1600), -- ppawluk,  C422, COMP3064, Lab,      2PM,  4PM
    (4, 4, 2, 2,  800, 1000), -- bvucetic, C416, COMP3073, Lecture,  8AM, 10AM
    (4, 4, 2, 1, 1000, 1200); -- bvucetic, C416, COMP3073, Lab,     10AM, 12PM
UPDATE `ScheduleCourse` SET `monday`   = 1 WHERE `c_id` = 4; -- COMP3073 on Mondays
UPDATE `ScheduleCourse` SET `thursday` = 1 WHERE `c_id` = 2; -- COMP3064 on Thursdays
UPDATE `ScheduleCourse` SET `friday`   = 1 WHERE `c_id` = 3; -- COMP3071 on Fridays
UPDATE `ScheduleCourse` SET `thursday` = 1 WHERE `c_id` = 1 AND `type_id` = 2; -- COMP3072 Lecture on Thursday
UPDATE `ScheduleCourse` SET `friday`   = 1 WHERE `c_id` = 1 AND `type_id` = 1; -- COMP3072 Lab on Friday

INSERT INTO `TimeOff` (`u_id`,`start_date`,`finish_date`,`reason`,`status_id`) VALUES
    (2, '2013-02-28', '2013-03-04', 'A reason', 1),
    (3, '2013-04-01', '2013-04-02', 'Some reason', 3),
    (5, '2013-04-09', '2013-04-09', 'Illness', 2),
    (4, '2013-04-02', '2013-04-07', 'Business trip', 1);

COMMIT;
