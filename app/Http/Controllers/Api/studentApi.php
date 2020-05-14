<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Api\jwt;

use App\Http\Controllers\Controller;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class studentApi extends Controller
{
    public function addStudent(Request $req)
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


        if (!isset($req['studentName']) or !isset($tokenArray['collegeId']) or !isset($tokenArray['uid']) or !isset($req['studentBirthday']) or !isset($req['dateOfRegistration']) or empty($req['studentName']) or empty($tokenArray['collegeId']) or empty($tokenArray['check']) or empty($req['studentBirthday']) or empty($req['dateOfRegistration'])) {
            $msg = "Insert all information";
            $information = array("true" => 0, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        }
        $studentName = $req['studentName'];
        $phone = $req['phone'];
        $studentSex = $req['studentSex'];
        $studentAddress = $req['studentAddress'];
        $bloodType = $req['bloodType'];
        $guardianPhone = $req['guardianPhone'];
        $studentEmail = $req['studentEmail'];
        $healthStatus = $req['healthStatus'];
        $idNumber = $req['idNumber'];
        $studentAge = $req['studentAge'];
        $studentSection = $req['studentSection'];
        $studentStage = $req['studentStage'];

        $studentDivision = $req['studentDivision'];
        $studentBirthday = $req['studentBirthday'];
        $dateOfRegistration = $req['dateOfRegistration'];
        $collegeId = $tokenArray['collegeId'];
        $addByUserID = $tokenArray['uid'];
        //students::insert([$req]);


        $specialization = $this->getSpecialization($studentSection, $studentStage, $studentDivision, $collegeId);


        $results = DB::insert("INSERT INTO `students` ( `studentName`, `phone`, `idNumber`, `studentAge`, `studentSex`, `studentAddress`, `bloodType`, `guardianPhone`, `studentEmail`, `healthStatus`, `studentBirthday`, `dateOfRegistration`, `collegeId`, `addByUserID`, `deleted`, `updatedAt`, `specialization`) VALUES('$studentName', '$phone', '$idNumber', '$studentAge', '$studentSex', '$studentAddress', '$bloodType', '$guardianPhone', '$studentEmail', '$healthStatus', '$studentBirthday', '$dateOfRegistration', '$collegeId', '$addByUserID', '0',null,'$specialization')", [1, 'Dayle']);

        if ($results) {
            $msg = "student added successfully";
            $information = array("true" => 1, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        }
        $msg = "something wrong !!";
        $information = array("true" => 0, "msg" => $msg);
        return json_encode($information, JSON_PRETTY_PRINT) . "\n";
    }

    public function getStudents(Request $req)
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
        $sp = db::select("SELECT * FROM specialization  LEFT JOIN students c1 ON c1.specialization = specialization.id WHERE specialization.section like '$studentSection' and specialization.stage LIKE '$studentStage' and specialization.division LIKE '$studentDivision' and specialization.collegeId='$collegeId' and c1.deleted=0");
        return json_encode($sp, JSON_PRETTY_PRINT) . "\n";
    }



    public function getStudentsNames(Request $req)
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
        $sp = db::select("SELECT c1.studentName,c1.id FROM specialization  LEFT JOIN students c1 ON c1.specialization = specialization.id WHERE specialization.section like '$studentSection' and specialization.stage LIKE '$studentStage' and specialization.division LIKE '$studentDivision' and specialization.collegeId='$collegeId' and c1.deleted=0");
        return json_encode($sp, JSON_PRETTY_PRINT) . "\n";
    }



    public function deleteStudent(Request $req)
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
        if (isset($req['studentId'])) {
            # code...
            $sId = $req['studentId'];
            $sp = DB::table('students')
                ->where('id', $sId)
                ->where('collegeId', $collegeId)
                ->update(['deleted' => 1]);
            $msg = "student deleted";
            $information = array("true" => 1, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        } else {
            $msg = "Student ID is required";
            $information = array("true" => 0, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        }

        // $studentSection = "bio";
        // $studentStage = "two";

        // $studentDivision = 'b';
        //$specialization = $this->getSpecialization($studentSection, $studentStage, $studentDivision, $collegeId);

        //$sp = DB::table('specialization')->where('collegeId', $collegeId)->where('deleted', 0)->get();
        //$sp = db::select("SELECT * FROM students LEFT JOIN specialization c1 ON students.specialization = c1.id WHERE c1.section like '$studentSection' and c1.stage LIKE '$studentStage' and c1.division LIKE '$studentDivision' and c1.collegeId='$collegeId'");

    }


    public function studentsAbsences(Request $req)
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


        if (!isset($req['studentIds'])    or empty($req['studentIds']) or !isset($req['subject'])    or empty($req['subject'])) {
            $msg = "Insert all information";
            $information = array("true" => 0, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        }
        $collegeId = $tokenArray['collegeId'];
        $subject = $req['subject'];
        $ids = json_decode($req['studentIds']);
        for ($i = 0; $i < count($ids); $i++) {
            $results = DB::insert("INSERT INTO `studentsAbsences` ( `studentId`, `subject`, `collegeId`) VALUES( '$ids[$i]','$subject','$collegeId')", [1, 'Dayle']);
        }

        if ($results) {
            $msg = "student added successfully";
            $information = array("true" => 1, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        }
        $msg = "something wrong !!";
        $information = array("true" => 0, "msg" => $msg);
        return json_encode($information, JSON_PRETTY_PRINT) . "\n";
    }







    public function getSpecialization($studentSection, $studentStage, $studentDivision, $collegeId)
    {
        # code...
        $sp = DB::table('specialization')->where('section', 'LIKE',  "%{$studentSection}%")->where('stage',  'LIKE', "%{$studentStage}%")->where('division',  'LIKE', "%{$studentDivision}%")->where('collegeId', $collegeId)->first();

        return $sp->id;
    }
}
