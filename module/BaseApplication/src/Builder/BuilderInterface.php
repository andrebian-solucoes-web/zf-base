<?php

namespace BaseApplication\Builder;

/**
 * Interface BuilderInterface
 * @package BaseApplication\Builder
 */
interface BuilderInterface
{
    /**
     * @param array $data
     * @return BuilderInterface
     */
    public function build(array $data): BuilderInterface;

    /**
     * @return mixed
     */
    public function getObject();
}
