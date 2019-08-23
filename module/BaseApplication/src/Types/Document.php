<?php declare(strict_types=1);

namespace BaseApplication\Types;

/**
 * Interface Document
 * @package BaseApplication\Types
 */
interface Document
{
    /**
     * Returns a masked string
     *
     * @return string
     */
    public function masked(): string;

    /**
     * Returns an unmasked string
     *
     * @return string
     */
    public function unmasked(): string;
}
