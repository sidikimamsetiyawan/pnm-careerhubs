<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeModel extends Model
{
    use HasFactory;

    protected $table = 'employees';

    // Primary key yang digunakan
    protected $primaryKey = 'emp_id';

    // Non-incrementing atau bukan tipe integer
    public $incrementing = false;

    // Jenis primary key (string dalam kasus ini)
    protected $keyType = 'string';

    static public function getSingle($id)
    {
        return EmployeeModel::find($id);
    }

    static public function getRecord()
    {
        return EmployeeModel::get();
    }
}
