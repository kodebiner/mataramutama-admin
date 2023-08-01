<?php namespace App\Models;

use CodeIgniter\Model;

class CornerModel extends Model
{
    protected $table         = 'corner';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'playerid', 'pertandinganid'
    ];
    protected $returnType    = 'array';
}