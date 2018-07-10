<?php

namespace AppBundle\Factory;

use AppBundle\Entity\Dinosaur;
use AppBundle\Service\DinosaurLengthDeterminator;

class DinosaurFactory
{

    /**
     * @var DinosaurLengthDeterminator
     */
    private $lengthDeterminator;

    public function __construct(DinosaurLengthDeterminator $lengthDeterminator)
    {
        $this->lengthDeterminator = $lengthDeterminator;
    }
    /**
     * @param $length
     * @return Dinosaur
     */
    public function growVelociraptor($length): Dinosaur
    {
        return $this->createDinosaur('Velociraptor', true, $length);
    }

    public function growFromSpecification($specification): Dinosaur
    {
        // defaults
        $codeName = 'InG-' . random_int(1, 99999);
        $isCarnivorous = false;
        $length = $this->lengthDeterminator->getLengthFromSpecification($specification);

        if (stripos($specification, 'carnivorous') !== false) {
            $isCarnivorous = true;
        }

        $dinosaur = $this->createDinosaur($codeName, $isCarnivorous, $length);

        return $dinosaur;
    }

    /**
     * @param string $genus
     * @param bool $isCarnivorous
     * @param int $length
     * @return Dinosaur
     */
    private function createDinosaur(string $genus, bool $isCarnivorous, int $length): Dinosaur
    {
        $dinosaur = new Dinosaur($genus, $isCarnivorous);
        $dinosaur->setLength($length);

        return $dinosaur;
    }
}