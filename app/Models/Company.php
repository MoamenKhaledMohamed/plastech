<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public function companyOrders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CompanyOrder::class);
    }
}
