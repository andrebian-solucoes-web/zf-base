<?php

namespace BaseApplication\Controller;

/**
 * Interface BindPreFormDataInterface
 * @package BaseApplication\Controller
 */
interface BindPreFormDataInterface
{
    /**
     * Intercept data before instantiate form. Eg: on post receive.
     *
     * @param array $data
     * @return mixed
     */
    public function bindPreFormData(array $data);
}
