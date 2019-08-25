<?php

namespace BaseApplication\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class RequestLog
 * @package BaseApplication\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="request_logs")
 */
class RequestLog
{
    use IdTrait;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $uri;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $method;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ip;

    /**
     * @var string
     * @ORM\Column(name="get_data", type="text", nullable=true)
     */
    private $getData;

    /**
     * @var string
     * @ORM\Column(name="post_data", type="text", nullable=true)
     */
    private $postData;

    /**
     * @var string
     * @ORM\Column(name="put_data", type="text", nullable=true)
     */
    private $putData;

    /**
     * @var string
     * @ORM\Column(name="files_data", type="text", nullable=true)
     */
    private $filesData;

    /**
     * @var string
     * @ORM\Column(name="header_data", type="text", nullable=true)
     */
    private $headerData;

    /**
     * @var string
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;
}
