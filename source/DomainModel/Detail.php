<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-03-26
 */

namespace Net\Bazzline\Component\ApacheServerStatusParser\DomainModel;

class Detail implements ReduceDataAbleToArrayInterface
{
    const REDUCED_DATA_TO_ARRAY_KEY_HTTP_METHOD         = 'http_method';
    const REDUCED_DATA_TO_ARRAY_KEY_IP_ADDRESS          = 'ip_address';
    const REDUCED_DATA_TO_ARRAY_KEY_PID                 = 'pid';
    const REDUCED_DATA_TO_ARRAY_KEY_STATUS              = 'status';
    const REDUCED_DATA_TO_ARRAY_KEY_URI_AUTHORITY       = 'uri_authority';
    const REDUCED_DATA_TO_ARRAY_KEY_URI_PATH_WITH_QUERY = 'uri_path_with_query';

    /** @var string */
    private $httpMethod;

    /** @var string */
    private $ipAddress;

    /** @var string */
    private $pid;

    /** @var string */
    private $status;

    /** @var string */
    private $uriAuthority;

    /** @var string */
    private $uriPathWithQuery;

    /**
     * Detail constructor.
     *
     * @param string $httpMethod
     * @param string $ipAddress
     * @param string $pid
     * @param string $status
     * @param string $uriAuthority
     * @param string $uriPathWithQuery
     */
    public function __construct(
        $httpMethod,
        $ipAddress,
        $pid,
        $status,
        $uriAuthority,
        $uriPathWithQuery
    )
    {
        $this->httpMethod       = $httpMethod;
        $this->ipAddress        = $ipAddress;
        $this->pid              = $pid;
        $this->status           = $status;
        $this->uriAuthority     = $uriAuthority;
        $this->uriPathWithQuery = $uriPathWithQuery;
    }

    /**
     * @return string
     */
    public function httpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * @return string
     */
    public function ipAddress()
    {
        return $this->ipAddress;
    }

    /**
     * @return string
     */
    public function pid()
    {
        return $this->pid;
    }

    /**
     * @return string
     */
    public function status()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function uriAuthority()
    {
        return $this->uriAuthority;
    }

    /**
     * @return string
     */
    public function uriPathWithQuery()
    {
        return $this->uriPathWithQuery;
    }

    /**
     * @return array
     *  [
     *      'http_method'           : string,
     *      'ip_address'            : string,
     *      'pid'                   : string,
     *      'status'                : string,
     *      'uri_authority'         : string,
     *      'uri_path_with_query'   : string
     *  ]
     */
    public function reduceDataToArray()
    {
        return [
            self::REDUCED_DATA_TO_ARRAY_KEY_HTTP_METHOD          => $this->httpMethod,
            self::REDUCED_DATA_TO_ARRAY_KEY_IP_ADDRESS           => $this->ipAddress,
            self::REDUCED_DATA_TO_ARRAY_KEY_PID                  => $this->pid,
            self::REDUCED_DATA_TO_ARRAY_KEY_STATUS               => $this->status,
            self::REDUCED_DATA_TO_ARRAY_KEY_URI_AUTHORITY        => $this->uriAuthority,
            self::REDUCED_DATA_TO_ARRAY_KEY_URI_PATH_WITH_QUERY  => $this->uriPathWithQuery
        ];
    }
}