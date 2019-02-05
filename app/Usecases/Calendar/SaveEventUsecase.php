<?php

namespace App\Usecases\Calendar;

require __DIR__ . '/../../../vendor/autoload.php';

class SaveEventUsecase
{
    public function __invoke($title, $date, $time_from, $time_to, $location = null)
    {
        $start = "{$date}T{$time_from}:00";
        $end = "{$date}T{$time_to}:00";
        $event = new \Google_Service_Calendar_Event(array(
            'summary' => $title,
            'location' => $location,
            'description' => null,
            'start' => array(
                'dateTime' => $start,
                'timeZone' => 'Asia/Tokyo',
            ),
            'end' => array(
                'dateTime' => $end,
                'timeZone' => 'Asia/Tokyo',
            ),
        ));
        return $event;
    }
}