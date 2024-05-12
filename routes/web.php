<?php

// // use App\Http\Controllers\Site\IndexController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\PageController;
use App\Http\Controllers\Site\IndexController;
use App\Http\Controllers\Site\AdvsController;
use App\Http\Controllers\Site\SearchController;
 use App\Http\Controllers\Site\ProfileController;
use App\Http\Controllers\Site\ActionsController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\SocialAuth;
use App\Http\Controllers\Site\MembersController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
include __DIR__.'/admin.php';



Route::group([ 'middleware' => 'fix_env'], function () {


     Route::get('/',[IndexController::class,'home'])->name('home');
     Route::get('page/{id}/{title}',[IndexController::class,'page'])->name('page');
     Route::get('blacklist',[IndexController::class,'blacklist'])->name('blacklist');
     //
     Route::get('last',[AdvsController::class,'last'])->name('advs.last');
     Route::get('requests',[AdvsController::class,'requests'])->name('advs.requests');
     Route::get('country/{country}',[AdvsController::class,'country'])->name('country');
     Route::get('area/{area}',[AdvsController::class,'area'])->name('area');
     Route::get('category/{cat}/{cat_name}',[AdvsController::class,'cat'])->name('cats');
     Route::get('categories',[AdvsController::class,'cats'])->name('categories');
     Route::get('types/{name}',[AdvsController::class,'types'])->name('types');

    Route::get('search',[SearchController::class,'search'])->name('search');
    Route::get('searchdetails',[SearchController::class,'getDetails'])->name('getDetails');

    Route::get('contactus',[PageController::class,'contactus'])->name('contactus');
    Route::post('contactus',[PageController::class,'contactus']);

    Route::resource('users',ProfileController::class);


     Route::group(['middleware' => 'auth'], function () {
         Route::any('select-subscription/{adv_id}',[\App\Http\Controllers\SubscriptionController::class,'index'])->name('select.subscription');
         Route::get('users/{username}/messages',[ProfileController::class,'msgs'])->middleware('auth')->name('users.msgs');
         Route::post('updatecontacts',[ProfileController::class,'contacts'])->name('contacts');


         Route::group(['middleware' => 'active'], function () {

             Route::get('user/shop/edit', [ProfileController::class,'update'])->name('sers.shop.edit');
             Route::post('deladvs', [AdvsController::class,'remove'])->name('deladvs');

             Route::get('chat/{userid?}',[ActionsController::class,'chat'])->name('users.chat');
             Route::post('chat/{userid?}',[ActionsController::class,'chat']);

             Route::get('user/requests/{type}',[ProfileController::class,'requests'])->name('users.requests');
             Route::get('user/ads/{type?}',[ProfileController::class,'advs'])->name('users.advs');
             Route::get('user/followers/{id?}',[ProfileController::class,'follow'])->name('users.follow');
             Route::post('user/rates/{id}',[ProfileController::class,'rate2'])->name('users.rates');
             Route::get('user/rate/{id}/{type}', [ProfileController::class,'rate'])->middleware('systems:rating')->name('users.rate');
             Route::get('timeline', [ProfileController::class,'timeline'])->name('users.timeline');
             Route::get('claims/{type}', [ProfileController::class,'claims'])->name('users.claims');
             Route::get('user/joins', [ProfileController::class,'joins'])->middleware('systems:joins')->name('users.joins');

         });
         Route::get('documentation_form', [ ProfileController::class,'documentation_form'])->middleware('auth')->name('users.documentation_form');
         Route::post('documentation_form',[ ProfileController::class,'documentation_form_post'])->middleware('auth');
     });

     //Route::resource('advertise', AdvsController::class);
     Route::get('advertise/index',[AdvsController::class,'index'])->name('advertise.index');
     Route::get('advertise/create',[AdvsController::class,'create'])->name('advertise.create');
     Route::post('advertise/',[AdvsController::class,'store'])->name('advertise.store');


     Route::get('advertise/edit/{id}',[AdvsController::class,'edit'])->name('advertise.edit');
     Route::put('advertise/update/{id}',[AdvsController::class,'update'])->name('advertise.update');


     Route::get('advertise/{id}/remove', [AdvsController::class,'remove'])->name('advertise.remove');
     Route::get('advertise/{id}/complete',[AdvsController::class,'complete'])->name('advertise.complete');
     Route::get('advertise/{id}/republished',[AdvsController::class,'republished'] )->name('advertise.republished');
     Route::get('advertise/{id}/{slug}',[AdvsController::class,'show'])->name('advertise.show');
     Route::get('advertise-print/{id}', [AdvsController::class,'print'])->name('advertise.print');

     // commision
     Route::get('commision', [PageController::class,'commision'])->name('commision');
     Route::post('commision', [PageController::class,'commision_post'])->name('commision.store');
     Route::get('commision_respons', [PageController::class,'payment_callback'])->name('commision.back');
     // commision

     // Dexter
     //Route::get('commision_Dex', ['as' => 'commision_Dex', 'uses' => 'PageController@commision_Dex']);
     Route::post('commision_Dex',[PageController::class,'commision_post_Dex'])->name('store_Dex');
     Route::get('commision_respons_DEx',[PageController::class,'payment_callback_DEx'])->name('payment_callback_DEx');
     // Dexter


     Route::group(['middleware' => 'active'], function () {

         Route::get('remove-image/{id}', [AdvsController::class,'remove_image'])->name('remove-image');
         Route::get('advertise/delete/{slug}/{id}', [AdvsController::class,'destroy'])->name('advertise.destroy');
         Route::match(['get', 'post'], 'report/{title}/{comment?}', [AdvsController::class,'claim'])->middleware( 'auth')->name('advertise.claims');
         Route::match(['get', 'post'], 'mediation', [AdvsController::class, 'median'])->middleware('systems:media')->name('advertise.median');
         Route::match(['get', 'post'], 'actions/{id}/{slug}', [AdvsController::class,'actions'])->middleware('auth')->name('advertise.actions');
         Route::match(['get', 'post'], 'transfer', [PageController::class,'transfer'])->name('transfer');
         Route::get('favourites', [ActionsController::class,'likes'])->middleware('auth')->name('likes');
         Route::any('rates/{id}', [ActionsController::class,'rates'])->name('rates');
         Route::get('like/{id}/{user?}/{like?}', [ActionsController::class,'like'])->middleware('auth')->name('like');
         Route::post('bids', [ActionsController::class,'bids'])->name('bids');
         Route::post('comment', [ActionsController::class,'comment'])->middleware('auth')->name('comment');
         Route::get('list-bids', [ProfileController::class,'list_bids'])->name('list-bids');
         Route::get('notfications', [ProfileController::class,'notfs'])->name('user.notfs');
     });

     Route::get('joins', [PageController::class,'joins'])->middleware('systems:joins')->name('joins');
     Route::match(['get', 'post'], 'joins/request/{type}', [PageController::class,'getjoins' ])->middleware('systems:joins','active')->name('joins.request');
     Route::get('banking', [PageController::class,'banking'])->name('banking');
     Route::get('error/{type?}', [PageController::class,'error'])->name('errors');

     Route::get('get-areas/{country_id}', [ActionsController::class,'getAreas'])->name('get-areas');
     Route::get('by-location/{country_id}/{area_id}', [AdvsController::class,'byLocation'])->name('get-areas2');
});

