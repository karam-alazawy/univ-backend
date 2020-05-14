<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Api\jwt;

use App\Http\Controllers\Controller;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class notification extends Controller
{
    public function addStudentNotification(Request $req)
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


        if (!isset($req['notificationTitle']) or !isset($tokenArray['collegeId']) or !isset($tokenArray['uid']) or !isset($req['notificationText']) or !isset($req['studentId']) or empty($req['notificationTitle']) or empty($tokenArray['collegeId']) or empty($tokenArray['check']) or empty($req['notificationText']) or empty($req['studentId'])) {
            $msg = "Insert all information";
            $information = array("true" => 0, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        }
        // $specialization = $this->getSpecialization($studentSection, $studentStage, $studentDivision, $collegeId);
        $notificationTitle = $req['notificationTitle'];
        $notificationText = $req['notificationText'];
        $studentId = $req['studentId'];
        $collegeId = $tokenArray['collegeId'];
        $uid = $tokenArray['uid'];
        $type = $req['type'];


        $results = DB::insert("INSERT INTO `studentNotification` ( `notificationTitle`, `notificationText`, `studentId`, `collegeId`, `addedByUser`, `type`) VALUES('$notificationTitle', '$notificationText', '$studentId', '$collegeId', '$uid', '$type')", [1, 'Dayle']);

        if ($results) {
            $msg = "notification send successfully";
            $information = array("true" => 1, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        }
        $msg = "something wrong !!";
        $information = array("true" => 0, "msg" => $msg);
        return json_encode($information, JSON_PRETTY_PRINT) . "\n";
    }



    public function addStageNotification(Request $req)
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


        if (!isset($req['section']) or !isset($req['stage']) or !isset($req['division']) or !isset($req['notificationTitle']) or !isset($tokenArray['collegeId']) or !isset($tokenArray['uid']) or !isset($req['notificationText']) or empty($req['notificationTitle']) or empty($tokenArray['collegeId']) or empty($tokenArray['check']) or empty($req['notificationText'])) {
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
        // $specialization = $this->getSpecialization($studentSection, $studentStage, $studentDivision, $collegeId);
        $notificationTitle = $req['notificationTitle'];
        $notificationText = $req['notificationText'];
        $uid = $tokenArray['uid'];
        $type = $req['type'];


        $results = DB::insert("INSERT INTO `stageNotifications` ( `notificationTitle`, `notificationText`, `collegeId`, `addedByUser` ,`type`,`section`,`stage`,`division`) VALUES('$notificationTitle', '$notificationText', '$collegeId', '$uid', '$type','$section','$stage','$division')", [1, 'Dayle']);

        if ($results) {
            $msg = "notification send successfully";
            $information = array("true" => 1, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        }
        $msg = "something wrong !!";
        $information = array("true" => 0, "msg" => $msg);
        return json_encode($information, JSON_PRETTY_PRINT) . "\n";
    }



    public function addTeacherNotification(Request $req)
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


        if (!isset($tokenArray['collegeId']) or !isset($tokenArray['uid']) or !isset($req['notificationText']) or !isset($req['teacherId']) or empty($tokenArray['collegeId']) or empty($tokenArray['check']) or empty($req['notificationText']) or empty($req['teacherId'])) {
            $msg = "Insert all information";
            $information = array("true" => 0, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        }
        // $specialization = $this->getSpecialization($studentSection, $studentStage, $studentDivision, $collegeId);



        $notificationText = $req['notificationText'];
        $type = $req['type'];
        $teacherId = $req['teacherId'];
        //        $sp = db::select("SELECT teacherName FROM teachers WHERE id='$teacherId'");
        $sp2 = DB::table('teachers')->where('id', $teacherId)->first();
        $teacherName = $sp2->teacherName;

        $collegeId = $tokenArray['collegeId'];
        $uid = $tokenArray['uid'];

        $results = DB::insert("INSERT INTO `teachersNotifications` ( `teacherName`, `notificationText`, `teacherId`, `collegeId`, `addedByUser`, `type`) VALUES('$teacherName', '$notificationText', '$teacherId', '$collegeId', '$uid', '$type')", [1, 'Dayle']);

        if ($results) {
            $msg = "notification send successfully";
            $information = array("true" => 1, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        }
        $msg = "something wrong !!";
        $information = array("true" => 0, "msg" => $msg);
        return json_encode($information, JSON_PRETTY_PRINT) . "\n";
    }



    public function getStageNotifications(Request $req)
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



    public function getTeacherNotifications(Request $req)
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
        $sp = db::select("SELECT * FROM teachersNotifications WHERE  teachersNotifications.collegeId='$collegeId' and teachersNotifications.addedByUser='$uid' and teachersNotifications.deleted=0 order by id desc limit 25");
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


    // public function studentsAbsences(Request $req)
    // {


    //     if (isset($_SERVER['HTTP_TOKEN'])) {
    //         # code...
    //         $token = $_SERVER['HTTP_TOKEN'];

    //         //return uid and collegeId;  
    //         $tokenArray = JWT::checkToken($token);
    //         if ($tokenArray['check'] == 0) {
    //             $msg = "access token is not correct or ended";
    //             $information = array("true" => 0, "msg" => $msg);
    //             return json_encode($information, JSON_PRETTY_PRINT) . "\n";
    //         }
    //     } else {
    //         $msg = "access token is required";
    //         $information = array("true" => 0, "msg" => $msg);
    //         return json_encode($information, JSON_PRETTY_PRINT) . "\n";
    //     }


    //     if (!isset($req['studentIds'])    or empty($req['studentIds']) or !isset($req['subject'])    or empty($req['subject'])) {
    //         $msg = "Insert all information";
    //         $information = array("true" => 0, "msg" => $msg);
    //         return json_encode($information, JSON_PRETTY_PRINT) . "\n";
    //     }
    //     $collegeId = $tokenArray['collegeId'];
    //     $subject = $req['subject'];
    //     $ids = json_decode($req['studentIds']);
    //     for ($i = 0; $i < count($ids); $i++) {
    //         $results = DB::insert("INSERT INTO `studentsAbsences` ( `studentId`, `subject`, `collegeId`) VALUES( '$ids[$i]','$subject','$collegeId')", [1, 'Dayle']);
    //     }

    //     if ($results) {
    //         $msg = "student added successfully";
    //         $information = array("true" => 1, "msg" => $msg);
    //         return json_encode($information, JSON_PRETTY_PRINT) . "\n";
    //     }
    //     $msg = "something wrong !!";
    //     $information = array("true" => 0, "msg" => $msg);
    //     return json_encode($information, JSON_PRETTY_PRINT) . "\n";
    // }






    public function getSpecialization($studentSection, $studentStage, $studentDivision, $collegeId)
    {
        # code...
        $sp = DB::table('specialization')->where('section', 'LIKE',  "%{$studentSection}%")->where('stage',  'LIKE', "%{$studentStage}%")->where('division',  'LIKE', "%{$studentDivision}%")->where('collegeId', $collegeId)->get()->first();

        return $sp;
    }
}
