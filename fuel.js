const maxCapacity = 20000; // Max capacity in liters
let currentFuel = 0; // Current fuel level in liters

const fuelLevelElement = document.getElementById('fuelLevel');
const fuelLitersElement = document.getElementById('fuelLiters');
const fuelPercentageElement = document.getElementById('fuelPercentage');
const fuelInputElement = document.getElementById('fuelInput');

function updateFuelLevel() {
  const fuelPercentage = (currentFuel / maxCapacity) * 100;
  
  // Smoothly animate the fuel level transition
  fuelLevelElement.style.height = `${fuelPercentage}%`;

  // Update the liters and percentage display
  fuelLitersElement.innerText = `${currentFuel} L`;
  fuelPercentageElement.innerText = `${Math.round(fuelPercentage)}%`;
}

function changeFuel(action) {
  const fuelInput = parseFloat(fuelInputElement.value);
  if (isNaN(fuelInput) || fuelInput <= 0) {
    alert('Please enter a valid amount of fuel.');
    return;
  }

  if (action === 'add') {
    // Prevent fuel from exceeding 100% of the tank capacity
    if (currentFuel + fuelInput > maxCapacity) {
      alert("Error: Cannot add fuel beyond the tank's capacity (20,000L).");
      return;
    }

    // Warn user if fuel exceeds 95% of the tank capacity
    if (currentFuel + fuelInput >= maxCapacity * 0.95) {
      alert("Warning: Tank is near full, please be cautious.");
    }

    currentFuel += fuelInput;

  } else if (action === 'remove') {
    // Prevent fuel removal if it will go below 5% of the tank capacity
    if (currentFuel - fuelInput < maxCapacity * 0.05) {
      alert("Emergency: Fuel level cannot drop below 5%. Action denied.");
      return;
    }

    currentFuel -= fuelInput;
  }

  // Ensure fuel level stays within range
  if (currentFuel > maxCapacity) {
    currentFuel = maxCapacity;
  } else if (currentFuel < 0) {
    currentFuel = 0;
  }

  // Update fuel display
  updateFuelLevel();
  fuelInputElement.value = ''; // Clear input field after action
}
