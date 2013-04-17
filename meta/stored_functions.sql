SET autocommit=0;
START TRANSACTION;

DELIMITER //

DROP FUNCTION IF EXISTS CountProfessorCourses //
CREATE FUNCTION CountProfessorCourses(ProfessorId BIGINT)
RETURNS INT
BEGIN
    DECLARE Course INT;
    SELECT COUNT(u_id) INTO Course FROM ProfessorCourse WHERE u_id = ProfessorId;
    RETURN Course;
END //

DROP FUNCTION IF EXISTS ProfessorHasSchedule //
CREATE FUNCTION ProfessorHasSchedule(ProfessorId BIGINT)
RETURNS BOOLEAN
BEGIN
    DECLARE CheckVar INT;
    SELECT Count(s_id) INTO CheckVar FROM Schedule WHERE u_id = ProfessorId;

    IF CheckVar >= 1 THEN
        RETURN TRUE;
    ELSE
        RETURN FALSE;
    END IF;
END //

DELIMITER ;
COMMIT;
