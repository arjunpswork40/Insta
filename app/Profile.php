<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guard = [];

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'url',
        'image'
    ];

    public function profileImage()
    {
        $imagePath = ($this->image) ? $this->image : '/profile/default-img.png';
        return '/storage/' . $imagePath;
    }

    public function followers()
    {
        return $this->belongsToMany(User::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
