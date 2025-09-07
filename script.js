document.addEventListener('DOMContentLoaded', function() {

// pulkstenis  
function startTime() {
    const now = new Date();
    const time = now.toLocaleTimeString("en-US", { 
        hour: '2-digit', 
        minute: '2-digit', 
        hour12: true 
    });

    document.getElementById('txt').innerHTML = "Local time : " + time;

    setTimeout(startTime, 500);
}

window.onload = startTime;
// prieks dienu maiņas
    const todayBtn = document.querySelector('.today');
    const tomorrowBtn = document.querySelector('.tomorrow');
    const tenDaysBtn = document.querySelector('.ten_days');
    const forecastContent = document.getElementById('forecast-content');
    const buttons = document.querySelectorAll('.buttons button');

    function loadForecast(params) {
        const url = 'get_forecast.php?' + new URLSearchParams(params).toString();
        fetch(url)
            .then(response => response.text())
            .then(html => {
                forecastContent.innerHTML = html;
            })
            .catch(error => console.error('Error loading forecast:', error));
    }

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            buttons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            if (this.classList.contains('today')) {
                loadForecast({ day: 0 });
            } else if (this.classList.contains('tomorrow')) {
                loadForecast({ day: 1 });
            } else if (this.classList.contains('ten_days')) {
                loadForecast({ view: '10days' });
            }
        });
    });

    // vienmer sakuma ielādē šodienas datus
    loadForecast({ day: 0 });
    
    
});
// dark mode
function dark_mode(btn) {
    var element = document.body;
    element.classList.toggle("dark-mode");
    
    if (element.classList.contains("dark-mode")) {
        //ja ir dark mode
        btn.textContent = "Dark";
    } else {
        // ja ir light mode
        btn.textContent = "Light";
    }
}
const unitSelect = document.getElementById('unitSelect');

// farenheit un miles selects
unitSelect.addEventListener('change', () => {
    const unit = unitSelect.value;
    
    //maina temperturas
    document.querySelectorAll('.big-temp, .weather-temp, .feels-like, .forecast-row .temp').forEach(el => {
        const c = parseFloat(el.getAttribute('data-c'));
        if (!isNaN(c)) {
            let convertedTemp = unit === 'FM' ? (c * 9/5 + 32) : c;
            let tempUnit = unit === 'FM' ? "°F" : "°C";

            if (el.classList.contains('feels-like')) {
                el.textContent = `Feels Like ${convertedTemp.toFixed(1)}${tempUnit}`;
            } else {
                el.textContent = `${convertedTemp.toFixed(1)}${tempUnit}`;
            }
        }
    });

    // --- maina vēja ātrumu
    document.querySelectorAll('.wind-speed, .forecast-row .wind_today').forEach(el => {
        const kmh = parseFloat(el.getAttribute('data-km'));
        if (!isNaN(kmh)) {
            let convertedSpeed = unit === 'FM' ? (kmh / 1.609) : kmh;
            let speedUnit = unit === 'FM' ? " mph" : " km/h";

            if (el.classList.contains('wind-speed')) {
                el.textContent = `${convertedSpeed.toFixed(1)}${speedUnit}`;
            } else {
                el.innerHTML = `<p>Wind: ${convertedSpeed.toFixed(1)}${speedUnit}</p>`;
            }
        }
    });
});
// priekš saules arc
function updateSunArc() {
    const arc = document.getElementById('progress-arc');
    if (!arc || !window.sunTimes) return;

    const sunrise = window.sunTimes.sunrise;
    const sunset = window.sunTimes.sunset;
    const now = Date.now();
    const totalLength = 125.6; //pusapla garums

    // Apreķina cik daudz ir jāaizpilda

    if (now < sunrise) {
        arc.style.strokeDashoffset = totalLength; // nav sācies
    } else if (now > sunset) {
        arc.style.strokeDashoffset = 0; // pilnībā pilns
    } else {
        const progress = (now - sunrise) / (sunset - sunrise);
        arc.style.strokeDashoffset = totalLength * (1 - progress);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    updateSunArc();
    // atjauno ik minuti
    setInterval(updateSunArc, 60000);
});
