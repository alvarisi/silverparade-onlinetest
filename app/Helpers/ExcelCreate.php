<?php 
namespace Helpers;
use Maatwebsite\Excel\Files;
use Maatwebsite\Excel\Facades\Excel;

class ExcelCreate  {
    protected $type;
    protected $attr;
    public function __construct($type,$attr) {
        $this->type = $type;
        $this->attr = $attr;
    }
    public function get()
    {
        Excel::create('template_'.$this->type,function($excel){
            $excel->sheet($this->type,function($sheet){
                $sheet->setOrientation('landscape');
                $sheet->row(1,$this->attr);
            });
        })->export('xls');
    }
}