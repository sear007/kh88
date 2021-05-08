<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Jackpots extends Model
{
    use HasFactory;
    protected $fillable = ['GameCode','Amount'];
    public function Games(){
       return $this->belongsTo(Games::class,'GameCode');
    }
}
