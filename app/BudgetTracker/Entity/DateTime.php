<?php
namespace App\BudgetTracker\Entity;

final class DateTime {

    public $endDate;
    public $startDate;
    public $month;
    public $year;

    private $format = 'Y-m-d';

    private function __construct(array $dateTime)
    {
        if(!is_null($dateTime['end_date'])) {
            $this->endDate = date($this->format, $dateTime['end_date']);
        }

        $this->startDate = date($this->format, $dateTime['start_date']);
        $this->month = date('m', $dateTime['start_date']);
        $this->year = date('Y', $dateTime['start_date']);
    }

    public static function week(?int $now = null)
    {
        $now = is_null($now) ? time() : $now;
        $firstDayWeek = strtotime('monday', $now);
        $lastDayWeek = strtotime('next sunday', $firstDayWeek);

        return new DateTime([
            "start_date" => $firstDayWeek,
            "end_date" => $lastDayWeek
        ]);
    }

    public static function month(?int $now = null)
    {
        $now = is_null($now) ? time() : $now;
        $firstDayMonth = strtotime('first day of this month', $now);
        $lastDayMonth = strtotime('last day of this month', $firstDayMonth);

        return new DateTime([
            "start_date" => $firstDayMonth,
            "end_date" => $lastDayMonth
        ]);
    }

    public static function year(?int $now = null)
    {
        $now = is_null($now) ? time() : $now;
        $firstDayYear = strtotime('first day of January', $now);
        $lastDayYear = strtotime('last day of December', $firstDayYear);

        return new DateTime([
            "start_date" => $firstDayYear,
            "end_date" => $lastDayYear
        ]);
    }

    public static function current()
    {
        return new DateTime([
            "start_date" => time(),
            "end_date" => time()
        ]);
    }

    public static function custom(string $start, string $end)
    {
        return new DateTime([
            "start_date" => strtotime($start),
            "end_date" => strtotime($end)
        ]);
    }

    public static function theseMonth()
    {
        return ;
    }

    public static function previousMonth()
    {
        $now = time();
        $firstDayYear = strtotime('-1 month', $now);

        return new DateTime([
            "start_date" => $firstDayYear,
            "end_date" => null
        ]);
    }

    /**
     * Set the value of format
     */
    public function setFormat($format): self
    {
        $this->format = $format;

        return $this;
    }
}