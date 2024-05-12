<?php
//use App\Http\Controllers\Admin\IndexController;

Route::group(['middleware' => ['auth', 'admin'], 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('/', '\App\Http\Controllers\Admin\IndexController@home')->name('admin');
    Route::post('remove', ['as' => 'admin.remove', 'uses' =>'\App\Http\Controllers\Admin\IndexController@remove']);
    Route::group(['prefix' => 'config'], function () {
    Route::match(['get', 'post'], '/', ['as' => 'admin.site_config', 'uses' =>'\App\Http\Controllers\Admin\IndexController@site_config']);

        Route::match(['get', 'post'], 'lawsuit_txt', ['as' => 'admin.lawsuit_txt', 'uses' =>'\App\Http\Controllers\Admin\IndexController@lawsuit_txt']);
        Route::match(['get', 'post'], 'contacts', ['as' => 'admin.contacts', 'uses' =>'\App\Http\Controllers\Admin\IndexController@contacts']);
        Route::match(['get', 'post'], 'contactus', ['as' => 'admin.contactus', 'uses' =>'\App\Http\Controllers\Admin\IndexController@contactus']);
        Route::match(['get', 'post'], 'aboutus', ['as' => 'admin.aboutus', 'uses' =>'\App\Http\Controllers\Admin\IndexController@aboutus']);
        Route::match(['get', 'post'], 'apps', ['as' => 'admin.apps', 'uses' =>'\App\Http\Controllers\Admin\IndexController@apps']);
        Route::match(['get', 'post'], 'systems', ['as' => 'admin.systems', 'uses' =>'\App\Http\Controllers\Admin\IndexController@systems']);
        Route::match(['get', 'post'], 'mail', ['as' => 'admin.mail', 'uses' =>'\App\Http\Controllers\Admin\IndexController@mail']);
        Route::match(['get', 'post'], 'sms', ['as' => 'admin.sms', 'uses' =>'\App\Http\Controllers\Admin\IndexController@sms']);
        Route::match(['get', 'post'], 'close', ['as' => 'admin.close', 'uses' =>'\App\Http\Controllers\Admin\IndexController@close']);
    });
    Route::match(['get', 'post'], 'commissions', ['as' => 'admin.commissions', 'uses' => '\App\Http\Controllers\Admin\CommissionsController@index']);
    Route::match(['get', 'post'], 'advs_config/{view}', ['as' => 'admin.advs.config', 'uses' =>'\App\Http\Controllers\Admin\IndexController@advs_config']);


    Route::get('advs/{adv}/rePublic','\App\Http\Controllers\Admin\AdvsController@rePublic')->name('admin.advs.rePublic');
    Route::get('admin.advs.index','\App\Http\Controllers\Admin\AdvsController@index')->name('admin.advs.index');
    Route::get('admin.advs.show/{adv}','\App\Http\Controllers\Admin\AdvsController@show')->name('admin.advs.show');

    Route::get('advs/{adv}/pdf','\App\Http\Controllers\Admin\AdvsController@pdf')->name('admin.advs.pdf')->where('adv','[0-9]+');


    // Dexter
    // Message
    Route::get ('/Message','\App\Http\Controllers\Admin\IndexController@site_Message')->name('message');
    Route::post('/Message','\App\Http\Controllers\Admin\IndexController@site_Message');
    // Members
    // add new members
    Route::get ('members/new','\App\Http\Controllers\Admin\MembersController@CreateNew')->name('CreateMember');
    Route::post('members/new','\App\Http\Controllers\Admin\MembersController@CreateNew');

    // View members
    Route::get ('members/manage','\App\Http\Controllers\Admin\MembersController@ManageMember')->name('ManageMember');
    // Edit
    Route::get ('members/edit/{id}','\App\Http\Controllers\Admin\MembersController@EditMember')->name('EditMember');
    Route::post('members/edit/{id}','\App\Http\Controllers\Admin\MembersController@EditMember');
    // Delete
    Route::get ('members/remove/{id}','\App\Http\Controllers\Admin\MembersController@RemoveMember')->name('RemoveMember');

    // Dexter


    Route::resource('advs','\App\Http\Controllers\Admin\AdvsController');
    //    Route::get('getDetails', ['as' => 'getDetails', 'uses' =>'\App\Http\Controllers\Admin\AdvsController@getDetails']);
    Route::resource('depts','\App\Http\Controllers\Admin\DeptsController');

    Route::resource('props','\App\Http\Controllers\Admin\PropsController');
    Route::resource('titles','\App\Http\Controllers\Admin\TitlesController');
    Route::get('getProps', ['as' => 'admin.getprops', 'uses' =>'\App\Http\Controllers\Admin\PropsController@getProps']);
    Route::get('getTitles', ['as' => 'admin.gettitles', 'uses' =>'\App\Http\Controllers\Admin\PropsController@getTitles']);
    Route::post('delPropTypes', ['as' => 'admin.proptypes.delete', 'uses' =>'\App\Http\Controllers\Admin\PropsController@delPropTypes']);
    Route::resource('pages','\App\Http\Controllers\Admin\PagesController');
    Route::get ('pages.index','\App\Http\Controllers\Admin\PagesController@index')->name('admin.pages.index');
    Route::get ('pages.create','\App\Http\Controllers\Admin\PagesController@create')->name('admin.pages.create');
    Route::resource('operations','\App\Http\Controllers\Admin\OperationsController');
    Route::resource('peroids', 'PeroidsController');
    Route::resource('country','\App\Http\Controllers\Admin\CountryController');
    Route::resource('area','\App\Http\Controllers\Admin\AreaController');
    Route::resource('paymethods', '\App\Http\Controllers\Admin\PaymethodsController');
    Route::resource('currency', 'CurrencyController');
    Route::resource('jointypes', 'JointypesController');
    Route::resource('posters', 'PostersController');
    Route::resource('sliders', 'SlidersController');
    Route::resource('users', '\App\Http\Controllers\Admin\UserController');
    Route::get ('users.index', '\App\Http\Controllers\Admin\UserController@index')->name('admin.users.index');
    Route::get ('users.create', '\App\Http\Controllers\Admin\UserController@create')->name('admin.users.create');
    Route::post ('users.store', '\App\Http\Controllers\Admin\UserController@store')->name('admin.users.store');
    Route::get ('users.edit/{id}', '\App\Http\Controllers\Admin\UserController@edit')->name('admin.users.edit');
    Route::put ('users.update/{id}', '\App\Http\Controllers\Admin\UserController@update')->name('admin.users.update');
    Route::get('user/joins/requests', ['as' => 'admin.users.requests', 'uses' => '\App\Http\Controllers\Admin\UserController@requests']);
    Route::resource('roles', '\App\Http\Controllers\Admin\RolesController');
    Route::get('pays', ['as' => 'admin.pays', 'uses' =>'\App\Http\Controllers\Admin\IndexController@pays']);
    //Route::get('jobs', ['as' => 'admin.jobs', 'uses' =>'\App\Http\Controllers\Admin\IndexController@jobs'])->name('admin.jobs');
    Route::get('jobs', [IndexController::class,'jobs'])->name('admin.jobs');
    Route::get('contactus', ['as' => 'admin.contactus', 'uses' =>'\App\Http\Controllers\Admin\IndexController@contactus']);
    Route::get('bankTransfer', '\App\Http\Controllers\Admin\BankTransferController@index')->name('bankTransfer');
    Route::get('claim', '\App\Http\Controllers\Admin\ClaimController@index')->name('admin.claim');
    //reports
    Route::get('/reports/users', '\App\Http\Controllers\Admin\ReportesController@users')->name('admin.reports.users');
    Route::get('/reports/advs', '\App\Http\Controllers\Admin\ReportesController@advs')->name('admin.reports.advs');
    Route::get('/reports/orders', '\App\Http\Controllers\Admin\ReportesController@orders')->name('admin.reports.orders');


    // Send Notifcation
    Route::get('/notifcation', '\App\Http\Controllers\Admin\NotifcationController@index')->name('admin.notifcation.index');
    Route::post('/notifcation', '\App\Http\Controllers\Admin\NotifcationController@store')->name('admin.notifcation.store');


    Route::get('/getDetailss', function() {
        if(request()->has('country')) {
            $lists = \App\Models\Area::where(['country_id'=>request('country')])->get();
            return view('ajax.area')->with(['area'=>$lists])->render();
        }
        if(request()->has('area')) {
            // dd(request('area'));
            $lists = \App\Models\Lawyer::where(['area_id'=>request('area'),'status'=>1])->get();
            return view('ajax.lawyerss')->with(['lists'=>$lists])->render();
        }
        return '';
    });

    // AreaLawyers



    // Documentation Form Catgeories
    Route::get('/documentation/category', '\App\Http\Controllers\Admin\DocumentationCatgeoryController@index')->name('admin.documentation.category.index');
    Route::get('/documentation/category/create', '\App\Http\Controllers\Admin\DocumentationCatgeoryController@create')->name('admin.documentation.category.create');
    Route::post('/documentation/category/create', '\App\Http\Controllers\Admin\DocumentationCatgeoryController@store')->name('admin.documentation.category.store');
    Route::get('/documentation/category/{category}/edit', '\App\Http\Controllers\Admin\DocumentationCatgeoryController@edit')->name('admin.documentation.category.edit')->where('category','[0-9]+');;
    Route::put('/documentation/category/{category}/update', '\App\Http\Controllers\Admin\DocumentationCatgeoryController@update')->name('admin.documentation.category.update')->where('category','[0-9]+');;

    // Documentation Form
    Route::get('/documentation', '\App\Http\Controllers\Admin\DocumentationController@index')->name('admin.documentation.index');
    Route::get('/documentation/{documentation}/show', '\App\Http\Controllers\Admin\DocumentationController@show')->name('admin.documentation.show')->where('documentation','[0-9]+');
    Route::get('/documentation/{documentation}/edit', '\App\Http\Controllers\Admin\DocumentationController@edit')->name('admin.documentation.edit')->where('documentation','[0-9]+');
    Route::put('/documentation/{documentation}/update', '\App\Http\Controllers\Admin\DocumentationController@update')->name('admin.documentation.update')->where('documentation','[0-9]+');
    Route::get('/documentation/{documentation}/activeted', '\App\Http\Controllers\Admin\DocumentationController@activeted')->name('admin.documentation.activeted')->where('documentation','[0-9]+');


    // subscriptions Form Catgeories
    Route::get('/subscriptions', '\App\Http\Controllers\Admin\SubscriptionController@index')->name('admin.subscription.index');
    Route::get('/subscriptions/create', '\App\Http\Controllers\Admin\SubscriptionController@create')->name('admin.subscription.create');
    Route::post('/subscriptions/create', '\App\Http\Controllers\Admin\SubscriptionController@store')->name('admin.subscription.store');
    Route::get('/subscriptions/edit/{subscription}', '\App\Http\Controllers\Admin\SubscriptionController@edit')->name('admin.subscription.edit');
    Route::post('/subscriptions/edit/{subscription}', '\App\Http\Controllers\Admin\SubscriptionController@update')->name('admin.subscription.update');
    Route::get('/subscriptions/delete/{subscription}', '\App\Http\Controllers\Admin\SubscriptionController@delete')->name('admin.subscription.delete');

    Route::fallback(function () {
        return redirect('/admin');
    });
});
