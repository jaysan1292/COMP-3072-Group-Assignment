USE bohhls;

SET autocommit=0;
START TRANSACTION;

CREATE OR REPLACE VIEW ProfessorSchedule AS
  SELECT
    Schedule.s_id,
    User.u_id,
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
  ORDER BY u_id;

COMMIT;
