<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo as BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LatestState;

class Article extends Model
{
    use HasFactory, LatestState;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'dom',
        'link',
        'website_id',
    ];
    /**
     * website that have this article
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo 
     */
    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }

}
