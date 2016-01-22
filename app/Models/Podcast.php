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

    const COLUMN_ID = 'id';
    const COLUMN_STATUS = 'status';
    const COLUMN_URL = 'url';
    const COLUMN_TRANSCRIPTION = 'transcription';
    const COLUMN_META = 'meta';
    const COLUMN_PODCAST_NAME = 'podcast_name';
    const COLUMN_EPISODE_NAME = 'episode_name';
    const COLUMN_ORIGINAL_FILE = 'original_file';
    const COLUMN_CONVERTED_FILE = 'converted_file';

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
}
