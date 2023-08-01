<?php namespace App\Models;

use CodeIgniter\Model;

class CrossingModel extends Model
{
    protected $table         = 'crossing';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'playerid', 'pertandinganid', 'complete'
    ];
    protected $returnType    = 'array';
}