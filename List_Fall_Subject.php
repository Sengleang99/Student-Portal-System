<?php include_once "Function.php"; ?>
<?php include_once "Header.php"; ?>


<script>
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
            window.location.href = 'List_Fall_Subject.php?Remove_SubjectFall=' + id;
        }
    });
}
</script>
<?php
global $cn;
if (isset($_POST['Assign_Fall'])) {
    // Assign students
    if (isset($_POST['assign_student']) && is_array($_POST['assign_student']) && isset($_POST['assign_lecturer'])) {
        $assignedStudents = $_POST['assign_student'];
        $assignedLecturers = $_POST['assign_lecturer'];
        $success = true;
        
        foreach ($assignedStudents as $Student) {
            foreach ($assignedLecturers as $Lecturer) { // Handling multiple lecturers
                // Prevent duplicate assignment
                $checkSql = "SELECT * FROM `tblsubjectfall` WHERE 
                `StudentStatusID` = '$Student' AND 
                `ScheduleID` = '$Lecturer'";
                $checkResult = $cn->query($checkSql);
                if ($checkResult->num_rows == 0) {
                    $sql = "INSERT INTO `tblsubjectfall` (`StudentStatusID`, `ScheduleID`) 
                    VALUES ('$Student', '$Lecturer')";
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

<div class="container-xxl position-relative bg-white d-flex p-0">
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Sidebar Start -->
    <?php include("Sidebar.php"); ?>

    <div class="content">
        <!-- Navbar Start -->
        <?php include("Navbar.php"); ?>
        <!-- Navbar End -->

        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-12">
                    <div class="bg-light rounded h-100 p-4">
                        <a href="Subject_Fail.php" class="btn btn-success float-end">Back</a>
                        <h6 class="mb-4">LECTURER LISTS</h6>
                        <button type="button" id="ExportToExcel" class="btn btn-success m-3"
                            onclick="window.location.href='export_student_fall_subject.php'">Export to Excel</button>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tblsubjectfall">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Student</th>
                                        <th scope="col">Subject Fall</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="Table_Subject">
                                    <?php 
                                    global $cn;
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
                        <!-- Pagination -->
                        <section class="float-end">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Start -->
        <?php include_once"Footer.php"; ?>
        <!-- Footer End -->
    </div>
    <!-- Content End -->

    <!-- Back to Top -->
    <?php include("Library_Javascript.php") ?>