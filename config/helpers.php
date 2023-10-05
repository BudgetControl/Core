<?php

/**
 *  HELPER LIBRARY
 */

if (!function_exists('curl_get')) {
    function curl_get(string $url)
    {
        // Inizializza una sessione cURL
        $ch = curl_init($url);

        // Imposta le opzioni di cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        // Esegui la richiesta GET
        $response = curl_exec($ch);

        // Gestisci eventuali errori di cURL
        if (curl_errno($ch)) {
            echo 'Errore cURL: ' . curl_error($ch);
        }

        // Chiudi la sessione cURL
        curl_close($ch);

        // Decodifica la risposta JSON
        $data = json_decode($response);

        return $data;
    }
}

if (!function_exists('color')) {
    function color()
    {
        $hex = '';
        for ($i = 0; $i < 6; $i++) {
            $hex .= dechex(mt_rand(0, 15));
        }
        return '#' . $hex;
    }
}



/** get percentage
 * 
 * @param float $first
 * @param float $second
 * 
 * @return int
 */
if (!function_exists('percentage')) {
    function percentage(float $first, float $second): int
    {
        try {
            $difference = abs($first - $second);
            $segno = ($first > $second) ? 1 : -1;
            $percentage = ($difference / $first) * 100 * $segno;

            return $percentage;
        } catch (\DivisionByZeroError) {

            return 0;
        }
    }
}

/**
 * sum of costo
 * @param array $data
 * @return float
 */
if (!function_exists('sum')) {

    function sum(array $data): float
    {
        $cost = (float) 0.00;
        foreach ($data as $value) {
            $cost += (float) $value['amount'];
        }
        return $cost;
    }
}

if(!function_exists('sum_entries')) {

    /**
     * calculate the total type
     * @return float
     * 
     * @throws EntryException
     */
    function sum_entries(\App\BudgetTracker\Models\Entry|array|\Illuminate\Database\Eloquent\Collection $data): float
    {
        if(empty($data)) {
            throw new \App\BudgetTracker\Exceptions\EntryException("No data foud to math in getTotal function");
        }

        return sum($data);

    }
}