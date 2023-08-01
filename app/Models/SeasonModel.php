<?php namespace App\Models;

use CodeIgniter\Model;

class SeasonModel extends Model
{
    protected $table         = 'season';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'year'
    ];
    protected $returnType    = 'array';
}