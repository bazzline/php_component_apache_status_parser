<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-03-26
 */

namespace Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser;

use InvalidArgumentException;

interface LineParserInterface
{
    /**
     * @param string $line
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function parse($line);
}