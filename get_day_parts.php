<?php
$data = file_get_contents("https://emo.lv/weather-api/forecast/?city=cesis,latvia");
$weatherData = json_decode($data, true);

$dayIndex = isset($_GET['day']) ? (int)$_GET['day'] : 0;
$forecastData = $weatherData['list'][$dayIndex];

$dayParts = ['morn', 'day', 'eve', 'night'];
$dayNames = ['Morning', 'Day', 'Evening', 'Night'];
$iconParts = ['half-moon', 'sun', 'sun', 'half-moon'];

for ($i = 0; $i < count($dayParts); $i++) {
    $dayPart = $dayParts[$i];
    $dayName = $dayNames[$i];
    $icon = $iconParts[$i];
    $tempC = round($forecastData['temp'][$dayPart]);
    $windKmh = round($forecastData['speed'] * 3.6); // m/s to km/h
    ?>
    <div class="forecast-row">
        <img src="gif/<?php echo $icon; ?>.png" alt="weather icon" class="nav-icon">
        <div class="day-info">
            <span class="daytime"><?php echo $dayName; ?></span>
            <span class="condition"><?php echo $forecastData['weather'][0]['main']; ?></span>
        </div>
        <div class="details-column">
            <span class="temp" data-c="<?php echo $tempC; ?>"> <?php echo $tempC; ?>°C</span>
            <div class="stacked-details">
                <span class="wind_today" data-km="<?php echo $windKmh; ?>"><p>Wind: <?php echo $windKmh; ?> km/h</p></span>
                <span class="humidity_today"><p>Humidity: <?php echo $forecastData['humidity']; ?>%</p></span>
            </div>
        </div>
    </div>
    <?php
}
?>
