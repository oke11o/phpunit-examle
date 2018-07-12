<?php

namespace Tests\AppBundle\Service;

use AppBundle\Entity\Dinosaur;
use AppBundle\Entity\Enclosure;
use AppBundle\Entity\Security;
use AppBundle\Factory\DinosaurFactory;
use AppBundle\Service\EnclosureBuilderService;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EnclosureBuilderServiceIntegrationTest extends KernelTestCase
{
    public function setUp()
    {
        self::bootKernel();

        $this->truncateEntities();
    }

    public function testItBuildsEnclosureWithDefaultSpecifications()
    {
//        /** @var EnclosureBuilderService $enclosureBuilderService */
//        $enclosureBuilderService = self::$kernel->getContainer()
//            ->get('test.'.EnclosureBuilderService::class);

        $dinoFactory = $this->createMock(DinosaurFactory::class);
        $dinoFactory->expects($this->any())
            ->method('growFromSpecification')
            ->willReturnCallback(function($spec) {
                return new Dinosaur();
            });
        /** @var EnclosureBuilderService $enclosureBuilderService */
        $enclosureBuilderService = new EnclosureBuilderService(
            $this->getEntityManager(),
            $dinoFactory
        );

        $enclosureBuilderService->buildEnclosure(1, 3);

        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $count = (int)$em->getRepository(Security::class)
            ->createQueryBuilder('s')
            ->select('COUNT(s.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $this->assertSame(1, $count, 'Amount of security systems is not the same');

        $count = (int)$em->getRepository(Dinosaur::class)
            ->createQueryBuilder('d')
            ->select('COUNT(d.id)')
            ->getQuery()
            ->getSingleScalarResult();
        $this->assertSame(3, $count, 'Amount of dinosaurs is not the same');

    }

    private function truncateEntities()
    {
        $purger = new ORMPurger($this->getEntityManager());
        $purger->purge();
    }

    /**
     * @param array $entities
     * @throws \Doctrine\DBAL\DBALException
     */
    private function truncateEntitiesCustom(array $entities)
    {
        $connection = $this->getEntityManager()->getConnection();
        $databasePlatform = $connection->getDatabasePlatform();
        if ($databasePlatform->supportsForeignKeyConstraints()) {
            $connection->query('SET FOREIGN_KEY_CHECKS=0');
        }
        foreach ($entities as $entity) {
            $query = $databasePlatform->getTruncateTableSQL(
                $this->getEntityManager()->getClassMetadata($entity)->getTableName()
            );
            $connection->executeUpdate($query);
        }
        if ($databasePlatform->supportsForeignKeyConstraints()) {
            $connection->query('SET FOREIGN_KEY_CHECKS=1');
        }
    }

    /**
     * @return EntityManager
     */
    private function getEntityManager(): EntityManager
    {
        return self::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }
}