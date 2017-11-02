<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-04-09
 */

namespace Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Fetcher;

use Exception;
use Net\Bazzline\Component\Curl\Builder\Builder;
use RuntimeException;

class HttpFetcher extends AbstractFetcher
{
    const STATUS_CODE_HIGHER_THAN_ALLOWED_EXCEPTION_MESSAGE = 'Returned response code >>%d<< is above the limit of >>%d<<. Dumping the response >>%s<<.';

    /** @var int */
    private $highestAllowedStatusCode;

    /** @var Builder */
    private $requestBuilder;

    /** @var string */
    private $url;



    /**
     * HttpFetcher constructor.
     *
     * @param Builder $builder
     * @param int $highestAllowedStatusCode
     */
    public function __construct(
        Builder $builder,
        $highestAllowedStatusCode = 400
    ) {
        $this->requestBuilder           = $builder;
        $this->highestAllowedStatusCode = $highestAllowedStatusCode;
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
     * @throws RuntimeException
     * @throws Exception
     */
    protected function fetchContentAsStringOrThrowRuntimeException()
    {
        //begin of dependencies
        $highestAllowedStatusCode   = $this->highestAllowedStatusCode;
        $requestBuilder             = $this->requestBuilder;
        $url                        = $this->url;
        //end of dependencies

        //begin of business logic
        $requestBuilder->useGet();
        $requestBuilder->onTheUrl($url . '?notable');

        $response = $requestBuilder->andFetchTheResponse();

        if ($response->statusCode() >= $highestAllowedStatusCode) {
            throw new RuntimeException(
                sprintf(
                    self::STATUS_CODE_HIGHER_THAN_ALLOWED_EXCEPTION_MESSAGE,
                    $response->statusCode(),
                    $highestAllowedStatusCode,
                    implode(', ' , $response->convertIntoAnArray())
                )
            );
        }

        return $response->content();
        //end of business logic
    }
}
