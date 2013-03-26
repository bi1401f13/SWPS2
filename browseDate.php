<?php

require_once "functions.php";

// Retrieve values in the URL parsed from the calendar dates link
$year = $_GET['year'];
$month = $_GET['month'];
$day = $_GET['day'];

// If all fields are set, add the shift
if(isset($_POST['shift_start_month'], $_POST['shift_end_month'], $_POST['shift_start_date'], $_POST['shift_end_date'], $_POST['shift_start_time'], $_POST['shift_end_time'], $_POST['shift_work_function'])){

    addShift($_POST['shift_start_month'], $_POST['shift_end_month'], $_POST['shift_start_date'], $_POST['shift_end_date'], $_POST['shift_start_time'], $_POST['shift_end_time'], $_POST['shift_work_function'], $_POST['shift_notes']);
}

// If the URL contains 'deleshift=yes', retreive its id from the url and delete it
if(isset($_GET['deleteShift']) == 'yes'){
    $shiftId = $_GET['shift_id'];
    
    deleteShift($shiftId);
}
?>

<!DOCTYPE html>

<html>
<head>
    <title>CTRL-ALL-SHIFTS</title>
    <link href="css/create_shift.css" rel="stylesheet" type="text/css" />
</head>

<body>


<div id="create_shift_popup">
		<div id="create">
            
            <!-- When the form is submitted, the query in the URL gets cleared. Therefore, we insert them again on submit in order to make the shifts on the current day show -->
			<form action=<?php echo "\"?year=$year&month=$month&day=$day\"" ?> method="post">
				<fieldset>
					<legend>Shift start</legend>
                    <div><!-- &nbsp;/&nbsp; = adds a slash with a non-breaking space on each side - to seperate day and month fields -->
					    <input type="text" id="start_date" value="<?php echo $day ?>" name="shift_start_date" />&nbsp;/&nbsp;
                        <label for="start_date">Date</label>
                    </div>
                    <div>
					    <input type="text" id="start_month" value="<?php echo $month ?>" name="shift_start_month" />
                        <label for="start_month">Month</label>
                    </div>
                    <div>
					    <input type="text" id="start_time" value="00:00" name="shift_start_time" />
                        <label for="start_time">Time</label>
                    </div>
				</fieldset>

				<fieldset>
					<legend>Shift end</legend>
                    <div>
                        <input type="text" id="end_date" value="<?php echo $day ?>" name="shift_end_date" />&nbsp;/&nbsp;
                        <label for="end_date">Date</label>
                    </div>
                    <div>
                        <input type="text" id="end_month" value="<?php echo $month ?>" name="shift_end_month" />
                        <label for="end_month">Month</label>
                    </div>
                    <div>
                        <input type="text" id="end_time" value="00:00" name="shift_end_time" />
                        <label for="end_time">Time</label>
                    </div>
				</fieldset>

				<label for="select_work_function">Work function</label>
				<select id="select_work_function" name="shift_work_function">
					<option value="work_function_1">Work function 1</option>
				</select>

				<label for="shift_notes">Notes</label>
				<textarea id="shift_notes" name="shift_notes" maxlength="1000">Notes
				</textarea>
				<br/>
				<input type="submit" value="Create shift" />
			</form>
		</div>
		<div id="overview">
            <h2>Shifts of the day</h2>
            <table>
                <thead>
                    <tr>
                        <th>Start time</th>
                        <th>End time</th>
                        <th>Work function</th>
                        <th>Notes</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php // Return events for the specified date
                        echo returnEventsOnDate($year,$month,$day);
                    ?>
                </tbody>
                
            </table>
            
            <a href="calendar.php">Go back to calendar</a>
		</div>
	</div>
</body>
</html>





<?php



?>