Route::get('getDetails', [\App\Http\Controllers\Admin\AdvsController::class,'getDetails'])->name('getDetails1');


Route::get('getDetailsJson', [\App\Http\Controllers\Admin\AdvsController::class,'getDetailsJson'])->name('getDetailsJson');


// Admin



Route::get('/sendMail', function () {
    // the message
    $to = "fenix.p2h@hotmail.com";
    $subject = "My subject";
    $txt = "Hello world!";
    $headers = "From: team@ardhwatalab.com" . "\r\n" .
        "CC: fenix.p2h@hotmail.com";

    mail($to, $subject, $txt, $headers);

    $user = App\Models\User::findOrFail(159);

    \Mail::send('auth.login', ['user' => $user], function ($m) use ($user) {
        $m->from('team@ardhwatalab.com', 'Dexter');

        $m->to($user->email, $user->username)->subject('Your Reminder!');
    });
    echo 'done';


});


Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
        Artisan::call('optimize:clear');
        //Artisan::call('optimize');

        system('composer dump-autoload');
        Artisan::call('optimize:clear');



    return 'Application cache cleared';
});


Route::get('/imageresize/medium/{photo}', function ($photo) {
    $photo_hash = md5($photo);
    $imagee = new Intervention\Image\ImageManagerStatic;
    if (!Cache::has($photo_hash)) {
        $image_encode = (string)$imagee->make(public_path($photo))
            ->resize(200, 200)
            ->encode('png', 100);
        Cache::forever($photo_hash, $image_encode);
    }
    header("Content-type: image/png");
    header('Expires: Wed, 21 Oct 2099 07:28:00 GMT');
    echo (string)Cache::get($photo_hash);
    die;
})->name('SPhone')->where('photo', '.*');

