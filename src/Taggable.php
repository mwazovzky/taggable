<?php

namespace MWazovzky\Taggable;

trait Taggable
{
    /**
     * Update Model boot method.
     * Detach all tags (and clean pivot table) when deleting the model.
     *
     * @param type name
     * @return type
     */
    protected static function bootTaggable()
    {
        static::deleted(function ($model) {
            $model->tags()->detach();
        });
    }

    /**
     * Get tags attached to the post.
     *
     * @return Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function tags()
    {
        // return $this->belongsToMany(Tag::class);
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Sync post tags.
     * Only valid tags are added to post.
     *
     * @param array $tagList - array of tags (names)
     * @return void
     */
    public function syncTags($tagList = [])
    {
        $this->tags()->sync(Tag::validate($tagList));
    }
}
