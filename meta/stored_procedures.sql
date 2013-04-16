SET autocommit=0;
START TRANSACTION;

DELIMITER //

--
-- Retrieves user information, given a User ID
--
DROP PROCEDURE IF EXISTS GetUser;
CREATE PROCEDURE GetUser(IN UserId BIGINT)
BEGIN
  SELECT
    User.*,
    UserType.type_desc,
    Department.dept_id,
    Department.name AS dept_name
  FROM
    User
      INNER JOIN UserType ON User.u_type = UserType.type_id
      INNER JOIN Department ON User.dept_id = Department.dept_id
  WHERE User.u_id = UserId;
END //

--
-- Retrieves login and user information, given their login name
--
DROP PROCEDURE IF EXISTS GetLoginUser;
CREATE PROCEDURE GetLoginUser(IN LoginName VARCHAR(32))
BEGIN
  SELECT
    User.*,
    Login.*,
    Department.name AS dept_name
  FROM
    User
      INNER JOIN Login ON User.u_id = Login.u_id
      INNER JOIN Department ON User.dept_id = Department.dept_id
  WHERE
    Login.login_name = LoginName;
END //

--
-- Retrieves the same information as GetLoginUser(), but with an ID instead
--
DROP PROCEDURE IF EXISTS GetLoginUserWithId;
CREATE PROCEDURE GetLoginUserWithId(IN UserId BIGINT)
BEGIN
  SELECT
    User.*,
    Login.*,
    Department.name AS dept_name
  FROM
    User
      INNER JOIN Login ON User.u_id = Login.u_id
      INNER JOIN Department ON User.dept_id = Department.dept_id
  WHERE
    User.u_id = UserId;
END //

--
-- Retrieves a professor's schedule, given his/her ID
--
DROP PROCEDURE IF EXISTS GetProfessorSchedule;
CREATE PROCEDURE GetProfessorSchedule(IN ProfessorId BIGINT)
BEGIN
  SELECT
    Schedule.s_id,
    User.first_name,
    User.last_name,
    Course.c_id,
    Course.c_code,
    Course.c_crn,
    Course.c_description,
    CourseType.type_id,
    CourseType.type_desc,
    Room.rm_number,
    Room.rm_size,
    ScheduleCourse.monday,
    ScheduleCourse.tuesday,
    ScheduleCourse.wednesday,
    ScheduleCourse.thursday,
    ScheduleCourse.friday,
    ScheduleCourse.start_time,
    ScheduleCourse.finish_time
  FROM
    Schedule
      INNER JOIN User ON Schedule.u_id = User.u_id
      INNER JOIN ScheduleCourse ON Schedule.s_id = ScheduleCourse.s_id
      INNER JOIN Course ON Course.c_id = ScheduleCourse.c_id
      INNER JOIN CourseType ON ScheduleCourse.type_id = CourseType.type_id
      INNER JOIN Room ON ScheduleCourse.room = Room.rm_id
  WHERE
    Schedule.u_id = ProfessorId;
END //

--
-- Retrieves all classes that take place in a given room (by ID)
--
DROP PROCEDURE IF EXISTS GetRoomClasses;
CREATE PROCEDURE GetRoomClasses(IN RoomId BIGINT)
BEGIN
  SELECT
    Room.rm_id, Room.rm_number, Room.rm_size,
    RoomType.type_id, RoomType.name,
    User.first_name, User.last_name,
    Course.*,
    ScheduleCourse.monday,
    ScheduleCourse.tuesday,
    ScheduleCourse.wednesday,
    ScheduleCourse.thursday,
    ScheduleCourse.friday,
    ScheduleCourse.start_time,
    ScheduleCourse.finish_time
  FROM
    Room
      INNER JOIN RoomType ON Room.rm_type = RoomType.type_id
      INNER JOIN ScheduleCourse ON ScheduleCourse.room = Room.rm_id
      INNER JOIN Course ON ScheduleCourse.c_id = Course.c_id
      INNER JOIN ProfessorCourse ON ProfessorCourse.c_id = Course.c_id
      INNER JOIN User ON ProfessorCourse.u_id = User.u_id
  WHERE
    Room.rm_id = RoomId;
END //

--
-- Retrieves information on a single course
-- i.e., a single timetable block
--
DROP PROCEDURE IF EXISTS GetCourseInfo;
CREATE PROCEDURE GetCourseInfo(IN CourseId BIGINT, IN TypeId TINYINT)
BEGIN
  SELECT
    Course.c_id,
    Course.c_code,
    Course.c_crn,
    Room.rm_number,
    ScheduleCourse.type_id,
    ScheduleCourse.monday,
    ScheduleCourse.tuesday,
    ScheduleCourse.wednesday,
    ScheduleCourse.thursday,
    ScheduleCourse.friday,
    ScheduleCourse.start_time,
    ScheduleCourse.finish_time
  FROM
    Course
      INNER JOIN ScheduleCourse ON Course.c_id = ScheduleCourse.c_id
      INNER JOIN Room ON ScheduleCourse.room = Room.rm_id
  WHERE
    Course.c_id = CourseId AND ScheduleCourse.type_id = TypeId;
