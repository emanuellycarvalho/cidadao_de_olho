<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deputado extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'nome',
        'partido'
    ];

    public function redesSociais(){
        return $this->belongsToMany(RedeSocial::class, 'deputado_redes_sociais');
    }

}
