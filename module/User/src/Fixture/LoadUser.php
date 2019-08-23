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
        $data = json_decode(file_get_contents(__DIR__ . '/../../data/logins.json'), true);

        foreach ($data as $d) {
            $role = $manager->getRepository(Role::class)
                ->findOneBy([
                    'name' => $d['role']
                ]);

            $user = new User([
                'name' => $d['name'],
                'username' => $d['username'],
                'password' => $d['password'],
                'role' => $role
            ]);

            $manager->persist($user);
        }

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
