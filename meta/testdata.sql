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
    (3, 'Declined');

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
    (50,  'C418', 1), -- 1
    (50,  'C416', 1), -- 2
    (50,  'C422', 1), -- 3
    (100, 'E322', 2), -- 4
    (100, 'E218', 2); -- 5

INSERT INTO `Course` (`c_code`,`c_description`,`c_crn`) VALUES
    ('COMP3072', 'Open Source Application Development',             '60001'), -- 1
    ('COMP3064', 'PC Game Development',                             '60002'), -- 2
    ('COMP3071', 'Designing and Implementing Database',             '60003'), -- 3
    ('COMP3073', 'System Implementation, Testing, and Maintenance', '60004'), -- 4
    ('COMP2075', 'Introduction to Web Services',                    '40001'), -- 5
    ('COMP3074', 'Mobile Application Development',                  '50001'), -- 6
    ('COMP3063', 'Applied Systems Analysis and Design',             '50002'), -- 7
    ('COMP3062', 'Advanced Web Application Development',            '50003'); -- 8

INSERT INTO `ProfessorCourse` (`u_id`,`c_id`) VALUES
    (2, 1),
    (4, 2),
    (3, 3),
    (5, 4),
    (4, 5),
    (4, 6),
    (5, 7),
    (4, 8);

INSERT INTO `Section` (`s_name`,`s_desc`,`s_size`) VALUES
    ('T127-6A', 'Computer Programmer/Analyst', 50), -- 1
    ('T127-5A', 'Computer Programmer/Analyst', 50), -- 2
    ('T127-4A', 'Computer Programmer/Analyst', 50); -- 3

INSERT INTO `SectionCourse` (`s_id`,`c_id`) VALUES
    (1, 1),
    (1, 2),
    (1, 3),
    (1, 4),
    (2, 6),
    (2, 7),
    (2, 8),
    (3, 5);

INSERT INTO `Schedule` (`u_id`) VALUES
    (2), -- rverma
    (3), -- arana
    (4), -- ppawluk
    (5); -- bvucetic

INSERT INTO `ScheduleCourse` (`s_id`,`c_id`,`room`,`type_id`,`day`,`start_time`,`finish_time`) VALUES
    (1, 1, 1, 2, 4, 1600, 1800), -- rverma,   COMP3072, C418, Lecture, Thurs,  4PM,  6PM
    (1, 1, 2, 1, 5, 1600, 1800), -- rverma,   COMP3072, C416, Lab,     Fri,    4PM,  6PM
    (2, 3, 1, 2, 5, 1000, 1200), -- arana,    COMP3071, C418, Lecture, Fri,   10AM, 12PM
    (2, 3, 1, 1, 5, 1200, 1400), -- arana,    COMP3071, C418, Lab,     Fri,   12PM,  2PM
    (3, 2, 3, 2, 4, 1200, 1400), -- ppawluk,  COMP3064, C422, Lecture, Thurs, 12PM,  2PM
    (3, 2, 3, 1, 4, 1400, 1600), -- ppawluk,  COMP3064, C422, Lab,     Thurs,  2PM,  4PM
    (3, 5, 4, 2, 1, 1200, 1400), -- ppawluk,  COMP2075, E322, Lecture, Mon,   12PM,  2PM
    (3, 5, 3, 1, 1, 1400, 1600), -- ppawluk,  COMP2075, C422, Lab,     Mon,    2PM,  4PM
    (3, 6, 5, 2, 4, 1000, 1200), -- ppawluk,  COMP3074, E218, Lecture, Thurs, 10AM, 12PM
    (3, 6, 1, 1, 3, 1400, 1600), -- ppawluk,  COMP3074, C418, Lab      Wed,    2PM,  4PM
    (3, 8, 4, 2, 3, 1200, 1400), -- ppawluk,  COMP3062, E322, Lecture, Wed,   12PM,  2PM
    (3, 8, 1, 1, 2, 1000, 1200), -- ppawluk,  COMP3062, C418, Lab      Tue,   10AM, 12PM
    (4, 4, 2, 2, 1,  800, 1000), -- bvucetic, COMP3073, C416, Lecture, Mon,    8AM, 10AM
    (4, 4, 2, 1, 1, 1000, 1200), -- bvucetic, COMP3073, C416, Lab,     Mon,   10AM, 12PM
    (4, 7, 5, 2, 3,  800, 1000), -- bvucetic, COMP3063, E218, Lecture, Wed,    8AM, 10AM
    (4, 7, 2, 1, 1, 1200, 1400); -- bvucetic, COMP3063, E416, Lab,     Mon,   12PM,  2PM

INSERT INTO `TimeOff` (`u_id`,`start_date`,`finish_date`,`reason`,`status_id`,`date_requested`) VALUES
    (2, '2013-02-28', '2013-03-04', 'A reason',      3, '2013-02-14 12:00:00'),
    (4, '2013-04-02', '2013-04-07', 'Business trip', 2, '2013-03-29 12:00:00'),
    (3, '2013-04-01', '2013-04-02', 'Some reason',   1, '2013-03-31 12:00:00'),
    (5, '2013-04-09', '2013-04-09', 'Illness',       1, '2013-04-01 12:00:00');

COMMIT;
