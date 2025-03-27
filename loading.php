<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading Page</title>
    <style>
        /* Full-screen setup */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #ffffff;
            overflow: hidden;
        }

        /* Centered website logo */
        .logo {
            animation: fadeIn 4s ease-in-out forwards;
        }

        /* Developer logo at the bottom */
        .developer-logo {
            position: absolute;
            bottom: 20px;
            font-size: 1.2rem;
            color: #555;
        }

        /* Animation */
        @keyframes fadeIn {
            0% { opacity: 0; transform: scale(0.8); }
            100% { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body>
    <img src="images/1.png" alt="Website Logo" class="logo">

    <div class="developer-logo">Powered by Sandeep.me</div>

    <script>
        // Redirect after 4 seconds (matches the animation duration)
        setTimeout(function() {
            window.location.href = "login.php"; // Laravel route for login page
        }, 4000);
    </script>

</body>
</html>
