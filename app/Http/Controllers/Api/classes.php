<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Api\jwt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Ext\Table\Table;

class classes extends Controller
{
    public function getClasses(Request $req)
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
        $sp = DB::table('specialization')->where('collegeId', $collegeId)->where('deleted', 0)->get();
        return json_encode($sp, JSON_PRETTY_PRINT) . "\n";
    }



    public function getSections(Request $req)
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
        $sp = DB::table('specialization')->where('collegeId', $collegeId)->where('deleted', 0)->select('section')->groupBy('section')->get();


        return json_encode($sp, JSON_PRETTY_PRINT) . "\n";
    }



    public function getStages(Request $req)
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

        $section = $req['section'];
        $collegeId = $tokenArray['collegeId'];
        $sp = DB::table('specialization')->where('collegeId', $collegeId)->where('section', $section)->where('deleted', 0)->select('stage')->groupBy('stage')->get();


        return json_encode($sp, JSON_PRETTY_PRINT) . "\n";
    }







    public function getDivisions(Request $req)
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

        $section = $req['section'];
        $stage = $req['stage'];
        $collegeId = $tokenArray['collegeId'];
        $sp = DB::table('specialization')->where('collegeId', $collegeId)->where('deleted', 0)->where('section', $section)->where('stage', $stage)->select('division', 'id')->groupBy('division', 'id')->get();


        return json_encode($sp, JSON_PRETTY_PRINT) . "\n";
    }





    public function getTeacherSp(Request $req)
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

        if (!empty($req['section'])) {
            $studentSection = $req['section'];
        } else {
            $msg = "section is required";
            $information = array("true" => 0, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        }
        if (!empty($req['stage'])) {
            $studentStage = $req['stage'];
        } else {
            $msg = "stage is required";
            $information = array("true" => 0, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        }
        if (!empty($req['division'])) {
            $studentDivision = $req['division'];
        } else {
            $msg = "division is required";
            $information = array("true" => 0, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        }

        $collegeId = $tokenArray['collegeId'];
        $sp = DB::table('specialization')->where('collegeId', $collegeId)->where('deleted', 0)->where('section', $studentSection)->where('stage', $studentStage)->where('division', $studentDivision)->select('id')->groupBy('id')->get()->first();


        return json_encode($sp, JSON_PRETTY_PRINT) . "\n";
    }




    public function addClass(Request $req)
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

        $section = $req['section'];
        $stage = $req['stage'];
        $division = $req['division'];
        $collegeId = $tokenArray['collegeId'];

        $result = DB::insert("INSERT INTO `specialization` ( `section`, `stage`, `division`, `collegeId`) VALUES('$section', '$stage', '$division', '$collegeId')");

        if ($result) {
            $msg = " added successfully";
            $information = array("true" => 1, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        }
        $msg = "something wrong !!";
        $information = array("true" => 0, "msg" => $msg);
        return json_encode($information, JSON_PRETTY_PRINT) . "\n";
    }
}
