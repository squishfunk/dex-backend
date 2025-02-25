<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'symbol',
        'supply',
        'logoURL',
        'description',
        'contractAddress',
        'deployerAddress',
    ];

    public function crowdsale()
    {
        return $this->hasOne(Crowdsale::class, 'tokenAddress', 'contractAddress');
    }
}
