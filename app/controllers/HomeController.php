<?php

class HomeController extends BaseController {

	public function index()
	{
		Auth::viaRemember();
		if(Auth::check())
		{
			$user = User::find(Auth::id());
			if($user->hasRole('admin'))
			{
				return Redirect::route('admin');
			}elseif ($user->hasRole('officer')) {
				return Redirect::route('officer');
			}elseif ($user->hasRole('user')) {
				return Redirect::route('user');
			}
		}else{
			return View::make('page.login')->with('title','Selamat Datang');
		}
	}

	public function login()
	{
		$username = Input::get('username');
		$password = Input::get('password');
		$remember_me = false;
		if(Input::get('remember_me') == '1')
		{
			$remember_me = true;
		}

		if(Auth::attempt(array('username' => $username, 'password' => $password,'enabled' => '1'), $remember_me))
		{
			return Redirect::route('home');
		}else{
			return Redirect::route('home')->with('failed','Login Gagal.');
		}
	}

	public function logout()
	{
		Auth::logout();
		return Redirect::route('home');
	}
}
