<?php
namespace App\Utilities;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
//use phpDocumentor\Reflection\Types\This;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

/**
 * HttpClient Wrapper class.
 *
 */
class HttpClient extends Client
{
    /**
     *
     * @var string
     */
    const HTTPCLIENT_CONNECTION_TIMEOUT = 20;

    /**
     *
     * @var string
     */
    const GET = 'GET';

    /**
     *
     * @var string
     */
    const POST = 'POST';

    /**
     *
     * @var string
     */
    const DELETE = 'DELETE';

    /**
     *
     * @var array
     */
    private $defaultOptions = [ ];

    /**
     *
     * @var string
     */
    private $baseUri;

    /**
     * HttpClient constructor.
     *
     * @param string $baseUri
     * @param array  $options
     */
    public function __construct($baseUri, $options = [])
    {
        parent::__construct([
                'base_url' => $baseUri
        ]);

        $this->baseUri = $baseUri;

        $this->defaultOptions = $options;
        $this->defaultOptions ['connect_timeout'] = self::HTTPCLIENT_CONNECTION_TIMEOUT;
        ;
        $this->defaultOptions ['verify'] = false;
        $this->defaultOptions ['http_errors'] = true;
    }

    /**
     * Makes a http request and return s response.
     *
     * @param string $endpoint
     * @param array|string|resource  $params
     * @param string $method
     * @param array  $options
     * @return Response
     * @throws GuzzleHttp\Exception\RequestException
     */
    public function makeRequest($endpoint, $params, $method = self::GET, $options = [], $isJsonData = false,
            $isMultipart = false)
    {
        $this->defaultOptions = array_merge($this->defaultOptions, $options);

        if ($method == self::POST) {
            if ($isJsonData) {
                $this->defaultOptions ['json'] = $params;
            } else if ($isMultipart) {
                $this->defaultOptions ['multipart'] = $params;
            } else {
                $this->defaultOptions ['body'] = $params;
            }
        } else if ($method == self::GET) {
            $this->defaultOptions ['query'] = $params;
        }

        // $request = new Request($method, $endpoint);
        $url = $this->baseUri . $endpoint;
        Log::info('BASE: ' . $this->baseUri);
        Log::info('URL: ' . $url);

        $response = $this->request($method, $url, $this->defaultOptions);

        return $response;
    }
}
