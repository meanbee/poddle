<?php

namespace App\Services\Ibm\SpeechToText;

use App\Services\Ibm\SpeechToText;
use GuzzleHttp\Cookie\SetCookie;
use Psr\Http\Message\ResponseInterface;

class Recognize
{

    const CONTENT_TYPE = 'audio/ogg';

    /**
     * @var SpeechToText
     */
    protected $speechToText;

    /**
     * Recognize constructor.
     *
     * @param              $fileName
     * @param              $contentType
     * @param bool         $uri
     * @param SpeechToText $speechToText
     */
    public function __construct(
        $fileName,
        $contentType = self::CONTENT_TYPE,
        $uri = false,
        SpeechToText $speechToText = null
    )
    {
        $this->speechToText = $speechToText ?: new SpeechToText();
    }

    /**
     * Returns only the final results. To enable interim results,
     * use session-based requests or Websockets API. Endianness
     * of the incoming audio is autodetected. Audio files larger
     * than 4 MB are required to be sent in streaming mode
     * (chunked transfer-encoding).
     *
     * Streaming audio size limit is 100 MB. In streaming mode,
     * the connection is closed by the server if no data chunk
     * is received for more than 30 seconds and the last chunk
     * has not been sent yet (if all data has been sent, it can
     * take more than 30 seconds to generate the response and the
     * request will not time out).
     *
     * Use getUrlWithSession() to prevent the session from expiring.
     * The connection is also closed by the server if no speech is
     * detected for "inactivity_timeout" seconds of audio (not
     * processing time). This time can be set by "inactivity_timeout"
     * parameter; the default is 30 seconds.
     *
     * @param string $fileName
     * @param string $contentType
     * @param bool   $uri
     *
     * @return ResponseInterface
     */
    public function recognize($fileName, $contentType, $uri) {
        $pathToFile = base_path("resources/podcasts/{$fileName}");
        $uri = $uri ?: $this->speechToText->getUrlWithSession('/recognize');

        foreach ($this->speechToText->getSetCookieHeader() as $cookie) {
            $cookie = SetCookie::fromString($cookie);
            $cookie->setDomain('stream.watsonplatform.net');
            $this->cookieJar->setCookie($cookie);
        }

        $data[] = [
            'name'     => 'audio_file',
            'contents' => fopen($pathToFile, 'r'),
        ];

        $this->recognize = $this->request($uri, 'POST', [
                'multipart' => $data,
                'cookies'   => $this->cookieJar,
                'headers'   => [
                    'content-type' => $contentType
                ],
            ]
        );

    }
}
