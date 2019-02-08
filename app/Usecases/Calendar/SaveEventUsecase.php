<?php

namespace App\Usecases\Calendar;

require __DIR__ . '/../../../vendor/autoload.php';

class SaveEventUsecase
{
    public function __invoke($title, $date, $isAllDay = 0, $time_from = '00:00', $time_to = '00:00', $location = null)
    {
        if($isAllDay == 0) {
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
        } else {
            $event = new \Google_Service_Calendar_Event(array(
                'summary' => $title,
                'location' => $location,
                'description' => null,
                'start' => array(
                    'date' => $date,
                    'dateTime' => null,
                    'timeZone' => 'Asia/Tokyo',
                ),
                'end' => array(
                    'date' => $date,
                    'dataTime' => null,
                    'timeZone' => 'Asia/Tokyo',
                ),
            ));
        }
        return $event;
    }
}