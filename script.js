document.addEventListener('DOMContentLoaded', function() {
    
    // priekš saules līnijas (nestrada)
    function updateSunArc() {
        const sunmoonContainer = document.querySelector('.sunmoon');
        const progressArc = document.getElementById('progress-arc');

        // vai elements vispār ir
        if (!sunmoonContainer || !progressArc) return;

        // parveido timestamps uz milisekundēm
        const sunriseTime = parseInt(sunmoonContainer.dataset.sunrise) * 1000;
        const sunsetTime = parseInt(sunmoonContainer.dataset.sunset) * 1000;
        const now = new Date().getTime();

        let progress = 0;
        const pathLength = progressArc.getTotalLength();
        if (pathLength === 0) {
            // Path is not rendered yet, exit and try again later
            return;
        }
        // izrēķina prgogresu konkretajai dienas stundai
        if (now > sunriseTime && now < sunsetTime) {
            progress = (now - sunriseTime) / (sunsetTime - sunriseTime);
        } else if (now >= sunsetTime) {
            //pec saulrieta ir pilns
            progress = 1;
        }

        // strokeDashoffset zimē līniju
    progressArc.style.strokeDasharray = pathLength;
        progressArc.style.strokeDashoffset = pathLength * (1 - progress);
    }

    updateSunArc();
    // update katru minutit
    setInterval(updateSunArc, 60000);

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

    // Load the "Today" forecast on page load
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