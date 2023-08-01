<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table         = 'user';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'username', 'fullname', 'email', 'password', 'created', 'updated', 'status', 'type', 'verification'
    ];
    protected $returnType    = 'App\Entities\User';
    protected $useTimestamps = false;
}