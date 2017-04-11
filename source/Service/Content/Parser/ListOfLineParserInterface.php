<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-03-30
 */

namespace Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser;

use InvalidArgumentException;

interface ListOfLineParserInterface
{
    /**
     * @param string[] $listOfLine
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function parse(array $listOfLine);
}