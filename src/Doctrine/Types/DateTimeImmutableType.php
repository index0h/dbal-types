<?php

namespace index0h\DBALTypes\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateTimeType;

class DateTimeImmutableType extends DateTimeType
{
    const NAME = 'datetime_immutable';

    /**
     * @return string
     */
    public function getName()
    {
        return static::NAME;
    }

    /**
     * @param \DateTimeImmutable|string|null $value
     * @param AbstractPlatform               $platform
     * @return \DateTimeImmutable|null
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (($value === null) || ($value instanceof \DateTimeImmutable)) {
            return $value;
        }

        if (is_string($value)) {
            $dateTime = \DateTimeImmutable::createFromFormat($platform->getDateTimeFormatString(), $value);

            if ($dateTime !== false) {
                return $dateTime;
            }
        }

        if (is_array($value) || is_object($value)) {
            $value = print_r($value, true);
        }

        throw ConversionException::conversionFailedFormat(
            (string) $value,
            $this->getName(),
            $platform->getDateTimeFormatString()
        );
    }

    /**
     * @param AbstractPlatform $platform
     * @return bool
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
