<?php namespace App\Models;

use CodeIgniter\Model;

class SavesModel extends Model
{
    protected $table         = 'saves';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'playerid', 'pertandinganid'
    ];
    protected $returnType    = 'array';
}