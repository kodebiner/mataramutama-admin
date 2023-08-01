<?php namespace App\Models;

use CodeIgniter\Model;

class PlayerAkademiModel extends Model
{
    protected $table         = 'playerakademi';
	protected $primaryKey = 'id';
    protected $allowedFields = [
        'akademiid', 'nama', 'birthdate', 'foto'
    ];
    protected $returnType    = 'array';
}