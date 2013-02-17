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
ALTER TABLE `UserType` AUTO_INCREMENT=0;
ALTER TABLE `User` AUTO_INCREMENT=0;
ALTER TABLE `Login` AUTO_INCREMENT=0;
ALTER TABLE `RoomType` AUTO_INCREMENT=0;
ALTER TABLE `Room` AUTO_INCREMENT=0;
ALTER TABLE `Course` AUTO_INCREMENT=0;
ALTER TABLE `ProfessorCourse` AUTO_INCREMENT=0;
ALTER TABLE `Section` AUTO_INCREMENT=0;
ALTER TABLE `SectionCourse` AUTO_INCREMENT=0;
ALTER TABLE `Schedule` AUTO_INCREMENT=0;
ALTER TABLE `CourseType` AUTO_INCREMENT=0;
ALTER TABLE `ScheduleCourse` AUTO_INCREMENT=0;

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
    ('John',       'Smith',   1),
    ('Rajib',      'Verma',   0),
    ('Abid',       'Rana',    0),
    ('Przemyslaw', 'Pawluk',  0),
    ('Biljana',    'Vucetic', 0);

-- Passwords are all '123456', hashed with hash('sha256', $password)
INSERT INTO `Login` VALUES
    (0, 'jsmith',   '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92'),
    (1, 'rverma',   '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92'),
    (2, 'arana',    '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92'),
    (3, 'ppawluk',  '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92'),
    (4, 'bvucetic', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92');
    
INSERT INTO `Room` (`rm_size`,`rm_number`,`rm_type`) VALUES
    (50,  'C418', 0),
    (50,  'C416', 0),
    (50,  'C422', 0),
    (100, 'E322', 1),
    (100, 'E218', 1);

INSERT INTO `Course` (`c_code`,`c_description`,`c_crn`) VALUES
    ('COMP3072', 'Open Source Application Development',             '00001'),
    ('COMP3064', 'PC Game Development',                             '00002'),
    ('COMP3071', 'Designing and Implementing Database',             '00003'),
    ('COMP3073', 'System Implementation, Testing, and Maintenance', '00004');

INSERT INTO `ProfessorCourse` (`u_id`,`c_id`) VALUES
    (1, 0),
    (2, 2),
    (3, 1),
    (4, 3);

INSERT INTO `Section` (`s_name`,`s_desc`,`s_size`) VALUES
    ('T127-A', 'Computer Programmer/Analyst', 50);

INSERT INTO `SectionCourse` (`s_id`,`c_id`) VALUES
    (0, 0),
    (0, 1),
    (0, 2),
    (0, 3);