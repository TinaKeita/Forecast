<?php $data = file_get_contents("https://emo.lv/weather-api/forecast/?city=cesis,latvia");?>

<?php $weatherData = json_decode($data, true);?>
<?php echo "Pilsēta: " . $weatherData['city']['name']?>