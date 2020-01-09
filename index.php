<?php 
    
require __DIR__ . '/vendor/autoload.php';

if (php_sapi_name() != 'cli') {
    throw new Exception('This application must be run on the command line.');
}

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Pcr Calender');
    $client->setScopes(Google_Service_Calendar::CALENDAR_EVENTS);
    $client->setAuthConfig('credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
    $tokenPath = 'token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }

    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one.
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));

            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);

            // Check to see if there was an error.
            if (array_key_exists('error', $accessToken)) {
                throw new Exception(join(', ', $accessToken));
            }
        }
        // Save the token to a file.
        if (!file_exists(dirname($tokenPath))) {
            mkdir(dirname($tokenPath), 0700, true);
        }
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
    return $client;
}

// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Calendar($client);

// Print the next 10 events on the user's calendar.
$calendarId = 'df3at3nb9hjjhfgvje26aa0frc@group.calendar.google.com';
$optParams = array(
  'maxResults' => 999,
  'orderBy' => 'startTime',
  'singleEvents' => true,
  'timeMin' => date('c'),
);
$results = $service->events->listEvents($calendarId, $optParams);
$events = $results->getItems();



if (empty($events)) {
    print "No upcoming events found.\n";
} else {
    print "Update events:\n";
    foreach ($events as $event) {
        $start = $event->start->dateTime;
        $end = $event->end->dateTime;
        if (empty($start)) {
            $start = $event->start->date;
        }
        printf("%s (%s) (%s)\n", $event->getSummary(), $start, $end);
    }
}

$client = new GuzzleHttp\Client();
$res = $client->request('GET', 'https://pcredivewiki.tw/static/data/event.json');
$statusCode = $res->getStatusCode();

if($statusCode != 200) {
    throw new Exception('Request pcredivewiki calendar failed.\n');
}
$rawString = $res->getBody();
$rawJson = json_decode($rawString, true);

foreach($events as $event) {
    $service->events->delete($calendarId, $event->id);
}

foreach($rawJson as $item) {
    $start_time = strtotime($item['start_time']);
    $end_time = strtotime($item['end_time']);
    if($end_time >= strtotime("today")) {
        $event = [
            'summary'   =>  $item['campaign_name'],
            'start' =>  [
                'dateTime' => date("c", $start_time),
                'timeZone' => 'Asia/Taipei',
            ],
            'end' =>  [
                'dateTime' => date("c", $end_time),
                'timeZone' => 'Asia/Taipei',
            ],
        ];
        $service->events->insert($calendarId, new Google_Service_Calendar_Event($event));
    }
}

