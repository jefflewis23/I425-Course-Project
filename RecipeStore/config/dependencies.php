<?php


use DI\Container;


return function (Container $container) {
// Set a dependency called "Professor"
    $container->set('Professor', function () {
        return new ProfessorController();
    });
    $container->set('Course', function () {
        return new CourseController();
    });
    // Set a dependency called "Class"
    $container->set('Class', function () {
        return new ClassController();
    });
    // Set a dependency called "Student"
    $container->set('Student', function () {
        return new StudentController();
    });
};