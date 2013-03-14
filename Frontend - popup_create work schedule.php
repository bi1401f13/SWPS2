<!DOCTYPE html>

<html>
<head>
    <title>CTRL-ALL-SHIFTS</title>
    <link href="css/create_shift.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div id="create_shift_popup">
		<div id="create">
			<form action="create_shift.php" method="post">
				<fieldset>
					<label>Start</label>
					<input type="text" value="current date" name="shift_start_date" />
					<input type="text" value="current month" name="shift_start_month" />
					<input type="text" value="time" name="shift_start_time" />
				</fieldset>

				<fieldset>
					<label>End</label>	
					<input type="text" value="current date" name="shift_end_date" />
					<input type="text" value="current month" name="shift_end_month" />
					<input type="text" value="time" name="shift_end_time" />
				</fieldset>

				<label for="select_work_function">Work function</label>
				<select id="select_work_function">
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
                        <th>Taken by</th>
                        <th>Notes</th>
                        <th>Status</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Kol 1</td>
                        <td>Kol 2</td>
                        <td>Kol 3</td>
                        <td>Kol 4</td>
                        <td>Kol 5</td>
                        <td>Kol 6</td>
                        <td><img src="images/trashcan.png" alt="Delete shift" title="Delete this shift" /></td>
                    </tr>
                    <tr>
                        <td>Kol 1</td>
                        <td>Kol 2</td>
                        <td>Kol 3</td>
                        <td>Kol 4</td>
                        <td>Kol 5</td>
                        <td>Kol 6</td>
                        <td>Kol 7</td>
                    </tr>
                </tbody>
                
            </table>
		</div>
	</div>


</body>
</html>
