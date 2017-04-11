<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-04-09
 */

namespace Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Fetcher;

use Net\Bazzline\Component\Curl\Builder\Builder;
use RuntimeException;

class HttpFetcher extends AbstractFetcher
{
    /** @var Builder */
    private $requestBuilder;

    /** @var string */
    private $url;

    /**
     * HttpFetcher constructor.
     *
     * @param Builder $builder
     */
    public function __construct(
        Builder $builder
    )
    {
        $this->requestBuilder   = $builder;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url  = $url;
    }

    /**
     * @return string
     * @throws \Net\Bazzline\Component\Csv\RuntimeException
     */
    protected function fetchContentAsStringOrThrowRuntimeException()
    {
        //begin of dependencies
        $requestBuilder = $this->requestBuilder;
        $url            = $this->url;
        //end of dependencies

        //begin of business logic
        $requestBuilder->useGet();
        $requestBuilder->onTheUrl($url . '?notable');

        $response = $requestBuilder->andFetchTheResponse();

        if ($response->statusCode() >= 300) {
            throw new RuntimeException(
                'something went wrong when using the url "' . $url . '"' . PHP_EOL
                . 'dumping the response: ' . implode(', ', $response->convertIntoAnArray())
            );
        }

        return $response->content();
        //end of business logic
    }
}