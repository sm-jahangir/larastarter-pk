<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Page extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;
    protected $guarded = ['id'];
        /**
     * Register media collections
     */
    public function registerMediaCollections() : void
    {
        $this->addMediaCollection('image')
            ->singleFile();
    }
    public function findBySlug($slug)
    {
        return self::where('slug', $slug)->where('status', true)->firstOrFail();
    }
}
