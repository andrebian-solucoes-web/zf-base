<?php

namespace User\View\Helper;

use Aluno\Entity\Aluno;
use Coordenador\Entity\Coordenador;
use Professor\Entity\Professor;
use User\Entity\User;
use User\Helper\UserIdentity;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Helper\AbstractHelper;

/**
 * Class ProfilePictureViewHelper
 * @package User\View\Helper
 */
class ProfilePictureViewHelper extends AbstractHelper
{
    /**
     * @var ServiceLocatorInterface
     */
    private $serviceManager;

    public function __construct(ServiceLocatorInterface $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * @param string $namespace
     * @return string
     */
    public function __invoke($namespace = 'Application')
    {
        $folders = [
            'Application' => 'avatar',
            'user' => 'avatar',
            'coordenador' => 'coordenador',
            'aluno' => 'aluno',
            'co-coordenador' => 'coordenador',
            'professor' => 'professor'
        ];

        $default = '/img/header-profile.png';

        $userIdentity = new UserIdentity();

        /** @var User|Coordenador|Aluno|Professor $loggedUser */
        $loggedUser = $userIdentity->getIdentity(ucfirst($namespace));

        if ($loggedUser->getAvatar() != '') {
            $default = $this->serviceManager->get('config')['s3_url'];
            $default .= '/files/' . $folders[$namespace] . '/' . $loggedUser->getId() . '/' . $loggedUser->getAvatar();
        }

        return $default;
    }
}
