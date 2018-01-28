<?php

namespace User\Fixture;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use User\Entity\Role;
use User\Entity\User;

/**
 * Class LoadUser
 * @package User\Fixture
 */
class LoadUser implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $admin = $manager->getRepository(Role::class)
            ->findOneBy([
                'name' => 'Administrador'
            ]);

        $user = new User([
            'name' => 'Admin',
            'username' => 'admin@site.com',
            'password' => 'admin123',
            'role' => $admin
        ]);

        $manager->persist($user);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}
