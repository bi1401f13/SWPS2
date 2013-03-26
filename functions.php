<?php require_once 'connect.php'; 


// Function to connect to database
function connectToDb(){
   
    // ###########################
    //Find ud af, hvorfor ovenstående 'require' ikke giver funktionen de required værdier. Jeg er nødt til at inkludere variablerne nedenfor, for at funktionen får dem. 
    // ###########################
    $db_hostname = "localhost";
    $db_database = "calendar";
    $db_username = "root";
    $db_password = "";

    //connect to database
    $db_connect = mysql_connect($db_hostname, $db_username, $db_password);
    
    //return error if connection was not established
    if(!$db_connect){
        die("Kunne ikke oprette forbindelse til databasen: ".mysql_error());
    } 
    
    //select database
    $selected_db = mysql_select_db($db_database);
    
    // Return database connection
    return $db_connect;
}

// Function to query database
function executeQuery($sql_query){
    
    // Connect to and select database
    $connect = connectToDb();
    
    // Add query result to variable
    $result = mysql_query($sql_query, $connect);
    
    // Return result
    return $result;
}

// Function to add a new shift
function addShift($startMonth, $endMonth, $startDate, $endDate, $startTime, $endTime, $workFunction, $notes){
    
    // Get the current year
    $year = date('Y'); 
    
    // Form timestamps from inputted arguments
    $shiftStart = $year.'-'.$startMonth.'-'.$startDate.' '.$startTime;
    $shiftEnd = $year.'-'.$endMonth.'-'.$endDate.' '.$endTime;
    
    $sql_query ="INSERT INTO shifts (shift_start, shift_end, work_function, notes) VALUES ('$shiftStart', '$shiftEnd', '$workFunction', '$notes')";
    
    executeQuery($sql_query); 
}

// Function to delete shift by shift-id (which is unique)
function deleteShift($shift_id){
    $sql_query = "DELETE FROM shifts WHERE shift_id = '$shift_id'"; 
    
    executeQuery($sql_query);
}

// Function to check if there is any shifts that starts or ends on the specified date
function checkIfEventExistOnDate($year, $month, $day){
    
    /*
    INSERT INTO shifts values('1','2013-03-14 12:15:00', '2013-03-14 15:15:00', "Dato 1");
    INSERT INTO shifts values('2','2013-03-15 10:00:00', '2013-03-16 01:00:00', "Dato 2 - spænder over to dage");
    */
    
    // Create the date-variable from the function inputs
    $date = $year.'-'.$month.'-'.$day;
    
    //http://www.w3schools.com/sql/func_datediff_mysql.asp
    //http://www.stillnetstudios.com/comparing-dates-without-times-in-sql-server/comment-page-1/
    $sql_query ="SELECT * FROM shifts WHERE DATEDIFF(shift_start, '$date') = 0 OR DATEDIFF(shift_end, '$date') = 0"; 
    
    // Use query function (executeQuery()) to return result of query
    $query_result = executeQuery($sql_query);
    
    // Get the amount of rows that is returned from the query. If no rows are returned no entry in the database is found for the specified date. 
    $num_rows = mysql_num_rows($query_result);
    
    // Return number of rows when the function is called
    return $num_rows;
    
}

// Function to return any shifts that starts or ends on the specified date
function returnEventsOnDate($year, $month, $day){
    
    // Create the date-variable from the function inputs
    $date = $year.'-'.$month.'-'.$day;
    
    //http://www.w3schools.com/sql/func_datediff_mysql.asp
    //http://www.stillnetstudios.com/comparing-dates-without-times-in-sql-server/comment-page-1/
    // HUSK at rette, så vi selecter de aktuelle felter og ikke bruger '*' - det gør man kun i testmiljø. 
    $sql_query ="SELECT * FROM shifts WHERE DATEDIFF(shift_start, '$date') = 0 OR DATEDIFF(shift_end, '$date') = 0";
    
    // Use query function (executeQuery()) to return result of query
    $query_result = executeQuery($sql_query);
    
    // Extract information for each entry in the table
    while($row = mysql_fetch_array($query_result)){
        
        echo "<tr>
                <td>".$row['shift_start']."</td>
                <td>".$row['shift_end']."</td>
                <td>".$row['work_function']."</td>
                <td>".$row['notes']."</td>
                <td><a href='browseDate.php?year=".$year."&month=".$month."&day=".$day."&shift_id=".$row['shift_id']."&deleteShift=yes'><img src='images/trashcan.png' alt='Delete shift' title='Delete this shift' /></a>
              </tr>";
    } 
}

