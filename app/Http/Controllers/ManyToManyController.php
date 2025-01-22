<?php

namespace App\Http\Controllers;

use App\Models\Hobby;
use App\Models\Student;
use App\Models\StudentHobby;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ManyToManyController extends Controller
{
    /*
    Will Learn
    1. Attach
    2. Detach
    3. Sync
    4. SyncWithoutDetaching
    5. Toggle
    6. UpdateExistingPivot
    7. Pivot Accessing
    8. Saving Related Models
    9. FirstOrCreate Method
    10. FirstOrNew Method
    */
    public function createNewStudentHobbies()
    {
        $student = Student::query()->create([
            "name" => "Nichola",
            "exp" => 1
        ]);

        $student->hobbies()->attach(
            [
                1 => ['sub_exp' => 20],
                2 => ['sub_exp' => 30],
                3 => ['sub_exp' => 40],
            ]
        );

        $exp = $student->hobbies()->sum('sub_exp') + $student->exp;

        $student->update([
            "exp" => $exp
        ]);

        return $this->responseServer(200, [
            "statusCode" => 200,
            "data" => $student->load('hobbies')
        ]);
    }

    // => ACTION CREATE PIVOT THEN CREATE STUDENT
    public function setArrayHobbies(Request $request)
    {
        $studentHobbies = Session::get('student_hobbies', []);

        $addedHobby = [
            "hobby_id" => $request->hobby_id,
            "sub_exp" => $request->sub_exp
        ];

        $studentHobbies[] = $addedHobby;
        
        Session::put('student_hobbies', $studentHobbies);

        return $this->responseServer(200, [
            "statusCode" => 200,
            "data" => $addedHobby
        ]);
    }

    public function getArrayHobbies()
    {
        $getSession = Session::get('student_hobbies');

        return $this->responseServer(200, [
            "statusCode" => 200,
            "data" => $getSession,
        ]);
    }

    public function storeStudentHobby(Request $request)
    {
        $studentHobbies = Session::get('student_hobbies');

        $student = Student::query()->create([
            "name" => $request->name,
            "exp" => $request->exp
        ]);

        $sumExp = 0;
        $extractStudentHobbies = [];

        foreach ($studentHobbies as $listHobby) {
            $extractStudentHobbies[$listHobby["hobby_id"]] = ["sub_exp" => $listHobby['exp']];

            var_dump($listHobby['sub_exp']);
            die();

            $sumExp = array_sum($listHobby['sub_exp']) + $student->exp;
        }

        $student->hobbies()->attach($extractStudentHobbies);

        $student->update([
            "exp" => $sumExp
        ]);
        
        Session::

        return $this->responseServer(200, [
            "statusCode" => 200,
            "data" => $student->load('hobbies')
        ]);
    }
}
