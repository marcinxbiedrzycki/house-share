<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->passwordEncoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $manager->persist($this->createUser(Uuid::uuid4(), 'admin', 'admin'));

        $manager->flush();
    }

    private function createUser(UuidInterface $uuid, string $name, string $password): User
    {
        $user = new User();
        $reflector = new \ReflectionClass(User::class);
        $uuidReflected = $reflector->getProperty('uuid');
        $uuidReflected->setAccessible(true);
        $uuidReflected->setValue($user, $uuid);
        $nameReflected = $reflector->getProperty('name');
        $nameReflected->setAccessible(true);
        $nameReflected->setValue($user, $name);
        $passwordReflected = $reflector->getProperty('password');
        $passwordReflected->setAccessible(true);
        $passwordReflected->setValue($user, $this->passwordEncoder->encodePassword($user, $password));

        return $user;
    }
}
