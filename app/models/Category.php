<?php
 
class Category extends Eloquent
{
    public $timestamps = false;
    protected $table="ms_categories";
    protected $fillable = array('name','description','ms_competitions_id');
    public function competitions()
    {
        return $this->belongsTo('Competition','ms_competitions_id','id');
    }
    public function questions()
    {
        return $this->hasMany('Question','ms_categories_id','id');
    }
    public function sesi()
    {
        return $this->hasMany('questions','ms_categories_id','id');
    }
}