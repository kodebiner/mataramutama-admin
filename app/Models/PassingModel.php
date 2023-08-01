<?php namespace App\Models;

use CodeIgniter\Model;

class PassingModel extends Model
{
    protected $table         = 'passing';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'playerid', 'pertandinganid', 'complete'
    ];
    protected $returnType    = 'array';
}