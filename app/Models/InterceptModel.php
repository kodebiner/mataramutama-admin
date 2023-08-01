<?php namespace App\Models;

use CodeIgniter\Model;

class InterceptModel extends Model
{
    protected $table         = 'intercept';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'playerid', 'pertandinganid', 'complete'
    ];
    protected $returnType    = 'array';
}