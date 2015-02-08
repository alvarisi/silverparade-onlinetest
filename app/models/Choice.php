<?php
 
class Choice extends Eloquent
{
    public $timestamps = false;
    protected $table="ms_choices";
    protected $fillable = array('name','ms_questions_id');
    public function questions()
    {
        return $this->belongsTo('Question','ms_questions_id','id');
    }
}