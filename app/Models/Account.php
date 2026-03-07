<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{   
    protected $fillable = [
        'user_id',
        'account_number',
        'account_type',
        'balance',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public static function generateAccountNumber()
    {
        return 'ACC' . now()->format('Ymd') . rand(1000, 9999);
    }
}
