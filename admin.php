<?php
include 'db_connect.php';
?>

<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #0d0c22;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        .button {
            display: inline-block;
            padding: 20px 40px;
            margin: 10px;
            color: #fff;
            background-color: #ff43a4;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 20px;
            transition: all 0.3s ease-in-out;
            /* Smooth transition */
            box-shadow: 0 0 5px #ff43a4,
                /* Inner glow */
                0 0 10px #ff43a4,
                /* Middle glow */
                0 0 15px #ff43a4,
                /* Outer glow */
                0 0 5px #ff43a4;
            /* Far outer glow */
        }

        .button:hover {
            
            background-color: #00ff41;
            /* Neon pink for button hover */
            box-shadow: 0 0 5px #00ff41,
                /* Inner glow */
                0 0 10px #00ff41,
                /* Middle glow */
                0 0 15px #00ff41,
                /* Outer glow */
                0 0 5px #00ff41;
            /* Far outer glow */
        }

        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
            display: none;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <form action="reset_db.php" method="post" onsubmit="showLoader()">
        <button type="submit" class="button">Rebuild Database</button>
    </form>

    <div id="loader" class="loader"></div>

    <script>
        function showLoader() {
            document.getElementById('loader').style.display = 'block';
        }
    </script>

    <div>
        <a href="ind.php" class="button">Back</a>
    </div>

</body>

</html>
