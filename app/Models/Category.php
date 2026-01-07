<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'icon',
    ];

    /**
     * Boot method para gerar slug automaticamente
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Relação 1:N - Uma categoria tem muitos eventos
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Accessor para contar eventos
     */
    public function getEventsCountAttribute()
    {
        return $this->events()->count();
    }
}