<?php
 
class Sesi extends Eloquent
{
    public $timestamps = true;
    protected $table="tr_sesi";
    protected $fillable = array('name','mulai','selesai','ms_categories_id');
    
    public function users()
    {
        return $this->belongsToMany('User','tr_usersesi','tr_sesi_id','ms_user_id');
    }
    public function categories()
    {
        return $this->belongsTo('Category','ms_categories_id','id');
    }
    public function usersesi()
    {
        return $this->hasMany('Usersesi','tr_sesi_id');
    }
    
    public function logsesi()
    {
         return $this->hasManyThrough('Logsesi', 'Usersesi', 'tr_sesi_id', 'tr_usersesi_id');
    }
}