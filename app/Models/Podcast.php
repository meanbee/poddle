<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{

    const STATUS_NEW = 'new';
    const STATUS_DOWNLOADED = 'downloaded';
    const STATUS_DOWNLOAD_FAILED = 'download_failed';
    const STATUS_FILE_CONVERTED = 'file_converted';
    const STATUS_FILE_CONVERSION_FAILED = 'file_conversion_failed';
    const STATUS_AUDIO_TO_TEXT_CONVERTED = 'audio_to_text_converted';
    const STATUS_AUDIO_TO_TEXT_CONVERSION_FAILED = 'audio_to_text_conversion_failed';
    const STATUS_TEXT_CONCEPTS_IDENTIFIED = 'text_concepts_identified';
    const STATUS_TEXT_CONCEPTS_IDENTIFICATION_FAILED = 'text_concepts_identification_failed';

    const COLUMN_AUTHOR = 'author';
    const COLUMN_CONCEPTS = 'concepts';
    const COLUMN_CONVERTED_FILE = 'converted_file';
    const COLUMN_DESCRIPTION = 'description';
    const COLUMN_EPISODE_NAME = 'episode_name';
    const COLUMN_GUID = 'guid';
    const COLUMN_ID = 'id';
    const COLUMN_LINK = 'link';
    const COLUMN_META = 'meta';
    const COLUMN_ORIGINAL_FILE_TYPE = 'original_file_type';
    const COLUMN_ORIGINAL_FILE = 'original_file';
    const COLUMN_PODCAST_NAME = 'podcast_name';
    const COLUMN_PUBLISHED_DATE = 'published_date';
    const COLUMN_RSS_ID = 'rss_id';
    const COLUMN_STATUS = 'status';
    const COLUMN_TRANSCRIPTION = 'transcription';
    const COLUMN_URL = 'url';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::COLUMN_PODCAST_NAME,
        self::COLUMN_URL,
        self::COLUMN_EPISODE_NAME,
        self::COLUMN_STATUS,
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
    protected $dates = ['created_at', 'updated_at', 'published_date'];

    /**
     * Get RSS feed of podcast.
     */
    public function getRss()
    {
        return $this->belongsTo('App\Models\Rss');
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
     * Set author
     *
     * @param $author
     * @return $this
     */
    public function setAuthor($author)
    {
        return $this->setAttribute(static::COLUMN_AUTHOR, $author);
    }

    /**
     * Get Concepts
     *
     * @return mixed
     */
    public function getConcepts()
    {
        $concepts = $this->getAttribute(static::COLUMN_CONCEPTS);
        // @TODO connect up with concepts, I don't know how they are being saved.
        return array($concepts);
    }

    /**
     * Set Concepts
     *
     * @param $concepts
     * @return $this
     */
    public function setConcepts($concepts)
    {
        return $this->setAttribute(static::COLUMN_CONCEPTS, $concepts);
    }

    /**
     * Get converted file
     *
     * @return mixed
     */
    public function getConvertedFile()
    {
        return $this->getAttribute(static::COLUMN_CONVERTED_FILE);
    }

    /**
     * Set converted file
     *
     * @param $file
     * @return $this
     */
    public function setConvertedFile($file)
    {
        return $this->setAttribute(static::COLUMN_CONVERTED_FILE, $file);
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
     * Get Episode Name
     *
     * @return mixed
     */
    public function getEpisodeName()
    {
        return $this->getAttribute(static::COLUMN_EPISODE_NAME);
    }

    /**
     * Set Episode Name
     *
     * @return $this
     */
    public function setEpisodeName($name)
    {
        return $this->setAttribute(static::COLUMN_EPISODE_NAME, $name);
    }

    /**
     * Get GUID
     *
     * @return mixed
     */
    public function getGuid()
    {
        return $this->getAttribute(static::COLUMN_GUID);
    }

    /**
     * Set GUID
     *
     * @param $guid
     * @return $this
     */
    public function setGuid($guid)
    {
        return $this->setAttribute(static::COLUMN_GUID, $guid);
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
     * Get link
     *
     * @return mixed
     */
    public function getLink()
    {
        return $this->getAttribute(static::COLUMN_LINK);
    }

    /**
     * Set Link
     *
     * @param $link
     * @return $this
     */
    public function setLink($link)
    {
        return $this->setAttribute(static::COLUMN_LINK, $link);
    }

    /**
     * Get meta
     *
     * @return mixed
     */
    public function getMeta()
    {
        return $this->getAttribute(static::COLUMN_META);
    }

    /**
     * Set meta
     *
     * @param $meta
     * @return $this
     */
    public function setMeta($meta)
    {
        return $this->setAttribute(static::COLUMN_META, $meta);
    }

    /**
     * Get original file type
     *
     * @return mixed
     */
    public function getOriginalFileType()
    {
        return $this->getAttribute(static::COLUMN_ORIGINAL_FILE_TYPE);
    }

    /**
     * Set original file type
     *
     * @param $fileType
     * @return $this
     */
    public function setOriginalFileType($fileType)
    {
        return $this->setAttribute(static::COLUMN_ORIGINAL_FILE_TYPE, $fileType);
    }

    /**
     * Get original file
     *
     * @return mixed
     */
    public function getOriginalFile()
    {
        return $this->getAttribute(static::COLUMN_ORIGINAL_FILE);
    }

    /**
     * Set original file
     *
     * @param $fileType
     * @return $this
     */
    public function setOriginalFile($file)
    {
        return $this->setAttribute(static::COLUMN_ORIGINAL_FILE, $file);
    }

    /**
     * Get Podcast Name
     *
     * @return mixed
     */
    public function getPodcastName()
    {
        return $this->getAttribute(static::COLUMN_PODCAST_NAME);
    }

    /**
     * Set Podcast Name
     *
     * @return $this
     */
    public function setPodcastName($name)
    {
        return $this->setAttribute(static::COLUMN_PODCAST_NAME, $name);
    }

    /**
     * Get Published Date
     *
     * @return mixed
     */
    public function getPublishedDate()
    {
        return $this->getAttribute(static::COLUMN_PUBLISHED_DATE);
    }

    /**
     * Set Published Date
     *
     * @param $publishedDate
     * @return $this
     */
    public function setPublishedDate($publishedDate)
    {
        return $this->setAttribute(static::COLUMN_PUBLISHED_DATE, $publishedDate);
    }

    /**
     * Get RSS ID
     *
     * @return mixed
     */
    public function getRssId()
    {
        return $this->getAttribute(static::COLUMN_RSS_ID);
    }

    /**
     * Set RSS ID
     *
     * @param $id
     * @return $this
     */
    public function setRssId($id)
    {
        return $this->setAttribute(static::COLUMN_RSS_ID, $id);
    }

    /**
     * Get Status
     *
     * @return mixed
     */
    public function getStatus()
    {
        return $this->getAttribute(static::COLUMN_STATUS);
    }

    /**
     * Set status
     *
     * @param $status
     * @return $this
     */
    public function setStatus($status)
    {
        return $this->setAttribute(static::COLUMN_STATUS, $status);
    }

    /**
     * Get Transcription
     *
     * @return mixed
     */
    public function getTranscription()
    {
        return str_replace('%HESITATION', '<br><br>', $this->getAttribute(static::COLUMN_TRANSCRIPTION));
    }

    /**
     * Set Transcription
     *
     * @param $transcription
     * @return $this
     */
    public function setTranscription($transcription)
    {
        return $this->setAttribute(static::COLUMN_TRANSCRIPTION, $transcription);
    }

    /**
     * Get URL
     *
     * @return mixed
     */
    public function getUrl()
    {
        return $this->getAttribute(static::COLUMN_URL);
    }

    /**
     * Set URL
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
        return str_slug(sprintf('%s %s', $this->getPodcastName(), $this->getEpisodeName()));
    }




    /**
     * Get recent podcasts
     *
     * @param $limit
     * @param $afterDate
     *
     * @return Podcast[]
     */
    static function getRecent($limit = 10, $afterDate = null)
    {
        $podcasts = self::orderBy(Podcast::COLUMN_PUBLISHED_DATE, 'desc')->take($limit);

        if ($afterDate) {
            $podcasts = $podcasts->whereDate(Podcast::COLUMN_PUBLISHED_DATE, '>=', $afterDate);
        }

        return $podcasts->get();
    }
}
