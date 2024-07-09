<?php include_once "Function.php"; ?>
<?php include_once "Header.php"; ?>

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
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        $('#Table_Status').html(data.students); // Populate students table
                        $('#Lecturer_Status').html(data
                            .lecturers); // Populate lecturers table
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
    <?php include_once "Sidebar.php"; ?>
    <div class="content">
        <?php include_once "Navbar.php"; ?>
        <form action="List_Fall_Subject.php" method="POST" enctype="multipart/form-data">
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="bg-light rounded h-100 p-4">
                            <h5 class="text-center">ASSIGN STUDENT FALL SUBJECTS</h5>
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
                                                echo '<option value="' . $row['ProgramID'] . '">' . 
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
                            </div>
                            <button type="submit" name="Assign_Fall" class="btn btn-primary">Save</button>
                            <a href="List_Fall_Subject.php" class="btn btn-success">Go to list</a>
                        </div>
                    </div>
        </form>
        <!-- Lecturers Table -->
        <div class="col-6">
            <div class="bg-light rounded p-4">
                <h6 class="mb-4">LECTURERS LIST</h6>
                <div class="table-responsive">
                    <table class="table table-bordered" id="tbllecturer">
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
        <!-- Students Table -->
        <div class="col-6">
            <div class="bg-light rounded p-4">
                <h6 class="mb-4">STUDENTS LIST</h6>
                <div class="table-responsive">
                    <table class="table table-bordered" id="tblstatus">
                        <thead>
                            <tr data-student-id="<?php $row['StudentID'] ?>">
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

    </div>
</div>
<?php include_once "Footer.php"; ?>
</div>

<?php include("Library_Javascript.php") ?>