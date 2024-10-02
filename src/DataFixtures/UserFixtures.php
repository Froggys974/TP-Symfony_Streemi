<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use App\Entity\Playlist;
use App\Entity\PlaylistMedia;
use App\Entity\Subscription;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        
    }
}
