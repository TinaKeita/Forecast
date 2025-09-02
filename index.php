<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VTDT sky</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php $data = file_get_contents("https://emo.lv/weather-api/forecast/?city=cesis,latvia");?>
    <?php $weatherData = json_decode($data, true);?>
    <?php echo "Pilsēta: " . $weatherData['city']['name']?>

    <div class="container">
        
    </div>

</body>
</html>