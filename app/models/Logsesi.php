<?php
 
class Logsesi extends Eloquent
{
    public $timestamps = false;
    protected $table="tr_logsesi";
    protected $fillable = array('mulai','selesai','tr_usersesi_id');
    public function usersesi()
    {
        return $this->belongsTo('Usersesi', 'tr_usersesi_id','id');
    }

    public function answers()
    {
    	return $this->hasMany('Answer','tr_logsesi_id','id');
    }
}