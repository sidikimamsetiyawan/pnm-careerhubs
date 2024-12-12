<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HobbyModel extends Model
{
    use HasFactory;

    protected $table = 'hobbies';

    static public function getSingle($id)
    {
        return HobbyModel::find($id);
    }

    static public function getRecord()
    {
        return HobbyModel::get();
    }
}
