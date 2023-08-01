<?php namespace App\Models;

use CodeIgniter\Model;

class FreekickModel extends Model
{
    protected $table         = 'freekick';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'playerid', 'pertandinganid'
    ];
    protected $returnType    = 'array';
}