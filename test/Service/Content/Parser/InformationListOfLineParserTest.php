<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-03-30
 */

namespace Test\Net\Bazzline\Component\ApacheServerStatus\Service\Content\Parser;

use JonasRudolph\PHPComponents\StringUtility\Implementation\StringUtility;
use Net\Bazzline\Component\ApacheServerStatusParser\DomainModel\Information;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser\InformationListOfLineParser;
use PHPUnit_Framework_TestCase;

class InformationListOfLineParserTest extends PHPUnit_Framework_TestCase
{
    /** @var InformationListOfLineParser */
    private $parser;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->parser   = new InformationListOfLineParser(
            new StringUtility()
        );
    }



    /**
     * @param array|string[] $listOfLine
     * @param Information $expectedInformation
     * @throws \InvalidArgumentException
     * @internal param $Information
     * @dataProvider validTestCaseDataProvider
     */
    public function testParseListOfLine(array $listOfLine, Information $expectedInformation)
    {
        //begin of dependency
        $parser = $this->parser;
        //end of dependency

        //begin of test
        $information    = $parser->parse($listOfLine);
        self::assertEquals(
            $expectedInformation->reduceDataToArray(),
            $information->reduceDataToArray()
        );
        //end of test
    }

    /**
     * @return array
     */
    public function validTestCaseDataProvider()
    {
        return [
            [
                'list_of_lines'  => [
                    'Apache Status',
                    'Apache Server Status for first.example.host.org (via 123.45.67.89)',
                    'Server Version: Apache/2.4.10 (Debian)',
                    'Server MPM: prefork',
                    'Server Built: Oct 06 1983 20:44:43'
                ],
                'expected_information'  => new Information(
                    'Oct 06 1983 20:44:43',
                    'first.example.host.org (via 123.45.67.89)',
                    'prefork',
                    'Apache/2.4.10 (Debian)'
                )
            ]
        ];
    }
}
