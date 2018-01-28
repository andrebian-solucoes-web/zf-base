<?php declare(strict_types=1);

namespace BaseApplication\Repository;

use BaseApplication\Model\SearchResult;

/**
 * Interface ApplicationRepositoryInterface
 * @package BaseApplication\Repository
 */
interface ApplicationRepositoryInterface
{
    /**
     * @param array $data
     * @param bool $returnArrayForExcel
     * @return SearchResult|array
     */
    public function search(array $data, $returnArrayForExcel = false);

    /**
     * @return mixed
     */
    public function countActive();
}
