function generateQRCode() {
    // Get input values
    const id = document.getElementById('id').value;
    const receiver = document.getElementById('receiver').value;
    const tel = document.getElementById('tel').value;
    const pickup = document.getElementById('pickup').value;
    const drop = document.getElementById('drop').value;

    // Create a data string with the package details
    const packageData = `id: ${id},Receiver: ${receiver}, Tel: ${tel}, Pickup: ${pickup}, Drop: ${drop}`;

    // Clear any previous QR code
    document.getElementById('qrcode').innerHTML = "";

    // Generate the QR code
    const qrcode = new QRCode(document.getElementById('qrcode'), {
        text: packageData,
        width: 200,
        height: 200
    });

    // Show the QR code result
    document.getElementById('qrResult').style.display = "block";
}
