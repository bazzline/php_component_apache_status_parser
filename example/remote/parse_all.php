<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-01-31
 */
use Net\Bazzline\Component\ApacheServerStatusParser\DomainModel\ReduceDataAbleToArrayInterface;

require __DIR__ . '/../../vendor/autoload.php';

//begin of helper functions
/**
 * @param array $array
 * @param string $prefix
 */
function dumpArray(array $array, $prefix = '  ')
{
    foreach ($array as $item => $value) {
        if ($value instanceof ReduceDataAbleToArrayInterface) {
            echo $prefix . $item . PHP_EOL;
            dumpArray($value->reduceDataToArray(), str_repeat($prefix, 2));
        } else if (is_array($value)) {
            echo $prefix . $item . PHP_EOL;
            dumpArray($value, str_repeat($prefix, 2));
        } else {
            echo $prefix . $item . ': ' . $value . PHP_EOL;
        }
    }
}

/**
 * @param null|array $lines
 * @param string $name
 */
function dumpSectionIfThereIsSomeContent(array $lines = null, $name)
{
    if (!is_null($lines)) {
        if (!empty($lines)) {
            echo '==== ' . $name . ' ====' . PHP_EOL;
            echo PHP_EOL;

            dumpArray($lines);

            echo PHP_EOL;
        }
    }
}
//end of helper functions

//begin of dependencies
$listOfNameToElapsedTime    = [];
$parserBuilderFactory       = new \Net\Bazzline\Component\ApacheServerStatusParser\Service\Builder\ParserBuilderFactory();
$storageBuilder             = new \Net\Bazzline\Component\ApacheServerStatusParser\Service\Builder\RemoteStorageBuilder();
$urlToTheExampleFile        = (
    ($argc > 1)
        ? $argv[1]
        : 'http://testdata.bazzline.net/apache_server_status/index.html'
);

$parserBuilder = $parserBuilderFactory->create();
//end of dependencies

//begin of business logic
PHP_Timer::start();

$storageBuilder->setUrlToTheApacheStatusFileToParseUpfront($urlToTheExampleFile);
$storageBuilder->selectParseModeAllUpfront();
$storageBuilder->build();

$listOfNameToElapsedTime['fetching'] = PHP_Timer::secondsToTimeString(
    PHP_Timer::stop()
);

$storage = $storageBuilder->andGetStorageAfterTheBuild();

dumpSectionIfThereIsSomeContent($storage->getListOfInformation(), 'Information');
dumpSectionIfThereIsSomeContent($storage->getListOfDetail(), 'Detail');
dumpSectionIfThereIsSomeContent($storage->getListOfScoreboard(), 'Scoreboard');
dumpSectionIfThereIsSomeContent($storage->getListOfStatistic(), 'Statistic');

PHP_Timer::start();

$parserBuilder->setStorageUpfront($storage);
$parserBuilder->build();

$listOfNameToElapsedTime['parsing'] = PHP_Timer::secondsToTimeString(
    PHP_Timer::stop()
);

dumpSectionIfThereIsSomeContent(
    $parserBuilder->andGetListOfDetailOrNullAfterwards(),
    'Parsed Detail'
);

dumpSectionIfThereIsSomeContent(
    [
        $parserBuilder->andGetInformationOrNullAfterwards()
    ],
    'Parsed Information'
);

dumpSectionIfThereIsSomeContent(
    [
        $parserBuilder->andGetScoreboardOrNullAfterwards()
    ],
    'Parsed Scoreboard'
);

dumpSectionIfThereIsSomeContent(
    [
        $parserBuilder->andGetStatisticOrNullAfterwards()
    ],
    'Parsed Statistic'
);

foreach ($listOfNameToElapsedTime as $name => $elapsedTime) {
    echo $name . ' took: ' . $elapsedTime . PHP_EOL;
}
//end of business logic
