<?php namespace App\Models;

use CodeIgniter\Model;

class TacklingModel extends Model
{
    protected $table         = 'tackling';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'playerid', 'pertandinganid', 'complete'
    ];
    protected $returnType    = 'array';
}