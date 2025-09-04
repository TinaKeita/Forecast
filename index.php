<?php $data = file_get_contents("https://emo.lv/weather-api/forecast/?city=cesis,latvia");?>
<?php $weatherData = json_decode($data, true);?>
<?php echo "Pilsēta: " . $weatherData['city']['name']?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VTDT sky</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="name">VTDT sky</div>
            <div class="search">
                 <input type="text" placeholder="Search...">
            </div>
            <div class="toogle"></div>
        </div>
        <div class="weather">
            Current weather 
            <div id="txt"></div></div>
        
        <div class="forecast">Forecast</div>
        <div class="small">
            <div class="air">Air <br><br><?php echo $weatherData['list'][0]['clouds']?></div>
            <div class="wind">Wind <br><br><?php echo $weatherData['list'][0]['speed'] . "km/h"?></div>
            <div class="humidity">Humitidy</div>
            <div class="visibility">Visibility</div>
            <div class="pressure_in">Pressure in</div>
            <div class="pressure">Pressure</div>
        </div>
        <div class="sunmoon">Sun & Moon</div>

    </div>
<script src="script.js"></script>
</body>
</html>