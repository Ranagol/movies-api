<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Movie extends Model
{
    protected $guarded = ['id'];

    public static function search($title, $skip, $take){
        //url command for give me all movies that have 'night' in their title: /movies?title=night
        //url command for skip the first five movie, take the next 10 movies: /movies?take=10&skip=5
        //combined url command: /movies?take=10&skip=5&title=night
        //return self Movie model
        //find movies with this title
        //skip what has to be skipped
        //take what has to be taken
        return self::where('title', 'LIKE', '%'.$title.'%')->skip($skip)->take($take)->get();
    }
}
