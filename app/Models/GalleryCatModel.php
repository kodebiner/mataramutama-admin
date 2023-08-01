<?php namespace App\Models;

use CodeIgniter\Model;

class GalleryCatModel extends Model
{
    protected $table         = 'gallerycat';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'slug', 'featured', 'status'
    ];
    protected $returnType    = 'array';
}