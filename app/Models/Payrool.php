<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payrool extends Model
{
    use HasFactory;
    protected $guarded = [];

      public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🧮 Accessor: otomatis format nominal jadi Rupiah
    public function getNetPayFormattedAttribute()
    {
        return 'Rp' . number_format($this->net_pay, 0, ',', '.');
    }

    // 🗓️ Accessor: format periode
    public function getPeriodFormattedAttribute()
    {
        return date('d M Y', strtotime($this->period_start)) . ' - ' . date('d M Y', strtotime($this->period_end));
    }

}
