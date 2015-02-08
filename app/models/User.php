<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	protected $table="ms_users";
	protected $fillable = array('email', 'password','username','enabled');
	public $timestamps = false;
	public function getAuthIdentifier(){
		return $this->getKey();
	}	
	public function getAuthPassword(){
		return $this->password;
	}
	public function getRememberToken()
	{
		return $this->remember_token;
	}
	public function setRememberToken($value)
	{
		 $this->remember_token = $value;
	}
	public function setRememberTokenName()
	{
		
	}
	public function getRememberTokenName()
	{
		return 'remember_token';
	}
	public function getReminderEmail(){
		return $this->email;
	}

	public function roles()
	{
		return $this->belongsToMany('Role','tr_user_roles','ms_user_id');
	}
	public function isUser()
	{
		$roles = $this->roles->toArray();
		return !empty($roles);
	}
	public function hasRole($check)
	{
		return in_array($check, array_fetch($this->roles->toArray(),'nama'));
	}

	private function getIdInArray($array, $term)
	{
		foreach ($array as $key => $value) {
			if($value == $term)
			{
				return $key;
			}
		}
		throw new UnexpectedValueException;
	}
	public function makeUser($t)
	{
		$assign = array();
		$roles = array_fetch(Role::all()->toArray(),'nama');
		$assign[] = $this->getIdInArray($roles,$t);
		$this->roles->attach($assign);
	}

	public function sesi()
    {
        return $this->belongsToMany('Sesi','tr_usersesi','ms_user_id');
    }
    public function usersesi()
    {
        return $this->hasMany('Usersesi','ms_user_id');
    }
}
