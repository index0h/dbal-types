<?php

namespace EG\Slots\Platform\Tests\Unit\AppBundle\Doctrine\Types;

use Doctrine\DBAL\Platforms\MySqlPlatform;
use index0h\DBALTypes\Doctrine\Types\Binary16UuidType;

class Binary16UuidTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testGetName()
    {
        $expected = Binary16UuidType::BINARY;
        /** @var Binary16UuidType|\PHPUnit_Framework_MockObject_MockObject $binary16UuidType */
        $binary16UuidType = $this->getMockBuilder(Binary16UuidType::class)
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $actual = $binary16UuidType->getName();

        $this->assertSame($expected, $actual);
    }

    public function testGetSQLDeclaration()
    {
        $expected = 'BINARY(16)';
        /** @var MySqlPlatform|\PHPUnit_Framework_MockObject_MockObject $mysqlPlatform */
        $mysqlPlatform = $this->getMockWithoutInvokingTheOriginalConstructor(MySqlPlatform::class);
        /** @var Binary16UuidType|\PHPUnit_Framework_MockObject_MockObject $binary16UuidType */
        $binary16UuidType = $this->getMockBuilder(Binary16UuidType::class)
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $actual = $binary16UuidType->getSQLDeclaration([], $mysqlPlatform);

        $this->assertSame($expected, $actual);
    }

    public function testConvertToPHPValueWithInvalidType()
    {
        /** @var MySqlPlatform|\PHPUnit_Framework_MockObject_MockObject $mysqlPlatform */
        $mysqlPlatform = $this->getMockWithoutInvokingTheOriginalConstructor(MySqlPlatform::class);
        /** @var Binary16UuidType|\PHPUnit_Framework_MockObject_MockObject $binary16UuidType */
        $binary16UuidType = $this->getMockBuilder(Binary16UuidType::class)
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
            $expectedMessage = sprintf(
                'Variable "$value" must be: "null" or "string", actual type: "%s"',
                gettype($fixture)
            );

            try {
                $binary16UuidType->convertToPHPValue($fixture, $mysqlPlatform);

                $this->fail('Not fail with: ' . $expectedMessage);
            } catch (\InvalidArgumentException $e) {
                $this->assertSame($expectedMessage, $e->getMessage());
            }
        }
    }

    public function testConvertToPHPValue()
    {
        $expected = '6e38e8dea5aa11e5b3f39b60a04c0be0';
        $binary   = pack('H*', $expected);
        /** @var MySqlPlatform|\PHPUnit_Framework_MockObject_MockObject $mysqlPlatform */
        $mysqlPlatform = $this->getMockWithoutInvokingTheOriginalConstructor(MySqlPlatform::class);
        /** @var Binary16UuidType|\PHPUnit_Framework_MockObject_MockObject $binary16UuidType */
        $binary16UuidType = $this->getMockBuilder(Binary16UuidType::class)
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $actual = $binary16UuidType->convertToPHPValue($binary, $mysqlPlatform);

        $this->assertSame($expected, $actual);
    }

    public function testConvertToDatabaseValueWithInvalidType()
    {
        /** @var MySqlPlatform|\PHPUnit_Framework_MockObject_MockObject $mysqlPlatform */
        $mysqlPlatform = $this->getMockWithoutInvokingTheOriginalConstructor(MySqlPlatform::class);
        /** @var Binary16UuidType|\PHPUnit_Framework_MockObject_MockObject $binary16UuidType */
        $binary16UuidType = $this->getMockBuilder(Binary16UuidType::class)
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
            $expectedMessage = sprintf(
                'Variable "$value" must be: "null" or "string", actual type: "%s"',
                gettype($fixture)
            );

            try {
                $binary16UuidType->convertToDatabaseValue($fixture, $mysqlPlatform);

                $this->fail('Not fail with: ' . $expectedMessage);
            } catch (\InvalidArgumentException $e) {
                $this->assertSame($expectedMessage, $e->getMessage());
            }
        }
    }

    public function testConvertToDatabaseValue()
    {
        $string   = '6e38e8dea5aa11e5b3f39b60a04c0be0';
        $expected = pack('H*', $string);
        /** @var MySqlPlatform|\PHPUnit_Framework_MockObject_MockObject $mysqlPlatform */
        $mysqlPlatform = $this->getMockWithoutInvokingTheOriginalConstructor(MySqlPlatform::class);
        /** @var Binary16UuidType|\PHPUnit_Framework_MockObject_MockObject $binary16UuidType */
        $binary16UuidType = $this->getMockBuilder(Binary16UuidType::class)
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $actual = $binary16UuidType->convertToDatabaseValue($string, $mysqlPlatform);

        $this->assertSame($expected, $actual);
    }
}
