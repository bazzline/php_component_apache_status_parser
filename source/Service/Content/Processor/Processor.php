<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-02-01
 */
namespace Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Processor;

use JonasRudolph\PHPComponents\StringUtility\Implementation\StringUtility;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Storage\StorageInterface;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\StateMachine\SectionStateMachine;

class Processor
{
    /** @var SectionStateMachine */
    private $stateMachine;

    /** @var StringUtility */
    private $stringUtility;

    /** @var StorageInterface */
    private $storage;

    /**
     * Parser constructor.
     *
     * @param SectionStateMachine $stateMachine
     * @param StringUtility $stringUtility
     * @param StorageInterface $storage
     */
    public function __construct(
        SectionStateMachine $stateMachine,
        StringUtility $stringUtility,
        StorageInterface $storage
    ) {
        $storage->clear();
        $stateMachine->reset();

        $this->stateMachine     = $stateMachine;
        $this->stringUtility    = $stringUtility;
        $this->storage          = $storage;
    }

    /**
     * @param string $line
     */
    public function process($line)
    {
        //begin of dependencies
        $stateMachine   = $this->stateMachine;
        $stringUtility  = $this->stringUtility;
        $storage        = $this->storage;
        //end of dependencies

        //begin of business logic
        if ($stringUtility->startsWith($line, 'Current Time:')) {
            $stateMachine->setCurrentStateToStatistic();
        } else if ($stringUtility->startsWith($line, 'Server Details')) {
            $stateMachine->setCurrentStateToDetail();
        }

        if ($stateMachine->theCurrentStateIsDetail()) {
            $storage->addDetail($line);
        } else if ($stateMachine->theCurrentStateIsInformation()) {
            $storage->addInformation($line);
        } else if ($stateMachine->theCurrentStateIsScoreboard()) {
            $storage->addScoreboard($line);
        } else if ($stateMachine->theCurrentStateIsStatistic()) {
            $storage->addStatistic($line);
        }

        if ($stringUtility->contains($line, 'requests currently being processed')) {
            $stateMachine->setCurrentStateToScoreboard();
        }
        //end of business logic
    }

    /**
     * @return StorageInterface
     */
    public function getStorage()
    {
        return $this->storage;
    }
}
