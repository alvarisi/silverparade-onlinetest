<?php
 
class Role extends Eloquent
{
    public $timestamps = false;
    protected $table="ms_roles";
    protected $fillable = array('name');
    public function users()
    {
        return $this->belongsToMany('User', 'tr_user_roles','ms_role_id');
    }
}