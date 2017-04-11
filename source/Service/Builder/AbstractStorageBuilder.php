<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-04-11
 */

namespace Net\Bazzline\Component\ApacheServerStatusParser\Service\Builder;

use JonasRudolph\PHPComponents\StringUtility\Implementation\StringUtility;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Fetcher\FetcherInterface;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Processor\Processor;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Storage\DetailOnlyStorage;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Storage\FullStorage;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Storage\StorageInterface;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\StateMachine\SectionStateMachine;
use Net\Bazzline\Component\Csv\RuntimeException;

abstract class AbstractStorageBuilder implements BuilderInterface
{
    const PARSE_MODE_ALL            = 'all';
    const PARSE_MODE_DETAIL_ONLY    = 'detail_only';

    /** @var Processor */
    protected $processor;

    /** @var string */
    protected $selectedParseMode;

    public function selectParseModeAllUpfront()
    {
        $this->selectedParseMode = self::PARSE_MODE_ALL;
    }

    public function selectParseModeDetailOnlyUpfront()
    {
        $this->selectedParseMode = self::PARSE_MODE_DETAIL_ONLY;
    }

    /**
     * @throws RuntimeException
     */
    public function build()
    {
        //begin of dependencies
        $fetcher        = $this->buildFetcher();
        $stateMachine   = new SectionStateMachine();
        $stringUtility  = new StringUtility();
        //end of dependencies

        //begin of business logic
        if ($this->isParseModeAllSelected()) {
            $storage = new FullStorage($stringUtility);
        } else if ($this->isParseModeDetailOnly()) {
            $storage = new DetailOnlyStorage($stringUtility);
        } else {
            throw new RuntimeException('no parse mode set');
        }

        $processor = new Processor(
            $stateMachine,
            $stringUtility,
            $storage
        );

        foreach ($fetcher->fetch() as $line) {
            $processor->process($line);
        }

        $this->processor = $processor;
        //end of business logic
    }

    /**
     * @return StorageInterface
     */
    public function andGetStorageAfterTheBuild()
    {
        return $this->processor->getStorage();
    }

    /**
     * @return FetcherInterface
     */
    abstract protected function buildFetcher();

    /**
     * @return bool
     */
    protected function isParseModeAllSelected()
    {
        return ($this->selectedParseMode === self::PARSE_MODE_ALL);
    }

    /**
     * @return bool
     */
    protected function isParseModeDetailOnly()
    {
        return ($this->selectedParseMode === self::PARSE_MODE_DETAIL_ONLY);
    }
}