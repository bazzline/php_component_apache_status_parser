<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-02-01
 */
namespace Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Storage;

interface StorageInterface
{
    /**
     * @param string $line
     */
    public function addDetail($line);

    /**
     * @param string $line
     */
    public function addInformation($line);

    /**
     * @param string $line
     */
    public function addScoreboard($line);

    /**
     * @param string $line
     */
    public function addStatistic($line);

    public function clear();

    /**
     * @return array
     */
    public function getListOfDetail();

    /**
     * @return array
     */
    public function getListOfInformation();

    /**
     * @return array
     */
    public function getListOfScoreboard();

    /**
     * @return array
     */
    public function getListOfStatistic();

    /**
     * @return boolean
     */
    public function hasListOfDetail();

    /**
     * @return boolean
     */
    public function hasListOfInformation();

    /**
     * @return boolean
     */
    public function hasListOfScoreboard();

    /**
     * @return boolean
     */
    public function hasListOfStatistic();
}