<?php

namespace App\DataFixtures;

use App\Entity\Options;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OptionsFixtures extends Fixture
{
    private const OPTIONS = [
        ["name" => "canape"],
        ["name" => "machine à café"],
        ["name" => "télévision"],
        ["name" => "projecteur"],
        ["name" => "enceinte"],
        ["name" => "fibre optique"],
        ["name" => "ventilateur"],
        ["name" => "chauffage"],
        ["name" => "cuisine"],
        ["name" => "micro-onde"]
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::OPTIONS as $options){
            $new_status_type = new Options();
            $new_status_type->setName($options['name']);
            $manager->persist($new_status_type);
        }
        $manager->flush();
    }
}