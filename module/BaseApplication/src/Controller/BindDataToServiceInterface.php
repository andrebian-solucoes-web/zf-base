<?php

namespace BaseApplication\Controller;

/**
 * Interface BindDataToServiceInterface
 * @package BaseApplication\Controller
 */
interface BindDataToServiceInterface
{
    /**
     * Prepares data before call $service->save();
     *
     * Here you can fetch the entities references and many others possibilities.
     *
     * @param array $data
     * @return mixed
     */
    public function bindDataToService(array $data);
}
