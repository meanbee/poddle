<?php

namespace App\Services\Ibm;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

abstract class Ibm
{

    const IBM_URL = null;
    const IBM_SESSION = '/v1/sessions';

    const DEFAULT_REQUEST_METHOD = 'POST';

    /**
     * @var string
     */
    protected $sessionId;

    /**
     * Ibm constructor.
     *
     * @param ClientInterface|null  $client
     * @param SessionInterface|null $session
     * @param array                 $config
     */
    public function __construct(
        ClientInterface $client = null,
        SessionInterface $session = null,
        array $config = []
    )
    {
        $this->client = $client ?: new Client($session, $config);
    }

    /**
     * Return a session id.
     *
     * @return string
     */
    public function getSessionId()
    {
        if(!$this->sessionId) {
            $url = $this->getUrl(static::IBM_SESSION);
            $contents = json_decode($this->request($url)->getBody()->getContents());
            $this->sessionId = $contents->session_id;
        }

        return $this->sessionId;
    }

    /**
     * Get the client
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * A helper method for getting the IBM Api Url.
     *
     * @param string $directory
     *
     * @return string
     * @throws Exception
     */
    public function getUrl($directory = '')
    {
        if(!static::IBM_URL) {
            throw new Exception("You must define the 'IBM_URL' constant in your class when extending `Ibm`");
        }

        return static::IBM_URL . $directory;
    }

    /**
     * A helper method for creating requests.
     *
     * @param string $directory
     * @param string $method
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws Exception
     */
    public function request($directory = '', $method = self::DEFAULT_REQUEST_METHOD) {
        return $this->getClient()->request($method, $this->getUrl($directory), [
            'auth' => [env('IBM_SPEECH_TO_TEXT_USERNAME'), env('IBM_SPEECH_TO_TEXT_PASSWORD')]
        ]);
    }
    
}
