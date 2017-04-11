<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-04-12
 */

namespace Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Fetcher;

use Net\Bazzline\Component\Csv\RuntimeException;

abstract class AbstractFetcher implements FetcherInterface
{
    /**
     * @return array
     * @throws RuntimeException
     */
    public function fetch()
    {
        //begin of business logic
        $contentAsString        = strip_tags($this->fetchContentAsStringOrThrowRuntimeException());
        $contentAsArray = explode(PHP_EOL, $contentAsString);

        $lines = array_filter(
            $contentAsArray,
            function ($item) {
                return (strlen(trim($item)) > 0);
            }
        );

        return $lines;
        //end of business logic
    }

    /**
     * @return string
     * @throws RuntimeException
     */
    abstract protected function fetchContentAsStringOrThrowRuntimeException();
}