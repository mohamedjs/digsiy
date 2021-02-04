<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LatestState;

class Website extends Model
{
    use HasFactory, LatestState;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'link',
        'last_scraped_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'last_scraped_at' => 'datetime',
    ];

    /**
     * Get the articles that belong to webite
     * 
     * @return Illuminate\Database\Eloquent\Model
     */
    public function articles(): Model
    {
        return $this->hasMany(Article::class);
    }
}
