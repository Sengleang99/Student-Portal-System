<?php include("Function.php"); ?>
<?php include("Header.php"); ?>
<?php 
     if (isset($_POST['Add_Status'])) {
        $Program = $_POST['Program'];
        $Note = $_POST['Note'];
        if (isset($_POST['assigned'])) {
            $assignedStudents = $_POST['assigned'];
            foreach ($assignedStudents as $Student) {
                $sql = "INSERT INTO tblstudentstatus (StudentID, ProgramID, Note) 
                        VALUES ('$Student', '$Program', '$Note')";
                $rs = $cn->query($sql);
                
                if (!$rs) {
                    echo "<script>
                            Swal.fire('Error!', 'Failed to add student ID: $Student.', 'error');
                          </script>";
                    break; // Exit the loop on first error
                }
            }
            if ($rs) {
                echo "<script>
                        Swal.fire('Successful!', 'Students added successfully!', 'success');
                      </script>";
            }
        } else {
            // No students selected
            echo "<script>
                    Swal.fire('Error!', 'No students selected.', 'error');
                  </script>";
        }
    }

    if(isset($_GET['StudentStatusID']) && isset($_GET['Assigned'])){
        $id = $_GET['StudentStatusID'];
        $Assigned = $_GET['Assigned'];
        $sql ="UPDATE `tblstudentstatus` SET Assigned=$Assigned WHERE StudentStatusID=$id";
        $rs = $cn->query($sql);
    }

       if(isset($_GET['Remove_Status'])){
            $id = $_GET['Remove_Status'];
            $sql ="DELETE FROM `tblstudentstatus` WHERE StudentStatusID=$id";
            $rs = $cn->query($sql);
            if ($rs) {
                echo "<script>
                        Swal.fire('Successful!', 'Students delete successfully!', 'success');
                      </script>";
            }
        }


        $recordsPerPage = 5; // Define how many records you want per page
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($currentPage - 1) * $recordsPerPage;
    
        // Count total records
        $totalRecordsSql = "SELECT COUNT(*) AS total FROM tblstudentstatus";
        $totalRecordsResult = $cn->query($totalRecordsSql);
        $totalRecords = $totalRecordsResult->fetch_assoc()['total'];
    
        // Calculate total pages
        $totalPages = ceil($totalRecords / $recordsPerPage);
    ?>
?>
<script>
function deleteStatus(id) {
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
            window.location.href = 'Status.php?Remove_Status=' + id;
        }
    });
}
</script>

