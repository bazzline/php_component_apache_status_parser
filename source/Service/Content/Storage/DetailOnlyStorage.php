<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-02-01
 */
namespace Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Storage;

class DetailOnlyStorage extends FullStorage
{
    /**
     * @param string $line
     */
    public function addInformation($line) {}

    /**
     * @param string $line
     */
    public function addScoreboard($line) {}

    /**
     * @param string $line
     */
    public function addStatistic($line) {}

    /**
     * @return boolean
     */
    public function hasListOfInformation()
    {
        return false;
    }

    /**
     * @return boolean
     */
    public function hasListOfScoreboard()
    {
        return false;
    }

    /**
     * @return boolean
     */
    public function hasListOfStatistic()
    {
        return false;
    }
}