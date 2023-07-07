<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('{type}/{year?}/{month?}/{day?}/{planned?}', function (string $type, string $year = '', string $month = '', int $day = 0, string $planned = '') {


    try {

        if($year === 'planned') {
            $year = '';
            $planned = 'planned';
        }

        $year = $year === '' ? date('Y', time()) : $year;
        $startDate = $month === '' ? new DateTime() : new DateTime("$year $month");
        $endDate = $month === '' ? new DateTime() : new DateTime("$year $month");
        $planned = $planned === 'planned' ? true : false;

        $start = $startDate->modify('first day of this month')->getTimestamp();
        $end = $endDate->modify('last day of this month')->getTimestamp();

        if ($day !== 0) {
            $monthNumber = date_parse($month)['month'];
            $start = strtotime("$year/$monthNumber/$day");
            $end = strtotime("$year/$monthNumber/$day");
        }

        $stats = new \App\Stats\Controllers\StatsController(date('Y/m/d H:i:s', $start),date('Y/m/d H:i:s', $end));

        return $stats->$type($planned);
    } catch (Exception $e) {
        \Illuminate\Support\Facades\Log::critical($e->getMessage());
        return response("Ops an error occured... check url params", 500);
    }
})->middleware('auth.jwt');
