<?php namespace App\Models;

use CodeIgniter\Model;

class OfficialModel extends Model
{
    protected $table         = 'official';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama', 'photo', 'position'
    ];
    protected $returnType    = 'array';
}