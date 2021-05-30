<?php

// Sobhan Haerizadeh
// Contact => @SobhanHrzBot

$api = "https://covid-api.mmediagroup.fr/v1/cases"; // Send Request for get information
$getApi = file_get_contents($api); // Get Informations
$getJson = json_decode($getApi , true); // Json Decode 
$getIran = $getJson['Iran']['All']; // Get information about IRAN COUNTRY
$getTotal = $getIran['confirmed']; // Get Total Cases
$getDeaths = $getIran['deaths']; // Get All Deaths
$getRecovered = $getIran['recovered']; // Get All Recovered
?>

<html>
<head>
<title>COVID-19 (Iran)</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>
<body>
<table class="table table-striped table-dark">
<tr>
<th>Total Cases</th>
<th>Recovered</th>
<th>Deaths</th>
</tr>
<tr>
<td><?php echo "<font color='#FE6F5E' size='6'>" .number_format($getTotal); ?></td>
<td><?php echo "<font color='green' size='6'>" .number_format($getRecovered); ?></td>
<td><?php echo "<font color='red' size='6'>" . number_format($getDeaths); ?></td>
</tr>
</table>
</body>
</html>