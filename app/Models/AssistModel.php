<?php namespace App\Models;

use CodeIgniter\Model;

class AssistModel extends Model
{
    protected $table         = 'assist';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'playerid', 'pertandinganid'
    ];
    protected $returnType    = 'array';
}