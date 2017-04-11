<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-03-30
 */

namespace Net\Bazzline\Component\ApacheServerStatusParser\DomainModel;

class Information implements ReduceDataAbleToArrayInterface
{
    const REDUCED_DATA_TO_ARRAY_KEY_DATE_OF_BUILT   = 'date_of_built';
    const REDUCED_DATA_TO_ARRAY_KEY_IDENTIFIER      = 'identifier';
    const REDUCED_DATA_TO_ARRAY_KEY_MODE_OF_MPM     = 'mode_of_mpm';
    const REDUCED_DATA_TO_ARRAY_KEY_VERSION         = 'version';

    /** @var string */
    private $dateOfBuilt;

    /** @var string */
    private $identifier;

    /** @var string */
    private $modeOfMpm;

    /** @var string */
    private $version;

    /**
     * Information constructor.
     *
     * @param string $dateOfBuilt
     * @param string $identifier
     * @param string $modeOfMpm
     * @param string $version
     */
    public function __construct(
        $dateOfBuilt,
        $identifier,
        $modeOfMpm,
        $version
    )
    {
        $this->dateOfBuilt  = $dateOfBuilt;
        $this->identifier   = $identifier;
        $this->modeOfMpm    = $modeOfMpm;
        $this->version      = $version;
    }

    /**
     * @return string
     */
    public function dateOfBuilt()
    {
        return $this->dateOfBuilt;
    }

    /**
     * @return string
     */
    public function identifier()
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function modeOfMpm()
    {
        return $this->modeOfMpm;
    }

    /**
     * @return string
     */
    public function version()
    {
        return $this->version;
    }

    /**
     * @return array
     *  [
     *      'date_of_built' : string,
     *      'identifier'    : string,
     * '    'mode_of_mpm'   : string,
     *      'version'       : string
     *  ]
     */
    public function reduceDataToArray()
    {
        return [
            self::REDUCED_DATA_TO_ARRAY_KEY_DATE_OF_BUILT   => $this->dateOfBuilt(),
            self::REDUCED_DATA_TO_ARRAY_KEY_IDENTIFIER      => $this->identifier(),
            self::REDUCED_DATA_TO_ARRAY_KEY_MODE_OF_MPM     => $this->modeOfMpm(),
            self::REDUCED_DATA_TO_ARRAY_KEY_VERSION         => $this->version()
        ];
    }
}