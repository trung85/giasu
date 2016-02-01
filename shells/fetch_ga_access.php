<?php

require_once dirname(__FILE__) . '/google-api-php-client/src/Google/autoload.php';

$servername = "db04.serverhosting.vn";
$username = "gia79246_admin";
$password = "123456@";
$dbname = "gia79246_tutordb_main";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mylog("----- Fetch starting... -----" . PHP_EOL);

$data          = getDataFromGA();
$ga_today      = $data['ga_today'];
$ga_yesterday  = $data['ga_yesterday'];
$ga_last_week  = $data['ga_last_week'];
$ga_last_month = $data['ga_last_month'];
$ga_all        = $data['ga_all'];

executeSql($conn, 'ga_today', $ga_today);
executeSql($conn, 'ga_yesterday', $ga_yesterday);
executeSql($conn, 'ga_last_week', $ga_last_week);
executeSql($conn, 'ga_last_month', $ga_last_month);
executeSql($conn, 'ga_all', $ga_all);



$data          = getRealtimeDataFromGA();
executeSql($conn, 'ga_online', $data['ga_online']);

mylog("----- Fetch ended -----" . PHP_EOL);

$conn->close();

// var_dump(getDataFromGA());
// var_dump(getRealtimeDataFromGA());

function executeSql($conn, $gaKey, $accessNum)
{
    $sql =  <<<_SQL_
    UPDATE wp_ga_data SET access_num=$accessNum      WHERE ga_key='$gaKey';
_SQL_;

    if ($conn->query($sql) === TRUE) {
        mylog("[getDataFromGA] $gaKey, $accessNum updated" . PHP_EOL);
    } else {
        mylog("[getDataFromGA] Error updating record: " . $conn->error . PHP_EOL);
    }
}

function getDataFromGA()
{
    // OAuth2 service account p12 key file
    $p12FilePath = dirname(__FILE__) . '/GiaSuTaiNangSaiGon-991960f3b23f.p12';

    // OAuth2 service account ClientId
    $serviceClientId = '720446430781-5cvfn89mkugmttmiuptlq5693gbr2blt.apps.googleusercontent.com';

    // OAuth2 service account email address
    $serviceAccountName = '720446430781-5cvfn89mkugmttmiuptlq5693gbr2blt@developer.gserviceaccount.com';

    // Scopes we're going to use, only analytics for this tutorial
    $scopes = array(
        'https://www.googleapis.com/auth/analytics.readonly'
    );

    $googleAssertionCredentials = new Google_Auth_AssertionCredentials(
        $serviceAccountName,
        $scopes,
        file_get_contents($p12FilePath)
    );

    $client = new Google_Client();
    $client->setClassConfig('Google_Cache_File', array('directory' => dirname(__FILE__) . '/cache'));

    $client->setAssertionCredentials($googleAssertionCredentials);
    $client->setClientId($serviceClientId);
    $client->setApplicationName("GiaSuTaiNangSaiGon");

    // Create Google Service Analytics object with our preconfigured Google_Client
    $analytics = new Google_Service_Analytics($client);
    // Add Analytics View ID, prefixed with "ga:"
    $analyticsViewId    = 'ga:106766364';
    $metrics            = 'ga:pageviews';

    list($startLastWeek, $endLastWeek) = getLastWeekDates();
    list($startLastMonth, $endLastMonth) = getLastMonthDates();

    $dates = array(
        'ga_today' => date("Y-m-d"),
        'ga_yesterday' => date('Y-m-d', strtotime("-1 days")),
        'ga_last_week' => array(
            'from' => $startLastWeek,
            'to' => $endLastWeek
        ),
        'ga_last_month' => array(
            'from' => $startLastMonth,
            'to' => $endLastMonth
        ),
        'ga_all' => array(
            'from' => "2015-08-01",
            'to' => date('Y-m-d')
        )
    );

    $result = array();
    foreach ($dates as $gaKey => $value) {
        $startDate = $endDate = null;
        if (is_array($value)) {
            $startDate = $value['from'];
            $endDate = $value['to'];
        } else {
            $startDate = $endDate = $value;
        }
            $data = $analytics->data_ga->get($analyticsViewId, $startDate, $endDate, $metrics, array(
                'dimensions'    => 'ga:pagePath',
                'sort'          => '-ga:pageviews',
            ));
        // Data
        $items = $data->getRows();

        $total = 0;
        foreach ($items as $key => $value) {
            $total += $value[1];
        }

        $result[$gaKey] = $total;
    }

    return $result;
}

function getRealtimeDataFromGA()
{

    $result = array();
    // OAuth2 service account p12 key file
    $p12FilePath = dirname(__FILE__) . '/GiaSuTaiNangSaiGon-991960f3b23f.p12';

    // OAuth2 service account ClientId
    $serviceClientId = '720446430781-5cvfn89mkugmttmiuptlq5693gbr2blt.apps.googleusercontent.com';

    // OAuth2 service account email address
    $serviceAccountName = '720446430781-5cvfn89mkugmttmiuptlq5693gbr2blt@developer.gserviceaccount.com';

    // Scopes we're going to use, only analytics for this tutorial
    $scopes = array(
        'https://www.googleapis.com/auth/analytics.readonly'
    );

    $googleAssertionCredentials = new Google_Auth_AssertionCredentials(
        $serviceAccountName,
        $scopes,
        file_get_contents($p12FilePath)
    );

    $client = new Google_Client();
    $client->setClassConfig('Google_Cache_File', array('directory' => dirname(__FILE__) . '/cache'));

    $client->setAssertionCredentials($googleAssertionCredentials);
    $client->setClientId($serviceClientId);
    $client->setApplicationName("GiaSuTaiNangSaiGon");

    // Create Google Service Analytics object with our preconfigured Google_Client
    $analytics = new Google_Service_Analytics($client);
    $analyticsViewId    = 'ga:106766364';
    $optParams = array(
        'dimensions' => 'rt:medium'
    );

    $result['ga_online'] = 0;
    try {
        $results = $analytics->data_realtime->get(
            $analyticsViewId,
            'rt:activeUsers',
            $optParams
        );
        $result['ga_online'] = $results->getTotalResults();
    } catch (apiServiceException $e) {
        // Handle API service exceptions.
        // $error = $e->getMessage();
    }

    return $result;
}

function getLastWeekDates()
{
    $previous_week = strtotime("-1 week +1 day");

    $start_week = strtotime("last sunday midnight", $previous_week);
    $end_week = strtotime("next saturday", $start_week);

    $start_week = date("Y-m-d", $start_week);
    $end_week = date("Y-m-d", $end_week);

    return array($start_week, $end_week);
}

function getLastMonthDates()
{
    return array(
        date("Y-m-d", strtotime("first day of previous month")),
        date("Y-m-d", strtotime("last day of previous month"))
    );
}

function mylog($msg)
{
    // open file
   $fd = fopen("/tmp/fetch_ga_giasu_saigon.log", "a");
   // write string
   $access = date("Y/m/d H:i:s");
   fwrite($fd, "Fetched: $access {$msg}");
   // close file
   fclose($fd);
}
