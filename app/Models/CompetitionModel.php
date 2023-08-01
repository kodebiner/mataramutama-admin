<?php namespace App\Models;

use CodeIgniter\Model;

class CompetitionModel extends Model
{
    protected $table         = 'competition';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'seasonid'
    ];
    protected $returnType    = 'array';
}