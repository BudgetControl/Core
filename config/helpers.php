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
    function percentage(float $first, float $second): float
    {
        try {
            $difference = abs($first - $second);
            $segno = ($first > $second) ? 1 : -1;
            $percentage = ($difference / $first) * 100 * $segno;

            return round($percentage, 2);
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

if (!function_exists("last_day_of_month")) {
    function last_day_of_month(string $dateTime, string $format = 'Y-m-d'): string
    {
        $date = new DateTime($dateTime);
        $date->modify('last day of this month');
        return $date->format($format);
    }
}

if (!function_exists("first_day_of_month")) {
    function first_day_of_month(string $dateTime, string $format = 'Y-m-d'): string
    {
        $date = new DateTime($dateTime);
        $date->modify('first day of this month');
        return $date->format($format);
    }
}

if (!function_exists('sum_entries')) {

    /**
     * calculate the total type
     * @return float
     * 
     * @throws EntryException
     */
    function sum_entries(\App\BudgetTracker\Models\Entry|array|\Illuminate\Database\Eloquent\Collection $data): float
    {
        if (empty($data)) {
            throw new \App\BudgetTracker\Exceptions\EntryException("No data foud to math in getTotal function");
        }

        return sum($data);
    }
}

if (!function_exists('random_color')) {

    /**
     * generate random exadecimal color
     */
    function random_color(): string
    {
        $characters = '0123456789ABCDEF';
        $color = '#';

        for ($i = 0; $i < 6; $i++) {
            $color .= $characters[rand(0, 15)];
        }

        return $color;
    }
}

/** get percentage
 * 
 * @param float $first
 * @param float $second
 * 
 * @return int
 */
if (!function_exists('user_ip')) {
    function user_ip($crypted = true): string
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else if (getenv("APP_ENV") == "testing")
            $ipaddress = "127.0.0.1_testing";
        else
            $ipaddress = "nan";

        if ($crypted === true) {
            $ipaddress =  sha1($ipaddress);
        }

        return $ipaddress;
    }
}

if (!function_exists('generateRandomPassword')) {
    function generateRandomPassword()
    {
        $length = 12;  // Puoi regolare la lunghezza della password qui
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $specialChars = '!@#$%^&*';

        // Mescola i caratteri per garantire che almeno uno di ogni tipo sia incluso
        $allChars = $uppercase . $lowercase . $numbers . $specialChars;
        $password = $uppercase[random_int(0, strlen($uppercase) - 1)] .
            $lowercase[random_int(0, strlen($lowercase) - 1)] .
            $numbers[random_int(0, strlen($numbers) - 1)] .
            $specialChars[random_int(0, strlen($specialChars) - 1)];

        // Completa la password con caratteri casuali
        while (strlen($password) < $length) {
            $password .= $allChars[random_int(0, strlen($allChars) - 1)];
        }

        // Mescola ulteriormente la password per rendere l'ordine casuale
        $password = str_shuffle($password);

        return $password;
    }
}
