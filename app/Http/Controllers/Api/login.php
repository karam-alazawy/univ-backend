<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\jwt;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class login extends Controller
{
    //
    public function login(Request $req)
    {
        if (!empty($req['username']) and !empty($req['password'])) {


            $user = DB::table('users')->where('username', $req['username'])->where('password', md5($req['password']))->get();
            if (count($user) > 0) {
                # code...
                $token = $this->getToken($user[0]->id, $user[0]->collegeId);
                $msg = "U Got The Tokken";
                $true = 1;
            } else {
                $msg = "معلوماتك غير صحيحة";
                $true = 0;
                $token = 0;
            }
        } else {
            $msg = "جميع المعلومات ضرورية لاكمال عملية تسجيل الدخول  !!";
            $true = 0;
            $token = 0;
        }


        $information = array("token" => $token, "msg" => $msg, "true" => $true);

        return json_encode($information, JSON_PRETTY_PRINT) . "\n";

        // public function deleteUser(Request $req){
        //     $id=$req['id'];
        //     $user = DB::delete('DELETE FROM `users` WHERE `users`.`id` = "'.$id.'"');
        //     return $user;
        // }
    }



    public function checkToken(Request $req)
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
            } else {
                $msg = "vaild";
                $information = array("true" => 1, "msg" => $msg);
                return json_encode($information, JSON_PRETTY_PRINT) . "\n";
            }
        } else {
            $msg = "access token is required";
            $information = array("true" => 0, "msg" => $msg);
            return json_encode($information, JSON_PRETTY_PRINT) . "\n";
        }
    }

    public function getToken($id, $collegeId)
    {
        // $pricesClass = new JWT();

        ############################################JWT############################################


        /** 
         * Create some payload data with user data we would normally retrieve from a
         * database with users credentials. Then when the client sends back the token,
         * this payload data is available for us to use to retrieve other data 
         * if necessary.
         */
        $userId = $id;

        /**
         * Uncomment the following line and add an appropriate date to enable the 
         * "not before" feature.
         */
        // $nbf = strtotime('2021-01-01 00:00:01');

        /**
         * Uncomment the following line and add an appropriate date and time to enable the 
         * "expire" feature.
         */
        $exp = strtotime(date("Y-m-d H:i:s", time() + 86400));

        // Get our server-side secret key from a secure location.
        $computerId = "myTokenKeyKaram";
        $serverKey =  $computerId;

        // create a token
        $payloadArray = array();
        $payloadArray['userId'] = $userId;
        $payloadArray['collegeId'] = $collegeId;
        if (isset($nbf)) {
            $payloadArray['nbf'] = $nbf;
        }
        if (isset($exp)) {
            $payloadArray['exp'] = $exp;
        }
        $token = JWT::encode($payloadArray, $serverKey);
        return $token;
    }
}
