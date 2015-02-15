<?php 
namespace Helpers;
use Maatwebsite\Excel\Files;
use Maatwebsite\Excel\Facades\Excel;

class ExcelHelper extends \Maatwebsite\Excel\Files\ExcelFile {
    protected $file;
    public function __construct($att) {
        $this->file = $att;
    }
    public function getFile()
    {
        $filename = $this->upload();
        return $filename;
    }

    public function upload()
    {
    	$this->file->move('./upload/xls/','data.xlsx');
    	return './upload/xls/data.xlsx';
    }
    public function get()
    {
        return Excel::selectSheetsByIndex(0)->load($this->getFile(), function($reader){
            $reader=$reader->ignoreEmpty();
        })->get();
    }
}