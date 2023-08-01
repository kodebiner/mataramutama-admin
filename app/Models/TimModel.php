<?php namespace App\Models;

use CodeIgniter\Model;

class TimModel extends Model
{
    protected $table         = 'tim';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'name'
    ];
    protected $returnType    = 'array';
}