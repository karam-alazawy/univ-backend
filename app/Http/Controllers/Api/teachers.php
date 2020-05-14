<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Api\jwt;

use App\Http\Controllers\Controller;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class teachers extends Controller
{
    public function addTeacher(Request $req)
    {


        if (isset($_SERVER['HTTP_TOKEN'])) {
            # code...
            $token = $_SERVER['HTTP_TOKEN'];

            //return uid and collegeId;  
            $tokenArray = JWT::checkToken($token);
            if ($tokenArray['check'] == 0) {
                $msg = "access token is not correct or ended";
                $information = array("true" => 0, "msg" => $msg);
                return json_encode($information, JSON_PRETTY_PRINT) . "\n";
            }
        } else {
            $msg = "access token is required";
            $information = array("true" => 0, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        }


        if (!isset($req['teacherName']) or !isset($tokenArray['collegeId']) or !isset($tokenArray['uid']) or !isset($req['teacherBirthday']) or empty($req['teacherName']) or empty($tokenArray['collegeId']) or empty($tokenArray['check']) or empty($req['teacherBirthday'])) {
            $msg = "Insert all information";
            $information = array("true" => 0, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        }
        $teacherName = $req['teacherName'];
        $phone = $req['phone'];
        $teacherSex = $req['teacherSex'];
        $teacherAddress = $req['teacherAddress'];
        $bloodType = $req['bloodType'];
        $teacherEmail = $req['teacherEmail'];
        $idNumber = $req['idNumber'];
        $teacherAge = $req['teacherAge'];

        $teacherBirthday = $req['teacherBirthday'];
        $dateOfRegistration = $req['dateOfRegistration'];
        $section = $req['section'];
        $collegeId = $tokenArray['collegeId'];
        $addByUserID = $tokenArray['uid'];
        //teachers::insert([$req]);
        $classes = $req['teacherDivs'];
        $salary = $req['salary'];
        $specialization = $req['specialization'];


        $results = DB::insert("INSERT INTO `teachers` ( `teacherName`, `phone`, `idNumber`, `teacherAge`, `teacherSex`, `teacherAddress`, `bloodType`, `teacherEmail`, `teacherBirthday`, `dateOfRegistration`, `collegeId`, `addByUserID`, `deleted`, `updatedAt`, `specialization`, `classes`, `salary`, `section`) VALUES('$teacherName', '$phone', '$idNumber', '$teacherAge', '$teacherSex', '$teacherAddress', '$bloodType', '$teacherEmail', '$teacherBirthday', '$dateOfRegistration', '$collegeId', '$addByUserID', '0',null,'$specialization','$classes','$salary','$section')", [1, 'Dayle']);

        if ($results) {
            $msg = "teacher added successfully";
            $information = array("true" => 1, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        }
        $msg = "something wrong !!";
        $information = array("true" => 0, "msg" => $msg);
        return json_encode($information, JSON_PRETTY_PRINT) . "\n";
    }

    public function getTeachers(Request $req)
    {
        if (isset($_SERVER['HTTP_TOKEN'])) {
            # code...
            $token = $_SERVER['HTTP_TOKEN'];

            //return uid and collegeId;  
            $tokenArray = JWT::checkToken($token);
            if ($tokenArray['check'] == 0) {
                $msg = "access token is not correct or ended";
                $information = array("true" => 0, "msg" => $msg);
                return json_encode($information, JSON_PRETTY_PRINT) . "\n";
            }
        } else {
            $msg = "access token is required";
            $information = array("true" => 0, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        }

        $collegeId = $tokenArray['collegeId'];
        if (!empty($req['section'])) {
            $teacherSection = $req['section'];
        } else
            $teacherSection = '%';


        // $teacherSection = "bio";
        // $teacherStage = "two";

        // $teacherDivision = 'b';
        //$specialization = $this->getSpecialization($teacherSection, $teacherStage, $teacherDivision, $collegeId);

        //$sp = DB::table('specialization')->where('collegeId', $collegeId)->where('deleted', 0)->get();
        //$sp = db::select("SELECT * FROM teachers LEFT JOIN specialization c1 ON teachers.specialization = c1.id WHERE c1.section like '$teacherSection' and c1.stage LIKE '$teacherStage' and c1.division LIKE '$teacherDivision' and c1.collegeId='$collegeId'");
        $sp = db::select("SELECT * FROM teachers  WHERE teachers.section like '$teacherSection' and teachers.collegeId='$collegeId' and teachers.deleted=0 order by id desc");
        return json_encode($sp, JSON_PRETTY_PRINT) . "\n";
    }



    public function getTeacherNames(Request $req)
    {
        if (isset($_SERVER['HTTP_TOKEN'])) {
            # code...
            $token = $_SERVER['HTTP_TOKEN'];

            //return uid and collegeId;  
            $tokenArray = JWT::checkToken($token);
            if ($tokenArray['check'] == 0) {
                $msg = "access token is not correct or ended";
                $information = array("true" => 0, "msg" => $msg);
                return json_encode($information, JSON_PRETTY_PRINT) . "\n";
            }
        } else {
            $msg = "access token is required";
            $information = array("true" => 0, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        }

        $collegeId = $tokenArray['collegeId'];
        if (!empty($req['section'])) {
            $studentSection = $req['section'];
        } else
            $studentSection = '%';

        if (!empty($req['stage'])) {
            $studentStage = $req['stage'];
        } else
            $studentStage = '%';

        if (!empty($req['division'])) {
            $studentDivision = $req['division'];
        } else
            $studentDivision = '%';

        // $studentSection = "bio";
        // $studentStage = "two";

        // $studentDivision = 'b';
        //$specialization = $this->getSpecialization($studentSection, $studentStage, $studentDivision, $collegeId);

        //$sp = DB::table('specialization')->where('collegeId', $collegeId)->where('deleted', 0)->get();
        //$sp = db::select("SELECT * FROM students LEFT JOIN specialization c1 ON students.specialization = c1.id WHERE c1.section like '$studentSection' and c1.stage LIKE '$studentStage' and c1.division LIKE '$studentDivision' and c1.collegeId='$collegeId'");
        $sp = db::select("SELECT c1.teacherName,c1.id FROM  teachers c1  WHERE  c1.section LIKE '$studentSection' and c1.collegeId='$collegeId' and c1.deleted=0");
        return json_encode($sp, JSON_PRETTY_PRINT) . "\n";
    }



    public function deleteTeacher(Request $req)
    {
        if (isset($_SERVER['HTTP_TOKEN'])) {
            # code...
            $token = $_SERVER['HTTP_TOKEN'];

            //return uid and collegeId;  
            $tokenArray = JWT::checkToken($token);
            if ($tokenArray['check'] == 0) {
                $msg = "access token is not correct or ended";
                $information = array("true" => 0, "msg" => $msg);
                return json_encode($information, JSON_PRETTY_PRINT) . "\n";
            }
        } else {
            $msg = "access token is required";
            $information = array("true" => 0, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        }

        $collegeId = $tokenArray['collegeId'];
        if (isset($req['teacherId'])) {
            # code...
            $sId = $req['teacherId'];
            $sp = DB::table('teachers')
                ->where('id', $sId)
                ->where('collegeId', $collegeId)
                ->update(['deleted' => 1]);
            $msg = "teacher deleted";
            $information = array("true" => 1, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        } else {
            $msg = "teacher ID is required";
            $information = array("true" => 0, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        }

        // $teacherSection = "bio";
        // $teacherStage = "two";

        // $teacherDivision = 'b';
        //$specialization = $this->getSpecialization($teacherSection, $teacherStage, $teacherDivision, $collegeId);

        //$sp = DB::table('specialization')->where('collegeId', $collegeId)->where('deleted', 0)->get();
        //$sp = db::select("SELECT * FROM teachers LEFT JOIN specialization c1 ON teachers.specialization = c1.id WHERE c1.section like '$teacherSection' and c1.stage LIKE '$teacherStage' and c1.division LIKE '$teacherDivision' and c1.collegeId='$collegeId'");

    }








    public function getSpecialization($teacherSection, $teacherStage, $teacherDivision, $collegeId)
    {
        # code...
        $sp = DB::table('specialization')->where('section', 'LIKE',  "%{$teacherSection}%")->where('stage',  'LIKE', "%{$teacherStage}%")->where('division',  'LIKE', "%{$teacherDivision}%")->where('collegeId', $collegeId)->first();

        return $sp->id;
    }
}
