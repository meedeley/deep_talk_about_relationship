<?php

namespace App\Http\Controllers;

use App\Models\Hobby;
use App\Models\Student;
use App\Models\StudentHobby;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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
    public function getStudent()
    {
        $students = Student::query()->get();

        return $this->responseServer(200, [
            "statusCode" => 200,
            "data" => $students
        ]);
    }

    public function getHobbies()
    {
        $hobbies = Hobby::query()->get();

        return $this->responseServer(200, [
            "statusCode" => 200,
            "data" => $hobbies
        ]);
    }

    public function getStudentHobbies()
    {
        $studentHobbies = StudentHobby::query()->get();

        return $this->responseServer(200, [
            "statusCode" => 200,
            "data" => $studentHobbies
        ]);
    }
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
    public function setSessionHobbies(Request $request)
    {
        $validated = Validator::make($request->all(), [
            "hobby_id" => "required|exists:hobbies,id",
            "sub_exp" => "required|numeric"
        ]);

        if ($validated->fails()) {
            return $this->responseServer(422, [
                "statusCode" => 422,
                "message" => $validated->errors()
            ]);
        }

        $studentHobbies = Session::get('student_hobbies', []);
        $hobbyId = null;

        foreach ($studentHobbies as $key => $studentHobby) {
            if (isset($studentHobby["hobby_id"]) && $studentHobby["hobby_id"] == $request->hobby_id) {
                $hobbyId = $key;
                break;
            }
        }

        if ($hobbyId !== null) {
            $studentHobbies[$hobbyId]["sub_exp"] += $request->sub_exp;
            $addedHobby = $studentHobbies[$hobbyId];
        } else {
            $addedHobby = [
                "hobby_id" => $request->hobby_id,
                "sub_exp" => $request->sub_exp
            ];
            $studentHobbies[] = $addedHobby;
        }

        Session::put('student_hobbies', $studentHobbies);

        return $this->responseServer(200, [
            "statusCode" => 200,
            "data" => $addedHobby
        ]);
    }

    public function getSessionHobbies()
    {
        $getSession = Session::get('student_hobbies');

        $getSession == null ? $getSession = [] : $getSession;

        return $this->responseServer(200, [
            "statusCode" => 200,
            "data" => $getSession,
        ]);
    }

    public function storeStudentHobbies(Request $request)
    {
        $validated = Validator::make($request->all(), [
            "name" => "required|string",
        ]);

        if ($validated->fails()) {
            return $this->responseServer(409, [
                "statusCode" => 409,
                "message" => $validated->errors()
            ]);
        }

        $studentHobbies = Session::get('student_hobbies');

        $student = Student::query()->create([
            "name" => $request->name,
            "exp" => 0
        ]);

        $sumExp = 0;
        $extractStudentHobbies = [];

        foreach ($studentHobbies as $listHobby) {
            $extractStudentHobbies[$listHobby["hobby_id"]] = ["sub_exp" => $listHobby['sub_exp']];

            $sumExp = collect($listHobby['sub_exp'])->sum();
        }

        $student->hobbies()->attach($extractStudentHobbies);

        $student->update([
            "exp" => $sumExp
        ]);

        Session::forget('student_hobbies');

        return $this->responseServer(200, [
            "statusCode" => 200,
            "data" => $student->load('hobbies')
        ]);
    }

    public function updateStudentHobbies(Request $request, int $id)
    {
        $student = Student::query()->findOrFail($id);

        $validated = Validator::make($request->all(), [
            "name" => "required|string",
            "hobbies" => "required|array",
            "hobbies.*.hobby_id" => "required|exists:hobbies,id",
            "hobbies.*.sub_exp" => "required|numeric"
        ]);

        if ($validated->fails()) {
            return $this->responseServer(409, [
                "statusCode" => 409,
                "message" => $validated->errors()
            ]);
        }

        $student->update(["name" => $request->name]);

        $recalculateExp = 0;
        foreach ($request->hobbies as $hobby) {
            $student->hobbies()->updateExistingPivot($hobby["hobby_id"], ['sub_exp' => $hobby["sub_exp"]]);

            $recalculateExp = $hobby["sub_exp"];
        }

        $student->update([
            "exp" => $recalculateExp
        ]);

        return $this->responseServer(200, [
            "statusCode" => 200,
            "data" => $student->load('hobbies')
        ]);
    }


    public function detachStudentHobbies(int $id) {
        $student = Student::query()->find($id);

        $student->hobbies()->detach();

        $student->delete();

        return $this->responseServer(200, [
            "statusCode" => 200,
            "data" => $student->load('hobbies')
        ]);
    }
}
