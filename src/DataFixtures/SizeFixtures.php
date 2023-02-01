<?php

namespace App\DataFixtures;

use App\Entity\Size;
use App\Entity\Model;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use League\Csv\Reader;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SizeFixtures extends Fixture implements DependentFixtureInterface
    {

    public function load(ObjectManager $manager)
        {
        $path = __dir__ . '/../../data/allS.csv';
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords(); //returns all the CSV records as an Iterator object

        $modelrepository = $manager->getRepository(Model::class);

        foreach ($csv->getRecords() as $record)
            {

            $model = $modelrepository->findOneBy(['code' => $record ['MODEL']]);

            if ($model === null)
                {
                throw new \RuntimeException("Could not find Model with the code  " . $record ['MODEL']);
                continue;
                }

            foreach ($record as $key => $value)
                {
                if ($key === ['MODEL'])
                    {
                    continue;
                    }
                $size = new Size();

                $size->setModel($model)->setSize($key)->setValue($value);

                $manager->persist($size);
                }
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
