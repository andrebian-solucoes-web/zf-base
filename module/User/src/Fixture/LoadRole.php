<?php

namespace User\Fixture;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use User\Entity\Role;

/**
 * Class LoadRole
 * @package User\Fixture
 */
class LoadRole implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $manager->persist(new Role([
            'name' => 'Admin'
        ]));
        $manager->persist(new Role([
            'name' => 'Diretoria'
        ]));
        $manager->persist(new Role([
            'name' => 'Comercial'
        ]));
        $manager->persist(new Role([
            'name' => 'Marketing'
        ]));

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 0;
    }
}
