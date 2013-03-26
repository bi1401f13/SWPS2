<?php
require_once "functions.php";

// Set default value of the $month variable to be the current month
$month = "current";

// If a specific month is selected, post its value to the $month variable (this is used further down the page)
if(isset($_POST['select_month'])){
$month = $_POST['select_month'];
}
?>

<!DOCTYPE html>

<html>
<head>
    <title>CTRL-ALL-SHIFTS</title>
    <link href="css/create_shift.css" rel="stylesheet" type="text/css" /> 
</head>

<body>
    <!-- Select element: allows user to chose what month the calendar should display -->
    <form action="" method="post">
        <select name="select_month">
            <option value="current">Current month</option>
            <option value="1">January</option>
            <option value="2">February</option>
            <option value="3">Marts</option>
            <option value="4">April</option>
            <option value="5">May</option>
            <option value="6">June</option>
            <option value="7">July</option>
            <option value="8">August</option>
            <option value="9">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
        </select>
        
        <input type="submit" value="See month" />
    </form>
	<?php 
        // If no value is selected the calendar will just display the current month and year
        if($month == "current") {
            $month = date('m');
            $year = date('Y');
            // Add a calendar for the current month and year
            echo createCalendar($month, $year);
        }
        // If a specific month is selected, pass its value from the select element and show the calendar for that month
      else {
            $month = $_POST['select_month'];
            $year = date('Y');
            // Add a calendar for the specified month and year
            echo createCalendar($month, $year);
        }

    ?>

</body>
</html>

