<?php
 
class Usersesi extends Eloquent
{
    public $timestamps = true;
    protected $table="tr_usersesi";
    protected $fillable = array('ms_user_id','tr_sesi_id');

    public function logsesi()
    {
        return $this->hasOne('Logsesi', 'tr_usersesi_id','id');
    }
    public function user()
    {
    	return $this->belongsTo('User','ms_user_id');
    }
    public function sesi()
    {
    	return $this->belongsTo('Sesi','tr_sesi_id');
    }
}