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
	public function destroy($id=null)
	{
		if(!empty($id))
		{
			$competition = Competition::with('categories',
					'categories.questions',
					'categories.questions.choices',
					'categories.questions.answers',
					'categories.sesi',
					'categories.sesi.usersesi',
					'categories.sesi.usersesi.logsesi'
					)->find($id);
			foreach ($competition->categories as $row) {
				foreach ($row->questions as $val) {
					foreach ($val->choices as $v) {
						$v->delete();
					}
					foreach ($val->answers as $v) {
						$v->delete();
					}
					if(File::exists('upload/question/'.$val->file))
					File::delete('upload/question/'.$val->file);
					$val->delete();
				}
				foreach ($row->sesi as $val) {
					foreach ($val->usersesi as $v) {
						$v->logsesi->delete();
						$v->delete();
					}
					$val->delete();
				}
				$row->delete();
			}
			$competition->delete();

			Session::flash('success','Data berhasil dihapus');
			return Redirect::back();
		}
	}
}
