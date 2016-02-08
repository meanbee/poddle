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
     * Get RSS feed of podcast.
     */
    public function getRss()
    {
        return $this->hasOne('App\Models\Rss');
    }
}
