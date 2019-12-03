<?php


namespace Lab02\WeatherStation;


class Statistics
{
    private $min;
    private $max;
    private $accumulator;
    private $countAccumulations;


    public function add(float $value)
    {
        if ($this->min > $value || is_null($this->min)) {
            $this->min = $value;
        }
        if ($this->max < $value || is_null($this->max)) {
            $this->max = $value;
        }
        $this->accumulator += $value;
        $this->countAccumulations++;
    }

    public function getMin()
    {
        return $this->min;
    }

    public function getMax()
    {
        return $this->max;
    }

    public function getAvg()
    {
        return is_null($this->accumulator) ? null : $this->accumulator / $this->countAccumulations;
    }


}