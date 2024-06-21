<?php include("Function.php"); ?>
<?php include("Header.php"); ?>

<?php
if (isset($_POST['Assign_Fall'])) {
    // Assign students
    if (isset($_POST['assign_student']) && is_array($_POST['assign_student']) && isset($_POST['assign_lecturer']) && isset($_POST['dateFall'])) {
        $assignedStudents = $_POST['assign_student'];
        $assignedLecturers = $_POST['assign_lecturer'];
        $dateFall = $_POST['dateFall'];
        $success = true;

        foreach ($assignedStudents as $Student) {
            $Lecturer = $assignedLecturers[0]; // assuming single lecturer
            
            // Prevent duplicate assignment
            $checkSql = "SELECT * FROM `tblsubjectfall` WHERE 
            `StudentStatusID` = '$Student' AND 
            `ScheduleID` = '$Lecturer' AND 
            `DateSubjectFall` = '$dateFall'";
            $checkResult = $cn->query($checkSql);
            
            if ($checkResult->num_rows == 0) {
                $sql = "INSERT INTO `tblsubjectfall` (`StudentStatusID`, `ScheduleID`, `DateSubjectFall`) 
                VALUES ('$Student', '$Lecturer', '$dateFall')";
                $rs = $cn->query($sql);
                if (!$rs) {
                    $success = false;
                    echo "<script>
                            Swal.fire('Error!', 'Failed to add student ID: $Student.', 'error');
                          </script>";
                    break;
                }
            }
        }
        if ($success) {
            echo "<script>
                    Swal.fire('Success!', 'Students assigned successfully.', 'success');
                  </script>";
        }
    } else {
        echo "<script>
                Swal.fire('Error!', 'No students or lecturer selected.', 'error');
              </script>";
    }
}

if(isset($_GET['Remove_SubjectFall'])){
    $id = $_GET['Remove_SubjectFall'];
    $sql ="DELETE FROM `tblsubjectfall` WHERE SubjectFallID = $id";
    $rs = $cn->query($sql);
    if($rs){
        echo "<script>
                Swal.fire('Successful!', 'Lecturer deleted successfully!', 'success').then(() => {
                    refreshPage();
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire('Error!', 'Failed to delete lecturer.', 'error');
              </script>";
    }
}
?>

<script>
$(function() {
    $('#Program').change(function() {
        var ProgramID = $(this).val();
        if (ProgramID) {
            $.ajax({
                type: 'POST',
                url: 'FetchData.php',
                data: {
                    id: ProgramID
                },
                // Expect JSON response
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        $('#Table_Status').html(data.students); // Populate students table
                        $('#Lecturer_Status').html(data.lecturers);
                    } else {
                        $('#Table_Status').html(
                            '<tr><td colspan="3">No students found</td></tr>');
                        $('#Lecturer_Status').html(
                            '<tr><td colspan="4">No lecturers found</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error: ' + error);
                    console.log(xhr.responseText); // Log the response text for debugging
                }
            });
        } else {
            $('#Table_Status').html('<tr><td colspan="3">Please select a program</td></tr>');
            $('#Lecturer_Status').html('<tr><td colspan="4">Please select a program</td></tr>');
        }
    });
});

function deleteSubjectFall(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'Subject_Fail.php?Remove_SubjectFall=' + id;
        }
    });
}
</script>