END //

--
-- Inserts a new user into the database
--
-- NOTE: This procedure will only function on MySQL 5.5+,
-- as it uses the SHA2() function, which is not available on older versions.
--
DROP PROCEDURE IF EXISTS CreateUser;
CREATE PROCEDURE CreateUser(IN FirstName VARCHAR(64),
                            IN LastName VARCHAR(64),
                            IN UserType TINYINT,
                            IN Password TEXT,
                            OUT NewId BIGINT)
BEGIN
  -- Insert the new user into the database
  INSERT INTO `User` (`first_name`,`last_name`,`u_type`) VALUES
    (FirstName, LastName, UserType);

  -- Get the ID of the previous insert
  SET NewId = LAST_INSERT_ID();

  -- Insert the new user into the database
  -- Login name = first initial + last name
  -- Password is hashed with the SHA256 hashing algorithm
  INSERT INTO `Login` VALUES
    (NewId,
     LOWER(CONCAT(SUBSTRING(FirstName, 1, 1), LastName)),
     SHA2(Password, 256));
END //

--
-- Has the same function as CreateUser, but takes in a password
-- that has already been hashed. Please note, however that the
-- authentication system expects passwords to be hashed with the
-- SHA256 algorithm.
--
-- In PHP: hash('sha256', $password)
--
DROP PROCEDURE IF EXISTS CreateUserPrehashed;
CREATE PROCEDURE CreateUserPrehashed(IN FirstName VARCHAR(64),
                                     IN LastName VARCHAR(64),
                                     IN UserType TINYINT,
                                     IN Password CHAR(64),
                                     OUT NewId BIGINT)
BEGIN
  -- Insert the new user into the database
  INSERT INTO `User` (`first_name`,`last_name`,`u_type`) VALUES
    (FirstName, LastName, UserType);

  -- Get the ID of the previous insert
  SET NewId = LAST_INSERT_ID();

  -- Insert the new user into the database
  -- Login name = first initial + last name
  INSERT INTO `Login` VALUES
    (NewId,
     LOWER(CONCAT(SUBSTRING(FirstName, 1, 1), LastName)),
     Password);
END //

DROP PROCEDURE IF EXISTS GetTimeOffRequests //
CREATE PROCEDURE GetTimeOffRequests ()
BEGIN
  SELECT
    TimeOff.t_id AS 'Id',
    CONCAT(User.first_name, ' ', User.last_name) AS 'Name',
    TimeOff.reason AS 'Reason',
    TimeOff.start_date AS 'Start',
    TimeOff.finish_date AS 'End',
    TimeOffStatus.name AS 'Status',
    TimeOffStatus.status_id AS 'StatusId',
    TimeOff.date_requested AS 'DateRequested'
  FROM
    TimeOff
      INNER JOIN User ON TimeOff.u_id = User.u_id
      INNER JOIN TimeOffStatus ON TimeOff.status_id = TimeOffStatus.status_id
  ORDER BY
    TimeOff.date_requested;
END //

DROP PROCEDURE IF EXISTS GetAdminCourseInfo //
CREATE PROCEDURE GetAdminCourseInfo (IN CourseId BIGINT)
BEGIN
  SELECT
    Course.c_code AS 'CourseCode',
    Course.c_description AS 'CourseDescription',
    Course.c_crn AS 'CRN',
    Room.rm_number AS 'RoomNumber',
    RoomType.name AS 'RoomType',
    Section.s_id AS 'SectionId',
    Section.s_name AS 'Section'
  FROM
    Course
      INNER JOIN ScheduleCourse ON Course.c_id = ScheduleCourse.c_id
      INNER JOIN Room ON Room.rm_id = ScheduleCourse.room
      INNER JOIN RoomType ON Room.rm_type = RoomType.type_id
      INNER JOIN SectionCourse ON Course.c_id = SectionCourse.c_id
      INNER JOIN Section ON SectionCourse.s_id = Section.s_id
  WHERE
    Course.c_id = CourseId;
END //

DROP PROCEDURE IF EXISTS GetAdminProfessorInfo //
CREATE PROCEDURE GetAdminProfessorInfo (IN ProfessorId BIGINT)
BEGIN
  SELECT
    CONCAT(User.first_name, ' ', User.last_name) AS 'Professor',
    User.contact AS 'ContactNumber',
    User.email AS 'EmailAddress',
    User.u_id AS 'EmployeeId',
    Department.dept_id AS 'DepartmentId',
    Department.name AS 'Department'
  FROM
    User
      INNER JOIN Department ON User.dept_id = Department.dept_id
  WHERE
    User.u_id = ProfessorId;
END //

DROP PROCEDURE IF EXISTS CreateTimeOffRequest //
CREATE PROCEDURE CreateTimeOffRequest (IN UserId BIGINT, IN Start DATE, IN Finish DATE, IN Reason TEXT)
BEGIN
  INSERT INTO `TimeOff`(`u_id`,`start_date`,`finish_date`,`reason`,`status_id`,`date_requested`) VALUES
    (UserId, Start, Finish, Reason, 1, NOW());
END //

DELIMITER ;

COMMIT;
