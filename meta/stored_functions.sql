SET autocommit=0;
START TRANSACTION;

DELIMITER //

DROP FUNCTION IF EXISTS CountProfessorCourses //
CREATE FUNCTION CountProfessorCourses(ProfessorID BIGINT)
RETURNS INT
BEGIN
  DECLARE Course INT;
  SELECT COUNT(u_id) INTO Course FROM ProfessorCourse WHERE u_id = ProfessorId;
  RETURN Course;
END //

DELIMITER ;
COMMIT;
