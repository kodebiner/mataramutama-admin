<?php namespace App\Models;

use CodeIgniter\Model;

class FoulsModel extends Model
{
    protected $table         = 'fouls';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'playerid', 'pertandinganid'
    ];
    protected $returnType    = 'array';
}