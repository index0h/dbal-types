<?php

namespace EG\Slots\Platform\Tests\Unit\AppBundle\Doctrine\Types;

use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\DBAL\Types\ConversionException;
use index0h\DBALTypes\Doctrine\Types\DateTimeImmutableType;

class DateTimeImmutableTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testGetName()
    {
        $expected = DateTimeImmutableType::NAME;
        /** @var DateTimeImmutableType|\PHPUnit_Framework_MockObject_MockObject $dateTimeImmutableType */
        $dateTimeImmutableType = $this->getMockBuilder(DateTimeImmutableType::class)
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $actual = $dateTimeImmutableType->getName();

        $this->assertSame($expected, $actual);
    }

    public function testConvertToPHPValueWithInvalidType()
    {
        /** @var MySqlPlatform|\PHPUnit_Framework_MockObject_MockObject $mysqlPlatform */
        $mysqlPlatform = $this->getMockWithoutInvokingTheOriginalConstructor(MySqlPlatform::class);
        /** @var DateTimeImmutableType|\PHPUnit_Framework_MockObject_MockObject $dateTimeImmutableType */
        $dateTimeImmutableType = $this->getMockBuilder(DateTimeImmutableType::class)
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $fixtures = [
            true,
            100,
            100.5,
            [],
            new \stdClass,
            stream_context_create(),
        ];

        foreach ($fixtures as $fixture) {
            $value = $fixture;

            if (is_array($fixture) || is_object($fixture)) {
                $value = print_r($fixture, true);
            }

            $expectedMessage = ConversionException::conversionFailedFormat(
                (string) $value,
                DateTimeImmutableType::NAME,
                $mysqlPlatform->getDateTimeFormatString()
            )->getMessage();

            try {
                $dateTimeImmutableType->convertToPHPValue($fixture, $mysqlPlatform);

                $this->fail('Not fail with: ' . $expectedMessage);
            } catch (ConversionException $e) {
                $this->assertSame($expectedMessage, $e->getMessage());
            }
        }
    }

    public function testConvertToPHPValueWithInvalidString()
    {
        $value = 'invalid';
        /** @var MySqlPlatform|\PHPUnit_Framework_MockObject_MockObject $mysqlPlatform */
        $mysqlPlatform = $this->getMockWithoutInvokingTheOriginalConstructor(MySqlPlatform::class);
        /** @var DateTimeImmutableType|\PHPUnit_Framework_MockObject_MockObject $dateTimeImmutableType */
        $dateTimeImmutableType = $this->getMockBuilder(DateTimeImmutableType::class)
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $mysqlPlatform->expects($this->any())
            ->method('getDateTimeFormatString')
            ->willReturn('Y-m-d H:i:s');

        $expectedMessage = ConversionException::conversionFailedFormat(
            $value,
            DateTimeImmutableType::NAME,
            $mysqlPlatform->getDateTimeFormatString()
        )->getMessage();

        try {
            $dateTimeImmutableType->convertToPHPValue($value, $mysqlPlatform);

            $this->fail('Not fail with: ' . $expectedMessage);
        } catch (ConversionException $e) {
            $this->assertSame($expectedMessage, $e->getMessage());
        }
    }

    public function testConvertToPHPValueWithNull()
    {
        $value = null;
        /** @var MySqlPlatform|\PHPUnit_Framework_MockObject_MockObject $mysqlPlatform */
        $mysqlPlatform = $this->getMockWithoutInvokingTheOriginalConstructor(MySqlPlatform::class);
        /** @var DateTimeImmutableType|\PHPUnit_Framework_MockObject_MockObject $dateTimeImmutableType */
        $dateTimeImmutableType = $this->getMockBuilder(DateTimeImmutableType::class)
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $actual = $dateTimeImmutableType->convertToPHPValue($value, $mysqlPlatform);

        $this->assertNull($actual);
    }

    public function testConvertToPHPValueWithDateTimeImmutable()
    {
        $value = new \DateTimeImmutable('2016-01-10 00:30:30');
        /** @var MySqlPlatform|\PHPUnit_Framework_MockObject_MockObject $mysqlPlatform */
        $mysqlPlatform = $this->getMockWithoutInvokingTheOriginalConstructor(MySqlPlatform::class);
        /** @var DateTimeImmutableType|\PHPUnit_Framework_MockObject_MockObject $dateTimeImmutableType */
        $dateTimeImmutableType = $this->getMockBuilder(DateTimeImmutableType::class)
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $mysqlPlatform->expects($this->any())
            ->method('getDateTimeFormatString')
            ->willReturn('Y-m-d H:i:s');

        $actual = $dateTimeImmutableType->convertToPHPValue($value, $mysqlPlatform);

        $this->assertSame($value, $actual);
    }

    public function testConvertToPHPValue()
    {
        $timestamp = '2016-01-10 00:30:30';
        $expected  = strtotime($timestamp);
        /** @var MySqlPlatform|\PHPUnit_Framework_MockObject_MockObject $mysqlPlatform */
        $mysqlPlatform = $this->getMockWithoutInvokingTheOriginalConstructor(MySqlPlatform::class);
        /** @var DateTimeImmutableType|\PHPUnit_Framework_MockObject_MockObject $dateTimeImmutableType */
        $dateTimeImmutableType = $this->getMockBuilder(DateTimeImmutableType::class)
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $mysqlPlatform->expects($this->once())
            ->method('getDateTimeFormatString')
            ->willReturn('Y-m-d H:i:s');

        $actual = $dateTimeImmutableType->convertToPHPValue($timestamp, $mysqlPlatform);

        $this->assertSame($expected, $actual->getTimestamp());
    }

    public function testRequiresSQLCommentHint()
    {
        /** @var MySqlPlatform|\PHPUnit_Framework_MockObject_MockObject $mysqlPlatform */
        $mysqlPlatform = $this->getMockWithoutInvokingTheOriginalConstructor(MySqlPlatform::class);
        /** @var DateTimeImmutableType|\PHPUnit_Framework_MockObject_MockObject $dateTimeImmutableType */
        $dateTimeImmutableType = $this->getMockBuilder(DateTimeImmutableType::class)
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $actual = $dateTimeImmutableType->requiresSQLCommentHint($mysqlPlatform);

        $this->assertTrue($actual);
    }
}
