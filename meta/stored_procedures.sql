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
    ScheduleCourse.day,
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
    Room.rm_id,
    Room.rm_number,
    Room.rm_size,
    RoomType.type_id,
    RoomType.name,
    CONCAT(User.first_name, ' ', User.last_name) AS 'prof_name',
    Course.c_id,
    Course.c_code,
    Course.c_description,
    Course.c_crn,
    ScheduleCourse.day,
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
    ScheduleCourse.day,
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
                            IN DeptId INT,
                            IN Password TEXT)
BEGIN
  DECLARE NewId BIGINT;

  -- Insert the new user into the database
  INSERT INTO `User` (`first_name`,`last_name`,`u_type`,`dept_id`) VALUES
    (FirstName, LastName, UserType, DeptId);

  -- Get the ID of the previous insert
  SET NewId = LAST_INSERT_ID();

  -- Insert the new user into the database
  -- Login name = first initial + last name
  -- Password is hashed with the SHA256 hashing algorithm
  INSERT INTO `Login` VALUES
    (NewId,
     LOWER(CONCAT(SUBSTRING(FirstName, 1, 1), LastName)),
     SHA2(Password, 256));

  SELECT NewId;
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
                                     IN DeptId INT,
                                     IN Password CHAR(64))
BEGIN
  DECLARE NewId BIGINT;

  -- Insert the new user into the database
  INSERT INTO `User` (`first_name`,`last_name`,`u_type`,`dept_id`) VALUES
    (FirstName, LastName, UserType, DeptId);

  -- Get the ID of the previous insert
  SET NewId = LAST_INSERT_ID();

  -- Insert the new user into the database
  -- Login name = first initial + last name
  INSERT INTO `Login` VALUES
    (NewId,
     LOWER(CONCAT(SUBSTRING(FirstName, 1, 1), LastName)),
     Password);

  SELECT NewId;
END //

DROP PROCEDURE IF EXISTS GetTimeOffRequests //
CREATE PROCEDURE GetTimeOffRequests ()
BEGIN
  SELECT
    TimeOff.t_id AS 'Id',
    User.u_id AS 'ProfessorId',
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
    ScheduleCourse.type_id AS 'CourseTypeId',
    CourseType.type_desc AS 'CourseType',
    Room.rm_number AS 'RoomNumber',
    RoomType.name AS 'RoomType',
    Section.s_id AS 'SectionId',
    Section.s_name AS 'Section',
    User.u_id AS 'ProfessorId',
    CONCAT(User.first_name, ' ', User.last_name) AS 'Professor'
  FROM
    Course
      INNER JOIN ScheduleCourse ON Course.c_id = ScheduleCourse.c_id
      INNER JOIN CourseType ON ScheduleCourse.type_id = CourseType.type_id
      INNER JOIN ProfessorCourse ON Course.c_id = ProfessorCourse.c_id
      INNEr JOIN User ON User.u_id = ProfessorCourse.u_id
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
  INSERT INTO `TimeOff`(`u_id`,`start_date`,`finish_date`,`reason`,`status_id`) VALUES
    (UserId, Start, Finish, Reason, 1);
END //

DROP PROCEDURE IF EXISTS UpdateContactInfo //
CREATE PROCEDURE UpdateContactInfo (IN UserId BIGINT, IN _Contact CHAR(10), IN _Email VARCHAR(64))
BEGIN
  UPDATE User
  SET contact = _Contact, email = _Email
  WHERE u_id = UserId;
END //

DROP PROCEDURE IF EXISTS GetUserTimeOffRequests //
CREATE PROCEDURE GetUserTimeOffRequests (IN UserId BIGINT)
BEGIN
  SELECT
    TimeOff.t_id AS 'Id',
    TimeOff.reason AS 'Reason',
    TimeOff.start_date AS 'Start',
    TimeOff.finish_date AS 'End',
    TimeOffStatus.name AS 'Status',
    TimeOffStatus.status_id AS 'StatusId',
    TimeOff.date_requested AS 'DateRequested'
  FROM
    TimeOff
      INNER JOIN TimeOffStatus ON TimeOff.status_id = TimeOffStatus.status_id
  WHERE
    TimeOff.u_id = UserId
  ORDER BY
    TimeOff.date_requested;
END //

DROP PROCEDURE IF EXISTS AdminUpdateTimeOffStatus //
CREATE PROCEDURE AdminUpdateTimeOffStatus (IN TimeOffId INT, IN StatusId INT)
BEGIN
  UPDATE TimeOff
  SET status_id = StatusId
  WHERE t_id = TimeOffId;
END //

--
-- Gets all professors except for those who are teaching more than 4 courses
--
DROP PROCEDURE IF EXISTS GetAvailableProfessors //
CREATE PROCEDURE GetAvailableProfessors ()
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
    CountProfessorCourses(User.u_id) < 4 AND
    User.u_type = 1;
END //

DROP PROCEDURE IF EXISTS GetRooms //
CREATE PROCEDURE GetRooms ()
BEGIN
  SELECT * FROM Room;
END //

--
-- Adds a new course into the database.
--
DROP PROCEDURE IF EXISTS CreateNewCourse //
CREATE PROCEDURE CreateNewCourse (IN CourseCode CHAR(8), IN CourseDescription VARCHAR(256), IN Crn CHAR(5), IN ProfessorId BIGINT, IN SectionId BIGINT,
                                  IN LabDay TINYINT, IN LabTime INT, IN LabRoomId BIGINT,
                                  IN LectureDay TINYINT, IN LectureTime INT, IN LectureRoomId BIGINT)
BEGIN
  DECLARE CourseId BIGINT;
  DECLARE HasSchedule BOOLEAN;
  DECLARE ScheduleId BIGINT;

  -- Create the new course
  INSERT INTO Course (c_code,c_description,c_crn) VALUES
    (CourseCode, CourseDescription, Crn);

  SET CourseId = LAST_INSERT_ID();

  -- Associate it with the given section
  INSERT INTO SectionCourse (s_id,c_id) VALUES
    (SectionId, CourseId);

  -- Associate it with the professor
  INSERT INTO ProfessorCourse (u_id,c_id) VALUES
    (ProfessorId, CourseId);

  -- First check if this professor has a schedule
  SET HasSchedule = ProfessorHasSchedule(ProfessorId);

  IF HasSchedule = TRUE THEN
    -- If they do, then get their schedule ID
    SET ScheduleId = (SELECT s_id FROM Schedule WHERE u_id = ProfessorId);
  ELSE
    -- Otherwise, create it.
    INSERT INTO Schedule (u_id) VALUES (ProfessorId);
    SET ScheduleId = LAST_INSERT_ID();
  END IF;

  -- Now add the new course to the professor's schedule.
  -- Starting with the lab class.
  INSERT INTO ScheduleCourse(s_id,c_id,room,type_id,day,start_time,finish_time) VALUES
    (ScheduleId, CourseId, LabRoomId, 1, LabDay, LabTime, (LabTime + 200)); -- Add 200 to the start time to get the finish time

  -- Now insert the lecture class.
  INSERT INTO ScheduleCourse(s_id,c_id,room,type_id,day,start_time,finish_time) VALUES
    (ScheduleId, CourseId, LectureRoomId, 2, LectureDay, LectureTime, (LectureTime + 200));
END //

DELIMITER ;
COMMIT;
