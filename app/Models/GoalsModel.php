<?php namespace App\Models;

use CodeIgniter\Model;

class GoalsModel extends Model
{
    protected $table         = 'goals';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'playerid', 'pertandinganid', 'playername', 'minute', 'type'
    ];
    protected $returnType    = 'array';
}