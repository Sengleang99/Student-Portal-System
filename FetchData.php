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

    $response = [
        'success' => false,
        'students' => '',
        'lecturers' => ''
    ];
    
    if (isset($_POST['id'])) {
        $id = intval($_POST['id']); // Sanitize input
        // Fetch students
        $studentSql = "SELECT 
                stt.StudentStatusID,
                sti.StudentID,
                sti.NameInLatin
            FROM tblstudentstatus stt
            JOIN tblprogram p ON stt.ProgramID = p.ProgramID
            JOIN tblstudentinfo sti ON stt.StudentID = sti.StudentID
            WHERE stt.ProgramID = $id";
        $studentResult = $cn->query($studentSql);
    
        if ($studentResult && $studentResult->num_rows > 0) {
            $students = '';
            while ($row = $studentResult->fetch_assoc()) {
                $students .= '<tr>
                    <td>' . htmlspecialchars($row['StudentID']) . '</td>
                    <td>' . htmlspecialchars($row['NameInLatin']) . '</td>
                    <td><input type="checkbox" name="assign_student[]" value="' . htmlspecialchars($row['StudentStatusID']) . '"></td>
                </tr>';
            }
            $response['students'] = $students;
        } else {
            $response['students'] = '<tr><td colspan="3">No students found</td></tr>';
        }
    
        // Fetch lecturers
        $lecturerSql = "SELECT
                scd.ScheduleID,
                lr.LecturerID,
                lr.LecturerName,
                s.SubjectEN
            FROM tblschedule scd
            JOIN tblsubject s ON scd.SubjectID = s.SubjectID
            JOIN tbllecturer lr ON scd.LecturerID = lr.LecturerID
            JOIN tblprogram p ON scd.ProgramID = p.ProgramID
            WHERE scd.ProgramID  = $id";
        $lecturerResult = $cn->query($lecturerSql);
    
        if ($lecturerResult && $lecturerResult->num_rows > 0) {
            $lecturers = '';
            while ($row = $lecturerResult->fetch_assoc()) {
                $lecturers .= '<tr>
                    <td>' . htmlspecialchars($row['LecturerID']) . '</td>
                    <td>' . htmlspecialchars($row['LecturerName']) . '</td>
                    <td>' . htmlspecialchars($row['SubjectEN']) . '</td>
                    <td><input type="checkbox" name="assign_lecturer[]" value="' . htmlspecialchars($row['ScheduleID']) . '"></td>
                </tr>';
            }
            $response['lecturers'] = $lecturers;
        } else {
            $response['lecturers'] = '<tr><td colspan="4">No lecturers found</td></tr>';
        }
    
        $response['success'] = true;
    }
    
    // Set header for JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    
    $cn->close();
    ?>