<?php namespace App\Models;

use CodeIgniter\Model;

class PelatihModel extends Model
{
    protected $table         = 'pelatih';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama', 'posisi', 'foto'
    ];
    protected $returnType    = 'array';
}