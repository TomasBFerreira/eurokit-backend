<?php

namespace App\Extractor;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\EntityManagerInterface;

class AbstractExtractor
{

    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function extract($entity, bool $withAssociations = false): array
    {
        $metadata = $this->manager->getClassMetadata(get_class($entity));

        $data = [];

        foreach ($metadata->fieldMappings as $mapping) {
            $name = $mapping['fieldName'];
            $method = 'get' . ucfirst($name);

            if (false === method_exists($entity, $method)) {
                continue;
            }

            $value = $entity->$method();

            $data[$name] = $value;
        }

        if (true === $withAssociations) 
        {
            foreach ($metadata->associationMappings as $mapping) {
                $type = $mapping['type'];

                if (false === in_array($type, [ClassMetadata::ONE_TO_ONE, ClassMetadata::MANY_TO_ONE])) {
                    continue;
                }

                $name = $mapping['fieldName'];
                $method = 'get' . ucfirst($name);

                if (false === method_exists($entity, $method)) {
                    continue;
                }

                $value = $entity->$method();

                $data[$name] = $this->extract($value);
            }
        }
        return $data;
    }

}
