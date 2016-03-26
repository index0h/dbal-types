<?php

namespace index0h\DBALTypes\Doctrine;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Doctrine\ORM\Mapping\Entity;

/**
 * Generate MySQL-compatible UUID for binary(16) column.
 */
class MySqlUuidGenerator extends AbstractIdGenerator
{
    /**
     * @param EntityManager $entityManager
     * @param Entity        $entity
     * @return string
     * @throws DBALException
     */
    public function generate(EntityManager $entityManager, $entity)
    {
        $sql  = 'SELECT UUID()';
        $uuid = $entityManager->getConnection()->query($sql)->fetchColumn(0);

        return str_replace('-', '', $uuid);
    }
}
