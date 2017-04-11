<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-02-01
 */
namespace Net\Bazzline\Component\ApacheServerStatusParser\Service\StateMachine;

class SectionStateMachine
{
    const STATE_OF_DETAIL       = 'detail';
    const STATE_OF_INFORMATION  = 'information';
    const STATE_OF_SCOREBOARD   = 'scoreboard';
    const STATE_OF_STATISTIC    = 'statistic';

    /** @var string */
    private $currentState;

    public function __construct()
    {
        $this->reset();
    }

    public function reset()
    {
        $this->setCurrentStateToInformation();
    }

    public function setCurrentStateToDetail()
    {
        $this->currentState = self::STATE_OF_DETAIL;
    }

    public function setCurrentStateToInformation()
    {
        $this->currentState = self::STATE_OF_INFORMATION;
    }

    public function setCurrentStateToScoreboard()
    {
        $this->currentState = self::STATE_OF_SCOREBOARD;
    }

    public function setCurrentStateToStatistic()
    {
        $this->currentState = self::STATE_OF_STATISTIC;
    }

    /**
     * @return bool
     */
    public function theCurrentStateIsDetail()
    {
        return ($this->currentState === self::STATE_OF_DETAIL);
    }

    /**
     * @return bool
     */
    public function theCurrentStateIsInformation()
    {
        return ($this->currentState === self::STATE_OF_INFORMATION);
    }

    /**
     * @return bool
     */
    public function theCurrentStateIsScoreboard()
    {
        return ($this->currentState === self::STATE_OF_SCOREBOARD);
    }

    /**
     * @return bool
     */
    public function theCurrentStateIsStatistic()
    {
        return ($this->currentState === self::STATE_OF_STATISTIC);
    }
}