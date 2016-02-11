<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rss extends Model
{

    protected $table = 'rss';

    const COLUMN_AUTHOR = 'author';
    const COLUMN_BUILD_DATE = 'build_date';
    const COLUMN_CATEGORY = 'category';
    const COLUMN_DESCRIPTION = 'description';
    const COLUMN_ID = 'id';
    const COLUMN_IMAGE = 'image';
    const COLUMN_LAST_SYNC = 'last_sync';
    const COLUMN_LINK = 'link';
    const COLUMN_NAME = 'name';
    const COLUMN_URL = 'url';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::COLUMN_AUTHOR,
        self::COLUMN_BUILD_DATE,
        self::COLUMN_CATEGORY,
        self::COLUMN_DESCRIPTION,
        self::COLUMN_IMAGE,
        self::COLUMN_LINK,
        self::COLUMN_NAME,
        self::COLUMN_URL,
    ];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [self::COLUMN_ID];

    /**
     * Which columns should automatically be converted to (Carbon) dates.
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'build_date', 'last_sync'];


    /**
     * Get podcasts for an RSS feed
     */
    public function podcasts()
    {
        return $this->hasMany('App\Models\Podcast');
    }

    /**
     * Get recent podcasts for an RSS feed
     *
     * @param int $limit
     * @return mixed
     */
    public function recentPodcasts($limit = 10)
    {
        return $this->hasMany('App\Models\Podcast')->take($limit);
    }


    /**
     * Get Author
     *
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->getAttribute(static::COLUMN_AUTHOR);
    }

    /**
     * Set Author
     *
     * @param $author
     * @return $this
     */
    public function setAuthor($author)
    {
       return $this->setAttribute(static::COLUMN_AUTHOR, $author);
    }

    /**
     * Get RSS feed build date
     *
     * @return mixed
     */
    public function getBuildDate()
    {
        return $this->getAttribute(static::COLUMN_BUILD_DATE);
    }

    /**
     * Set Build Date
     *
     * @param $date
     * @return $this
     */
    public function setBuildDate($date)
    {
        return $this->setAttribute(static::COLUMN_BUILD_DATE, $date);
    }


    /**
     * Get Categories
     *
     * @return mixed
     */
    public function getCategories()
    {
        return json_decode($this->getAttribute(static::COLUMN_CATEGORY));
    }

    /**
     * Get Description
     *
     * @return mixed
     */
    public function getDescription()
    {
        return $this->getAttribute(static::COLUMN_DESCRIPTION);
    }

    /**
     * Set Description
     *
     * @param $description
     * @return $this
     */
    public function setDescription($description)
    {
        return $this->setAttribute(static::COLUMN_DESCRIPTION, $description);
    }


    /**
     * Set Categories
     *
     * @param array $categories
     * @return $this
     */
    public function setCategories($categories)
    {
        if (!is_array($categories)) {
            $categories = [$categories];
        }

        return $this->setAttribute(static::COLUMN_CATEGORY, json_encode(array_values(array_unique($categories))));
    }

    /**
     * Get ID
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->getAttribute(static::COLUMN_ID);
    }

    /**
     * Get Image
     *
     * @return mixed
     */
    public function getImage()
    {
        return $this->getAttribute(static::COLUMN_IMAGE);
    }

    /**
     * Set Image
     *
     * @param $image
     * @return $this
     */
    public function setImage($image)
    {
        return $this->setAttribute(static::COLUMN_IMAGE, $image);
    }

    /**
     * Get Last Sync Date
     *
     * @return mixed
     */
    public function getLastSync()
    {
        return $this->getAttribute(static::COLUMN_LAST_SYNC);
    }

    /**
     * Set Last Sync Date
     * @param $date
     * @return $this
     */
    public function setLastSync($date)
    {
        return $this->setAttribute(static::COLUMN_LAST_SYNC, $date);
    }

    /**
     * Get Link (podcast homepage)
     *
     * @return mixed
     */
    public function getLink()
    {
        return $this->getAttribute(static::COLUMN_LINK);
    }

    /**
     * Set Link (podcast homepage)
     *
     * @param $link
     * @return $this
     */
    public function setLink($link)
    {
        return $this->setAttribute(static::COLUMN_LINK, $link);
    }

    /**
     * Get Name
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->getAttribute(static::COLUMN_NAME);
    }

    /**
     * Set Name
     *
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        return $this->setAttribute(static::COLUMN_NAME, $name);
    }

    /**
     * Get feed URL
     *
     * @return mixed
     */
    public function getUrl()
    {
        return $this->getAttribute(static::COLUMN_URL);
    }

    /**
     * Set feed URL
     *
     * @param $url
     * @return $this
     */
    public function setUrl($url)
    {
        return $this->setAttribute(static::COLUMN_URL, $url);
    }

    /**
     * Get Slug
     *
     * @return string
     */
    public function getSlug()
    {
        return str_slug($this->getName());
    }

    /**
     * Get new RSS submissions
     *
     * @param $limit
     * @param $afterDate
     *
     * @return Rss[]
     */
    static function getNew($limit = 10, $afterDate = null)
    {
        $rss = self::orderBy(Rss::CREATED_AT, 'desc')->take($limit);

        if ($afterDate) {
            $rss = $rss->whereDate(Rss::CREATED_AT, '>=', $afterDate);
        }

        return $rss->get();
    }
}
