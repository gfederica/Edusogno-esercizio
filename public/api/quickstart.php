<?php

set_time_limit(0);

require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

require __DIR__ . '/vendor/phpmailer/phpmailer/src/Exception.php';
require __DIR__ . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require __DIR__ . '/vendor/phpmailer/phpmailer/src/SMTP.php';

include_once __DIR__ . '/../db/DB_CONFIG.php';



// richieste al mio db
$sql = "SELECT * FROM eventi ORDER BY id DESC";
$eventi = $conn->query($sql);
$eventi = $eventi->fetch_assoc();

$nome_evento = $eventi['nome_evento'];
$descrizione_evento = $eventi['descrizione_evento'];
$data_calendar = $eventi['data'].'T'.$eventi['ora'].'-11:00';
// 'dateTime' => '2021-09-27T11:00:00-11:00',
$data = $eventi['data'];
$ora = $eventi['ora'];
$link = $eventi['link'];




$utente = [];
$sql = "SELECT * FROM utenti";
$utenti = $conn->query($sql);
$num_rows = $utenti->num_rows;

for ($i=0; $i < $num_rows ; $i++) { 
  $utente[] = $utenti->fetch_assoc();
} 


// if (php_sapi_name() != 'cli') {
//     throw new Exception('This application must be run on the command line.');
// }

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Google Calendar API PHP Quickstart');
    $client->setScopes(Google_Service_Calendar::CALENDAR);
    $client->setAuthConfig(__DIR__ . '/credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');
    //redirect
    // $redirect_uri = 'http://localhost/Edusogno/Edusogno-esercizio/public/';
    // $client->setRedirectUri($redirect_uri);

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
$calendarId = 'primary';
$optParams = array(
  'maxResults' => 10,
  'orderBy' => 'startTime',
  'singleEvents' => true,
  'timeMin' => date('c'),
);
$results = $service->events->listEvents($calendarId, $optParams);
$events = $results->getItems();

// Refer to the PHP quickstart on how to setup the environment:
// https://developers.google.com/calendar/quickstart/php
// Change the scope to Google_Service_Calendar::CALENDAR and delete any stored
// credentials.

// creo l'evento
$event = new Google_Service_Calendar_Event(array(
    'summary' => $nome_evento,
    'location' => 'Online',
    'description' => $descrizione_evento,
    'start' => array(
      'dateTime' => $data_calendar,
      'timeZone' => 'Europe/Rome',
    ),
    'end' => array(
      'dateTime' => $data_calendar,
      'timeZone' => 'Europe/Rome',
    ),
    'recurrence' => array(
      'RRULE:FREQ=DAILY;COUNT=1'
    ),
    'attendees' => array($utente),
    'reminders' => array(
      'useDefault' => FALSE,
      'overrides' => array(
        array('method' => 'email', 'minutes' => 24 * 60),
        array('method' => 'popup', 'minutes' => 10),
      ),
    ),
  ));

  $calendarId = 'primary';
  $event = $service->events->insert($calendarId, $event);
  printf('Event created: %s\n', $event->htmlLink); 
  
//genero evento Meet
  $solution_key = new Google_Service_Calendar_ConferenceSolutionKey();
  $solution_key->setType("hangoutsMeet");
  $confrequest = new Google_Service_Calendar_CreateConferenceRequest();
  $confrequest->setRequestId("12345");
  $confrequest->setConferenceSolutionKey($solution_key);
  $confdata = new Google_Service_Calendar_ConferenceData();
  $confdata->setCreateRequest($confrequest);
  $event->setConferenceData($confdata);
  
  $event = $service->events->patch($calendarId, $event->id, $event, array('conferenceDataVersion' => 1));
  
  // link evento : $event->hangoutLink
  $sql = "SELECT * FROM eventi ORDER BY id";
  $eventi = $conn->query($sql);
  $eventi = $eventi->fetch_assoc();
  $linkMeet = $event->hangoutLink;

  if ($link == NULL) {
    $update = "UPDATE eventi SET link = '$linkMeet' ORDER BY id DESC LIMIT 1";
    $finalResponse = $conn->query($update);
  }  

  // invio della mail
  foreach ($utenti as $utente) {
    $mail = new PHPMailer();
    $mail->IsSMTP();

    $emailUtente = $utente['email'];
    
    
    $mail->SMTPDebug  = 0;  
    $mail->SMTPAuth   = TRUE;
    $mail->SMTPSecure = "tls";
    $mail->Port       = 587;
    $mail->Host       = "smtp.gmail.com";
    $mail->Username   = "federica.giudice.edusogno.test@gmail.com";
    $mail->Password   = "1Test2Edusogno!";
  
    $mail->IsHTML(true);
    $mail->AddAddress("$emailUtente");
    $mail->SetFrom("federica.giudice.edusogno.test@gmail.com", "Federica Giudice");
    // $mail->AddReplyTo("reply-to-email", "reply-to-name");
    // $mail->AddCC("cc-recipient-email", "cc-recipient-name");
    $mail->Subject = "Reminder evento";
    $content = "Ciao " . $utente['nome'] . " " . $utente['cognome'] . "<br> Sei stato invitato all'evento " . $nome_evento . " in data " . $data . " " . $ora . "<br> e puoi partecipare alla call tramite il seguente <a href=".$link.">link</a>.";
 
    $mail->MsgHTML($content); 

    if(!$mail->Send()) {
      echo "Error while sending Email.", $mail->ErrorInfo;
    } else {
      echo "Email sent successfully";
    }
  }
  

if (empty($events)) {
    print "No upcoming events found.\n";
} else {
    print "Upcoming events:\n";
    foreach ($events as $event) {
        $start = $event->start->dateTime;
        if (empty($start)) {
            $start = $event->start->date;
        }
        printf("%s (%s)\n", $event->getSummary(), $start);
    }
}

?>