<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-03-26
 */

namespace Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser;

use InvalidArgumentException;
use JonasRudolph\PHPComponents\StringUtility\Implementation\StringUtility;
use Net\Bazzline\Component\ApacheServerStatusParser\DomainModel\Detail;

class DetailLineParser implements LineParserInterface
{
    /** @var StringUtility */
    private $stringUtility;

    /**
     * DetailLineParserTest constructor.
     *
     * @param StringUtility $stringUtility
     */
    public function __construct(
        StringUtility $stringUtility
    ) {
        $this->stringUtility = $stringUtility;
    }

    /**
     * @param string $line
     * @return Detail
     * @throws InvalidArgumentException
     */
    public function parse($line)
    {
        //begin of dependencies
        $stringUtility = $this->stringUtility;
        //end of dependencies

        //begin of business logic
        $lineAsArray = explode(' ', $line);

        $arrayIsInvalid = (count($lineAsArray) < 19);

        if ($arrayIsInvalid) {
            throw new InvalidArgumentException(
                self::class . ' can not parse given line "' . $line . '"'
            );
        }

        $httpMethod = (
            $stringUtility->startsWith($lineAsArray[16], '{')
                ? substr($lineAsArray[16], 1)
                : $lineAsArray[16]
        );
        $pid = filter_var(
                $lineAsArray[2],
                FILTER_SANITIZE_NUMBER_INT
            );
        $status = str_replace(
                [
                    '[',
                    ']'
                ],
                '',
                $lineAsArray[4]
            );
        $uriAuthority = str_replace(
                [
                    '[',
                    ']'
                ],
                '',
                (isset($lineAsArray[19]) ? $lineAsArray[19] : $lineAsArray[18])
            );
        $uriPathWithQuery = (
            $stringUtility->endsWith($lineAsArray[17], '}')
                ? substr($lineAsArray[17], 0, -1)
                : $lineAsArray[17]
        );

        return new Detail(
            $httpMethod,
            $lineAsArray[15],
            $pid,
            $status,
            $uriAuthority,
            $uriPathWithQuery
        );
        //end of business logic
    }
}
