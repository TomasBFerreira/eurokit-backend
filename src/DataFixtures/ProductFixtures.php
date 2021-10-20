<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Series;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use League\Csv\Reader;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProductFixtures extends Fixture implements DependentFixtureInterface
    {

    public function load(ObjectManager $manager)
        {
        $path = __dir__ . '/../../data/products.csv';
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords(); //returns all the CSV records as an Iterator object

        $productrepository = $manager->getRepository(Product::class);
        
        foreach ($csv->getRecords() as $record)
            {
            $name = $record ['NAME'];
            $series = $productrepository->findOneBy(['name' => $record ['SERIES']]);
            $product = new Product();
            
            $product->setName($name)->setSeries($series);
            //dump($product);
            $manager->persist($product);
        }
            
            $manager->flush();
        }

    public function getDependencies()
        {
        return [ 
        SeriesFixtures::class,
        ];
        }

    }
    