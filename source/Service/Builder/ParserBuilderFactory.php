<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-04-11
 */

namespace Net\Bazzline\Component\ApacheServerStatusParser\Service\Builder;

use JonasRudolph\PHPComponents\StringUtility\Implementation\StringUtility;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser\DetailLineParser;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser\DetailListOfLineParser;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser\InformationListOfLineParser;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser\ScoreboardListOfLineParser;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser\StatisticListOfLineParser;

class ParserBuilderFactory
{
    /**
     * @return ParserBuilder
     */
    public function create()
    {
        $stringUtility = new StringUtility();

        return new ParserBuilder(
            new DetailListOfLineParser(
                new DetailLineParser(
                    $stringUtility
                )
            ),
            new InformationListOfLineParser(
                $stringUtility
            ),
            new ScoreboardListOfLineParser(),
            new StatisticListOfLineParser(
                $stringUtility
            )
        );
    }
}
