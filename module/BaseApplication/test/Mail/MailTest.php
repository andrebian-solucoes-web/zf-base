<?php

namespace Test\BaseApplication\Mail;

use BaseApplication\Mail\Mail;
use Mockery;
use PHPUnit\Framework\TestCase;
use User\Entity\User;
use Zend\View\Renderer\PhpRenderer;

/**
 * Class MailTest
 * @package Test\BaseApplication\Mail
 *
 * @group BaseApplication
 * @group Mail
 */
class MailTest extends TestCase
{
    /**
     * @var Mail
     */
    private $mail;

    protected function setUp()
    {
        parent::setUp();
        $this->mail = new Mail($this->getTransport(), $this->getConfig(), $this->getView());
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @return \Mockery\MockInterface
     */
    public function getTransport()
    {
        $mockery = new Mockery();
        $transport = $mockery->mock('Zend\Mail\Transport\Smtp');
        $transport->shouldReceive('send')->andReturn($transport);

        return $transport;
    }

    public function getConfig()
    {
        return [
            'name' => 'smtp.gmail.com',
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'connection_class' => 'login',
            'connection_config' => [
                'username' => '',
                'password' => '',
                'from' => 'no-reply@domain.com',
                'ssl' => 'tls',
            ],
            'transport' => 'sendmail'
        ];
    }

    public function getView()
    {
        $renderer = new PhpRenderer();
        return $renderer;
    }

    /**
     * @test
     */
    public function checkSetPage()
    {
        $result = $this->mail->setPage('xpto');
        $this->assertNotNull($result);
    }

    /**
     * @test
     */
    public function checkSetSubject()
    {
        $result = $this->mail->setSubject('xpto');
        $this->assertNotNull($result);
    }

    /**
     * @test
     */
    public function checkSetTo()
    {
        $result = $this->mail->setTo('test@test.com');
        $this->assertNotNull($result);
    }

    /**
     * @test
     */
    public function checkSetData()
    {
        $result = $this->mail->setData(['url' => 'http://localhost']);
        $this->assertNotNull($result);
    }

    /**
     * @test
     */
    public function checkLogMail()
    {
        $result = $this->mail->logMail('<html><body>Test</body></html>', true);
        $this->assertNotNull($result);
    }

    /**
     * @test
     */
    public function checkRenderView()
    {
        $this->mail->setData(['url' => 'url']);
        $this->mail->setPage('test');
        $this->mail->setTo('test@test.com');
        $this->mail->setFrom('test@test.com');
        $this->mail->prepare('BaseApplication');
        $result = $this->mail->renderView('test', ['url' => 'url'], '', true);
        $this->assertNotNull($result);
    }

    /**
     * @test
     */
    public function checkPrepare()
    {
        $this->mail->setPage('test');
        $this->mail->setData(
            [
                'user' => new User(),
                'url' => 'url'
            ]
        );
        $this->mail->setTo('test@test.com');
        $this->mail->addAttachment(__DIR__ . '/MailTest.php');
        $this->mail->setFrom('test@test.com');
        $result = $this->mail->prepare('BaseApplication', true);
        $this->assertNotNull($result);
    }

    /**
     * @test
     */
    public function checkPrepareWithInvalidFile()
    {
        $this->mail->setPage('test');
        $this->mail->setData(
            [
                'user' => new User(),
                'url' => 'url'
            ]
        );
        $this->mail->setTo('teste@teste.com');
        $this->mail->setFrom('test@test.com');
        $this->mail->addAttachment(__DIR__);
        $result = $this->mail->prepare('BaseApplication', true);
        $this->assertNotNull($result);
    }

    /**
     * @test
     */
    public function checkSend()
    {
        $result = $this->mail->send();
        $this->assertNotNull($result);
    }

    /**
     * @test
     */
    public function checkSendFail()
    {
        $mockery = new Mockery();
        $transport = $mockery->mock('Zend\Mail\Transport\Smtp');

        $mail = new Mail($transport, $this->getConfig(), $this->getView());
        $result = $mail->send();
        $this->assertNotNull($result);
    }

    /**
     * @test
     */
    public function checkAddAttachment()
    {
        $result = $this->mail->addAttachment(__DIR__);
        $this->assertInstanceOf(Mail::class, $result);

        $result2 = $this->mail->addAttachments([__DIR__]);
        $this->assertInstanceOf(Mail::class, $result2);

        $result3 = $this->mail->setAttachments([__DIR__]);
        $this->assertInstanceOf(Mail::class, $result3);
    }
}
