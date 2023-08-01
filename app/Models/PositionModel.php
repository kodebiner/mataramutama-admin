<?php namespace App\Models;

use CodeIgniter\Model;

class PositionModel extends Model
{
    protected $table         = 'position';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'groupid'
    ];
    protected $returnType    = 'array';
}