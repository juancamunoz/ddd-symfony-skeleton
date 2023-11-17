<?php

namespace App\Context\Auth\User\Infrastructure\Persistence\Doctrine\Fixture;

use App\Tests\Unit\Auth\User\Domain\UserMother;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $manager->persist(UserMother::default());
        $manager->flush();
    }
}
