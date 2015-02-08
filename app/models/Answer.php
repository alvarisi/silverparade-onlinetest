<?php
 
class Answer extends Eloquent
{
    public $timestamps = false;
    protected $table="tr_answer";
    protected $fillable = array('tr_logsesi_id','ms_questions_id','answer');

    public function logsesi()
    {
        return $this->belongsTo('Logsesi', 'tr_logsesi_id','id');
    }
    public function logsesi()
    {
        return $this->belongsTo('Question', 'ms_questions_id','id');
    }


}