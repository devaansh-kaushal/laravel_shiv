<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    function getAllUser(){
        $data = DB::table('users')->get();
        return view('user/index',['userList' => $data]);
    }

    function saveUser(){
        $return['status'] = "111";
        $return['message'] = "error";
        $return['response'] = "error found..";
        if(isset($_POST['username']) && !empty(trim($_POST['username'])) && isset($_POST['email']) && !empty(trim($_POST['email']))){
            $dataInsert = DB::table('users')->insert([
                'name' => trim($_POST['username']),
                'email' => trim($_POST['email'])
            ]);
            if(!empty($dataInsert)){
                $return['status'] = "000";
                $return['message'] = "reload";
                $return['response'] = "reload";
            }
        }
        return json_encode($return,true);
    }

    function deleteUser(){
        $return['status'] = "111";
        $return['message'] = "error";
        $return['response'] = "error found..";
        if(isset($_POST['userId']) && !empty(trim($_POST['userId']))){
            $deleted = DB::table('users')->where('id', '=',trim($_POST['userId']))->delete();
            if(!empty($deleted)){
                $return['status'] = "000";
                $return['message'] = "reload";
                $return['response'] = "reload";
            }
        }
        return json_encode($return,true);
    }
}
