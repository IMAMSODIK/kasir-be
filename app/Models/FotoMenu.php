<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoMenu extends Model
{
    /** @use HasFactory<\Database\Factories\FotoMenuFactory> */
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'foto_path'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
