<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}
        
        public function getIndex()
        {
            $this->layout = View::make('frontend\layouts\index-home');
            $this->layout->title = trans('syntara::all.frontend.home');
            $this->layout->breadcrumb = Config::get('syntara::breadcrumbs.home');
        }

}
