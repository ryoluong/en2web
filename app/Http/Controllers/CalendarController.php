<?php

namespace App\Http\Controllers;

require __DIR__ . '/../../../vendor/autoload.php';

use Illuminate\Http\Request;
use App\Google;
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
        $this->calendarId = 'ok6ivv4869iegdf6fihbljum1o@group.calendar.google.com';
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
        // Print the next 10 events on the user's calendar.
        $calendarId = 'ok6ivv4869iegdf6fihbljum1o@group.calendar.google.com';
        $optParams = array(
        'maxResults' => 8,
        'orderBy' => 'startTime',
        'singleEvents' => true,
        'timeMin' => date('c'),
        );
        $results = $this->service->events->listEvents($calendarId, $optParams);
        $events = $results->getItems();
        if(!empty($events)) {
            $week = array("日", "月", "火", "水", "木", "金", "土");
            foreach($events as $event)
            {
                $datetime = date_create($event->start->dateTime);
                $event->start->week = $week[(int)$datetime->format('w')];
                $event->start->month = (int)$datetime->format('m');
                $event->start->day = (int)$datetime->format('d');
                $event->start->time = substr($event->start->dateTime, 11, 5);
                $event->end->time = substr($event->end->dateTime, 11, 5);
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
        $event = $usecase(
            $request->title,
            $request->date,
            $request->time_from,
            $request->time_to,
            $request->location
        );
        $this->service->events->insert($this->calendarId, $event);
        return redirect('/calendar');
    }
    
    public function edit($eventId)
    {
        $event = $this->service->events->get($this->calendarId, $eventId);
        $title = $event->getSummary();
        $dateTime = $event->getStart()->dateTime;
        $date = substr($dateTime, 0, 10);
        $start = substr($dateTime, 11, 5);
        $end = substr($event->getEnd()->dateTime, 11, 5);
        $location = $event->getLocation();
        return view('web.calendar.edit', compact(['title', 'date', 'start', 'end', 'location', 'eventId']));
    }

    public function update($eventId, SaveEventRequest $request, SaveEventUsecase $usecase)
    {
        $event = $usecase(
            $request->title,
            $request->date,
            $request->time_from,
            $request->time_to,
            $request->location
        );
        $this->service->events->update($this->calendarId, $eventId, $event);
        return redirect('/calendar');
    }

    public function destroy($eventId)
    {
        $this->service->events->delete($this->calendarId, $eventId);
        return redirect('/calendar');
    }

}
