<?php

use Helpers\ExcelCreate;

class TemplateController extends BaseController {
	
	public function create($name='')
	{
		if($name == 'user')
		{
			$attr = array('Nama', 'Username', 'Password','Email');
			$unduh = new ExcelCreate($name,$attr);
	        return $unduh->get();
		}
	}
}