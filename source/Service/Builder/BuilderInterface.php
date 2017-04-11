<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-04-10
 */

namespace Net\Bazzline\Component\ApacheServerStatusParser\Service\Builder;

use RuntimeException;

interface BuilderInterface
{
    /**
     * @throws RuntimeException
     */
    public function build();
}
