<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-03-30
 */

namespace Test\Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Storage;

use JonasRudolph\PHPComponents\StringUtility\Implementation\StringUtility;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Storage\DetailOnlyStorage;
use PHPUnit_Framework_TestCase;

class DetailOnlyStorageTest extends PHPUnit_Framework_TestCase
{
    /** @var DetailOnlyStorage */
    private $storage;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->storage  = new DetailOnlyStorage(
            new StringUtility()
        );
    }

    public function testAddInformation()
    {
        //begin of dependency
        $storage    = $this->storage;
        //end of dependency

        //begin of test
        self::assertEmpty($storage->getListOfInformation());
        $storage->addInformation('tralala');
        self::assertEmpty($storage->getListOfInformation());
        //end of test
    }

    public function testAddScoreboard()
    {
        //begin of dependency
        $storage    = $this->storage;
        //end of dependency

        //begin of test
        self::assertEmpty($storage->getListOfScoreboard());
        $storage->addScoreboard('tralala');
        self::assertEmpty($storage->getListOfScoreboard());
        //end of test
    }

    public function testAddStatistic()
    {
        //begin of dependency
        $storage    = $this->storage;
        //end of dependency

        //begin of test
        self::assertEmpty($storage->getListOfStatistic());
        $storage->addStatistic('tralala');
        self::assertEmpty($storage->getListOfStatistic());
        //end of test
    }
}