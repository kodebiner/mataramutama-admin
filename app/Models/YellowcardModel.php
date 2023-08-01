<?php namespace App\Models;

use CodeIgniter\Model;

class YellowcardModel extends Model
{
    protected $table         = 'yellowcard';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'playerid', 'pertandinganid'
    ];
    protected $returnType    = 'array';
}