<?php


namespace Lab02\WeatherStationPro;


class WindDirectionStatistics
{
    private $countAccumulations;
    private $sinAcc;
    private $cosAcc;

    // https://habr.com/ru/post/423243/
    public function add(float $value)
    {
        $this->sinAcc += sin(deg2rad($value));
        $this->cosAcc += cos(deg2rad($value));
        $this->countAccumulations++;
    }

    public function getAvg()
    {
        if (is_null($this->countAccumulations)) {
            return null;
        }
        $avgSin = $this->sinAcc / $this->countAccumulations;
        $avgCos = $this->cosAcc / $this->countAccumulations;
        $angle = rad2deg(atan2($avgSin, $avgCos));
        $angle = $angle < 0 ? ($angle + 360) : $angle;
        return round($angle, 2);
    }
}