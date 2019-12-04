<?php


use Lab02\Common\WindDirectionStatistics;
use PHPUnit\Framework\TestCase;

class WeatherStationProTest extends TestCase
{

    public function testWindDirectionStatistics()
    {
        $stat = new WindDirectionStatistics();

        $stat->add(0);
        $stat->add(90);
        $this->assertEquals(45, $stat->getAvg());
        $stat->add(180);
        $this->assertEquals(90, $stat->getAvg());
        $stat->add(90);
        $this->assertEquals(90, $stat->getAvg());
        $stat->add(90);
        $this->assertEquals(90, $stat->getAvg());
    }

}




