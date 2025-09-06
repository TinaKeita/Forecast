<?php $data = file_get_contents("https://emo.lv/weather-api/forecast/?city=cesis,latvia");?>
<?php $weatherData = json_decode($data, true);?>
    <?php
    function windDirection($deg) {
        $directions = ['N', 'NE', 'E', 'SE', 'S', 'SW', 'W', 'NW'];
        return $directions[round($deg / 45) % 8];
    }
    ?>

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
        <!-- augšējais posms -->
    <nav class="navbar">
        <div class="navbar-left">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                <path d="M96 160C96 142.3 110.3 128 128 128L512 128C529.7 128 544 142.3 544 160C544 177.7 529.7 192 512 192L128 192C110.3 192 96 177.7 96 160zM96 320C96 302.3 110.3 288 128 288L512 288C529.7 288 544 302.3 544 320C544 337.7 529.7 352 512 352L128 352C110.3 352 96 337.7 96 320zM544 480C544 497.7 529.7 512 512 512L128 512C110.3 512 96 497.7 96 480C96 462.3 110.3 448 128 448L512 448C529.7 448 544 462.3 544 480z"/>
            </svg>
            <p class="logo-text">VTDT Sky</p>
            <img src="gif/location.gif" alt="Location Icon" class="nav-icon">
            <p><?php echo $weatherData['city']['name'] . ", " . $weatherData['city']['country'] ?></p>
        </div>

        <div class="navbar-center">
            <div class="search-container">
                <input type="text" placeholder="Search Location" class="search-bar">
                <img src="gif/search.png" class="search-icon">
                <img src="gif/worldwide.gif" class="worldwide-icon">
            </div>

            <button class="darkmode">Dark</button>
        </div>

        <div class="navbar-right">
            <img src="gif/bell.gif" alt="Bell" class="nav-icon">
            <img src="gif/settings.gif" alt="Settings" class="nav-icon">
        </div>
    </nav>


    <!-- Current weather -->
    <div class="weather"> 
        <p>Current weather</p>
        <?php $today = $weatherData['list'][0]; ?>

        <div id="txt"></div>

        <div class="temp-row">
            <div class="temp_container">
                <img src="gif/sun.png" alt="Bell" class="sun-icon">   
                <p class="big-temp"><?php echo round($today['temp']['day']); ?>°C </p>
            </div>
            <div class="about_container">
                <p><?php echo ucfirst($today['weather'][0]['description']); ?></p>
                <p>Feels like: <?php echo round($today['feels_like']['day']); ?>°C</p>
            </div> 
        </div>
        
         <p>Current wind direction: 
            <?php 
                $deg = $weatherData['list'][0]['deg'];
                echo windDirection($deg);
            ?>
        </p>
     </div>
        
        <!-- forecast priekš dienas daļām -->
        <div class="forecast">
            <h2>Forecast (Today)</h2>

            <div class="forecast-row">
                <span class="time">Morning</span>
                <span class="condition"><?php echo $weatherData['list'][0]['weather'][0]['main']; ?></span>
                <span class="separator">|</span>
                <span class="temp"><?php echo round($weatherData['list'][0]['temp']['morn']); ?>°C</span>
                <span class="wind_today">💨 <?php echo round($weatherData['list'][0]['speed']); ?> m/s</span>
                <span class="humidity_today">💧 <?php echo $weatherData['list'][0]['humidity']; ?>%</span>
            </div>

            <div class="forecast-row">
                <span class="time">Day</span>
                <span class="condition"><?php echo $weatherData['list'][0]['weather'][0]['main']; ?></span>
                <span class="separator">|</span>
                <span class="temp"><?php echo round($weatherData['list'][0]['temp']['day']); ?>°C</span>
                <span class="wind_today">💨 <?php echo round($weatherData['list'][0]['speed']); ?> m/s</span>
                <span class="humidity_today">💧 <?php echo $weatherData['list'][0]['humidity']; ?>%</span>
            </div>

            <div class="forecast-row">
                <span class="time">Evening</span>
                <span class="condition"><?php echo $weatherData['list'][0]['weather'][0]['main']; ?></span>
                <span class="separator">|</span>
                <span class="temp"><?php echo round($weatherData['list'][0]['temp']['eve']); ?>°C</span>
                <span class="wind_today">💨 <?php echo round($weatherData['list'][0]['speed']); ?> m/s</span>
                <span class="humidity_today">💧 <?php echo $weatherData['list'][0]['humidity']; ?>%</span>
            </div>

            <div class="forecast-row">
                <span class="time">Night</span>
                <span class="condition"><?php echo $weatherData['list'][0]['weather'][0]['main']; ?></span>
                <span class="separator">|</span>
                <span class="temp"><?php echo round($weatherData['list'][0]['temp']['night']); ?>°C</span>
                <span class="wind_today">💨 <?php echo round($weatherData['list'][0]['speed']); ?> m/s</span>
                <span class="humidity_today">💧 <?php echo $weatherData['list'][0]['humidity']; ?>%</span>
            </div>
        </div>

        <!-- mazās kastes -->
        <div class="small">
            <div class="air">Air <br><br><?php echo $weatherData['list'][0]['clouds']?></div>
            <div class="wind">Wind <br><br><?php echo $weatherData['list'][0]['speed'] . " km/h"?></div>
            <div class="humidity">Humitidy <br><br><?php echo $weatherData['list'][0]['humidity'] . "%"?></div>
            <div class="visibility">Visibility</div>
            <div class="pressure_in">Pressure in <br><br>
            <?php 
                $pressure_original = $weatherData['list'][0]['pressure'];
                $pressure_in = round($pressure_original * 0.02953, 2);
                echo $pressure_in . ' in';
            ?>
            </div>
            <div class="pressure">Pressure <br><br><?php echo $weatherData['list'][0]['pressure'] . "°"?></div>
        </div>

        <!-- saulriets / saullēkts -->
        <div class="sunmoon">
            <p>Sun & Moon Summary</p>
            <p>Sunrise <?php echo date('g:i A', $weatherData['list'][0]['sunrise']); ?></p>
            <p>Sunset <?php echo date('g:i A', $weatherData['list'][0]['sunset']); ?></p>
        </div>

    </div>
<script src="script.js"></script>
</body>
</html>