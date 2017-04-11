<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-03-29
 */

namespace Test\Net\Bazzline\Component\ApacheServerStatus\Service\Content\Parser;

use InvalidArgumentException;
use JonasRudolph\PHPComponents\StringUtility\Implementation\StringUtility;
use Net\Bazzline\Component\ApacheServerStatusParser\DomainModel\Detail;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser\DetailLineParser;
use PHPUnit_Framework_TestCase;

class DetailLineParserTest extends PHPUnit_Framework_TestCase
{
    /** @var DetailLineParser */
    private $parser;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->parser   = new DetailLineParser(
            new StringUtility()
        );
    }

    /**
     * @param string $line
     * @expectedException InvalidArgumentException
     * @dataProvider invalidTestCaseDataProvider
     */
    public function testParseWithInvalidContent($line)
    {
        //begin of dependencies
        $parser = $this->parser;
        //end of dependencies

        //begin of business logic
        $parser->parse($line);
        //end of business logic
    }

    /**
     * @param string $line
     * @param Detail $expectedDetail
     * @dataProvider validTestCaseDataProvider
     */
    public function testParseValidContent($line, Detail $expectedDetail)
    {
        //begin of dependencies
        $parser = $this->parser;
        //end of dependencies

        //begin of business logic
        $parsedDetail   = $parser->parse($line);

        self::assertEquals($expectedDetail->reduceDataToArray(), $parsedDetail->reduceDataToArray());
        //end of business logic
    }


    public function invalidTestCaseDataProvider()
    {
        return [
            [
                'line'  => 'Server Detail'
            ],
            [
                'line'  => 'Server0-0(22754): 0|24|186 [Ready] u47.68 s5.9 cu0 cs0 19 1 (0 B|1.0 MB|3.5 MB) 198.76.54.42 {GET / HTTP/1.1} [example.host.org:80]'
            ]
        ];
    }

    /**
     * @return array
     */
    public function validTestCaseDataProvider()
    {
        return [
            [
                'line'              => 'Server 0-0 (22754): 0|24|186 [Ready] u47.68 s5.9 cu0 cs0 19 1 (0 B|1.0 MB|3.5 MB) 198.76.54.42 {GET / HTTP/1.1} [example.host.org:80]',
                'expected_detail'   => new Detail(
                    'GET',
                    '198.76.54.42',
                    '22754',
                    'Ready',
                    'example.host.org:80',
                    '/'
                )
            ],
            [
                'line'              => 'Server 1-0 (5743): 0|255|427 [Write] u157.22 s21.37 cu.4 cs.35 6 0 (0 B|183.1 kB|372.5 kB) 123.45.67.121 {GET /example/backend/api/important-process-name} [example.host.org:80]',
                'expected_detail'   => new Detail(
                    'GET',
                    '123.45.67.121',
                    '5743',
                    'Write',
                    'example.host.org:80',
                    '/example/backend/api/important-process-name'
                )
            ]
        ];
    }
}