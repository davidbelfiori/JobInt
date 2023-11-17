<?php


function ValidateEmail($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {

        exit("invalid format");

    }

    $api_key = "0a1de96d2202412897b83dd89800ab2b";

    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL => "https://emailvalidation.abstractapi.com/v1?api_key=$api_key&email=$email",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true
    ]);

    $response = curl_exec($ch);

    curl_close($ch);

    $data = json_decode($response, true);

    if ($data['deliverability'] === "UNDELIVERABLE") {

        return("Undeliverable");

    }

    if ($data["is_disposable_email"]["value"] === true) {

        return("Disposable");

    }

    return("valid");
}
