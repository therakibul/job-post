<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Listing extends Model
{
    use HasFactory;


    public function scopeFilter($query, $filter){
        if($filter['tag'] ?? false){
            $query->where('tags', 'like', '%'.request('tag').'%');
        }
        if($filter['search'] ?? false){
            $query->where('title', 'like', '%'.request('search').'%')
                    ->orWhere('description', 'like', '%'.request('search').'%')
                    ->orWhere('location', 'like', '%'.request('search').'%')
                    ->orWhere('tags', 'like', '%'.request('search').'%');
        }
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}