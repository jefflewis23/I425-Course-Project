<?php
/**
 * Author: Derek Wright
 * Date: 5/29/2023
 * File: Student.php
 * Description: This document defines the Student model class.
 */

namespace MyCollegeAPI\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //The table associated with this model
    protected $table = 'students';

    //The primary key of the table
    protected $primaryKey = 'id';

    //The PK is non-numeric
    public $incrementing = false;

    //If the PF is not an integer, set its type
    protected $keyType = 'char';

    //If the created_at and updated_at columns are not used
    public $timestamps = false;

    /* Define the many-to-many relationship between Student and MyClass model classes.
    *  The third intermediate table linking the students and classes tables in DB is enrollments.
     * In the enrollment table, section and student are the foreign keys.
    */
    public function classes() {
        return $this->belongsToMany(MyClass::class, 'enrollments', 'student', 'section')
            ->withPivot('grade');
    }

    //Retrieve all students
    public static function getStudents() {
        $students = self::all();
        return $students;
    }

    //View a specific student
    public static function getStudentById(string $id) {
        $student = self::findOrFail($id);
        return $student;
    }

    //Get a student's classes
    public static function getStudentClasses(string $id) {
        return self::findOrFail($id)->classes;

        // Get grades only
        /*
        $student = self::findOrFail($id);
        foreach($student->classes as $class) {
            var_dump($class->pivot->grade);
        }
        exit;*/
    }

    //Search for students
    public static function searchStudents($term) {
        if(is_numeric($term)) {
            $query = self::where('gpa', '>=', $term);
        } else {
            $query = self::where('id', 'like', "%$term%")
                ->orWhere('name', 'like', "%$term%")
                ->orWhere('email', 'like', "%$term%")
                ->orWhere('major', 'like', "%$term%");
        }
        return $query->get();
    }

    //Insert a new student
    public static function createStudent($request) {
        //Retrieve parameters from request body
        $params = $request->getParsedBody();

        //Create a new Student instance
        $student = new Student();

        //Set the student's attributes
        foreach($params as $field => $value) {
            $student->$field = ($field == "gpa") ? number_format($value, 1) : $value;
        }

        //Insert the student into the database
        $student->save();
        return $student;
    }

    //Update a student
    public static function updateStudent($request) {
        //Retrieve parameters from request body
        $params = $request->getParsedBody();

        //Retrieve id from the request url
        $id = $request->getAttribute('id');
        $student = self::findOrFail($id);
        if(!$student) {
            return false;
        }

        //update attributes of the student
        foreach($params as $field => $value) {
            $student->$field = $value;
        }
        //save the student into the database
        $student->save();
        return $student;
    }

    //Delete a student
    public static function deleteStudent($request) {
        //Retrieve id from the request
        $id = $request->getAttribute('id');
        $student = self::findOrFail($id);
        return($student ? $student->delete() : $student);
    }

}