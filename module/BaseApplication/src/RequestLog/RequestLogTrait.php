<?php

namespace BaseApplication\RequestLog;

use Zend\Db\Adapter\Adapter;
use Zend\Mvc\MvcEvent;

/**
 * Trait RequestLogTrait
 * @package BaseApplication\RequestLog
 */
trait RequestLogTrait
{
    /**
     * @param MvcEvent $mvcEvent
     */
    public function registerRequestLog(MvcEvent $mvcEvent)
    {
        /** @var Adapter $db */
        $db = $mvcEvent->getApplication()->getServiceManager()->get(Adapter::class);

        $putParams = $mvcEvent->getRequest()->getContent();

        if (! is_string($putParams)) {
            $putParams = json_encode($putParams);
        }

        $headers = json_encode($_SERVER);
        $getData = json_encode($_GET);
        $postData = json_encode($_POST);
        $filesData = json_encode($_FILES);
        $putData = $putParams;
        $date = date('Y-m-d H:i:s');

        $query = "INSERT INTO `request_logs` "
            . "(`method`, `uri`, `ip`, `header_data`, `get_data`, `put_data`, `post_data`, `created_at`, `files_data`) "
            . "VALUES "
            . "(?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $db->query($query);
        $stmt->execute([
            isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '',
            isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '',
            isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '',
            $headers,
            $getData,
            $putData,
            $postData,
            $date,
            $filesData
        ]);
    }
}
