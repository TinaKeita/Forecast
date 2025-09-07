<?php
$data = file_get_contents("https://emo.lv/weather-api/forecast/?city=cesis,latvia");
$weatherData = json_decode($data, true);

$dayIndex = isset($_GET['day']) ? (int)$_GET['day'] : 0;
$forecastData = $weatherData['list'][$dayIndex];

$isTenDays = isset($_GET['view']) && $_GET['view'] === '10days';

if ($isTenDays) {
    // desmit dienam
    for ($i = 2; $i < 10 && $i < count($weatherData['list']); $i++) {
        $dayData = $weatherData['list'][$i];
?>
        <div class="forecast-row" data-day-index="<?php echo $i; ?>">
            <img src="gif/sun.png" alt="weather icon" class="nav-icon">
            <div class="day-info">
                <span class="daytime"><?php echo date('D', $dayData['dt']); ?></span>
                <span class="condition"><?php echo date('Y-m-d', $dayData['dt']); ?></span>
            </div>
            <div class="details-column">
                <span class="temp"><?php echo round($dayData['temp']['day']); ?>°C</span>
                <div class="stacked-details">
                    <span class="wind_today"><p>Wind: <?php echo round($dayData['speed']); ?> m/s</p></span>
                    <span class="humidity_today"><p>Humidity: <?php echo $dayData['humidity']; ?>%</p></span>
                </div>
            </div>
        </div>
<?php
    }
} else {
    // Priekš pašas dienas
    $dayParts = ['morn', 'day', 'eve', 'night'];
    $dayNames = ['Morning', 'Day', 'Evening', 'Night'];
    $iconParts = ['half-moon', 'sun', 'sun', 'half-moon'];

    for ($i = 0; $i < count($dayParts); $i++) {
        $dayPart = $dayParts[$i];
        $dayName = $dayNames[$i];
        $icon = $iconParts[$i];
?>
        <div class="forecast-row">
            <img src="gif/<?php echo $icon; ?>.png" alt="weather icon" class="nav-icon">
            <div class="day-info">
                <span class="daytime"><?php echo $dayName; ?></span>
                <span class="condition"><?php echo $forecastData['weather'][0]['main']; ?></span>
            </div>
            <div class="details-column">
                <span class="temp"><?php echo round($forecastData['temp'][$dayPart]); ?>°C</span>
                <div class="stacked-details">
                    <span class="wind_today"><p>Wind: <?php echo round($forecastData['speed']); ?> m/s</p></span>
                    <span class="humidity_today"><p>Humidity: <?php echo $forecastData['humidity']; ?>%</p></span>
                </div>
            </div>
        </div>
<?php
    }
}
?>