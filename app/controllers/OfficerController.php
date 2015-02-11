<?php

class OfficerController extends BaseController {

	public function index()
	{
		return View::make('page.officer.index')->with('title','Selamat Datang');
	}
}
