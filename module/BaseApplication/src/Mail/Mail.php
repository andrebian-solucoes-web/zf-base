<?php

namespace BaseApplication\Mail;

use Exception;
use finfo;
use Zend\Mail\Message;
use Zend\Mail\Transport\TransportInterface;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Mime;
use Zend\Mime\Part as MimePart;
use Zend\View\Model\ViewModel;
use Zend\View\Resolver\TemplatePathStack;
use Zend\View\View;

/**
 * Class Mail
 * @package BaseApplication\Mail
 */
class Mail
{
    /**
     * @var TransportInterface
     */
    protected $transport;

    /**
     * @var View
     */
    protected $view;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var Message
     */
    protected $message;

    /**
     * @var string
     */
    protected $subject;

    /**
     * @var string
     */
    protected $to;

    /**
     * @var string
     */
    protected $from;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var string
     */
    protected $page;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var array
     */
    private $attachments = [];

    /**
     * Mail constructor.
     *
     * @param TransportInterface $transport
     * @param $config
     * @param $view
     * @param string $page
     */
    public function __construct(TransportInterface $transport, $config, $view, $page = '')
    {
        $this->transport = $transport;
        $this->view = $view;
        $this->page = $page;
        $this->config = $config;

        $this->message = new Message();
    }

    /**
     * @param $page
     *
     * @return $this
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @param $subject
     *
     * @return $this
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @param $to
     *
     * @return $this
     */
    public function setTo($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * @param $from
     * @return $this
     */
    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @param $data
     *
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param $html
     * @param bool $isTest
     * @return $this
     */
    public function logMail($html, $isTest = false)
    {
        $pathLog = __DIR__ . '/../../../../tmp/';
        $file = $this->to . date('H_i_s') . '.html';
        $pathFile = $pathLog . $file;

        $f = fopen($pathFile, "w+");
        fwrite($f, $html);
        fclose($f);

        if ($isTest) {
            unlink($pathFile);
        }

        return $this;
    }

    /**
     * @param $page
     * @param array $data
     * @param string $moduleName
     * @param bool $isTest
     */
    public function renderView($page, array $data, $moduleName = '', $isTest = false)
    {
        $model = new ViewModel();

        $template = "email/{$page}.phtml";

        $class = get_class($this->view);
        if ($class == 'Zend\View\Renderer\PhpRenderer' && $moduleName) {
            $templatePath = dirname(dirname(dirname(dirname(__DIR__)))) . '/module/' . ucfirst($moduleName) . '/';
            $templatePath .= 'view/';

            $resolver = new TemplatePathStack();
            $resolver->addPath($templatePath);
            $this->view->setResolver($resolver);
        }

        $model->setTemplate($template);
        $model->setOption('has_parent', true);
        $model->setVariables($data);
        $html = $this->view->render($model);
        $this->logMail($html, $isTest);

        return $html;
    }

    /**
     * @param string $moduleName
     * @param bool $isTest
     * @return $this
     */
    public function prepare($moduleName = '', $isTest = false)
    {
        $html = new MimePart($this->renderView($this->page, $this->data, $moduleName, $isTest));
        $html->type = "text/html";

        $body = new MimeMessage();
        $body->setParts(array($html));
        $this->body = $body;

        $this->message->setFrom($this->from)
            ->setEncoding('UTF8')
            ->setTo($this->to)
            ->setSubject($this->subject)
            ->setBody($this->body);

        if (count($this->attachments) > 0) {
            $mimeMessage = $this->message->getBody();
            if (! $mimeMessage instanceof MimeMessage) {
                $this->setBody(new MimePart($mimeMessage));
                $mimeMessage = $this->message->getBody();
            }

            $bodyContent = $mimeMessage->generateMessage();
            $bodyPart = new MimePart($bodyContent);
            $bodyPart->type = Mime::TYPE_HTML; // TODO
            $attachmentParts = array();
            $info = new finfo(FILEINFO_MIME_TYPE);
            foreach ($this->attachments as $attachment) {
                if (! is_file($attachment)) {
                    continue;
                } // If checked file is not valid, continue to the next

                $part = new MimePart(fopen($attachment, 'r'));
                $part->filename = basename($attachment);
                $part->type = $info->file($attachment);
                $part->encoding = Mime::ENCODING_BASE64;
                $part->disposition = Mime::DISPOSITION_ATTACHMENT;
                $attachmentParts[] = $part;
            }

            array_unshift($attachmentParts, $bodyPart);
            $body = new MimeMessage();
            $body->setParts($attachmentParts);
            $this->message->setBody($body);
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function send()
    {
        try {
            $this->transport->send($this->message);
            $sent = true;
        } catch (Exception $e) {
            var_dump($e->getMessage());
            $sent = false;
        }

        return $sent;
    }

    /**
     * @param $path
     *
     * @return $this
     */
    public function addAttachment($path)
    {
        $this->attachments[] = $path;

        return $this;
    }

    /**
     * @param array $paths
     *
     * @return $this
     */
    public function addAttachments(array $paths)
    {
        $this->attachments = array_merge($this->attachments, $paths);

        return $this;
    }

    /**
     * @param array $paths
     *
     * @return $this
     */
    public function setAttachments(array $paths)
    {
        $this->attachments = $paths;

        return $this;
    }
}
