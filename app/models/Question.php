<?php
 
class Question extends Eloquent
{
    public $timestamps = false;
    protected $table="ms_questions";
    protected $fillable = array('name', 'file','ms_categories_id','theAnswer');
    public function categories()
    {
        return $this->belongsTo('Category','ms_categories_id','id');
    }
    public function choices()
    {
        return $this->hasMany('Choice','ms_questions_id','id');
    }

    public function answers()
    {
        return $this->hasMany('Answer','ms_questions_id','id');
    }
}