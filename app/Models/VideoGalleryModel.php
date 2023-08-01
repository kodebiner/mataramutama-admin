<?php namespace App\Models;

use CodeIgniter\Model;

class VideoGalleryModel extends Model
{
    protected $table         = 'videogallery';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'title', 'videoid'
    ];
    protected $returnType    = 'array';
}