<div class="container-fluid position-relative bg-white d-flex p-0">
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <?php include("Sidebar.php"); ?>
    <div class="content">
        <?php include("Navbar.php"); ?>

        <form action="Subject_Fail.php" method="POST" enctype="multipart/form-data">
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="bg-light rounded h-100 p-4">
                            <h5 class=" text-center">ASSIGN STUDENT FALL SUBJECTS</h5>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <select id="Program" name="Program" class="form-select">
                                        <option class="text-center" value="">------------------Select
                                            Program----------------</option>
                                        <?php
                                            $sql = "SELECT 
                                            p.ProgramID,
                                            m.MajorEN,
                                            s.SemesterEN,
                                            y.YearEN,
                                            sh.ShiftEN,
                                            b.BatchEN,
                                            c.CampusEN,
                                            d.DegreeNameEN
                                        FROM tblprogram p
                                        JOIN tblmajor m ON p.MajorID = m.MajorID
                                        JOIN tblsemester s ON p.SemesterID = s.SemesterID
                                        JOIN tblyear y ON p.YearID = y.YearID
                                        JOIN tblshift sh ON p.ShiftID = sh.ShiftID
                                        JOIN tblbatch b ON p.BatchID = b.BatchID
                                        JOIN tbldegree d ON p.DegreeID = d.DegreeID
                                        JOIN tblcampus c ON p.CampusID = c.CampusID";
                                            $rs = $cn->query($sql);
                                            while ($row = $rs->fetch_assoc()) {
                                                echo 
                                                    '<option value="' . 
                                                        $row['ProgramID'] . '">' . 
                                                        $row['MajorEN'] . '/' . 
                                                        $row['YearEN'] . '/' . 
                                                        $row['SemesterEN'] . '/'. 
                                                        $row['DegreeNameEN'] .'/'. 
                                                        $row['ShiftEN'] . '/' . 
                                                        $row['BatchEN'] . '/' . 
                                                        $row['CampusEN'] . 
                                                    '</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="">Date Subject Fall</label>
                                    <input type="date" name="dateFall" id="dateFall" class="form-control">
                                </div>
                            </div>
                            <button type="submit" name="Assign_Fall" class="btn btn-primary mt-2">Save</button>
                        </div>
                    </div>
                    <!-- Students Table -->
                    <div class="col-6">
                        <div class="bg-light rounded p-4">
                            <h6 class="mb-4">STUDENTS LIST</h6>
                            <div class="table-responsive">
                                <table class="table" id="tblstatus">
                                    <thead>
                                        <tr>
                                            <th scope="col">Id</th>
                                            <th scope="col">Student</th>
                                            <th scope="col">Assign</th>
                                        </tr>
                                    </thead>
                                    <tbody id="Table_Status">
                                        <!-- Students will be populated here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Lecturers Table -->
                    <div class="col-6">
                        <div class="bg-light rounded p-4">
                            <h6 class="mb-4">LECTURERS LIST</h6>
                            <div class="table-responsive">
                                <table class="table" id="tbllecturer">
                                    <thead>
                                        <tr>
                                            <th scope="col">Id</th>
                                            <th scope="col">Lecturer</th>
                                            <th scope="col">Subject</th>
                                            <th scope="col">Assign</th>
                                        </tr>
                                    </thead>
                                    <tbody id="Lecturer_Status">
                                        <!-- Lecturers will be populated here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Subject Fall Table -->
                    <div class="col-12">
                        <div class="bg-light rounded p-4">
                            <h6 class="mb-4">STUDENT LIST FALL SUBJECTS</h6>
                            <div class="table-responsive">
                                <table class="table" id="tblsubjectfall">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Student</th>
                                            <th scope="col">Subject</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="Table_Subject">
                                        <?php 
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
                                            JOIN tblsubject sub ON scd.SubjectID = sub.SubjectID
                                        ";
                                        $rs = $cn->query($sql);
                                        while ($row = $rs->fetch_assoc()) {
                                            ?>
                                        <tr>
                                            <td><?php echo $row['SubjectFallID']; ?></td>
                                            <td><?php echo $row['NameInLatin']; ?></td>
                                            <td><?php echo $row['SubjectEN'] .'('.$row['LecturerName'] .')'. ''  ?></td>
                                            <td><?php echo $row['DateSubjectFall']; ?></td>
                                            <td><a type="button" href="#"
                                                    onclick="deleteSubjectFall(<?php echo $row['SubjectFallID'] ?>)"><i
                                                        class="bi bi-trash-fill text-danger"></i> </a></td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php include("Footer.php"); ?>
                </div>
            </div>
        </form>
    </div>
</div>