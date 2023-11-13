<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Plate Number Coding System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('bg.jpg');
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            opacity: 100%;
        }

        .container {
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        select,
        input[type="time"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 18px;
            margin-top: 10px;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #36454F;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 18px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Plate Number Coding System</h2>
        <form method="post">
            <div class="form-group">
                <label for="carType">Vehicle Type: </label>
                <input type="text" id="carType" name="carType" required>
            </div>
            <div class="form-group">
                <label for="plateNumber">Plate Number (e.g., ABC1234): </label>
                <input type="text" id="plateNumber" name="plateNumber" placeholder="ABC1234" pattern="[A-Za-z]{3}\d{1,16}" required>
            </div>
            <div class="form-group">
                <label for="day">Select Day: </label>
                <select id="day" name="day" required>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                    <option value="Saturday">Saturday</option>
                    <option value="Sunday">Sunday</option>
                </select>
            </div>
            <div class="form-group">
                <label for="time">Select Time: </label>
                <input type="time" id="time" name="time" required>
            </div>
            <input type="submit" name="submit" value="Check Coding">
        </form>
        <br>
        <div>
        <?php
if (isset($_POST['submit'])) {
    $plateNumber = strtoupper($_POST['plateNumber']);
    $lastDigit = (int)substr($plateNumber, -1);
    $day = $_POST['day'];
    $time = $_POST['time'];
    $vehicleType = $_POST['carType'];
    $selectedTime = date('h:i A', strtotime($time)); // Format the selected time

    // Check if the selected time is within the coding hours (7:00 AM - 8:00 PM)
    $codingStartTime = strtotime('07:00');
    $codingEndTime = strtotime('20:00');
    $selectedTimeUnix = strtotime($time);

    if ($selectedTimeUnix < $codingStartTime || $selectedTimeUnix > $codingEndTime) {
        echo "Motor Vehicle " . $vehicleType . " with Plate No. " . $plateNumber . " is NOT under coding on " . date('l', strtotime('today')) . " at " . $selectedTime . ".";
    } else {
        if (strlen(preg_replace('/\D/', '', $plateNumber)) <= 2 && (int)$plateNumber < 16) {
            echo "Motor Vehicle " . $vehicleType . " with Plate No. " . $plateNumber . " is EXEMPTED in coding scheme.";
        } else {
            $codingDays = [
                1 => 'Monday',
                2 => 'Monday',
                3 => 'Tuesday',
                4 => 'Tuesday',
                5 => 'Wednesday',
                6 => 'Wednesday',
                7 => 'Thursday',
                8 => 'Thursday',
                9 => 'Friday', // Friday coding for plates ending with 9
                0 => 'Friday' // Friday coding for plates ending with 0
            ];

            if ($day == 'Saturday' || $day == 'Sunday') {
                echo "Motor Vehicle " . $vehicleType . " with Plate No. " . $plateNumber . " is NOT CODING on " . $day . " at " . $selectedTime . ".";
            } else {
                if (array_key_exists($lastDigit, $codingDays) && $codingDays[$lastDigit] == $day) {
                    echo "Motor Vehicle " . $vehicleType . " with Plate No. " . $plateNumber . " is CODING on " . $day . " at " . $selectedTime . ".";
                } else {
                    echo "Motor Vehicle " . $vehicleType . " with Plate No. " . $plateNumber . " is NOT under coding on " . $day . " at " . $selectedTime . ".";
                }
            }
        }
    }
}
?>




        </div>
    </div>
</body>
</html>
