<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SpecialHoliday extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_special_holiday');
    }
}
