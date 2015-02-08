<?php
 
class Competition extends Eloquent
{
    public $timestamps = false;
    protected $table="ms_competitions";
    protected $fillable = array('name');
    public function categories()
    {
        return $this->hasMany('Category','ms_competitions_id','id');
    }
}