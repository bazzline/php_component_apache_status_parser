<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-02-01
 */
namespace Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Storage;

use JonasRudolph\PHPComponents\StringUtility\Implementation\StringUtility;

class FullStorage implements StorageInterface
{
    /** @var null|int */
    private $currentIndexKeyForListOfDetail;

    /** @var array */
    private $listOfDetail;

    /** @var array */
    private $listOfInformation;

    /** @var array */
    private $listOfScoreboard;

    /** @var array */
    private $listOfStatistic;

    /** @var StringUtility */
    private $stringUtility;

    /**
     * ContentCollection constructor.
     *
     * @param StringUtility $stringUtility
     */
    public function __construct(
        StringUtility $stringUtility
    ) {
        $this->clear();

        $this->stringUtility = $stringUtility;
    }

    /**
     * @param string $line
     */
    public function addDetail($line)
    {
        //@todo why? - Isn't this a job for the parser?
        $stringTool = $this->stringUtility;

        if (is_null($this->currentIndexKeyForListOfDetail)) {
            ++$this->currentIndexKeyForListOfDetail;
        } else {
            if ($stringTool->startsWith($line, 'Server')) {
                ++$this->currentIndexKeyForListOfDetail;
            }
        }

        if (isset($this->listOfDetail[$this->currentIndexKeyForListOfDetail])) {
            $this->listOfDetail[$this->currentIndexKeyForListOfDetail] .= $line;
        } else {
            $this->listOfDetail[$this->currentIndexKeyForListOfDetail] = $line;
        }
    }

    /**
     * @param string $line
     */
    public function addInformation($line)
    {
        $this->listOfInformation[] = $line;
    }

    /**
     * @param string $line
     */
    public function addScoreboard($line)
    {
        $this->listOfScoreboard[] = $line;
    }

    /**
     * @param string $line
     */
    public function addStatistic($line)
    {
        $this->listOfStatistic[] = $line;
    }

    public function clear()
    {
        $this->currentIndexKeyForListOfDetail   = null;
        $this->listOfDetail                     = [];
        $this->listOfInformation                = [];
        $this->listOfScoreboard                 = [];
        $this->listOfStatistic                  = [];
    }

    /**
     * @return array
     */
    public function getListOfDetail()
    {
        return $this->listOfDetail;
    }

    /**
     * @return array
     */
    public function getListOfInformation()
    {
        return $this->listOfInformation;
    }

    /**
     * @return array
     */
    public function getListOfScoreboard()
    {
        return $this->listOfScoreboard;
    }

    /**
     * @return array
     */
    public function getListOfStatistic()
    {
        return $this->listOfStatistic;
    }

    /**
     * @return boolean
     */
    public function hasListOfDetail()
    {
        return (!empty($this->listOfDetail));
    }

    /**
     * @return boolean
     */
    public function hasListOfInformation()
    {
        return (!empty($this->listOfInformation));
    }

    /**
     * @return boolean
     */
    public function hasListOfScoreboard()
    {
        return (!empty($this->listOfScoreboard));
    }

    /**
     * @return boolean
     */
    public function hasListOfStatistic()
    {
        return (!empty($this->listOfStatistic));
    }
}
