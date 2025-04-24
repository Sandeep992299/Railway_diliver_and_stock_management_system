const maxCapacity = 20000;
let currentFuel = 0;

const fuelLevelElement = document.getElementById('fuelLevel');
const fuelLitersElement = document.getElementById('fuelLiters');
const fuelPercentageElement = document.getElementById('fuelPercentage');
const fuelInputElement = document.getElementById('fuelInput');

// Update UI
function updateFuelLevel() {
  const fuelPercentage = (currentFuel / maxCapacity) * 100;
  fuelLevelElement.style.height = `${fuelPercentage}%`;
  fuelLitersElement.innerText = `${currentFuel} L`;
  fuelPercentageElement.innerText = `${Math.round(fuelPercentage)}%`;
}

// Load current fuel on page load
window.addEventListener('DOMContentLoaded', () => {
  fetch('get_fuel_level.php')
    .then(res => res.json())
    .then(data => {
      currentFuel = parseInt(data.fuel_remain) || 0;
      updateFuelLevel();
    });
});

// Add or remove fuel
function changeFuel(action) {
  const fuelInput = parseFloat(fuelInputElement.value);
  if (isNaN(fuelInput) || fuelInput <= 0) {
    alert('Please enter a valid amount of fuel.');
    return;
  }

  if (action === 'add') {
    if (currentFuel + fuelInput > maxCapacity) {
      alert("Error: Cannot add fuel beyond the tank's capacity (20,000L).");
      return;
    }
    if (currentFuel + fuelInput >= maxCapacity * 0.95) {
      alert("Warning: Tank is near full, please be cautious.");
    }
  } else if (action === 'remove') {
    if (currentFuel - fuelInput < maxCapacity * 0.05) {
      alert("Emergency: Fuel level cannot drop below 5%. Action denied.");
      return;
    }
  }

  // Send update to backend
  fetch('fuel_process.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `volume=${fuelInput}&action=${action}`
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        currentFuel = parseInt(data.fuel_remain);
        updateFuelLevel();
      } else {
        alert(data.error || 'Operation failed.');
      }
    })
    .catch(err => {
      console.error(err);
      alert('An error occurred while processing the request.');
    });

  fuelInputElement.value = '';
}
