<?php
    function logNow($logInfo, $logger, $conn){
        date_default_timezone_set('Asia/Manila');
        $logDate = date_format(new DateTime() ,'h:i A, F d, Y');
        $logQuery = "INSERT INTO logs (log_date, log_description, admin_id)
        VALUES ('$logDate', '$logInfo', '$logger')";
        if (mysqli_query($conn, $logQuery)) {
            $noError = true;
        }
    }
?>