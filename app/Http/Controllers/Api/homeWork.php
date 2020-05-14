<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Api\jwt;

use App\Http\Controllers\Controller;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class homeWork extends Controller
{
    public function addHomeWork(Request $req)
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


        if (!isset($req['section']) or !isset($req['stage']) or !isset($req['division']) or !isset($req['homeWorkTitle']) or !isset($tokenArray['collegeId']) or !isset($tokenArray['uid']) or !isset($req['homeWorkText']) or empty($req['homeWorkTitle']) or empty($tokenArray['collegeId']) or empty($tokenArray['check']) or empty($req['homeWorkText'])) {
            $msg = "Insert all information";
            $information = array("true" => 0, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        }
        $collegeId = $tokenArray['collegeId'];

        if (!empty($req['section'])) {
            $section = $req['section'];
        }
        if (!empty($req['stage'])) {
            $stage = $req['stage'];
        }

        if (!empty($req['division'])) {
            $division = $req['division'];
        }

        // $studentSection = "bio";
        // $studentStage = "two";

        // $studentDivision = 'b';


        //$special = $this->getSpecialization($req['section'], $req['stage'], $req['division'], $tokenArray['collegeId']);
        $specialization = $this->getSpecialization($section, $stage, $division, $collegeId);
        $homeWorkTitle = $req['homeWorkTitle'];
        $homeWorkText = $req['homeWorkText'];
        $uid = $tokenArray['uid'];
        $type = $req['type'];


        $results = DB::insert("INSERT INTO `homeWork` ( `homeWorkTitle`, `homeWorkText`, `collegeId`, `addedByUser`,`specialization`) VALUES('$homeWorkTitle', '$homeWorkText', '$collegeId', '$uid','$specialization')", [1, 'Dayle']);

        if ($results) {
            $msg = "homework send successfully";
            $information = array("true" => 1, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        }
        $msg = "something wrong !!";
        $information = array("true" => 0, "msg" => $msg);
        return json_encode($information, JSON_PRETTY_PRINT) . "\n";
    }





    public function getStageHomeWork(Request $req) //not work yet
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
        $uid = $tokenArray['uid'];
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
        $sp = db::select("SELECT * FROM stageNotifications WHERE stageNotifications.section like '$studentSection' and stageNotifications.stage LIKE '$studentStage' and stageNotifications.division LIKE '$studentDivision' and stageNotifications.collegeId='$collegeId' and stageNotifications.addedByUser='$uid' and stageNotifications.deleted=0 limit 25");
        return json_encode($sp, JSON_PRETTY_PRINT) . "\n";
    }


    public function deleteHomeWork(Request $req) //not work yet
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

    public function getSpecialization($studentSection, $studentStage, $studentDivision, $collegeId)
    {
        # code...
        $sp = DB::table('specialization')->where('section', $studentSection)->where('stage',  $studentStage)->where('division',  $studentDivision)->where('collegeId', $collegeId)->get()->first();

        return $sp->id;
    }
}
