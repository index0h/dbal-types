<?php
namespace index0h\DBALTypes\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class Binary16UuidType extends Type
{
    /**
     * @param array            $fieldDeclaration
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'BINARY(16)';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::BINARY;
    }

    /**
     * @param resource|string|null $value
     * @param AbstractPlatform     $platform
     * @return null|string
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (!is_string($value) && !is_null($value)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Variable "$value" must be: "null" or "string", actual type: "%s"',
                    gettype($value)
                )
            );
        }

        if (is_string($value)) {
            $value = unpack('H*', $value);

            return array_shift($value);
        }

        return null;
    }

    /**
     * @param string|null      $value
     * @param AbstractPlatform $platform
     * @return string|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!is_string($value) && !is_null($value)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Variable "$value" must be: "null" or "string", actual type: "%s"',
                    gettype($value)
                )
            );
        }

        return is_string($value) ? pack('H*', $value) : null;
    }
}
