<?php
$cn= new mysqli("localhost","root","","student_portal_management");
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=student_program_status.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Query to fetch data
$sql = "SELECT 
            stt.StudentStatusID,
            stt.Note,
            st.NameInLatin,
            stt.Assigned,
            p.ProgramID,
            m.MajorEN,
            sh.ShiftEN,
            b.BatchEN,
            ac.AcademicYear
        FROM tblstudentstatus stt 
        JOIN tblprogram p ON stt.ProgramID = p.ProgramID
        JOIN tblstudentinfo st ON stt.StudentID = st.StudentID
        JOIN tblmajor m ON p.MajorID = m.MajorID
        JOIN tblshift sh ON p.ShiftID = sh.ShiftID
        JOIN tblbatch b ON p.BatchID = b.BatchID
        JOIN tblacademicyear ac ON p.AcademicYearID = ac.AcademicYearID";

$rs = $cn->query($sql);

// Check if there are any results
if ($rs->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr>
            <th>ID</th>
            <th>Student Name</th>
            <th>Program</th>
            <th>Status</th>
            <th>Note</th>
          </tr>";
    
    // Output data as rows in the table
    while ($row = $rs->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['StudentStatusID'] . "</td>";
        echo "<td>" . $row['NameInLatin'] . "</td>";
        echo "<td>" . $row['MajorEN'] . '/' . $row['ShiftEN'] . '/' . $row['BatchEN'] . '/' . $row['AcademicYear'] . "</td>";
        echo "<td>" . ($row['Assigned'] ? 'Active' : 'Disabled') . "</td>";
        echo "<td>" . $row['Note'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No records found.";
}




?>