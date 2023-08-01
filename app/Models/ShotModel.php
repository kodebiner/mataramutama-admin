<?php namespace App\Models;

use CodeIgniter\Model;

class ShotModel extends Model
{
    protected $table         = 'shot';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'playerid', 'pertandinganid', 'ontarget'
    ];
    protected $returnType    = 'array';
}