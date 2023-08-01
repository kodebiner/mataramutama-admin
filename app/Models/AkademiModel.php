<?php namespace App\Models;

use CodeIgniter\Model;

class AkademiModel extends Model
{
    protected $table         = 'akademi';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama', 'slug'
    ];
    protected $returnType    = 'array';
}