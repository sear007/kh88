<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Games extends Model
{
    use HasFactory;
    protected $fillable = [
        'GameType',
        'Code',
        'GameOCode',
        'GameCode',
        'GameName',
        'Specials',
        'Technology',
        'SupportedPlatForms',
        'Order',
        'DefaultWidth',
        'DefaultHeight',
        'Image1',
        'Image2',
        'FreeSpin',
    ];
    public function Jackpots(){
       return $this->hasOne(Jackpots::class,'GameCode','GameCode');
    }
}
