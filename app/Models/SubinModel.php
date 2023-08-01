<?php namespace App\Models;

use CodeIgniter\Model;

class SubinModel extends Model
{
    protected $table         = 'subin';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'playerid', 'pertandinganid', 'minute'
    ];
    protected $returnType    = 'array';
}