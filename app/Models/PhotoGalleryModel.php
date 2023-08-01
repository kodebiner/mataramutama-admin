<?php namespace App\Models;

use CodeIgniter\Model;

class PhotoGalleryModel extends Model
{
    protected $table         = 'photogallery';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'catid', 'photo'
    ];
    protected $returnType    = 'array';
}