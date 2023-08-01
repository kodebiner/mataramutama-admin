<?php namespace App\Models;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table         = 'berita';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'title', 'slug', 'foto', 'intro', 'konten', 'featured'
    ];
    protected $returnType    = 'array';
}