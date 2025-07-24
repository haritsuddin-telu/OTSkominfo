<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Secret extends Model
{
    use HasFactory;
    protected $fillable = [
        'text', 'slug', 'expires_at', 'used', 'user_id'
    ];
    protected $dates = ['expires_at'];
}
