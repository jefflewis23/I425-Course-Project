<?php
/**
 * Author: Derek Wright
 * Date: 5/24/2023
 * File: Professor.php
 * Description: Define the Professor model class
 */

namespace MyCollegeAPI\Models;

use Illuminate\Database\Eloquent\Model;

class Professor extends Model {
    //The table associated with this model
    protected $table = 'professors';

    //The primary key of the table
    protected $primaryKey = 'id';

    //The PK ins non-numeric
    public $incrementing = false;

    //If the PF is not an integer, set its type
    protected $keyType = 'char';

    //If the created_at and updated_at columns are not used
    public  $timestamps = false;

    // Define the one-to-many relationship between Professor and MyClass model classes
    // The first parameter is the model class name; the second parameter is the foreign key.
    public function classes() {
        return $this->hasMany(MyClass::class, 'professor');
    }

    //Retrieve all professors
    public static function getProfessors() {
        //$professors = self::all();

        //Retrieve professors along with their classes
        $professors = self::with('classes')->get();
        return $professors;
    }

    //View a specific professor by id
    public static function getProfessorById(string $id) {
        $professor = self::findOrFail($id);

        // Get classes taught by the professor
        $professor->load('classes');
        //$professor["image"] = "http://localhost/I425/" . $professor["image"];
        return $professor;
    }

    //View all classes taught by a professor
    public static function getClassesByProfessor(string $id) {
        $classes = self::findOrFail($id)->classes;
        return $classes;
    }
}