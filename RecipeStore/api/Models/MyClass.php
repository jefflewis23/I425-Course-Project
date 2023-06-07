<?php
/**
 * Author: Derek Wright
 * Date: 5/29/2023
 * File: MyClass.php
 * Description: Define the MyClass model class.
 */

namespace MyCollegeAPI\Models;

use Illuminate\Database\Eloquent\Model;

class MyClass extends Model {
    //The table associated with this model
    protected $table = 'classes';

    //The primary key of the table
    protected $primaryKey = 'section';

    //The PK is non-numeric
    public $incrementing = false;

    //If the PF is not an integer, set its type
    protected $keyType = 'char';

    //If the created_at and updated_at columns are not used
    public $timestamps = false;

    // Define the one to many (inverse) relationship  between Professor and MyClass model classes
    // The first parameter is the model class name; the second parameter is the foreign key.
    public function professor() {
        return $this->belongsTo(Professor::class, 'professor');
    }

    // Define the one to many (inverse) relationship  between Course and MyClass model classes
    public function course() {
        return $this->belongsTo(Course::class, 'course');
    }

    /* Define the many-to-many relationship between Student and MyClass model classes.
    *  The third intermediate table linking the students and classes tables in DB is enrollments.
     * In the enrollment table, section and student are the foreign keys.
    */
    public function students() {
        return $this->belongsToMany(Student::class, 'enrollments', 'section', 'student')
            ->withPivot('grade');
    }

    //Retrieve all classes
    public static function getClasses() {
        //$classes = self::all();

        //Get all classes along with the professors
        $classes = self::with(['professor', 'course'])->get();
        return $classes;
    }

    //Retrieve a specific class by a section number
    public static function getClassBySection(int $section) {
        $class = self::findOrFail($section);

        // get the professor who teaches the class
        $class->load('professor')->load('course');

        return $class;
    }

    // Retrieve students enrolled in a class section
    public static function getStudentBySection(int $section) {
        return self::findOrFail($section)->students;
    }
}