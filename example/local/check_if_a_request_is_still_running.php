<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-04-26
 */

require __DIR__ . '/../../vendor/autoload.php';

if ($argc < 2) {
    echo 'Invalid number of arguments provided.' . PHP_EOL;
    echo 'Usage:' . PHP_EOL;
    echo '    ' . basename(__FILE__) . ' <int: pid> [<string: uri path> [<string: path to the example file>]]' . PHP_EOL;

    exit(1);
}
//begin of dependencies
$foundNoMatchingDetail          = true;
$listOfPidToUriPathWithQuery    = [];
$pathToTheExampleFile           = (
    ($argc > 3)
        ? $argv[3]
        : __DIR__ . '/server-status?notable.html'
);
$parserBuilderFactory           = new \Net\Bazzline\Component\ApacheServerStatusParser\Service\Builder\ParserBuilderFactory();
$pid                            = $argv[1];
$stringUtility                  = new \JonasRudolph\PHPComponents\StringUtility\Implementation\StringUtility();
$storageBuilder                 = new \Net\Bazzline\Component\ApacheServerStatusParser\Service\Builder\LocalStorageBuilder();
$uriPath                        = (
($argc > 2)
    ? $argv[2]
    : ''
);
//end of dependencies

//begin of business logic
$parserBuilder      = $parserBuilderFactory->create();
$uriPathProvided    = (strlen($uriPath) > 0);

$storageBuilder->setPathToTheApacheStatusFileToParseUpfront($pathToTheExampleFile);
$storageBuilder->selectParseModeDetailOnlyUpfront();
$storageBuilder->build();

$storage = $storageBuilder->andGetStorageAfterTheBuild();

$parserBuilder->setStorageUpfront($storage);
$parserBuilder->build();

$listOfDetail = $parserBuilder->andGetListOfDetailOrNullAfterwards();

$listOfDetailIsTraversable = (is_array($listOfDetail));

if ($listOfDetailIsTraversable) {
    foreach ($listOfDetail as $detail) {
        $listOfPidToUriPathWithQuery[$detail->pid()] = $detail->uriPathWithQuery();

        if ($detail->pid() == $pid) {
            if ($uriPathProvided) {
                if ($stringUtility->startsWith($detail->uriPathWithQuery(), $uriPath)) {
                    $foundNoMatchingDetail = false;

                    echo ':: Found a request with the pid: "' . $pid . '".' . PHP_EOL;
                    echo ':: Found a request where the uri path with query starts with: "' . $uriPath . '".' . PHP_EOL;
                    echo ':: Uri path with query' . PHP_EOL;
                    echo $detail->uriPathWithQuery() . PHP_EOL;
                }
            } else {
                $foundNoMatchingDetail = false;

                echo ':: Found a request with the pid: "' . $pid . '".' . PHP_EOL;
                echo ':: Uri path with query' . PHP_EOL;
                echo $detail->uriPathWithQuery() . PHP_EOL;
            }
        }
    }

    if ($foundNoMatchingDetail) {
        echo ':: Dumping list of available requests.' . PHP_EOL;
        echo PHP_EOL;
        echo 'pid' . "\t" . 'uri path with query' . PHP_EOL;
        echo '--------------------------------' . PHP_EOL;

        foreach ($listOfPidToUriPathWithQuery as $pid => $uriPathWithQuery) {
            echo $pid . "\t" . $uriPathWithQuery . PHP_EOL;
        }
    }
} else {
    echo ':: Error' . PHP_EOL;
    echo 'no details found in file "' . $pathToTheExampleFile . '"' . PHP_EOL;
}
//end of business logic