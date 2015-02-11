<?php

class QuestionController extends BaseController {

	public function index()
	{
		$content = Question::orderBy('id','desc')->with('categories')->get();
		return View::make('page.officer.question')
			->with('title','Daftar Pertanyaan')
			->with('content',$content);
	}
	public function create()
	{
		$category = Category::all();
		return View::make('page.officer.questionform')
			->with('content',null)
			->with('category',$category)
			->with('title','Tambah Pertanyaan')
		;
	}

	public function store()
	{
		$name = Input::get('name');
		$category = Input::get('ms_categories_id');
		$file = '';
		if(Input::hasFile('file'))
		{
			$extension=Input::file('file')->getClientOriginalExtension();
			$file=$this->randomToken(10).'.'.$extension;
			$ada=true;
			while($ada){
				$adakah=Question::where('file','=',$file)->count();
				if($adakah > 0)
				{
					$file=$this->randomToken(11).'.'.$extension;
				}else{
					$ada=false;
				}
			}
			
			Input::file('file')->move('upload/question/', $file);
			$path = public_path('upload/question/' . $file);
			$img2= Image::make($path);
			$img2->save('upload/question/'.$file,70);
		}
		$q = Question::create([
			'name' => $name,
			'file' => $file,
			'ms_categories_id' => $category,
			'theAnswer' => Input::get('answer')
		]);
		for($i=1;$i<=5;$i++)
		{
			Choice::create([
				'flag' => $i,
				'name' => Input::get('answer'.$i),
				'ms_questions_id' => $q->id
			]);
		}
		Session::flash('success','Data berhasil ditambahkan');
		return Redirect::back();
	}

	public function info($id=null)
	{
		if(empty($id))
			return Redirect::back();
		$content = Question::with('choices','categories')->find($id);
		return View::make('page.officer.questioninfo')
		->with('title','Detail Pertanyaan')
		->with('content',$content)
		;
	}

	public function destroy()
	{

		return Redirect::back();	
	}
	public function edit($id)
	{
		$category = Category::all();
		$content = Question::find($id);
		return View::make('page.officer.questionform')
			->with('content',$content)
			->with('category',$category)
			->with('title','Tambah Pertanyaan')
		;
	}

	public function update($id)
	{
		$category = Category::all();
		$content = Question::find($id);
		$content->name = Input::get('name');
		$content->ms_categories_id = Input::get('ms_categories_id');
		$file = '';
		if(Input::hasFile('file'))
		{
			if(File::exists('upload/question/'.$content->file))
			File::delete('upload/question/'.$content->file);
			$extension=Input::file('file')->getClientOriginalExtension();
			$file=$this->randomToken(10).'.'.$extension;
			$ada=true;
			while($ada){
				$adakah=Question::where('file','=',$file)->count();
				if($adakah > 0)
				{
					$file=$this->randomToken(11).'.'.$extension;
				}else{
					$ada=false;
				}
			}
			
			Input::file('file')->move('upload/question/', $file);
			$path = public_path('upload/question/' . $file);
			$img2= Image::make($path);
			$img2->save('upload/question/'.$file,70);
			$content->file = $file;
		}
		$content->theAnswer = Input::get('answer');
		$content->save();

		for($i=1;$i<=5;$i++)
		{
			$c = Choice::where('ms_questions_id',$content->id)->where('flag',$i)->first();
			$c->name = Input::get('answer'.$i);
			$c->save();
		}
		Session::flash('success','Data berhasil diperbarui');
		return Redirect::back();
	}
}
