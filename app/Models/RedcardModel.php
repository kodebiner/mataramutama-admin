<?php namespace App\Models;

use CodeIgniter\Model;

class RedcardModel extends Model
{
    protected $table         = 'redcard';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'playerid', 'pertandinganid'
    ];
    protected $returnType    = 'array';
}