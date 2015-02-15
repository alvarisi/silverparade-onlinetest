<?php

class CategoryController extends BaseController {

	public function index()
	{
		$content = Category::orderBy('id','desc')->with('competitions')->get();
		return View::make('page.officer.category')
			->with('title','Daftar Kategori')
			->with('content',$content);
	}
	public function create()
	{
		$competition = Competition::all();
		return View::make('page.officer.categoryform')
			->with('content',null)
			->with('competition',$competition)
			->with('title','Tambah Kategori')
		;
	}

	public function store()
	{
		$name = Input::get('name');
		$description = Input::get('description');
		$competition = Input::get('ms_competitions_id');
		Category::create([
			'name' => $name,
			'description' => $description,
			'ms_competitions_id' => $competition,
		]);
		Session::flash('success','Data berhasil ditambahkan');
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

	public function destroy($id=null)
	{
		if(!empty($id))
		{
			$category = Category::with(
					'questions',
					'questions.choices',
					'questions.answers',
					'sesi',
					'sesi.usersesi',
					'sesi.usersesi.logsesi'
					)->find($id);
			
			foreach ($category->questions as $val) {
				foreach ($val->choices as $v) {
					$v->delete();
				}
				foreach ($val->answers as $v) {
					$v->delete();
				}
				$val->delete();
			}
			foreach ($category->sesi as $val) {
				foreach ($val->usersesi as $v) {
					$v->logsesi->delete();
					$v->delete();
				}
				$val->delete();
			}
			$category->delete();

			Session::flash('success','Data berhasil dihapus');
			return Redirect::back();
		}
	}
	public function getDescription()
	{
		$x = Input::get('x');
		$category = Category::find($x);
		return Response::json($category);
	}
}
