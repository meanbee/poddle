<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rss extends Model
{

    protected $table = 'rss';

    const COLUMN_ID = 'id';
    const COLUMN_URL = 'url';
    const COLUMN_PODCAST_ID = 'podcast_id';
    const COLUMN_LINK = 'link';
    const COLUMN_NAME = 'name';
    const COLUMN_DESCRIPTION = 'description';
    const COLUMN_AUTHOR = 'author';
    const COLUMN_IMAGE = 'image';
    const COLUMN_BUILD_DATE = 'build_date';
    const COLUMN_CATEGORY = 'category';
    const COLUMN_LAST_SYNC = 'last_sync';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::COLUMN_URL,
        self::COLUMN_LINK,
        self::COLUMN_NAME,
        self::COLUMN_DESCRIPTION,
        self::COLUMN_AUTHOR,
        self::COLUMN_IMAGE,
        self::COLUMN_BUILD_DATE,
        self::COLUMN_CATEGORY,
    ];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [self::COLUMN_ID, self::COLUMN_PODCAST_ID];

    /**
     * Get podcasts for an RSS feed
     */
    public function podcasts()
    {
        return $this->hasMany('App\Models\Podcast');
    }
}
