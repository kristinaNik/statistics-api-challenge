<?php

namespace App\Tests\Unit;

use App\Entity\Hotel;
use PHPUnit\Framework\TestCase;

class HotelTest extends TestCase
{
    private $hotel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->hotel = new Hotel();
    }

    public function testGetName()
    {
       $value = 'Test Hotel';

       $response = $this->hotel->setName($value);
       $getName = $this->hotel->getName();

       self::assertInstanceOf(Hotel::class, $response);
       self::assertEquals($value, $getName);
    }
}
