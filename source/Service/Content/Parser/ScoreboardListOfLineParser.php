<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-04-07
 */

namespace Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser;

use InvalidArgumentException;
use JonasRudolph\PHPComponents\StringUtility\Implementation\StringUtility;
use Net\Bazzline\Component\ApacheServerStatusParser\DomainModel\Scoreboard;

class ScoreboardListOfLineParser implements ListOfLineParserInterface
{
    /**
     * @param string[] $listOfLine
     *
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function parse(array $listOfLine)
    {
        //begin of business logic
        $listOfLineHasMinimalSize = (count($listOfLine) > 12);

        if ($listOfLineHasMinimalSize) {
            $listOMandatoryProperties   = [
                'list_of_legend'    => [],
                'line_of_process'   => ''
            ];

            $collectListOfLegend    = false;

            foreach ($listOfLine as $line) {
                if ($collectListOfLegend) {
                    $listOMandatoryProperties['list_of_legend'][] = $line;
                } else {
                    if ($line === 'Scoreboard Key:') {
                        $collectListOfLegend = true;
                    } else {
                        $listOMandatoryProperties['line_of_process'] .= $line;
                    }
                }
            }

            foreach ($listOMandatoryProperties as $name => $mandatoryProperty) {
                if (empty($mandatoryProperty)) {
                    throw new InvalidArgumentException(
                        'could not find mandatory property "' . $name . '"'
                    );
                }
            }

            $scoreboard = new Scoreboard(
                $listOMandatoryProperties['line_of_process'],
                $listOMandatoryProperties['list_of_legend']
            );
        } else {
            throw new InvalidArgumentException(
                self::class . ' can not parse given list of line "'
                . implode(',', $listOfLine) . '"'
            );
        }

        return $scoreboard;
        //end of business logic
    }
}