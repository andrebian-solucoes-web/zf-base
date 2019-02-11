<?php declare(strict_types=1);

namespace BaseApplication\Repository;

/**
 * Interface ApplicationRepositoryInterface
 * @package BaseApplication\Repository
 * @codeCoverageIgnore
 */
interface ApplicationRepositoryInterface
{
    /**
     * @param array $data
     * @param bool $returnArrayForExcel
     * @return mixed
     */
    public function search(array $data, $returnArrayForExcel = false);

    /**
     * @return mixed
     */
    public function countActive();
}
