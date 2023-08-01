<?php namespace App\Models;

use CodeIgniter\Model;

class ClubModel extends Model
{
    protected $table         = 'club';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'logo'
    ];
    protected $returnType    = 'array';
}