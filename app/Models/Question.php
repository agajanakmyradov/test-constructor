<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Answer;

class Question extends Model
{
    use HasFactory;

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function($question){
            $question->answers->each(function($answer){
               $answer->delete();
            });
        });
    }
}
