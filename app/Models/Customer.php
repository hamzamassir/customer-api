<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
     protected $table = 'customers';

     // Specify the primary key if it's not 'id'
     protected $primaryKey = 'id';

    // If the primary key is not an incrementing integer
    //  public $incrementing = false;

     // Specify the data type of the primary key if it's not an integer
    //protected $keyType = 'string';

     // Define fillable fields for mass assignment
     protected $fillable = [
         'customer_id',
         'first_name',
         'last_name',
         'company',
         'city',
         'country',
         'phone_1',
         'phone_2',
         'email',
         'subscription_date',
         'website',
     ];
}
