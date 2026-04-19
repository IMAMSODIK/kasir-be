<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Menu extends Model
{
    /** @use HasFactory<\Database\Factories\MenuFactory> */
    use HasFactory;

    protected $fillable = [
        'id',
        'nama_menu',
        'kategori_menu_id',
        'harga',
        'status',
        'deskripsi',
        'is_ready'
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function kategoriMenu()
    {
        return $this->belongsTo(KategoriMenu::class, 'kategori_menu_id');
    }

    public function fotoMenus()
    {
        return $this->hasMany(FotoMenu::class, 'menu_id');
    }
}
