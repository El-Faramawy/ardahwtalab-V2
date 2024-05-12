<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Subscription;


class SubscriptionController extends Controller{
    public function index(){
        // return "asads" ;
        $subscriptions = Subscription::paginate(10);
        return view('admin.subscription.index' , ['subscriptions' => $subscriptions]);
    }
    public function create(){
        return view('admin.subscription.create');
    }
    public function store(Request $request){
        // dd(\request()->all());
        $request['active'] = $request['active'] ? "1" : "0" ;
        $this->validate($request , [
            'title' => ['required'] ,
            'description' => ['required'] ,
            'price' => ['required'] ,
            'duration' => ['required'] ,
            ]);
        // $data = \request()->validate([
        //     'title' => ['required'] ,
        //     'description' => ['required'] ,
        //     'price' => ['required'] ,
        //     'duration' => ['required'] ,
        // ]);
        // dd($request->all());
        Subscription::create($request->all());

        return redirect()->route('admin.subscription.index');
    }
    public function edit(Subscription $subscription){
        return view('admin.subscription.edit' , ['subscription' => $subscription]);
    }

    public function update(Request $request , Subscription $subscription){
        $request['active'] = $request['active'] ? "1" : "0" ;
        $this->validate($request , [
            'title' => ['required'] ,
            'description' => ['required'] ,
            'price' => ['required'] ,
            'duration' => ['required'] ,
            ]);
            // dd($request->all());
            $subscription->update($request->all());
            return redirect()->route('admin.subscription.index');

    }
        public function delete(Subscription $subscription){
            $subscription->delete();
            return redirect()->route('admin.subscription.index');}

}
