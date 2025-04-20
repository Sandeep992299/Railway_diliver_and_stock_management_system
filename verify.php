<?php
session_start();

$success = "";
$error = "";

if (!isset($_SESSION['temp_user']) || !isset($_SESSION['otp'])) {
    header("Location: login.php");
    exit();
}

$name = $_SESSION['temp_user']['name'];

if (isset($_POST['resend'])) {
    $_SESSION['otp'] = rand(100000, 999999);

    mail($_SESSION['temp_user']['email'], "OTP", "Your new OTP is: " . $_SESSION['otp']);

    $success = "✅ OTP has been resent to your email!";
}

if (isset($_POST['verify'])) {
    $inputOtp = $_POST['otp'];

    if ($inputOtp == $_SESSION['otp']) {
        $_SESSION['user_id'] = $_SESSION['temp_user']['id'];
        $_SESSION['user_name'] = $_SESSION['temp_user']['name'];
        $_SESSION['user_email'] = $_SESSION['temp_user']['email'];
        $_SESSION['user_role'] = $_SESSION['temp_user']['role'];

        unset($_SESSION['temp_user']);
        unset($_SESSION['otp']);

        echo "<script>
            localStorage.setItem('triggerConfetti', 'true');
            localStorage.setItem('welcomeUser', '$name');
            window.location.href = 'main.php';
        </script>";
        exit();
    } else {
        $error = "❌ Invalid OTP! Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OTP Verification</title>
    <link rel="icon" href="images/1.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
</head>
<body class="bg-cover bg-center bg-no-repeat min-h-screen relative" style="background-image: url('images/background.jpg');">
    <div class="absolute inset-0 bg-black bg-opacity-10 backdrop-blur-md"></div>

    <!-- Loader -->
    <div id="loader" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="loader border-8 border-t-blue-500 border-gray-200 rounded-full h-20 w-20 animate-spin"></div>
    </div>

    <div class="flex justify-center items-center min-h-screen relative z-10">
        <div class="bg-white bg-opacity-90 p-8 rounded-2xl shadow-2xl w-full max-w-md animate-fadeIn">
            <h2 class="text-3xl font-bold text-center mb-4 text-gray-800">Welcome <?= htmlspecialchars($name) ?> 🎉</h2>
            <p class="text-center text-sm text-gray-600 mb-6">Enter the OTP sent to your email</p>

            <?php if ($success): ?>
                <div class="bg-green-100 text-green-800 p-3 mb-4 rounded text-center"><?= $success ?></div>
            <?php elseif ($error): ?>
                <div class="bg-red-100 text-red-800 p-3 mb-4 rounded text-center"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST" class="space-y-4" onsubmit="showLoader()">
                <input type="text" name="otp" placeholder="Enter OTP" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400" required />
                <button type="submit" name="verify" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300">
                    Verify
                </button>
            </form>

            <form method="POST" class="mt-4 text-center">
                <button type="submit" name="resend" id="resendBtn" class="text-blue-600 text-sm hover:underline disabled:opacity-50" disabled>
                    ⏱️ Resend OTP in <span id="countdown">60</span>s
                </button>
            </form>
        </div>
    </div>

    <style>
        .animate-fadeIn {
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <script>
        function showLoader() {
            document.getElementById('loader').classList.remove('hidden');
        }

        // Confetti on successful login
        if (localStorage.getItem('triggerConfetti') === 'true') {
            confetti({ particleCount: 100, spread: 70, origin: { y: 0.6 } });
            localStorage.removeItem('triggerConfetti');
        }

        // Countdown logic for resend
        let timeLeft = 60;
        const countdownSpan = document.getElementById("countdown");
        const resendBtn = document.getElementById("resendBtn");

        const timer = setInterval(() => {
            timeLeft--;
            countdownSpan.textContent = timeLeft;

            if (timeLeft <= 0) {
                clearInterval(timer);
                resendBtn.disabled = false;
                resendBtn.innerHTML = "🔁 Resend OTP";
            }
        }, 1000);
    </script>
</body>
</html>
