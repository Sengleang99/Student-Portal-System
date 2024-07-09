<?php
$cn = new mysqli("localhost", "root", "", "student_portal_management");

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="schedules.xls"');
header('Cache-Control: max-age=0');

// Fetch data from the database
$sql = "SELECT  
    scd.ScheduleID,
    l.LecturerName,
    s.SubjectEN,
    d.DayWeekName,
    t.TimeName,
    r.RoomName,
    m.MajorEN,
    y.YearEN,
    se.SemesterEN,
    dg.DegreeNameEN,
    b.BatchEN,
    a.AcademicYear,
    shi.ShiftEN
FROM tblschedule scd
INNER JOIN tblprogram p ON scd.ProgramID = p.ProgramID
INNER JOIN tblsubject s ON scd.SubjectID = s.SubjectID
INNER JOIN tbllecturer l ON scd.LecturerID = l.LecturerID
INNER JOIN tbldayweek d ON scd.DayWeekID = d.DayWeekID
INNER JOIN tbltime t ON scd.TimeID = t.TimeID
INNER JOIN tblroom r ON scd.RoomID = r.RoomID
INNER JOIN tblmajor m ON p.MajorID = m.MajorID
INNER JOIN tblyear y ON p.YearID = y.YearID
INNER JOIN tblsemester se ON p.SemesterID = se.SemesterID
INNER JOIN tbldegree dg ON p.DegreeID = dg.DegreeID
INNER JOIN tblbatch b ON p.BatchID = b.BatchID
INNER JOIN tblshift shi ON p.ShiftID = shi.ShiftID
INNER JOIN tblacademicyear a ON p.AcademicYearID = a.AcademicYearID
ORDER BY scd.ScheduleID DESC";

$result = $cn->query($sql);

echo "<table border='1'>";
echo "<tr>
    <th>Schedule ID</th>
    <th>Lecturer</th>
    <th>Subject</th>
    <th>Day</th>
    <th>Time</th>
    <th>Room</th>
    <th>Major</th>
    <th>Year</th>
    <th>Semester</th>
    <th>Degree</th>
    <th>Batch</th>
    <th>Academic Year</th>
    <th>Shift</th>
</tr>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['ScheduleID']}</td>
            <td>{$row['LecturerName']}</td>
            <td>{$row['SubjectEN']}</td>
            <td>{$row['DayWeekName']}</td>
            <td>{$row['TimeName']}</td>
            <td>{$row['RoomName']}</td>
            <td>{$row['MajorEN']}</td>
            <td>{$row['YearEN']}</td>
            <td>{$row['SemesterEN']}</td>
            <td>{$row['DegreeNameEN']}</td>
            <td>{$row['BatchEN']}</td>
            <td>{$row['AcademicYear']}</td>
            <td>{$row['ShiftEN']}</td>
        </tr>";
    }
}

echo "</table>";

$cn->close();
?>