<?php
     $cn= new mysqli("localhost","root","","student_portal_management");
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $sql="SELECT * FROM `tblmajor` WHERE `FacultyID` = $id";
        $rs = $cn->query($sql);      
            $out = '';        
            while ($row = $rs->fetch_assoc()) {
                $out .= '<option value="'.$row['MajorID'].'">'.$row['MajorEN'].'</option>';
            }   
            echo $out;
    }  

    if (isset($_POST['id'])) {
        $ProgramID = $_POST['id'];
        
        // Fetch students
        $studentSql = "SELECT 
                        stt.StudentStatusID,
                        sti.NameInLatin
                        FROM tblstudentstatus stt
                        JOIN tblstudentinfo sti ON stt.StudentID = sti.StudentID
                        WHERE stt.ProgramID = $ProgramID";
        $studentResult = $cn->query($studentSql);
        
        $students = '';
        while ($row = $studentResult->fetch_assoc()) {
            $students .= '<tr><td>' . $row['StudentStatusID'] . '</td><td>' . $row['NameInLatin'] . '</td><td><button class="btn btn-sm btn-primary">Assign</button></td></tr>';
        }
        
        // Fetch lecturers
        $lecturerSql = "SELECT
                        lt.LecturerID,
                        lt.Name AS LecturerName
                        FROM tbllecturer lt
                        JOIN tblprogram_lecturer pl ON lt.LecturerID = pl.LecturerID
                        WHERE pl.ProgramID = $ProgramID";
        $lecturerResult = $cn->query($lecturerSql);
        
        $lecturers = '';
        while ($row = $lecturerResult->fetch_assoc()) {
            $lecturers .= '<tr><td>' . $row['LecturerID'] . '</td><td>' . $row['LecturerName'] . '</td></tr>';
        }
    
        // Return data as JSON
        echo json_encode(['students' => $students, 'lecturers' => $lecturers]);
    }
?>