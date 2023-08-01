<?php namespace App\Models;

use CodeIgniter\Model;

class KlasemenModel extends Model
{
    protected $table         = 'klasemen';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'timid', 'competitionid', 'image'
    ];
    protected $returnType    = 'array';
}