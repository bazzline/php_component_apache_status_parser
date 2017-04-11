<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-04-04
 */

namespace Net\Bazzline\Component\ApacheServerStatusParser\DomainModel;

class Scoreboard implements ReduceDataAbleToArrayInterface
{
    const REDUCED_DATA_TO_ARRAY_KEY_LIST_OF_LEGEND  = 'legend';
    const REDUCED_DATA_TO_ARRAY_KEY_LINE_OF_PROCESS = 'process';

    /** @var string */
    private $lineOfProcess;

    /** @var array */
    private $listOfLegend;

    /**
     * Scoreboard constructor.
     *
     * @param string $lineOfProcess
     * @param array $listOfLegend
     */
    public function __construct(
        $lineOfProcess,
        array $listOfLegend
    )
    {
        $this->lineOfProcess    = $lineOfProcess;
        $this->listOfLegend     = $listOfLegend;
    }

    /**
     * @return string
     */
    public function lineOfProcess()
    {
        return $this->lineOfProcess;
    }

    /**
     * @return array
     */
    public function listOfLegend()
    {
        return $this->listOfLegend;
    }

    /**
     * @return array
     *  [
     *      'legend'    : array,
     *      'process'   : array
     *  ]
     */
    public function reduceDataToArray()
    {
        return [
            self::REDUCED_DATA_TO_ARRAY_KEY_LINE_OF_PROCESS => $this->lineOfProcess,
            self::REDUCED_DATA_TO_ARRAY_KEY_LIST_OF_LEGEND  => $this->listOfLegend
        ];
    }
}