<?php

namespace App\DataFixtures;

use App\Entity\Series;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use League\Csv\Reader;

class SeriesFixtures extends Fixture
    {

    public function load(ObjectManager $manager)
        {
        $path = __dir__ . '/../../data/series.csv';
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);

        $header = $csv->getHeader(); //returns the CSV header record
        $records = $csv->getRecords(); //returns all the CSV records as an Iterator object

        foreach ($csv->getRecords() as $record)
            {
            $name = $record ['NAME'];
            $series = new Series();
            
            $series->setName($name);   
            dump($series);
            $manager->persist($series);
        }
            
            $manager->flush();
        }
        }
    