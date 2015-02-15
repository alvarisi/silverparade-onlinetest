<?php

class TestController extends BaseController {

	public function participant()
	{
		if(Request::isMethod('get'))
		{
			$data['categories'] = Category::all();
			return View::make('page.officer.participant')
				->with('content',null)
				->with('data',$data)
				->with('title','Daftar Partisipan Tes');
		}else{
			$data['categories'] = Category::all();
			$sesi = Input::get('tr_sesi_id');
			$content['sesi'] = Sesi::with('categories','users','usersesi','usersesi.user')->find($sesi);
			if(empty($content['sesi']->users->toArray())){
				$content['users'] = Role::with('users')->whereName('user')->first()->users;
			}else{
				$x = Role::with('users')->whereName('user')->first();
				$content['users'] = User::whereNotIn('id',$content['sesi']->users->lists('id'))->whereIn('id',$x->users->lists('id'))->get();
			};
			// $content['users'] = Sesi::with('users')->
			return View::make('page.officer.participant')
				->with('content',$content)
				->with('data',$data)
				->with('title','Daftar Partisipan Tes');
		}
	}

	public function result()
	{
		if(Request::isMethod('get'))
		{
			$data['categories'] = Category::all();
			return View::make('page.officer.result')
				->with('content',null)
				->with('data',$data)
				->with('title','Hasil Tes');
		}else{
			$data['categories'] = Category::all();
			$sesi = Input::get('tr_sesi_id');
			$content['sesi'] = Sesi::with('categories','usersesi','usersesi.user','usersesi.logsesi','usersesi.logsesi.answers','usersesi.logsesi.answers.question')->find($sesi);
			// $content['users'] = Sesi::with('users')->
			return View::make('page.officer.result')
				->with('content',$content)
				->with('data',$data)
				->with('title','Hasil Tes');
		}
	}

	public function getSession()
	{
		$x = Input::get('x');
		$data = Sesi::where('ms_categories_id',$x)->get();
		return Response::json($data);
	}
	
	public function store()
	{
		$user = Input::get('ms_users_id');
		$sesi = Input::get('tr_sesi_id');
		$a=User::find($user);
		$a->sesi()->attach($sesi);
		Session::flash('success','Data berhasil ditambahkan');
		$data['categories'] = Category::all();
		$content['sesi'] = Sesi::with('categories','users')->find($sesi);
		if(empty($content['sesi']->users->toArray())){
			$content['users'] = Role::with('users')->whereName('user')->first()->users;
		}else{
			$x = Role::with('users')->whereName('user')->first();
				$content['users'] = User::whereNotIn('id',$content['sesi']->users->lists('id'))->whereIn('id',$x->users->lists('id'))->get();
		};
		// $content['users'] = Sesi::with('users')->
		return View::make('page.officer.participant')
			->with('content',$content)
			->with('data',$data)
			->with('title','Daftar Partisipan Tes');
	}

	public function testlist(){
		$content = User::with('usersesi','usersesi.logsesi','usersesi.sesi','usersesi.sesi.categories')->find(Auth::id());
		return View::make('page.user.testlist')
			->with('content',$content)
			->with('title','Daftar Tes');
	}
	public function goTest($id=null)
	{
		if(!empty($id))
		{
			date_default_timezone_set('Asia/Jakarta');
			$content = Usersesi::with('logsesi','logsesi.answers','sesi','sesi.categories')->find($id);
			$date = strtotime($content->sesi->mulai);
			$mulai = date('Y-m-d H:i:s',$date);
			$date = strtotime($content->sesi->selesai);
			$selesai = date('Y-m-d H:i:s',$date);

			if($mulai < date('Y-m-d H:i:s') && $selesai > date('Y-m-d H:i:s'))
			{
				
			}else{
				// echo $mulai."<br>";
				// echo date('Y-m-d H:i:s')."<br>";
				// // echo $selesai;
				// dd($selesai);
				return Redirect::to('user/test/list');
			}

			if($content->logsesi()->count()>0)
			{
				if($content->logsesi->selesai != '0000-00-00 00:00:00')
				{
					return Redirect::to('user/test/list');
				}
				// return Redirect::back();
			}
			
			return View::make('page.user.testlanding')
			->with('content',$content)
			->with('title','Informasi Tes');
		}
	}
	public function execute($id)
	{
		if(!empty($id))
		{
			if(Request::isMethod('get'))
			{
				date_default_timezone_set('Asia/Jakarta');
				$lg = Usersesi::with('logsesi','sesi')->find($id);
				$date = strtotime($lg->sesi->mulai);
				$mulai = date('Y-m-d H:i:s',$date);
				$date = strtotime($lg->sesi->selesai);
				$selesai = date('Y-m-d H:i:s',$date);
				if($mulai > date('Y-m-d H:i:s') || $selesai > date('Y-m-d H:i:s'))
				{

				}else{
					Redirect::to('user/test/list');
				}
				if($lg->logsesi()->count()==0)
				{
					Logsesi::create([
						'tr_usersesi_id' => $id,
						'mulai' => date('Y-m-d H:i:s')
					]);
				}else{
					if($lg->logsesi->selesai != '0000-00-00 00:00:00')
					{
						return Redirect::to('user/test/list');
					}
				}
				$content = Usersesi::with('logsesi','logsesi.answers','sesi','sesi.categories','sesi.categories.questions','sesi.categories.questions.choices')->find($id);
				return View::make('page.user.testexecute')
				->with('content',$content)
				->with('title','Tes : '.$content->sesi->categories->name);	
			}else{
				date_default_timezone_set('Asia/Jakarta');
				$lg=Usersesi::with('logsesi','sesi','sesi.categories','sesi.categories.questions','sesi.categories.questions.choices')->find($id);
				$lg->logsesi->selesai= date('Y-m-d H:i:s');
				$lg->logsesi->save();
				foreach ($lg->sesi->categories->questions as $row) {
					$answer = Input::get($row->id);
					if(!empty($answer))
					{
						Answer::create([
							'tr_logsesi_id' => $lg->logsesi->id,
							'ms_questions_id' => $row->id,
							'answer' => $answer
						]);
					}
				}
				Session::flash('success','Jawaban anda telah tersimpan');
				return Redirect::to('user/test/list');
			}
		}
	}
	public function destroy($id=null)
	{
		if(!empty($id))
		{
			$usersesi = Usersesi::with(
					'logsesi',
					'logsesi.answers'
					)->find($id);
			if($usersesi->logsesi()->count() > 0)
			{
				foreach ($usersesi->logsesi->answers as $vv) {
					$vv->delete();
				}
				$usersesi->logsesi->delete();	
			}
			$usersesi->delete();
			Session::flash('success','Data berhasil dihapus');
			return Redirect::to('test/participant');
		}
	}
}