<div class="container-xxl position-relative bg-white d-flex p-0">
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <?php include("Sidebar.php"); ?>
    <div class="content">

        <?php include("Navbar.php"); ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="bg-light rounded h-100 p-4">
                            <h5 class="text-center">ASSING STUDENT PROGRAMS</h5>
                            <div class="row">
                                <div class="col-12">
                                    <input type="number" id="id" name="id" hidden>
                                </div>
                                <div class="col-12">
                                    <label for="Schedule">Program</label>
                                    <select id="Program" name="Program" class="form-select">
                                        <option value="">Select Program</option>
                                        <?php
                                            $sql = "SELECT 
                                                tblprogram.ProgramID, 
                                                tblmajor.MajorEN, 
                                                tblsemester.SemesterEN, 
                                                tblyear.YearEN,
                                                tblshift.ShiftEN,
                                                tblbatch.BatchEN
                                            FROM tblprogram 
                                            INNER JOIN tblmajor ON tblprogram.MajorID = tblmajor.MajorID 
                                            INNER JOIN tblshift ON tblprogram.ShiftID = tblshift.ShiftID 
                                            INNER JOIN tblbatch ON tblprogram.BatchID = tblbatch.BatchID 
                                            INNER JOIN tblsemester ON tblprogram.SemesterID = tblsemester.SemesterID 
                                            INNER JOIN tblyear ON tblprogram.YearID = tblyear.YearID";
                                            $rs = $cn->query($sql);
                                            while ($row = $rs->fetch_assoc()) {
                                                echo 
                                                '<option value="' 
                                                . $row['ProgramID'] . '">' 
                                                . $row['MajorEN'] . '/' 
                                                . $row['YearEN'] . '/' 
                                                . $row['SemesterEN'] . '/' 
                                                . $row['ShiftEN'] 
                                                . $row['SemesterEN'] . '/' 
                                                . $row['BatchEN'] .
                                                '</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="Note">Note</label>
                                    <input type="text" name="Note" id="Note" class="form-control">
                                </div>
                            </div>
                            <button type="submit" name="Add_Status" id="Add_Status"
                                class="btn btn-primary mt-2">Save</button>
                        </div>
                    </div>

                    <div class="col-4 mt-4">
                        <div class="bg-light rounded p-4">
                            <h6 class="mb-4">AVAILABLE STUDENTS</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Id</th>
                                            <th scope="col">Student</th>
                                            <th scope="col">Assign</th>
                                        </tr>
                                    </thead>
                                    <tbody id="Table_Status">
                                        <?php
                                            // Modified query to exclude already assigned students
                                            $sql = "SELECT st.StudentID, st.NameInLatin 
                                                    FROM tblstudentinfo st 
                                                    LEFT JOIN tblstudentstatus stt ON st.StudentID = stt.StudentID
                                                    WHERE stt.StudentID IS NULL";
                                            $rs = $cn->query($sql);
                                            if ($rs->num_rows>0) {
                                                while ($row = $rs->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>{$row['StudentID']}</td>";
                                                    echo "<td>{$row['NameInLatin']}</td>";
                                                    echo '<td><input type="checkbox" name="assigned[]" value="' . $row['StudentID'] . '"></td>';
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='3'>No available students.</td></tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
        </form>

        <div class="col-8 mt-4">
            <div class="bg-light rounded p-4">
                <h6 class="mb-4">STUDENTS CURRENT PROGRAMS</h6>
                <div class="table-responsive">
                    <button type="button" id="ExportToExcel" class="btn btn-success m-3"
                        onclick="window.location.href='export_student_program.php'">Export to Excel</button>
                    <table class="table table-bordered" id="tblstatus">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Student</th>
                                <th scope="col">Program</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT 
                                    StudentStatusID,
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
                                    JOIN tblacademicyear ac ON p.AcademicYearID = ac.AcademicYearID
                                    ORDER BY stt.StudentStatusID DESC 
                                    LIMIT $recordsPerPage OFFSET $offset";
                                $rs = $cn->query($sql);
                                if ($rs->num_rows>0) {
                                    while ($row = $rs->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>{$row['StudentStatusID']}</td>";
                                        echo "<td>{$row['NameInLatin']}</td>";
                                        echo "<td>{$row['MajorEN']}<br/>{$row['ShiftEN']}/{$row['BatchEN']}/{$row['AcademicYear']}</td>";
                                        echo "<td>"; 
                                        if ($row['Assigned'] == 1) {
                                            echo "<p><a class='btn btn-success' href='Status.php?StudentStatusID=" . $row['StudentStatusID'] . "&Assigned=0'>Active</a></p> ";
                                        } else {
                                            echo "<p><a class='btn btn-danger' href='Status.php?StudentStatusID=" . $row['StudentStatusID'] . "&Assigned=1'>Disable</a></p> ";
                                        }
                                        echo "</td>";
                                        echo "<td>
                                                <a href='#' onclick='deleteStatus(" . $row['StudentStatusID'] . ")'>
                                                    <i class='bi bi-trash-fill' style='color: red; font-size: 20px;'></i>
                                                </a>
                                            </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No data found.</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                    <section class="float-end">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <?php if ($currentPage > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>"
                                        aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?php if ($i == $currentPage) echo 'active'; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                                <?php endfor; ?>
                                <?php if ($currentPage < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </section>
                </div>

            </div>

        </div>

    </div>
</div>

<?php include("Footer.php"); ?>
<?php include("Library_Javascript.php"); ?>