<?php


namespace Lab02\Common;


class PrintHelper
{
    public function printStatistics(string $indicator, Statistics $statistics): void
    {
        $indicator = strtolower($indicator);
        $max = $statistics->getMax() ? $statistics->getMax() : 'undefined';
        $min = $statistics->getMin() ? $statistics->getMin() : 'undefined';
        $avg = $this->avgText($statistics);
        echo "$indicator statistics (min, max, avg): $min $max $avg" . PHP_EOL;
    }

    public function printWindDirectionStat(string $indicator, WindDirectionStatistics $statistics): void
    {
        $indicator = strtolower($indicator);
        $avg = $this->avgText($statistics);
        echo "$indicator statistics (avg): $avg" . PHP_EOL;
    }

    private function avgText($statistics): string
    {
        return $statistics->getAvg() ? round($statistics->getAvg(), 2) : 'undefined';
    }

}

