<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['header', 'content', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    protected function createdAt(): Attribute
    {
        return new Attribute(get: fn($value) => Carbon::parse($value)->diffForHumans(), set: fn($value) => $value);
        //
    }
    protected function updatedAt(): Attribute
    {
        return new Attribute(get: fn($value) => Carbon::parse($value)->diffForHumans(), set: fn($value) => $value);
        //
    }
}
