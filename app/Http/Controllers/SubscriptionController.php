<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use App\Models\Advs;
use Illuminate\Http\Request;
use App\Models\Subscription ;
use Illuminate\Support\Facades\Auth;


class SubscriptionController extends Controller
{

    public function index ($adv_id){
        if(isset($_GET['show']) and $_GET['show'] == 1){
           $subscriptions = Subscription::where(['active' => 1])->where('price', '>', 0)->get();

        }else{
           $subscriptions = Subscription::where(['active' => 1])->get();
        }



        // dd($subscriptions ,$adv_id );

        $user = Auth::user();
        if(isset($user) && $user->Expire_Date > date('Y-m-d')){

            $advirtise = Advs::findOrFail($adv_id);
            $advirtise->update([
                'active' => 1 ,
                'subscription_id' => 8 ,
                'end_date' =>  $user->Expire_Date ,
                ]);
            return redirect()->route('advertise.show' , ['slug' => $advirtise->slug , 'id' => $advirtise->id]);


        }

        return view('site.subscription.subscriptions' , ['subscriptions' => $subscriptions , 'adv_id' => $adv_id]);
    }

}