Route::get('dayleftcron' , function (){
    $advs = App\Advs::where('active' , 1)->where('end_date' , "<=" , Carbon::now()->addDays(1))->get();
    // dd($advs);
    if (count($advs) < 1){
        return "no items" ;

    }
    foreach($advs as $adv){
        //   dd(Carbon::now()->diffInDays($adv->end_date));
        if(Carbon::now()->diffInDays($adv->end_date) == 1){
            Notfs::create([

                'user_id'        => $adv->user_id,
                'link' =>  route('select.subscription', ['adv_id' => $adv->id]),

                'text'   => "
            	        عمينا العزيز نفيدكم بأن مدة الاعلان رقم $adv->id ستنتهي خلال يوم من الوقت المحدد أدناه وتفادياً لإيقاف الاعلان يمكنكم تجديد الاشتراك بالضغط هنا
            	        "
            ]);
            echo "1 day later for advs id $adv->id <br>" ;
        }
        else{
            echo 'no item dey left';
        }
    }
});

Route::get("testcrone" , function(){
    $advs = App\Advs::where('active' , 1)->where('end_date' , "<=" , Carbon::now()->addDays(2))->get();
    foreach($advs as $adv){
        //   dd(Carbon::now()->diffInDays($adv->end_date));

        if(Carbon::now()->gte($adv->end_date)){
            Notfs::create([

                'user_id'        => $adv->user_id,
                'link' =>  route('select.subscription', ['adv_id' => $adv->id]),
                'text'   => "
            	        عميلنا العزيز نفيدكم علماً بأنه تم ايقاف الاعلان الخاص بكم ورقمه $adv->id للتجديد اضغط هنا
            	        "
            ]);
            $adv->update([
                'active' => 0 ,
            ]);
            echo "adv {$adv->id} is inactive <br>" ;
        }
        else{
            echo "no item active <br>" ;
        }
    }

});

Route::get('/members', [MembersController::class,'index'])->middleware('auth')->name('select-members');


Route::group(['middleware' => 'guest', 'namespace' => 'Auth'], function () {
    // Authentication Routes...
    Route::get('/login',[AuthController::class,'login'])->name('login');
    Route::post('/login',[AuthController::class,'login']);

    Route::get('/signup',[AuthController::class,'signup'])->name('signup');
    Route::post('/signup',[AuthController::class,'signup']);

    Route::get('oauth/login/{driver}',[SocialAuth::class,'getSocialAuth'])->name('slogin');
    Route::get('oauth/callback',[SocialAuth::class,'callback'])->name('callback');
    Route::view('password/reset','auth.passwords.email');
    Route::post('password_reset',[AuthController::class,'password_reset'])->name('password_reset');

    Route::get('password/reset/{token}',[AuthController::class,'reset_password'])->name('reset_password');


});

Route::get('users/active',[AuthController::class,'user_active'])->name('users.active');
Route::post('users/active',[AuthController::class,'user_active']);

Route::get('logout',[AuthController::class,'logout'])->middleware('auth')->name('logout');
Route::get('active/{id}/{token}',[AuthController::class,'active'])->name('auth.active');



Route::get('lawyer_logout', function () {
    auth('lawyer')->logout();
    return redirect()->to('/');
});


//Auth::routes();
