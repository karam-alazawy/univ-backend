<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Api\jwt;

use App\Http\Controllers\Controller;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class schedule extends Controller
{



    public function addDaySchedule(Request $req)
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


        if (!isset($req['day']) or !isset($tokenArray['collegeId']) or !isset($tokenArray['uid']) or  empty($tokenArray['collegeId']) or empty($tokenArray['check']) or empty($req['day']) or empty($req['durations']) or empty($req['lessons'])) {
            $msg = "Insert all information";
            $information = array("true" => 0, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        }
        $day = $req['day'];
        $collegeId = $tokenArray['collegeId'];
        $uid = $tokenArray['uid'];

        if (isset($req['section'])) {
            $studentSection = $req['section'];
            $studentStage = $req['stage'];

            $studentDivision = $req['division'];
            $specialization = $this->getSpecialization($studentSection, $studentStage, $studentDivision, $collegeId);
        } elseif (isset($req['specialization']))
            $specialization = $req['specialization'];
        else {
            $msg = "Insert specialization";
            $information = array("true" => 0, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        }
        $lessons = $req['lessons'];
        $durations = $req['durations'];
        $lessons = explode(",", $lessons);
        $durations = explode(",", $durations);



        $sp = DB::table('weeklySchedule')->select('id')->where('day',  $day)->where('specialization',  $specialization)->where('collegeId', $collegeId)->where('addedByUser', $uid)->where('deleted', 0)->get();
        if (count($sp)) {
            $res = DB::table('daySchedule')
                ->where('dayId', $sp[0]->id)
                ->where('collegeId', $collegeId)
                ->delete();
            for ($i = 0; $i < count($lessons); $i++) {
                # code...
                DB::table('daySchedule')->insert([
                    ['dayId' => $sp[0]->id, 'lesson' => $lessons[$i], 'hour' => $durations[$i], 'collegeId' => $collegeId, 'addedByUser' => 1],
                ]);
            }
        } else {
            DB::table('weeklySchedule')->insert([
                'day' => $day, 'specialization' => $specialization, 'collegeId' => $collegeId, 'addedByUser' => 1
            ]);
            $sp = DB::table('weeklySchedule')->select('id')->where('day',  $day)->where('specialization',  $specialization)->where('collegeId', $collegeId)->where('addedByUser', $uid)->where('deleted', 0)->get();
            for ($i = 0; $i < count($lessons); $i++) {
                # code...
                DB::table('daySchedule')->insert([
                    ['dayId' => $sp[0]->id, 'lesson' => $lessons[$i], 'hour' => $durations[$i], 'collegeId' => $collegeId, 'addedByUser' => 1],
                ]);
            }
        }
        return $sp;
    }


    public function getDaySchedule(Request $req)
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


        if (!isset($req['id']) or !isset($tokenArray['collegeId']) or !isset($tokenArray['uid']) or  empty($tokenArray['collegeId']) or empty($tokenArray['check']) or empty($req['id'])) {
            $msg = "Insert all information";
            $information = array("true" => 0, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        }
        $id = $req['id'];
        $collegeId = $tokenArray['collegeId'];



        $uid = $tokenArray['uid'];


        $sp = DB::table('daySchedule')->select('lesson', 'hour', 'id')->where('dayId',  $id)->where('collegeId', $collegeId)->where('addedByUser', $uid)->where('deleted', 0)->get();
        return $sp;
    }



    public function getSchedule(Request $req)
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

        //$specialization = $req['specialization'];
        $collegeId = $tokenArray['collegeId'];
        $uid = $tokenArray['uid'];

        $studentSection = $req['section'];
        $studentStage = $req['stage'];

        $studentDivision = $req['division'];
        $specialization = $this->getSpecialization($studentSection, $studentStage, $studentDivision, $collegeId);

        //$sp = DB::table('specialization')->where('collegeId', $collegeId)->where('deleted', 0)->get();
        //$sp = db::select("SELECT * FROM students LEFT JOIN specialization c1 ON students.specialization = c1.id WHERE c1.section like '$studentSection' and c1.stage LIKE '$studentStage' and c1.division LIKE '$studentDivision' and c1.collegeId='$collegeId'");
        $sp = DB::table('weeklySchedule')->select('day', 'id')->where('specialization',  $specialization)->where('collegeId', $collegeId)->where('addedByUser', $uid)->where('deleted', 0)->get();
        return json_encode($sp, JSON_PRETTY_PRINT) . "\n";
    }





    public function deleteLesson(Request $req)
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
        if (isset($req['lessonId'])) {
            # code...
            $lId = $req['lessonId'];
            $sp = DB::table('daySchedule')
                ->where('id', $lId)
                ->where('collegeId', $collegeId)
                ->update(['deleted' => 1]);
            $msg = "Lesson deleted";
            $information = array("true" => 1, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        } else {
            $msg = "Lesson ID is required";
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
