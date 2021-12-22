<?php

namespace App\DataFixtures;

use App\Entity\Model;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use League\Csv\Reader;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ModelFixtures extends Fixture implements DependentFixtureInterface
    {

    public function load(ObjectManager $manager)
        {
        $path = __dir__ . '/../../data/temp_models.csv';
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords(); //returns all the CSV records as an Iterator object

        $productrepository = $manager->getRepository(Product::class);

        foreach ($csv->getRecords() as $record)
            {
            $description = $record ['DESCRIPTION'];
            $code = $record ['CODE'];
            $size = $record ['SIZES'];

            $size_array = explode(",", $size);
            $product = $productrepository->findOneBy(['name' => $record ['PRODUCTS']]);
            $model = new Model();

            $model->setCode($code)->setDescription($description)->setProduct($product)->setSizes($size_array);
            $manager->persist($model);
            }

        $manager->flush();
        }

    public function getDependencies()
        {
        return [
            ProductFixtures::class,
        ];
        }

    }
