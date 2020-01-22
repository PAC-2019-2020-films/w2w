<?php

namespace Test;

abstract class BaseTestCase extends \PHPUnit\Framework\TestCase
{

    protected function assertNonEmptyArrayOf($fullyQualifiedClassName, $items)
    {
        $this->assertIsArray($items);
        $this->assertNotEmpty($items);
        foreach ($items as $item) {
            $this->assertInstanceOf($fullyQualifiedClassName, $item);
        }
    }



    /* example test exception est lancée */

    /*public function testCannotBeCreatedFromInvalidEmailAddress(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Email::fromString('invalid');
    }*/
        
}
