<?php

namespace Src\Models;

class ReserveDate
{
    private $year;
    private $month;
    private $day;
    private $hour;

    public function __construct($year, $month, $day, $hour)
    {
        $this->year = $this->checkOnZero($year);
        $this->month = $this->checkOnZero($month);
        $this->day = $this->checkOnZero($day);
        $this->hour = $this->checkOnZero($hour);
    }

    public function getDate()
    {
        return "$this->year-$this->month-$this->day $this->hour:00:00";
    }

    public function getEndDate($duration)
    {
        $allHours = $duration + $this->hour;
        $newDuration = $allHours % 24;
        $newDay = intval($allHours / 24);
        return new ReserveDate($this->year, $this->month, $this->day + $newDay, $newDuration);
    }

    public function checkOnZero($value)
    {
        if ($value < 10) {
            return "0" . $value;
        }
        return $value;
    }
}