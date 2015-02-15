<?php
use Helpers\ExcelHelper;
use Helpers\validators\Validator;

class UserController extends BaseController {

	public function listUser($type = 'user')
	{
		$content = Role::with('users')->whereName($type)->first();
		return View::make('page.officer.userlist')
			->with('title','Daftar User')
			->with('content',$content);
	}

	public function create($type = 'user')
	{
		if($type == 'user')
		{
			return View::make('page.officer.userform')
				->with('title','Tambah user')
				;
		}
	}

	public function store($type = 'user')
	{
		$role = Role::where('name',$type)->first();
		$en = Input::get('enabled');
		if(empty($en))
			$en='';
		$id = User::where('username',Input::get('username'))->first();
		if(empty($id)){
			$user = User::create([
				'name' => Input::get('name'),
				'username' => Input::get('username'),
				'password' => Hash::make(Input::get('password')),
				'email' => Input::get('email'),
				'enabled' => $en
			]);

			$user->roles()->attach($role->id);
			Session::flash('success','Data berhasil ditambahkan');	
		}else{
			Session::flash('failed','Duplikasi username.');	
		}
		
		return Redirect::back();
	}

	public function edit($id=null)
	{
		$content = User::find($id);
		return View::make('page.officer.userform')
		->with('title','Edit Pengguna')
		->with('content',$content)
		;
	}
	public function update($id=null)
	{
		$content = User::find($id);
		$en = Input::get('enabled');
		if(empty($en))
			$content->enabled = '';
		else
			$content->enabled = '1';
		$content->name = Input::get('name');
		$content->email = Input::get('email');
		$content->save();

		return View::make('page.officer.userform')
		->with('title','Edit Pengguna')
		->with('content',$content)
		;
	}
	public function reset($id=null)
	{
		$user = User::find($id);
		$user->password = Hash::make($user->username);
		$user->save();
		Session::flash('success','Password berhasil di reset.(sama dengan username)');
		return Redirect::back();
	}

	public function index()
	{
		$user = User::find(Auth::id());
		return View::make('page.user.index')
			->with('title','Selamat Datang')
			->with('content',$user);
	}

	public function account()
	{
		$user = User::with('roles')->find(Auth::id());
		if($user->hasRole('user'))
		{
			return View::make('page.user.account')
			->with('title','Informasi Akun Anda')
			->with('content',$user);
		}elseif($user->hasRole('officer'))
		{
			return View::make('page.officer.account')
			->with('title','Informasi Akun Anda')
			->with('content',$user);
		}
	}
	public function selfedit()
	{
		$user = User::with('roles')->find(Auth::id());
		if($user->hasRole('user'))
		{
			
			if(Request::isMethod('get'))
			{
				return View::make('page.user.selfuserform')
				->with('title','Edit Akun Anda')
				->with('content',$user);
			}else{
				$user->name = Input::get('name');
				$user->email = Input::get('email');
				$user->save();
				Session::flash('success','Data berhasil diperbarui');
				return Redirect::back();
			}
		}
		elseif($user->hasRole('officer'))
		{
			if(Request::isMethod('get'))
			{
				return View::make('page.officer.selfuserform')
				->with('title','Edit Akun Anda')
				->with('content',$user);	
			}else{
				$user->name = Input::get('name');
				$user->email = Input::get('email');
				$user->save();
				Session::flash('success','Data berhasil diperbarui');
				return Redirect::back();
			}
		}	
	}
	public function change()
	{
		$user = User::with('roles')->find(Auth::id());
		if($user->hasRole('user'))
		{
			
			if(Request::isMethod('get'))
			{
				return View::make('page.user.change')
				->with('title','Edit Akun Anda')
				->with('content',$user);
			}else{
				$password = Input::get('password');
				if(!Hash::check($password,$user->password))
				{
					Session::flash('failed','Password lama anda salah!');
					return Redirect::back();
				}
				$user->password = Hash::make(Input::get('npassword'));
				$user->save();
				Session::flash('success','Data berhasil diperbarui');
				return Redirect::back();
			}
		}
		elseif($user->hasRole('officer'))
		{
			if(Request::isMethod('get'))
			{
				return View::make('page.officer.change')
				->with('title','Ubah Password')
				->with('content',$user);	
			}else{
				$password = Input::get('password');
				if(!Hash::check($password,$user->password))
				{
					Session::flash('failed','Password lama anda salah!');
					return Redirect::back();
				}
				$user->password = Hash::make(Input::get('npassword'));
				$user->save();
				Session::flash('success','Data berhasil diperbarui');
				return Redirect::back();
			}
		}	
	}
	public function excel()
	{
		if(Request::isMethod('get'))
		{
			return View::make('page.officer.userupload')
				->with('title','Upload user');
		}else{
			$impors= new ExcelHelper(Input::file('file'));
        
	        $data=$impors->get();
	        foreach ($data as $row) {
	        	$id = User::where('username',$row->username)->first();
	        	if(empty($id))
	        	{
	        		$a = User::create([
		        		'nama' => $row->nama,
		        		'username' => $row->username,
		        		'password' => Hash::make($row->password),
		        		'email' => $row->email,
		        		'enabled' => '1',
		        	]);
		        	$a->roles()->attach(3);
	        	}else{
	        		Session::flash('failed',"Duplikasi username '".$row->username."'");
					return Redirect::back();
	        	}
	        	
	        }
	        Session::flash('success','Data berhasil ditambahkan');
			return Redirect::back();
		}
	}
	public function destroy($id=null)
	{
		if(!empty($id))
		{
			$user = User::with(
					'usersesi',
					'usersesi.logsesi',
					'usersesi.logsesi.answers'
					)->find($id);
			
			foreach ($user->usersesi as $v) {
				if($v->logsesi()->count())
				{
					foreach ($v->logsesi->answers as $vv) {
						$vv->delete();
					}
					$v->logsesi->delete();
				}
				
				$v->delete();
			}
			$user->delete();

			Session::flash('success','Data berhasil dihapus');
			return Redirect::back();
		}
	}

}
