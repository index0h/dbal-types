<?php

namespace index0h\DBALTypes\tests\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Statement;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use index0h\DBALTypes\Doctrine\MySqlUuidGenerator;

class MySqlUuidGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerate()
    {
        $sql  = 'SELECT UUID()';
        $uuid = 'd376307f-d8eb-11e5-85ae-080027d70e5a';
        /** @var \PHPUnit_Framework_MockObject_MockObject|EntityManager $entityManager */
        $entityManager = $this->getMockWithoutInvokingTheOriginalConstructor(EntityManager::class);
        $connection    = $this->getMockWithoutInvokingTheOriginalConstructor(Connection::class);
        $query         = $this->getMockWithoutInvokingTheOriginalConstructor(Statement::class);
        $entity        = new Entity();
        $generator     = new MySqlUuidGenerator();
        $expected      = str_replace('-', '', $uuid);

        $entityManager->expects($this->once())
            ->method('getConnection')
            ->willReturn($connection);

        $connection->expects($this->once())
            ->method('query')
            ->with($sql)
            ->willReturn($query);

        $query->expects($this->once())
            ->method('fetchColumn')
            ->with(0)
            ->willReturn($uuid);

        $actual = $generator->generate($entityManager, $entity);

        $this->assertSame($expected, $actual);
    }
}
