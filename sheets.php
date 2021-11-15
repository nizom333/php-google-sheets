<?php

// composer require google/apiclient:^2.0


require __DIR__ . '/vendor/autoload.php';

$client = new \Google_Client();
$client->setApplicationName('Google Sheets and Bitrix24');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
$client->setAuthConfig(__DIR__ . '/credentials.json');
$service = new \Google_Service_Sheets($client);
$spreadsheetId = $_ENV['SHEETS_ID'];

$range = "A2:Q";
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$values = $response->getValues();

if(empty($values))
{
    echo "No data found";
}
else
{
    foreach ($values as &$row) {
        $row = array_combine([
            'ID',
            'TYPE',
            'QUEUE',
            'DOM',
            'SECTION',
            'FLOOR',
            'NUMBER',
            'STATUS',
            'LAYOUT_TYPE',
            'ROOMS',
            'LEVEL_COUNT',
            'TOTAL_AREA',
            'LIVING_AREA',
            'KITCHEN_AREA',
            'PRICE_M2_DOLLAR',
            'PRICE_M2_SUM',
            'TOTAL_PRICE'
        ], $row);

        echo "<pre>"; print_r($row); echo "</pre>";
    }
}
