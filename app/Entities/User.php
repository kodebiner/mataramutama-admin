<?php namespace App\Entities;

use CodeIgniter\Entity;
use CodeIgniter\I18n\Time;

class User extends Entity
{
	public function setPassword(string $password)
    {
        $this->attributes['password'] = password_hash($password, PASSWORD_BCRYPT);

        return $this;
    }
}