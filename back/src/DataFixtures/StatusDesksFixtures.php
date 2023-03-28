<?php

namespace App\DataFixtures;

use App\Entity\StatusDesks;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StatusDesksFixtures extends Fixture
{

    private const STATUS = [
        ["name" => "salle de réunion"],
        ["name" => "bureau simple"],
        ["name" => "salle de repos "],
        ["name" => "salle de détente"]
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::STATUS as $status){
            $new_status_type = new StatusDesks();
            $new_status_type->setName($status['name']);
            $manager->persist($new_status_type);
        }
        $manager->flush();
    }
}