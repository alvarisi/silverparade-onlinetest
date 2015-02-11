<?php

class CompetitionController extends BaseController {

	public function index()
	{
		$content = Competition::orderBy('id','desc')->get();
		return View::make('page.officer.competition')
			->with('title','Daftar Kompetisi')
			->with('content',$content);
	}
	public function create()
	{
		return View::make('page.officer.competitionform')
			->with('content',null)
			->with('title','Tambah Kompetisi')
		;
	}

	public function store()
	{
		$name = Input::get('name');
		Competition::create([
			'name' => $name
		]);
		Session::flash('success','Data berhasil ditambahkan');
		return Redirect::back();
	}

	public function edit($id)
	{
		$content = Competition::find($id);
		return View::make('page.officer.competitionform')
			->with('content',$content)
			->with('title','Edit Kompetisi')
		;
	}

	public function update($id)
	{
		$content = Competition::find($id);
		$content->name = Input::get('name');
		$content->save();
		Session::flash('success','Data berhasil diperbarui');
		return Redirect::back();
	}
}
