<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crowdsale extends Model
{
    use HasFactory;

    protected $fillable = [
        'rate',
        'contractAddress',
        'tokenAddress',
        'deployerAddress'
    ];

    public function token()
    {
        return $this->belongsTo(Token::class, 'tokenAddress', 'contractAddress');
    }
}
