<?php

namespace BaseApplication\Service;

/**
 * Interface ServiceInterface
 * @package BaseApplication\Service
 * @codeCoverageIgnore
 */
interface ServiceInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function save(array $data);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * @param $id
     * @return mixed
     */
    public function inactivate($id);

    /**
     * @param $id
     * @return mixed
     */
    public function activate($id);

    /**
     * @return array
     */
    public function getErrors();
}
