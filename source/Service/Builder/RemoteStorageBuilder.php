<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-04-11
 */

namespace Net\Bazzline\Component\ApacheServerStatusParser\Service\Builder;

use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Fetcher\FetcherInterface;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Fetcher\HttpFetcher;
use Net\Bazzline\Component\Curl\Builder\BuilderFactory;

class RemoteStorageBuilder extends AbstractStorageBuilder
{
    /** @var HttpFetcher */
    private $fetcher;

    /** @var string */
    private $url;

    public function __construct()
    {
        $factory = new BuilderFactory();

        $this->fetcher = new HttpFetcher(
            $factory->create()
        );
    }

    /**
     * @param string $url
     */
    public function setUrlToTheApacheStatusFileToParseUpfront($url)
    {
        $this->url = $url;
    }

    /**
     * @return FetcherInterface
     */
    protected function buildFetcher()
    {
        //begin of dependencies
        $fetcher    = $this->fetcher;
        $url        = $this->url;
        //end of dependencies

        //begin of business logic
        $fetcher->setUrl($url);

        return $fetcher;
        //end of business logic
    }
}
