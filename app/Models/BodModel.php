<?php namespace App\Models;

use CodeIgniter\Model;

class BodModel extends Model
{
    protected $table         = 'bod';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama', 'photo', 'position'
    ];
    protected $returnType    = 'array';
}