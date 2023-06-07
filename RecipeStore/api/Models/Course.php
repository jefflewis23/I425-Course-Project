<?php
/**
 * Author: Derek Wright
 * Date: 5/24/2023
 * File: Course.php
 * Description: This defines the Course model class.
 */
namespace MyCollegeAPI\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model {
    //The table associated with this model
    protected $table = 'courses';

    //The primary key of the table
    protected $primaryKey = 'number';

    //The PK is non-numeric
    public $incrementing = false;

    //If the PF is not an integer, set its type
    protected $keyType = 'char';

    //If the created_at and updated_at columns are not used
    public $timestamps = false;

    // Define the one to many relationship between Course and MyClass model classes
    // The first parameter is the model class name; the second parameter is the foreign key.
    public function classes() {
        return $this->hasMany(MyClass::class, 'course');
    }

    //Retrieve all courses
    public static function getCourses($request) {
        //$courses = self::all();
        //$courses = self::with('classes')->get();
        //return $courses;

        /*********** code for pagination and sorting ***************************/
        //get the total number of row count
        $count = self::count();

        //Get querystring variables from url
        $params = $request->getQueryParams();

        //do limit and offset exist?
        $limit = array_key_exists('limit', $params) ? (int)$params['limit'] : 10;   //items per page
        $offset = array_key_exists('offset', $params) ? (int)$params['offset'] : 0;  //offset of the first item

        //pagination
        $links = self::getLinks($request, $limit, $offset);

        //build query
        $query = self::with('classes');  //build the query to get all courses
        $query = $query->skip($offset)->take($limit);  //limit the rows

        //code for sorting
        $sort_key_array = self::getSortKeys($request);

        //soft the output by one or more columns
        foreach ($sort_key_array as $column => $direction) {
            $query->orderBy($column, $direction);
        }

        //retrieve the courses
        $courses = $query->get();  //Finally, run the query and get the results

        //construct the data for response
        $results = [
            'totalCount' => $count,
            'limit' => $limit,
            'offset' => $offset,
            'links' => $links,
            'sort' => $sort_key_array,
            'data' => $courses
        ];

        return $results;
    }

    //Retrieve a specific course
    public static function getCourseByNumber(string $number) {
        $course = self::findOrFail($number);
        $course->load('classes');
        return $course;
    }

    //View all classes of a course
    public static function getClassesByCourse(string $number) {
        $classes = self::findOrFail($number)->classes;
        return $classes;
    }


    // Return an array of links for pagination. The array includes links for the current, first, next, and last pages.
    private static function getLinks($request, $limit, $offset) {
        $count = self::count();

        // Get request uri and parts
        $uri = $request->getUri();
        if($port = $uri->getPort()) {
            $port = ':' . $port;
        }
        $base_url = $uri->getScheme() . "://" . $uri->getHost() . $port . $uri->getPath();

        // Construct links for pagination
        $links = [];
        $links[] = ['rel' => 'self', 'href' => "$base_url?limit=$limit&offset=$offset"];
        $links[] = ['rel' => 'first', 'href' => "$base_url?limit=$limit&offset=0"];
        if ($offset - $limit >= 0) {
            $links[] = ['rel' => 'prev', 'href' => "$base_url?limit=$limit&offset=($offset - $limit)"];
        }
        if ($offset + $limit < $count) {
            $links[] = ['rel' => 'next', 'href' => "$base_url?limit=$limit&offset=($offset + $limit)"];
        }
        $links[] = ['rel' => 'last', 'href' => "$base_url?limit=$limit&offset=$limit * (ceil($count / $limit) - 1)"];

        return $links;
    }

    /*
     * Sort keys are optionally enclosed in [ ], separated with commas;
     * Sort directions can be optionally appended to each sort key, separated by :.
     * Sort directions can be 'asc' or 'desc' and defaults to 'asc'.
     * Examples: sort=[number:asc,title:desc], sort=[number, title:desc]
     * This function retrieves sorting keys from uri and returns an array.
    */
    private static function getSortKeys($request) {
        $sort_key_array = [];

        // Get querystring variables from url
        $params = $request->getQueryParams();

        if (array_key_exists('sort', $params)) {
            $sort = preg_replace('/^\[|\]$|\s+/', '', $params['sort']);  // remove white spaces, [, and ]
            $sort_keys = explode(',', $sort); //get all the key:direction pairs
            foreach ($sort_keys as $sort_key) {
                $direction = 'asc';
                $column = $sort_key;
                if (strpos($sort_key, ':')) {
                    list($column, $direction) = explode(':', $sort_key);
                }
                $sort_key_array[$column] = $direction;
            }
        }

        return $sort_key_array;
    }
}