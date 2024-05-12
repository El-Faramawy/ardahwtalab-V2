<?php 

namespace App\Http\Controllers;


use App\Http\Requests;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{

    public function index (){
        return view('site.booking.bokings');
    }

}