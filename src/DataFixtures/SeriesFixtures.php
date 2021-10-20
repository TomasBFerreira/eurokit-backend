<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use League\Csv\Reader;

class SeriesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $csv = Reader::createFromPath('%kernel.root_dir%/../src/data/test.csv', 'r');
        $csv->setHeaderOffset(0);

        $header = $csv->getHeader(); //returns the CSV header record
        dump($header);
        exit;
        $records = $csv->getRecords(); //returns all the CSV records as an Iterator object
                
        $manager->flush();
    }
}
