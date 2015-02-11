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

	public function destroy()
	{
		
		return Redirect::back();	
	}
	public function edit($id)
	{
		$competition = Competition::all();
		$content = Category::with('competitions')->find($id);
		return View::make('page.officer.categoryform')
			->with('content',$content)
			->with('competition',$competition)
			->with('title','Edit Kategori')
		;
	}
	public function update($id)
	{
		$content = Category::find($id);
		$content->name = Input::get('name');
		$content->description = Input::get('description');
		$content->ms_competitions_id = Input::get('ms_competitions_id');
		$content->save();
		Session::flash('success','Data berhasil diperbarui');
		return Redirect::back();
	}
}
