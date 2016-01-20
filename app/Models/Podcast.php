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
    const STATUS_AUDIO_TO_TEXT_CONVERSION_FAILED = 'audio_to_text_convertion_failed';
    const STATUS_TEXT_CONCEPTS_IDENTIFIED = 'text_concepts_identified';
    const STATUS_TEXT_CONCEPTS_IDENTIFICATION_FAILED = 'text_concepts_identification_failed';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'podcast_name',
        'episode_name',
        'url'
    ];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
}
