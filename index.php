<?php
    date_default_timezone_set('Europe/Riga');
    $city = "cesis,latvia";

    if (isset($_POST["search"]) && !empty($_POST["search"])) {
        $city = $_POST["search"];
    }
    // api beigas jaunajai pilsetai
    $api_url = "https://emo.lv/weather-api/forecast/?city=" . urlencode($city);
    $data = @file_get_contents($api_url);
    // vai api aizgaja
    if ($data === false) {
        $errorMessage = "Nevar piekļut datiem";
        $weatherData = null; 
    } else {
        $weatherData = json_decode($data, true);
        
        // ja dati ir valid
        if (json_last_error() !== JSON_ERROR_NONE || !isset($weatherData['list'])) {
            $errorMessage = "Nederīgi dati";
            $weatherData = null;
        }
    }

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
            <p class="location"><?php echo $weatherData['city']['name'] . ", " . $weatherData['city']['country'] ?></p>
        </div>

        <div class="navbar-center">
            <form method="post" action="index.php" class="search-container">
                    <input type="text" name="search" placeholder="<?php echo isset($weatherData['city']['name']) ? $weatherData['city']['name'] : 'Search city'; ?>" class="search-bar">
                    <button type="submit" style="background:none; border:none; padding:0;">
                        <img src="gif/search.png" class="search-icon">
                    </button>
                    <img src="gif/worldwide.gif" class="worldwide-icon">
            </form>

            <button class="darkmode" onclick="dark_mode(this)">Dark</button>
        </div>

        <div class="navbar-right">
            <img src="gif/bell.gif" alt="Bell" class="nav-icon">
            <img src="gif/settings.gif" alt="Settings" class="nav-icon">
        </div>
    </nav>


    <!-- Current weather -->
    <div class="weather"> 
    <?php $today = $weatherData['list'][0]; ?>   
        <div class="top-row">
            <p class="main">Current weather</p>
        
            <div class="select">
                <select class="select" id="unitSelect">
                    <option value="CK">Celsius and Kilometers</option>
                    <option value="FM">Fahrenheit and Miles</option>
                </select>
            </div>
        </div>

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
        
        <!-- mazās kastes -->
        <div class="small">
            <div class="air">
                <div class="line">
                    <img src="gif/clouds.gif" alt="clouds" class="nav-icon">
                    <div class="row">
                        <p>Air quality</p>
                        <p class='data-value'><?php echo $weatherData['list'][0]['clouds']?></p>
                    </div>
                </div>
            </div>
            <div class="wind">
                <div class="line">
                    <img src="gif/wind.gif" alt="clouds" class="nav-icon">
                    <div class="row">
                        <p>Wind</p>
                        <p class='data-value'><?php echo $weatherData['list'][0]['speed'] . " km/h"?></p>
                    </div>
                </div>
            </div>
            <div class="humidity">
                <div class="line">
                    <img src="gif/humidity.gif" alt="clouds" class="nav-icon">
                    <div class="row">
                        <p>Humitidy</p>
                        <p class='data-value'> <?php echo $weatherData['list'][0]['humidity'] . "%"?></p>
                    </div>
                </div>
            </div>
            <div class="visibility">
                <div class="line">
                    <img src="gif/vision.gif" alt="clouds" class="nav-icon">
                    <div class="row">
                        <p>Visibility</p>
                        <p class='data-value'> 10 km/h</p>
                    </div>
                </div>
            </div>
            <div class="pressure_in">
                <div class="line">
                    <img src="gif/air-pump.gif" alt="clouds" class="nav-icon">
                    <div class="row">
                        <p>Pressure in</p>
                        <p class='data-value'>
                            <?php
                                $pressure_original = $weatherData['list'][0]['pressure'];
                                $pressure_in = round($pressure_original * 0.02953, 2);
                                echo $pressure_in . ' in';
                            ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="pressure">
            <div class="line">
                <img src="gif/air-pump.gif" alt="clouds" class="nav-icon">
                <div class="row">
                    <p>Pressure </p>
                    <p class='data-value'><?php echo $weatherData['list'][0]['pressure'] . "°"?></p>
                </div>
            </div>
            </div>
        </div>

        <!-- saulriets / saullēkts -->
        <div class="sunmoon">
            <div class="sun_top"><p>Sun & Moon Summary</p></div>
            <div class="sunrise">
                <div class="quality">
                    <img src="gif/sun.gif" alt="sun" class="sunrise-icon">
                    <div class="middle_vertical">
                        <p>Air Quality</p>
                        <p style="font-weight:bold;"><?php echo $weatherData['list'][0]['clouds']?></p>
                    </div> 
                </div> 
                <div class="time-arc-wrapped">
                <div class="time">
                    <img src="gif/sunrise.gif" alt="sunrise" class="sunrise-icon">
                    <p>Sunrise</p>
                    <p style="font-weight:bold;"><?php echo date('g:i A', $weatherData['list'][0]['sunrise']); ?></p>
                </div>
                <div class="arc">
                    <svg width="100" height="50" viewBox="0 0 100 50">
                    <path 
                        id="bg-arc"
                        d="M 10 50 A 40 40 0 1 1 90 50"
                        fill="transparent"
                        stroke="#E0E0E0" 
                        stroke-width="10"
                        
                    />
                      <path
                        id="progress-arc"
                        d="M 10 50 A 40 40 0 1 1 90 50"
                        fill="transparent"
                        stroke="orange"
                        stroke-width="10"
                    />
                    </svg>

                </div>

                <div class="time">
                    <img src="gif/sunset.gif" alt="sunrise" class="sunrise-icon">
                    <p>Sunset</p>
                    <p style="font-weight:bold;"><?php echo date('g:i A', $weatherData['list'][0]['sunset']); ?></p>
                </div>    
                </div>
            </div>
        </div>
       <!-- forecast priekš dienas daļām -->
        <div class="forecast">
            <div class="buttons">
                <button class="today">Today</button>
                <button class="tomorrow">Tomorrow</button>
                <button class="ten_days">10 days</button>
            </div>
    <div id="forecast-content">
    </div>
    <div id="day-popup" class="popup-overlay" style="display:none;">
    <div class="popup-content">
        <span class="close-popup">&times;</span>
        <div id="popup-details">
        <!-- šeit būs dienas datu daļas priekš dienas -->
        </div>
    </div>
    </div>

    </div>

<script>
  window.sunTimes = {
    sunrise: <?php echo $weatherData['list'][0]['sunrise']; ?> * 1000,
    sunset: <?php echo $weatherData['list'][0]['sunset']; ?> * 1000
  };
</script>

<script src="script.js"></script>
</body>
</html>