// Function to create calendar
function createCalendar($month, $year){  
        
    // Get the unix timestamp for the first day in the specified month. We use unix timestamp in order to make sure that the timestamp is not dependent on 
    // the server date/time, but the timezone of the visitor - using mktime(hour, minute, second, month, day, year).
    $timestamp = mktime(0,0,0,$month,1,$year);
    
    // Using the timestamp from the specified date, get the number of days in specified month - using date(format, timestamp). 
    // t = number of days (see PHP manual)
    $numberOfDaysInMonth = date('t', $timestamp);
    
    // Get a numeric representation of the first day of the month from the timestamp
    // w = numeric representation of first day in month (see PHP manual)
    $firstDayOfMonth = date('w', $timestamp);
    
    // Get the name of the month from the timestamp
    // F = Full name of month (see PHP manual)
    $monthName = date('F', $timestamp);
        
    // Add name of month to h2 heading
    $calendar ='<h2>'.$monthName.' '.$year.'</h2>';
        
    // Create first part of calendar table.
     $calendar .= '<table>';
    
    // Create table column headings (weekdays). Could as well have been made as an array where a foreach loop would grab each day from the array.
    $calendar .='<thead>
                    <tr>
                        <th>Monday</th>
                        <th>Tuesday</th>
                        <th>Wednesday</th>
                        <th>Thursday</th>
                        <th>Friday</th>
                        <th>Saturday</th>
                        <th>Sunday</th>
                    </tr>
                </thead>'; 
    
    // Create table body  
    $calendar .='<tbody>
                    <tr>';   
    
    // Count how many days there are before the first day of the month ($firstDayOfMonth). Output these as blank cells.
    // Start count at 1 because monday is day in the week 1 (we know this because $firstDayOfMonth returns '5' for the first day of March which is a friday). 
    for($daysBeforeFirstDayOfMonth = 1; $daysBeforeFirstDayOfMonth < $firstDayOfMonth; $daysBeforeFirstDayOfMonth++){
            $calendar .='<td>&nbsp;</td>';
    }
    
    // Add a cell with the date for each day of the month. 
    // Count from 1 because the first day of the month is alway the 1st.
    for($dayInMonth = 1; $dayInMonth <= $numberOfDaysInMonth; $dayInMonth++){
    
        // Check is there is one or more shifts on a date - if there is, style the table cell
        if(checkIfEventExistOnDate($year,$month,$dayInMonth) > 0){
            //$calendar .='<td style="background:#ff6600;">'.$dayInMonth.'</td>';
            $calendar .='<td style="background:#ff6600;"><a href="browseDate.php?year='.$year.'&month='.$month.'&day='.$dayInMonth.'">'.$dayInMonth.'</a></td>';
        } 
        
        // If there are no shifts on a date, apply default style to the cell
        else {  
            $calendar .='<td><a href="browseDate.php?year='.$year.'&month='.$month.'&day='.$dayInMonth.'">'.$dayInMonth.'</a></td>';
        }    
        
        //For each day that is added, add 1 to the first day of month. 
        //As long as the first day of the month is below 7 the days are added in the same row. 
        $firstDayOfMonth++;
            
        // When the first day of month reaches 7, the row is ended to push days to a new row and the days counter is reset to start over again. 
        if($firstDayOfMonth > 7){
                $calendar .='</tr><tr>';
                $firstDayOfMonth = 1;
        }
    }
    
    // Complete the table with body and table closing tags.
    $calendar .='</tbody>
            </table>';
    
    // Return calendar    
    return $calendar;
    
}



?>