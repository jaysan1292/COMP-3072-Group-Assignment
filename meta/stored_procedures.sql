SET autocommit=0;
START TRANSACTION;

DROP PROCEDURE IF EXISTS CreateUser;
DROP PROCEDURE IF EXISTS CreateUserPrehashed;
DROP PROCEDURE IF EXISTS GetLoginUser;
DROP PROCEDURE IF EXISTS GetLoginUserWithId;
DROP PROCEDURE IF EXISTS GetProfessorSchedule;
DROP PROCEDURE IF EXISTS GetRoomClasses;
DROP PROCEDURE IF EXISTS GetUser;

DELIMITER //

--
-- Retrieves user information, given a User ID
--
CREATE PROCEDURE GetUser(IN UserId BIGINT)
BEGIN
  SELECT
    User.*,
    UserType.type_desc
  FROM
    User
      INNER JOIN UserType ON User.u_type = UserType.type_id
  WHERE User.u_id = UserId;
END //

--
-- Retrieves login and user information, given their login name
--
CREATE PROCEDURE GetLoginUser(IN LoginName VARCHAR(32))
BEGIN
  SELECT
    User.*,
    Login.*
  FROM
    User
      INNER JOIN Login ON User.u_id = Login.u_id
  WHERE
    Login.login_name = LoginName;
END //

--
-- Retrieves the same information as GetLoginUser(), but with an ID instead
--
CREATE PROCEDURE GetLoginUserWithId(IN UserId BIGINT)
BEGIN
  SELECT
    User.*,
    Login.*
  FROM
    User
      INNER JOIN Login ON User.u_id = Login.u_id
  WHERE
    User.u_id = UserId;
END //

--
-- Retrieves a professor's schedule, given his/her ID
--
CREATE PROCEDURE GetProfessorSchedule(IN ProfessorId BIGINT)
BEGIN
  SELECT
    Schedule.s_id,
    User.first_name,
    User.last_name,
    Course.c_code,
    Course.c_crn,
    Course.c_description,
    CourseType.type_id,
    CourseType.type_desc,
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
  WHERE
    Schedule.u_id = ProfessorId;
END //

--
-- Retrieves all classes that take place in a given room (by ID)
--
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
-- Inserts a new user into the database
--
-- NOTE: This procedure will only function on MySQL 5.5+,
-- as it uses the SHA2() function, which is not available on older versions.
--
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

DELIMITER ;

COMMIT;