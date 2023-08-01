<?php namespace App\Models;

use CodeIgniter\Model;

class StoreModel extends Model
{
    protected $table         = 'store';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'photo', 'price'
    ];
    protected $returnType    = 'array';
}