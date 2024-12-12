<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_hobbies', 'hobby_id', 'user_id');
    }


}
