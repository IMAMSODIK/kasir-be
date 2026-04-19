<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriMenu extends Model
{
    /** @use HasFactory<\Database\Factories\KategoriMenuFactory> */
    use HasFactory;

    protected $fillable = [
        'nama_kategori',
        'status',
        'icon'
    ];

    public function menus()
    {
        return $this->hasMany(Menu::class, 'kategori_menu_id');
    }
}
