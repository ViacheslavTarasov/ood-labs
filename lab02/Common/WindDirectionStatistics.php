<?php


namespace Lab02\Common;


class WindDirectionStatistics
{
    private $sinAcc;
    private $cosAcc;

    // https://habr.com/ru/post/423243/
    public function add(float $value)
    {
        $this->sinAcc += sin(deg2rad($value));
        $this->cosAcc += cos(deg2rad($value));
    }

    public function getAvg()
    {
        if (is_null($this->sinAcc)) {
            return null;
        }
        $angle = rad2deg(atan2($this->sinAcc, $this->cosAcc));
        $angle = $angle < 0 ? ($angle + 360) : $angle;
        return round($angle, 2);
    }
}