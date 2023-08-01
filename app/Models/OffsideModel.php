<?php namespace App\Models;

use CodeIgniter\Model;

class OffsideModel extends Model
{
    protected $table         = 'offside';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'playerid', 'pertandinganid'
    ];
    protected $returnType    = 'array';
}