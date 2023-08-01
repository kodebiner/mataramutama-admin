<?php namespace App\Models;

use CodeIgniter\Model;

class CleanSheetsModel extends Model
{
    protected $table         = 'cleansheets';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'playerid', 'pertandinganid'
    ];
    protected $returnType    = 'array';
}