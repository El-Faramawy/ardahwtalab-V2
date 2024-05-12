<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use App\Models\Members;
use Auth;


class MembersController extends Controller
{
    public function __construct(){
        return $this->middleware('auth');
    }

    public function index(){
       $user = Auth::user();
       if(isset($user->Expire_Date)){
           if(strtotime($user->Expire_Date) >= strtotime(date('d-m-Y'))){
               $now = strtotime(date('d-m-Y')); // or your date as well
               $your_date = strtotime($user->Expire_Date);
               $datediff =  $your_date - $now;

                $days =  round($datediff / (60 * 60 * 24));
                echo" <center style='position: absolute; top: 40%; right: 40%;'>
                        <h2>
                            Your Account Will be Expired at:
                            <b style='color:blue'>".$user->Expire_Date."</b>
                             <b style='color:red'>(".$days.")</b>  Days Left
                        <h2>
                        <a href='./'>Back To Home </a>

                        <meta http-equiv=\"refresh\" content=\"4; url=./\">
                    </center>";
           }else{
               $members = Members::all();
               return view('site.members.members' , ['members' => $members,'user'=> $user]);
           }
       }else{
            $members = Members::all();
           return view('site.members.members' , ['members' => $members,'user'=> $user]);
       }


    }


}
