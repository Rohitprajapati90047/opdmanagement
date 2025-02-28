let currentIndex = 0;
const slides = document.querySelectorAll('.slide');
const totalSlides = slides.length;

function nextSlide() {
    // Remove 'active' class from all slides
    slides.forEach(slide => slide.classList.remove("active"));

    // Update index and show the next slide
    currentIndex = (currentIndex + 1) % totalSlides;
    slides[currentIndex].classList.add("active");

    // Move the slider
    document.querySelector('.slides').style.transform = `translateX(-${currentIndex * 100}%)`;
}

// Auto-change slides every 3 seconds
setInterval(nextSlide, 3000);

// Initialize first slide as active
slides[currentIndex].classList.add("active");


// dashboard code below
let lastVisits = parseInt(localStorage.getItem("lastVisits")) || 100;
let lastRegistrations = parseInt(localStorage.getItem("lastRegistrations")) || 50;
let lastHospitals = 10;

async function fetchDashboardData() {
    lastVisits = Math.min(600, lastVisits + Math.floor(Math.random() * 2 + 1));
    localStorage.setItem("lastVisits", lastVisits);
    
    lastRegistrations = Math.min(600, lastRegistrations + Math.floor(Math.random() * 2 + 1));
    localStorage.setItem("lastRegistrations", lastRegistrations);
    
    let hospChange = Math.floor(Math.random() * 10 - 5);
    lastHospitals = Math.max(5, Math.min(600, lastHospitals + hospChange));

    return {
        visits: lastVisits,
        registrations: lastRegistrations,
        hospitals: lastHospitals
    };
}

async function updateDashboard() {
    const data = await fetchDashboardData();
    document.getElementById("visits").textContent = data.visits;
    document.getElementById("registrations").textContent = data.registrations;
    document.getElementById("hospitals").textContent = data.hospitals;
    
    updateChart("visitsChart", "Visits", data.visits, "#FF5733");
    updateChart("registrationsChart", "Registrations", data.registrations, "#33FF57");
    updateChart("hospitalsChart", "Hospitals", data.hospitals, "#3357FF");
}

function updateChart(canvasId, label, value, color) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;
    
    const ctx = canvas.getContext("2d");
    if (canvas.chartInstance instanceof Chart) {
        canvas.chartInstance.destroy();
    }
    canvas.chartInstance = new Chart(ctx, {
        type: "pie",
        data: {
            labels: [label, "Remaining"],
            datasets: [{
                data: [value, 600 - value],
                backgroundColor: [color, "skyblue"]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}

document.addEventListener("DOMContentLoaded", updateDashboard);

// end dashboard code
