<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Api\jwt;

use App\Http\Controllers\Controller;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class advertisement extends Controller
{



    public function addAdvertisement(Request $req)
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


        if (!isset($req['advText']) or !isset($tokenArray['collegeId']) or !isset($tokenArray['uid']) or  empty($tokenArray['collegeId']) or empty($tokenArray['check']) or empty($req['advText'])) {
            $msg = "Insert all information";
            $information = array("true" => 0, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        }
        $collegeId = $tokenArray['collegeId'];


        $advText = $req['advText'];
        $uid = $tokenArray['uid'];
        $type = $req['type'];


        $results = DB::insert("INSERT INTO `advertisement` ( `advText`, `collegeId`, `addedByUser` ,`type`) VALUES('$advText', '$collegeId', '$uid', '$type')", [1, 'Dayle']);

        if ($results) {
            $msg = "notification send successfully";
            $information = array("true" => 1, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        }
        $msg = "something wrong !!";
        $information = array("true" => 0, "msg" => $msg);
        return json_encode($information, JSON_PRETTY_PRINT) . "\n";
    }



    public function getAdvertisements(Request $req)
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

        // $studentSection = "bio";
        // $studentStage = "two";

        // $studentDivision = 'b';
        //$specialization = $this->getSpecialization($studentSection, $studentStage, $studentDivision, $collegeId);

        //$sp = DB::table('specialization')->where('collegeId', $collegeId)->where('deleted', 0)->get();
        //$sp = db::select("SELECT * FROM students LEFT JOIN specialization c1 ON students.specialization = c1.id WHERE c1.section like '$studentSection' and c1.stage LIKE '$studentStage' and c1.division LIKE '$studentDivision' and c1.collegeId='$collegeId'");
        $sp = db::select("SELECT * FROM advertisement WHERE advertisement.collegeId='$collegeId' and advertisement.addedByUser='$uid' and advertisement.deleted=0 limit 20");
        return json_encode($sp, JSON_PRETTY_PRINT) . "\n";
    }







    public function getSpecialization($studentSection, $studentStage, $studentDivision, $collegeId)
    {
        # code...
        $sp = DB::table('specialization')->where('section', 'LIKE',  "%{$studentSection}%")->where('stage',  'LIKE', "%{$studentStage}%")->where('division',  'LIKE', "%{$studentDivision}%")->where('collegeId', $collegeId)->get()->first();

        return $sp;
    }
}
