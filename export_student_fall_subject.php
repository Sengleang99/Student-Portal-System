<?php
$cn= new mysqli("localhost","root","","student_portal_management");
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Student_fall_subject.xls"');
header('Cache-Control: max-age=0');

$sql = "SELECT 
            sjf.SubjectFallID,
            sjf.DateSubjectFall,
            s.NameInLatin,
            l.LecturerName,
            sub.SubjectEN
        FROM tblsubjectfall sjf
        JOIN tblstudentstatus stt ON sjf.StudentStatusID = stt.StudentStatusID
        JOIN tblstudentinfo s ON stt.StudentID = s.StudentID
        JOIN tblschedule scd ON sjf.ScheduleID = scd.ScheduleID
        JOIN tbllecturer l ON scd.LecturerID = l.LecturerID
        JOIN tblsubject sub ON scd.SubjectID = sub.SubjectID";

$rs = $cn->query($sql);

// Check if there are any results
if ($rs->num_rows > 0) {
    echo "<table border='1'>";
    echo "<h5>List Student fall subject</h5>";
    echo "<tr>
            <th>ID</th>
            <th>Student Name</th>
            <th>Subject</th>
            <th>Lecturer</th>
            <th>Date</th>
          </tr>";
    
    // Output data as rows in the table
    while ($row = $rs->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['SubjectFallID'] . "</td>";
        echo "<td>" . $row['NameInLatin'] . "</td>";
        echo "<td>" . $row['SubjectEN'] . "</td>";
        echo "<td>" . $row['LecturerName'] . "</td>";
        echo "<td>" . $row['DateSubjectFall'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No records found.";
}




?>