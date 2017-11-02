<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-03-30
 */

namespace Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser;

use InvalidArgumentException;
use JonasRudolph\PHPComponents\StringUtility\Implementation\StringUtility;
use Net\Bazzline\Component\ApacheServerStatusParser\DomainModel\Information;

class InformationListOfLineParser implements ListOfLineParserInterface
{
    /** @var StringUtility */
    private $stringUtility;



    /**
     * InformationListOfLineParser constructor.
     *
     * @param StringUtility $stringUtility
     */
    public function __construct(
        StringUtility $stringUtility
    ) {
        $this->stringUtility    = $stringUtility;
    }

    /**
     * @param string[] $listOfLine
     *
     * @return Information
     * @throws InvalidArgumentException
     * @todo make it beautiful to look at
     */
    public function parse(array $listOfLine)
    {
        //begin of dependencies
        $stringUtility = $this->stringUtility;
        //end of dependencies

        //begin of business logic
        $listOfLineHasMinimalSize = (count($listOfLine) > 3);

        if ($listOfLineHasMinimalSize) {
            $listOfMandatoryPropertyNameToStartsWithPrefix = [
                'date_of_built' => 'Server Built: ',
                'identifier'    => 'Apache Server Status for ',
                'mode_of_mpm'   => 'Server MPM: ',
                'version'       => 'Server Version: '
            ];

            $listOMandatoryProperties = [
                'date_of_built' => null,
                'identifier'    => null,
                'mode_of_mpm'   => null,
                'version'       => null
            ];

            foreach ($listOfLine as $line) {
                //stop repeating yourself, us the $listOfMandatoryPropertyNameToStartsWithPrefix
                //take a look to the StatisticListOfLineParser
                if ($stringUtility->startsWith($line, 'Apache Server Status for ')) {
                    $listOMandatoryProperties['identifier'] = substr($line, 25);    //always use numbers if you are dealing with static strings
                } else if ($stringUtility->startsWith($line, 'Server Version: ')) {
                    $listOMandatoryProperties['version'] = substr($line, 16);
                } else if ($stringUtility->startsWith($line, 'Server MPM: ')) {
                    $listOMandatoryProperties['mode_of_mpm'] = substr($line, 12);
                } else if ($stringUtility->startsWith($line, 'Server Built: ')) {
                    $listOMandatoryProperties['date_of_built'] = substr($line, 14);
                }
            }

            foreach ($listOMandatoryProperties as $name => $mandatoryProperty) {
                if (is_null($mandatoryProperty)) {
                    throw new InvalidArgumentException(
                        'could not find mandatory property "'
                        . $listOfMandatoryPropertyNameToStartsWithPrefix[$name]
                        . '"'
                    );
                }
            }

            $information = new Information(
                $listOMandatoryProperties['date_of_built'],
                $listOMandatoryProperties['identifier'],
                $listOMandatoryProperties['mode_of_mpm'],
                $listOMandatoryProperties['version']
            );
        } else {
            throw new InvalidArgumentException(
                self::class . ' can not parse given list of line "'
                . implode(',', $listOfLine) . '"'
            );
        }

        return $information;
        //end of business logic
    }
}
