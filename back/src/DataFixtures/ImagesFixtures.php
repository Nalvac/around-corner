<?php

namespace App\DataFixtures;

use App\Entity\Images;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ImagesFixtures extends Fixture
{
    private const LINKS = [
        ["link" => "https://pyxis.nymag.com/v1/imgs/dd5/c89/a9b576bce60fbd4b1eec939e4860d0b380-680b6a2aaeb898f0c0cd2ab5162b14880a71e321.2x.rsocial.w600.jpg"],
        ["link" => "https://target.scene7.com/is/image/Target/desks_SBL-Shape-SB-210908-1631102260329?wid=668&qlt=80&fmt=webp"],
        ["link" => "https://secure.img1-fg.wfcdn.com/im/15144401/resize-h500-w750%5Ecompr-r85/5575/55757428/default_name.jpg"]

    ];
    public function load(ObjectManager $manager)
    {
        foreach (self::LINKS as $link){
            $new_link_type = new Images();
            $new_link_type->setLink($link['link']);
            $manager->persist($new_link_type);
        }
        $manager->flush();
    }
}