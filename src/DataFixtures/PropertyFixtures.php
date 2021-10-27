<?php

namespace App\DataFixtures;

use App\Entity\Property;
use App\Entity\Model;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use League\Csv\Reader;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PropertyFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $path = __dir__ . '/../../data/properties.csv';
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords(); //returns all the CSV records as an Iterator object

        $modelrepository = $manager->getRepository(Model::class);

        foreach ($csv->getRecords() as $record) {
            $name = $record ['NAME'];
            $value = $record ['VALUE'];
            $model = $modelrepository->findOneBy(['code' => $record ['MODEL']]);
            $property = new Property();

            $property->setName($name)->setValue($value)->setModel($model);
            $manager->persist($property);
        }

            $manager->flush();
    }

    public function getDependencies()
    {
        return [
        ModelFixtures::class,
        ];
    }
}
