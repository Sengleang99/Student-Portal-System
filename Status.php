<?php include("Function.php"); ?>
<?php include("Header.php"); ?>
<?php 
     if (isset($_POST['Add_Status'])) {
        $Program = $_POST['Program'];
        $AssignDate = $_POST['AssignDate'];
        $Note = $_POST['Note'];
    
        // Check if students are selected
        if (isset($_POST['assigned']) && is_array($_POST['assigned'])) {
            $assignedStudents = $_POST['assigned'];
    
            foreach ($assignedStudents as $Student) {
                $sql = "INSERT INTO tblstudentstatus (StudentID, ProgramID, Note, AssignDate) 
                        VALUES ('$Student', '$Program', '$Note', '$AssignDate')";
                $rs = $cn->query($sql);
                
                if (!$rs) {
                    // Show error if insertion fails for any student
                    echo "<script>
                            Swal.fire('Error!', 'Failed to add student ID: $Student.', 'error');
                          </script>";
                    break; // Exit the loop on first error
                }
            }
    
            // Show success message if all insertions are successful
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
        }
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
                                <div class="col-6">
                                    <label for="AssignDate">Assign date</label>
                                    <input type="date" name="AssignDate" id="AssignDate" class="form-control">
                                </div>
                                <div class="col-6">
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
                                <table class="table">
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
                    <table class="table" id="tblstatus">
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
                                    m.MajorEN
                                    FROM tblstudentstatus stt 
                                    JOIN tblprogram p ON stt.ProgramID = p.ProgramID
                                    JOIN tblstudentinfo st ON stt.StudentID = st.StudentID
                                    JOIN tblmajor m ON p.MajorID = m.MajorID";
                                $rs = $cn->query($sql);
                                if ($rs->num_rows>0) {
                                    while ($row = $rs->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>{$row['StudentStatusID']}</td>";
                                        echo "<td>{$row['NameInLatin']} </td>";
                                        echo "<td>{$row['MajorEN']} </td>";
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
                    <section class=" float-end">
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
                        </nav><!-- End Pagination with icons -->
                    </section>
                </div>

            </div>

        </div>

    </div>
</div>

<?php include("Footer.php"); ?>
<?php include("Library_Javascript.php"); ?>