<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusCustomer extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id', 'status_id', 'remark'
    ];

    public function statusDetail()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
}
