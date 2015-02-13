<?php

class SesiController extends BaseController {

	public function index()
	{
		$content = Sesi::with('categories')->get();
		return View::make('page.officer.sesi')
			->with('title','Daftar Sesi Tes')
			->with('content',$content);
	}
	public function create()
	{
		$category = Category::all();
		return View::make('page.officer.sesiform')
			->with('content',null)
			->with('category',$category)
			->with('title','Tambah Sesi Tes')
		;
	}

	public function store()
	{
		$name = Input::get('name');
		$mulai = Input::get('mulai');
		$selesai = Input::get('selesai');

		$category = Input::get('ms_categories_id');
		Sesi::create([
			'name' => $name,
			'mulai' => $mulai,
			'selesai' => $selesai,
			'ms_categories_id' => $category,
		]);
		Session::flash('success','Data berhasil ditambahkan');
		return Redirect::back();
	}

	public function destroy($id=null)
	{
		if(!empty($id))
		{
			$sesi = Sesi::with(
					'usersesi',
					'usersesi.logsesi',
					'usersesi.logsesi.answers',
					)->find($id);
			
			foreach ($sesi->usersesi as $v) {
				foreach ($v->logsesi->answers as $vv) {
					$vv->delete();
				}
				$v->logsesi->delete();
				$v->delete();
			}
			$sesi->delete();

			Session::flash('success','Data berhasil dihapus');
			return Redirect::back();
		}
	}

	public function edit($id)
	{
		$category = Category::all();
		$content = Sesi::with('categories')->find($id);
		return View::make('page.officer.sesiform')
			->with('content',$content)
			->with('category',$category)
			->with('title','Edit Tes Sesi')
		;
	}
	public function update($id)
	{
		$content = Sesi::find($id);
		$content->name = Input::get('name');
		$content->ms_categories_id = Input::get('ms_categories_id');
		$content->mulai = Input::get('mulai');
		$content->selesai = Input::get('selesai');
		$content->save();
		Session::flash('success','Data berhasil diperbarui');
		return Redirect::back();
	}
}
