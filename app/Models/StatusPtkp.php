<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPtkp extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'ptkp_2016',
        'ptkp_2015',
        'ptkp_2009_2012',
    ];

    public function Payroll()
    {
        return $this->hasMany(Payroll::class, 'status_id');
    }
    public function pajaks()
    {
        return $this->hasMany(Pajak::class, 'status_id');
    }

}
