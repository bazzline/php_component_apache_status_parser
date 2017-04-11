<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-02-01
 */
namespace Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Fetcher;

use Net\Bazzline\Component\GenericAgreement\Exception\Runtime;
use RuntimeException;

class FileFetcher extends AbstractFetcher
{
    /** @var string */
    private $path;

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     * @throws \Net\Bazzline\Component\Csv\RuntimeException
     */
    protected function fetchContentAsStringOrThrowRuntimeException()
    {
        //begin of dependencies
        $path   = $this->path;
        //end of dependencies

        //begin of business logic
        if (!is_readable($path)) {
            throw new Runtime(
                'provided path "' . $path . '" is not readable.'
            );
        }

        return file_get_contents($path);
        //begin of business logic
    }
}