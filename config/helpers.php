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
