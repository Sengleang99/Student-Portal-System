<?php 
$cn= new mysqli("localhost","root","","student_portal_management");
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="program.xls"');
header('Cache-Control: max-age=0');

// SQL query to fetch program data
$sql = "SELECT 
    tblprogram.ProgramID, tblprogram.StartDate, tblprogram.EndDate, tblprogram.DateIssue,
    tblyear.YearID, tblyear.YearEN, 
    tblsemester.SemesterID, tblsemester.SemesterEN, 
    tblmajor.MajorID, tblmajor.MajorEN, 
    tblshift.ShiftID, tblshift.ShiftEN, 
    tbldegree.DegreeID, tbldegree.DegreeNameEN, 
    tblacademicyear.AcademicYearID, tblacademicyear.AcademicYear, 
    tblbatch.BatchID, tblbatch.BatchEN, 
    tblcampus.CampusID, tblcampus.CampusEN
    FROM tblprogram
    INNER JOIN tblmajor ON tblprogram.MajorID = tblmajor.MajorID
    INNER JOIN tblsemester ON tblprogram.SemesterID = tblsemester.SemesterID
    INNER JOIN tblyear ON tblprogram.YearID = tblyear.YearID
    INNER JOIN tblshift ON tblprogram.ShiftID = tblshift.ShiftID
    INNER JOIN tbldegree ON tblprogram.DegreeID = tbldegree.DegreeID
    INNER JOIN tblacademicyear ON tblprogram.AcademicYearID = tblacademicyear.AcademicYearID
    INNER JOIN tblbatch ON tblprogram.BatchID = tblbatch.BatchID
    INNER JOIN tblcampus ON tblprogram.CampusID = tblcampus.CampusID";

// Execute the query
$rs = $cn->query($sql);

// Start the table and output column headers
echo "<table border='1'>";
echo "<tr>
    <th>Program ID</th>
    <th>Year</th>
    <th>Semester</th>
    <th>Shift</th>
    <th>Degree</th>
    <th>Academic Year</th>
    <th>Major</th>
    <th>Batch</th>
    <th>Campus</th>
    <th>Start Date</th>
    <th>End Date</th>
    <th>Date Issue</th>
</tr>";

// Check if the query returned any rows
if ($rs->num_rows > 0) {
    // Output data of each row
    while ($row = $rs->fetch_assoc()) {
        echo "<tr>
            <td>{$row['ProgramID']}</td>
            <td>{$row['YearEN']}</td>
            <td>{$row['SemesterEN']}</td>
            <td>{$row['ShiftEN']}</td>
            <td>{$row['DegreeNameEN']}</td>
            <td>{$row['AcademicYear']}</td>
            <td>{$row['MajorEN']}</td>
            <td>{$row['BatchEN']}</td>
            <td>{$row['CampusEN']}</td>
            <td>{$row['StartDate']}</td>
            <td>{$row['EndDate']}</td>
            <td>{$row['DateIssue']}</td>
        </tr>";
    }
}
echo "</table>";
?>