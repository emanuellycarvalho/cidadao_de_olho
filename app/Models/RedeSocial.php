<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Deputado;

class RedeSocial extends Model
{
    use HasFactory;

    protected $table = 'redes_sociais';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'nome'
    ];

    public function usuarios(){
        return $this->belongsToMany(Deputado::class, 'deputado_redes_sociais', 'rede_id')->withPivot('active');
    }
}
