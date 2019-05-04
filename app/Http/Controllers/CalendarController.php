<?php

namespace App\Http\Controllers;

require __DIR__ . '/../../../vendor/autoload.php';

use Illuminate\Http\Request;
use App\Google;
use App\Event;
use App\Http\Requests\SaveEventRequest;
use App\Usecases\Calendar\SaveEventUsecase;

class CalendarController extends Controller
{   
    protected $client;
    protected $service;
    protected $calendarId;

    public function __construct()
    {
        $this->setClient();
        $this->service = new \Google_Service_Calendar($this->client);
        $this->calendarId = config('const.GOOGLE_CALENDAR_ID');
    }

    /**
     * Set an authorized API client.
     */
    public function setClient()
    {
        $this->client = new \Google_Client();
        $this->client->setApplicationName('Google Calendar API PHP');
        $this->client->setScopes(\Google_Service_Calendar::CALENDAR);
        $this->client->setAuthConfig(__DIR__ . '/../../Calendar/credentials.json');
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');
        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $tokenPath = __DIR__ . '/../../Calendar/token.json';
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $this->client->setAccessToken($accessToken);
        }

        // If there is no previous token or it's expired.
        if ($this->client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($this->client->getRefreshToken()) {
                $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
            } else {
                // Request authorization from the user.
                $authUrl = $this->client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $authUrl);
                print 'Enter verification code: ';
                $authCode = trim(fgets(STDIN));

                // Exchange authorization code for an access token.
                $accessToken = $this->client->fetchAccessTokenWithAuthCode($authCode);
                $this->client->setAccessToken($accessToken);

                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
            }
            // Save the token to a file.
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($this->client->getAccessToken()));
        }        
    }

    public function index()
    {
        $optParams = array(
        'maxResults' => 26,
        'orderBy' => 'startTime',
        'singleEvents' => true,
        'timeMin' => date('c'),
        );
        $results = $this->service->events->listEvents($this->calendarId, $optParams);
        $events = $results->getItems();
        if(!empty($events)) {
            $weeks = array("日", "月", "火", "水", "木", "金", "土");
            foreach($events as $event)
            {
                if(!is_null($event->start->dateTime)) {
                    $datetime = date_create($event->start->dateTime);
                    $week = $weeks[(int)$datetime->format('w')];
                    $month = (int)$datetime->format('m');
                    $day = (int)$datetime->format('d');
                    $start = substr($event->start->dateTime, 11, 5);
                    $end = substr($event->end->dateTime, 11, 5);
                    $event->when = "{$month}月{$day}日({$week}) {$start}-{$end}";
                } else {
                    $date = date_create($event->start->date);
                    $week = $weeks[(int)$date->format('w')];
                    $month = (int)$date->format('m');
                    $day = (int)$date->format('d');
                    $event->when = "{$month}月{$day}日({$week})";
                }
            }
        }
        return view('web.calendar.index', compact(['events']));
    }

    public function create()
    {
        $today = \Carbon\Carbon::today()->format('Y-m-d');
        return view('web.calendar.create', compact(['today']));
    }

    public function store(SaveEventRequest $request, SaveEventUsecase $usecase)
    {
        // Google Calendarに追加する処理
        $event = $usecase(
            $request->title,
            $request->date,
            $request->isAllDay,
            $request->time_from,
            $request->time_to,
            $request->location
        );
        $createdEvent = $this->service->events->insert($this->calendarId, $event);

        // 自データベースにイベントを保存する処理（LINE通知用）
        $id = $createdEvent->getId();
        Event::create([
            'id' => $id,
            'title' => request('title'),
            'date' =>  request('date'),
            'start_time' => request('time_from'),
            'end_time' => request('time_to'),
            'location' => request('location'),
            'one_month_before' => request('oneMonthBefore', 0),
            'two_weeks_before' => request('twoWeeksBefore', 0),                        
            'one_week_before' => request('oneWeekBefore', 0),                    
            'the_day_before' => request('theDayBefore', 0),                    
            'the_day' => request('the_day', 0)
        ]);
        return redirect('/calendar');
    }
    
    public function edit($eventId)
    {
        $event = $this->service->events->get($this->calendarId, $eventId);
        $title = $event->getSummary();
        if(!is_null($event->start->dateTime)) {
            $dateTime = $event->start->dateTime;
            $date = substr($dateTime, 0, 10);
            $start = substr($dateTime, 11, 5);
            $end = substr($event->getEnd()->dateTime, 11, 5);
        } else {
            $date = $event->start->date;
            $start = null;
            $end = null;
        }
        $location = $event->getLocation();
        $eventDb = Event::updateOrCreate([
            'id' => $eventId
        ],[
            'title' => $title,
            'date' => $date,
            'start_time' => $start,
            'end_time' => $end,
            'location' => $location
        ]);
        
        return view('web.calendar.edit', compact(['title', 'date', 'start', 'end', 'location', 'eventId', 'eventDb']));
    }

    public function update($eventId, SaveEventRequest $request, SaveEventUsecase $usecase)
    {
        $event = $usecase(
            $request->title,
            $request->date,
            $request->isAllDay,
            $request->time_from,
            $request->time_to,
            $request->location
        );
        $createdEvent = $this->service->events->update($this->calendarId, $eventId, $event);
        $id = $createdEvent->getId();
        Event::updateOrCreate([
            'id' => $id,
        ],[
            'title' => request('title'),
            'date' =>  request('date'),
            'start_time' => request('time_from'),
            'end_time' => request('time_to'),
            'location' => request('location'),
            'one_month_before' => request('oneMonthBefore', 0),
            'two_weeks_before' => request('twoWeeksBefore', 0),                        
            'one_week_before' => request('oneWeekBefore', 0),                    
            'the_day_before' => request('theDayBefore', 0),                    
            'the_day' => request('theDay', 0)
        ]);
        return redirect('/calendar');
    }

    public function destroy($eventId)
    {
        $this->service->events->delete($this->calendarId, $eventId);
        Event::where('id', $eventId)->first()->delete();
        return redirect('/calendar');
    }

}
