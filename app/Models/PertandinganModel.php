<?php namespace App\Models;

use CodeIgniter\Model;

class PertandinganModel extends Model
{
    protected $table         = 'pertandingan';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'homeaway', 'opponentid', 'date', 'stadium', 'status', 'competitionid', 'timid'
    ];
    protected $returnType    = 'array';
}