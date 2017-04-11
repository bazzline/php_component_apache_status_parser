<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-04-07
 */

namespace Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser;

use InvalidArgumentException;
use Net\Bazzline\Component\ApacheServerStatusParser\DomainModel\Detail;

class DetailListOfLineParser implements ListOfLineParserInterface
{
    /** @var DetailLineParser */
    private $detailLineParser;

    /**
     * DetailListOfLineParser constructor.
     *
     * @param DetailLineParser $detailLineParser
     */
    public function __construct(
        DetailLineParser $detailLineParser
    )
    {
        $this->detailLineParser = $detailLineParser;
    }

    /**
     * @param string[] $listOfLine
     *
     * @return Detail[]
     * @throws InvalidArgumentException
     */
    public function parse(array $listOfLine)
    {
        //begin of dependencies
        $detailLineParser           = $this->detailLineParser;
        $listOfParsedDetailLines    = [];
        //end of dependencies

        //begin of business logic
        foreach ($listOfLine as $line) {
            try {
                $listOfParsedDetailLines[]  = $detailLineParser->parse($line);
            } catch (InvalidArgumentException $invalidArgumentException) {
                //echo get_class($detailLineParser) . ' could not parse the following line:' . PHP_EOL;
                //echo '    ' . $line . PHP_EOL;
                //echo $invalidArgumentException->getMessage() . PHP_EOL;
            }
        }

        return $listOfParsedDetailLines;
        //end of business logic
    }
}