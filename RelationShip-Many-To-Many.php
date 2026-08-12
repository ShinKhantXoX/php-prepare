<?php

// | Relationship     | Example            | Foreign Key        |
// | ---------------- | ------------------ | ------------------ |
// | One-to-One       | User → Profile     | profiles.user_id   |
// | One-to-Many      | User → Posts       | posts.user_id      |
// | Many-to-One      | Posts → User       | posts.user_id      |
// | Many-to-Many     | Students ↔ Courses | Pivot table        |


// ==================================================
// Many-to-Many
// ==================================================
//
// A student can take many courses.
// A course can have many students.
//
// Student  * -------- *  Course
//
// Because both sides can have many records,
// we need a pivot/junction table.
//


// ------------------- Database ----------------------


// students
// ---------
// id
// name


// courses
// ---------
// id
// name


// student_course
// -------------
// student_id
// course_id
//
// This is the pivot table.
//
// Example:
//
// students
// id | name
// 1  | Shin
// 2  | John
//
//
// courses
// id | name
// 1  | PHP
// 2  | Laravel
// 3  | JavaScript
//
//
// student_course
// student_id | course_id
// 1          | 1
// 1          | 2
// 1          | 3
// 2          | 1
//
// Shin → PHP
// Shin → Laravel
// Shin → JavaScript
//
// John → PHP
//
// --------------------------------------------------


// ------------------- Pure SQL ----------------------


// Get all courses for student 1:

// SELECT courses.name
// FROM courses
// JOIN student_course
//     ON courses.id = student_course.course_id
// WHERE student_course.student_id = 1;


// Result:
//
// PHP
// Laravel
// JavaScript
//
// --------------------------------------------------


// Get all students in course 1:

// SELECT students.name
// FROM students
// JOIN student_course
//     ON students.id = student_course.student_id
// WHERE student_course.course_id = 1;


// Result:
//
// Shin
// John


// ------------------- PHP PDO Example ---------------


// Get all courses for student 1:

// $studentId = 1;

// $sql = "
//     SELECT courses.name
//     FROM courses
//     JOIN student_course
//         ON courses.id = student_course.course_id
//     WHERE student_course.student_id = :student_id
// ";

// $stmt = $pdo->prepare($sql);

// $stmt->execute([
//     'student_id' => $studentId
// ]);

// $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);


// --------------------------------------------------


// Get all students for course 1:

// $courseId = 1;

// $sql = "
//     SELECT students.name
//     FROM students
//     JOIN student_course
//         ON students.id = student_course.student_id
//     WHERE student_course.course_id = :course_id
// ";

// $stmt = $pdo->prepare($sql);

// $stmt->execute([
//     'course_id' => $courseId
// ]);

// $students = $stmt->fetchAll(PDO::FETCH_ASSOC);


// ==================================================
// Important Interview Point
// ==================================================
//
// Many-to-Many requires a PIVOT TABLE.
//
// Student
//    |
//    | *
//    |
//    v
// student_course
//    |
//    | *
//    |
//    v
// Course
//
// The pivot table contains:
//
// student_id
// course_id
//
//
// In Laravel:
//
// Student
//     -> belongsToMany(Course::class)
//
// Course
//     -> belongsToMany(Student::class)