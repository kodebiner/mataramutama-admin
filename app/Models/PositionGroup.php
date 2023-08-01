<?php namespace App\Models;

use CodeIgniter\Model;

class PositionGroup extends Model
{
    protected $table         = 'positiongroup';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'name'
    ];
    protected $returnType    = 'array';
}