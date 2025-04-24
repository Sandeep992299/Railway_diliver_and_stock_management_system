// Initial storage values
let mailStorage = 0;

// Update UI for Mail Storage
function updateMailStorageUI() {
    const maxStorage = 1000;
    const percent = (mailStorage / maxStorage) * 100;
    document.getElementById('mailStorageValue').innerText = `${mailStorage}/${maxStorage} (${percent.toFixed(2)}%)`;
    document.getElementById('mailBar').style.width = percent + '%';
}



// Mail Stock Management Functions
function updateMailStorage(amount) {
    const inputValue = parseInt(document.getElementById('mailInput').value) || 0;
    mailStorage = Math.min(1000, Math.max(0, mailStorage + (inputValue * amount)));
    updateMailStorageUI();
}



// Initial storage values
let fertilizerStorageKg = 0;  
let fertilizerStoragePacks = 0; 

// Update UI for Fertilizer Storage
function updateFertilizerStorageUI() {
    const maxStorageKg = 100000;  
    const maxStoragePacks = 2000; 
    const percentKg = (fertilizerStorageKg / maxStorageKg) * 100;
    const percentPacks = (fertilizerStoragePacks / maxStoragePacks) * 100;

    document.getElementById('fertilizerStorageValue').innerText = `${fertilizerStorageKg} kg/${maxStorageKg} kg (${percentKg.toFixed(2)}%) - ${fertilizerStoragePacks} packs/${maxStoragePacks} packs (${percentPacks.toFixed(2)}%)`;
    document.getElementById('fertilizerBar').style.width = percentKg + '%';  // Update the progress bar based on kg
}

// Fertilizer Stock Management Functions
function updateFertilizerStorage(amount) {
    const packs = parseInt(document.getElementById('fertilizerInput').value) || 0;

    // Update the storage by the number of packs entered 
    const weightChange = packs * 50; 

    // Update the storage, ensuring it does not exceed the maximum limit
    fertilizerStorageKg = Math.min(100000, Math.max(0, fertilizerStorageKg + (weightChange * amount)));
    fertilizerStoragePacks = Math.min(2000, Math.max(0, fertilizerStoragePacks + (packs * amount)));

    updateFertilizerStorageUI();
}

