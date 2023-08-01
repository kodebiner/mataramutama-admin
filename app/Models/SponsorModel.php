<?php namespace App\Models;

use CodeIgniter\Model;

class SponsorModel extends Model
{
    protected $table         = 'sponsor';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama', 'width', 'height', 'picture', 'urutan'
    ];
    protected $returnType    = 'array';
}