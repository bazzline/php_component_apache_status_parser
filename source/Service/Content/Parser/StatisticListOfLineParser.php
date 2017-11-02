<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-04-04
 */

namespace Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Parser;

use InvalidArgumentException;
use JonasRudolph\PHPComponents\StringUtility\Implementation\StringUtility;
use Net\Bazzline\Component\ApacheServerStatusParser\DomainModel\Statistic;

class StatisticListOfLineParser implements ListOfLineParserInterface
{
    /** @var StringUtility */
    private $stringUtility;

    public function __construct(
        StringUtility $stringUtility
    ) {
        $this->stringUtility = $stringUtility;
    }

    /**
     * @param string[] $listOfLine
     *
     * @return Statistic
     * @throws InvalidArgumentException
     */
    public function parse(array $listOfLine)
    {
        //begin of dependencies
        $stringUtility  = $this->stringUtility;
        //end of dependencies

        //begin of business logic
        $listOfLineHasMinimalSize = (count($listOfLine) > 9);

        if ($listOfLineHasMinimalSize) {
            $listOfMandatoryPropertyNameToStartsWithPrefix  = [
                'current_timestamp'                         => 'Current Time: ',
                'cpu_usage'                                 => 'CPU Usage: ',
                'parent_server_configuration_generation'    => 'Parent Server Config. Generation: ',
                'parent_server_mpm_generation'              => 'Parent Server MPM Generation: ',
                'restart_time'                              => 'Restart Time: ',
                'server_up_time'                            => 'Server uptime:  ',
                'server_load'                               => 'Server load: ',
                'total_accesses'                            => 'Total accesses: '
            ];
            /**
             * always use numbers if you are dealing with static strings
             * <prefix >: string length
                Current Time: : 14
                CPU Usage: : 11
                Parent Server Config. Generation: : 34
                Parent Server MPM Generation: : 30
                Restart Time: : 14
                Server uptime:  : 16
                Server load: : 13
                Total accesses: : 16
                Total Traffic: : 15
             */

            $listOMandatoryProperties   = [
                'b_per_seconds'                             => null,
                'current_time'                              => null,
                'cpu_load'                                  => null,
                'cpu_usage'                                 => null,
                'idle_workers'                              => null,
                'kb_per_seconds'                            => null,
                'parent_server_configuration_generation'    => null,
                'parent_server_mpm_generation'              => null,
                'request_per_seconds'                       => null,
                'request_currently_being_processed'         => null,
                'restart_time'                              => null,
                'server_up_time'                            => null,
                'server_load'                               => null,
                'total_accesses'                            => null,
                'total_traffic'                             => null
            ];

            foreach ($listOfLine as $line) {
                if ($stringUtility->startsWith($line, $listOfMandatoryPropertyNameToStartsWithPrefix['current_timestamp'])) {
                    $listOMandatoryProperties['current_time'] = strtotime(
                        substr($line, 14)
                    );
                } else if ($stringUtility->startsWith($line, $listOfMandatoryPropertyNameToStartsWithPrefix['cpu_usage'])) {
                    $lineAsArray = explode(' - ', $line);

                    $listOMandatoryProperties['cpu_load'] = filter_var(
                        $lineAsArray[1],
                        FILTER_SANITIZE_NUMBER_INT
                    );
                    $listOMandatoryProperties['cpu_usage'] = substr($lineAsArray[0], 11);
                } else if ($stringUtility->startsWith($line, $listOfMandatoryPropertyNameToStartsWithPrefix['parent_server_configuration_generation'])) {
                    $listOMandatoryProperties['parent_server_configuration_generation'] = substr($line, 34);
                } else if ($stringUtility->startsWith($line, $listOfMandatoryPropertyNameToStartsWithPrefix['parent_server_mpm_generation'])) {
                    $listOMandatoryProperties['parent_server_mpm_generation'] = substr($line, 30);
                } else if ($stringUtility->startsWith($line, $listOfMandatoryPropertyNameToStartsWithPrefix['restart_time'])) {
                    $listOMandatoryProperties['restart_time'] = strtotime(
                        substr($line, 14)
                    );
                } else if ($stringUtility->startsWith($line, $listOfMandatoryPropertyNameToStartsWithPrefix['server_up_time'])) {
                    $listOMandatoryProperties['server_up_time'] = substr($line, 16);
                } else if ($stringUtility->startsWith($line, $listOfMandatoryPropertyNameToStartsWithPrefix['server_load'])) {
                    $listOMandatoryProperties['server_load'] = substr($line, 13);
                } else if ($stringUtility->startsWith($line, $listOfMandatoryPropertyNameToStartsWithPrefix['total_accesses'])) {
                    $lineAsArray    = explode(' - ', $line);

                    $listOMandatoryProperties['total_accesses'] = substr($lineAsArray[0], 16);
                    $listOMandatoryProperties['total_traffic']  = substr($lineAsArray[1], 15);
                } else if ($stringUtility->endsWith($line, 'request')) {
                    $lineAsArray    = explode(' - ', $line);

                    $listOMandatoryProperties['b_per_seconds']                      = filter_var(
                        $lineAsArray[1],
                        FILTER_SANITIZE_NUMBER_INT
                    );
                    $listOMandatoryProperties['kb_per_seconds']                     = filter_var(
                        $lineAsArray[2],
                        FILTER_SANITIZE_NUMBER_INT
                    );
                    $listOMandatoryProperties['request_per_seconds']                = filter_var(
                        $lineAsArray[0],
                        FILTER_SANITIZE_NUMBER_INT
                    );
                } else if ($stringUtility->endsWith($line, 'workers')) {
                    $lineAsArray    = explode(',', $line);

                    $listOMandatoryProperties['idle_workers']                       = filter_var(
                        $lineAsArray[1],
                        FILTER_SANITIZE_NUMBER_INT
                    );
                    $listOMandatoryProperties['request_currently_being_processed']  = filter_var(
                        $lineAsArray[0],
                        FILTER_SANITIZE_NUMBER_INT
                    );
                }
            }

            foreach ($listOMandatoryProperties as $name => $mandatoryProperty) {
                if (is_null($mandatoryProperty)) {
                    throw new InvalidArgumentException(
                        'could not find mandatory property "'
                        . $listOfMandatoryPropertyNameToStartsWithPrefix[$name]
                        . '"'
                    );
                }
            }

            $statistic = new Statistic(
                $listOMandatoryProperties['b_per_seconds'],
                $listOMandatoryProperties['cpu_load'],
                $listOMandatoryProperties['cpu_usage'],
                $listOMandatoryProperties['current_time'],
                $listOMandatoryProperties['idle_workers'],
                $listOMandatoryProperties['kb_per_seconds'],
                $listOMandatoryProperties['parent_server_configuration_generation'],
                $listOMandatoryProperties['parent_server_configuration_generation'],
                $listOMandatoryProperties['request_currently_being_processed'],
                $listOMandatoryProperties['request_per_seconds'],
                $listOMandatoryProperties['restart_time'],
                $listOMandatoryProperties['server_load'],
                $listOMandatoryProperties['server_up_time'],
                $listOMandatoryProperties['total_accesses'],
                $listOMandatoryProperties['total_traffic']
            );
        } else {
            throw new InvalidArgumentException(
                self::class . ' can not parse given list of line "'
                . implode(',', $listOfLine) . '"'
            );
        }

        return $statistic;
        //end of business logic
    }
}
