<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-02-01
 */
namespace Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Fetcher;

use RuntimeException;

interface FetcherInterface
{
    /**
     * @return array
     * @throws RuntimeException
     */
    public function fetch();
}