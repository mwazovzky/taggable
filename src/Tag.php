<?php

namespace MWazovzky\Taggable;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The attributes that are NOT mass assignable. Yolo!
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays via toArray() and json via json_encode().
     * Pivot data is hidden
     *
     * @var array
     */
    protected $hidden = ['pivot'];

    /**
     * Get the route key name for Laravel.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    /**
     * Get models tagged by the tag.
     * Create method for every taggable model.
     *
     * @return Illuminate\Database\Eloquent\Relations\morphedByMany
     */
    // public function posts()
    // {
    //     return $this->morphedByMany(Post::class, 'taggable');
    // }

    /**
     * Validate tags.
     * Convert array of tags into array of valid tag ids.
     * Non-existing tags are ignored.
     *
     * @param array $names - array of tag names (string)
     * @return array of ids
     */
    public static function validate($names = null)
    {
        if (!$names) {
            return [];
        }

        return static::whereIn('name', $names)->pluck('id')->toArray();
    }
}
