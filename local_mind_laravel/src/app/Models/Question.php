<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'title',
        'content',
        'location',
        'latitude',
        'longitude',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    //A user can favorite many questions
    // A question can be favorited by many users
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favourites');
    }

    public function isFavorited()
    {
        return auth()->check()
            && $this->favoritedBy()->where('user_id', auth()->id())->exists();
    }
}
