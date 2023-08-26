<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Holiday;
use App\Models\Leave;
use App\Models\SpecialHoliday;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    /**
     * Get the outlet that owns the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function outlet(): BelongsTo
    {
        return $this->belongsTo(Outlet::class);
    }
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
    public function holiday()
    {
        return $this->hasMany(Holiday::class);
    }

    public function schedule()
    {
        return $this->hasOne(Schedule::class);
    }

    public function specialHolidays()
    {
        return $this->belongsToMany(SpecialHoliday::class, 'employee_special_holiday')->withTimestamps();
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function permissions(){
        return $this->hasMany(Permission::class);
    }



    public static function boot(): void
    {
        parent::boot();

        static::created(function ($employee) {
            // Buat entri pengguna baru dengan menggunakan data dari karyawan yang baru ditambahkan
            $user = new User();
            $user->employee_id = $employee->id;
            $user->name = $employee->name;
            $user->email = $employee->email;
            $user->role = 'Employee';
            $user->photo = 'photos/default-employee-photo.jpeg';
            $user->password = bcrypt('password'); // Ganti dengan kata sandi yang diinginkan
            $user->save();
        });
    }
    public function updateAttendanceStatus($date)
    {

        // Periksa apakah hari ini adalah hari libur
        $isHoliday = $this->holiday()->where('choosen_day', Carbon::parse($date)->translatedFormat('l'))->exists();
        // Periksa apakah hari ini adalah hari cuti
        $isLeave = $this->leaves()
            ->where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->where('status', 'approved') // Pastikan hanya cuti yang sudah diapprove yang diperhitungkan
            ->exists();
        $isSpecialHoliday = $this->specialHolidays()->whereDate('start_date', '<=', $date)
            ->whereDate('end_date', '>=', $date)
            ->exists();

        $status = '';
        if ($isHoliday || $isSpecialHoliday) {
            $status = 'Holiday';
        } elseif ($isLeave) {
            $status = 'Leave';
        }
        if ($status !== '') {
            $this->attendance()->updateOrCreate([
                'check_out_date' => $date
            ], [
                'status' => $status
            ]);
            return;
        }

    }
}
