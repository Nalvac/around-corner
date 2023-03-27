<?php

namespace App\DataFixtures;

use App\Entity\StatusUsers;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StatusUsersFixtures extends Fixture
{
    private const STATUS = [
        ["name" => "alternant"],
        ["name" => "étudiant"],
        ["name" => "entrepreneur"],
        ["name" => "salarié"],
        ["name" => "freelancer"]
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::STATUS as $status){
            $new_status_type = new StatusUsers();
            $new_status_type->setName($status['name']);
            $manager->persist($new_status_type);
        }
        $manager->flush();
    }
}