<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCustomerModel extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'user_customer';
    protected $primaryKey = 'user_customer_id';
    protected $fillable = [
        'user_customer_name',
        'user_customer_email',
        'user_customer_password',
    ];
}
