<?php namespace App\Models;

use CodeIgniter\Model;

class SuboutModel extends Model
{
    protected $table         = 'subout';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'playerid', 'pertandinganid', 'minute'
    ];
    protected $returnType    = 'array';
}