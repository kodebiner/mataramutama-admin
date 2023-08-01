<?php namespace App\Models;

use CodeIgniter\Model;

class PlayerModel extends Model
{
    protected $table         = 'player';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'namapunggung', 'profilepic', 'photo', 'nopunggung', 'tinggibadan', 'beratbadan', 'tgllahir', 'positionid', 'timid', 'description'
    ];
    protected $returnType    = 'array';
}