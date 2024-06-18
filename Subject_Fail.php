<?php include("Function.php"); ?>
<?php include("Header.php"); ?>


<script>
$(function() {
    $('#Program').change(function() {
        var ProgramID = $(this).val();
        alert(ProgramID)
        if (ProgramID) {
            $.ajax({
                type: 'POST',
                url: 'FetchData.php',
                data: {
                    id: ProgramID
                },
                success: function(data) {
                    if (data.success) {
                        $('#Table_Status').html(data.students); // Populate students table
                        $('#Lecturer_Status').html(data.lecturers);
                    } else {
                        $('#Table_Status').html(
                            '<tr><td colspan="3">No students found</td></tr>');
                        $('#Lecturer_Status').html(
                            '<tr><td colspan="3">No lecturers found</td></tr>');
                    }
                },

            });
        }
    });
});
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

        <form action="Subject_Fail.php" method="POST" enctype="multipart/form-data">
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="bg-light rounded h-100 p-4">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <select id="Program" name="Program" class="form-select">
                                        <option value="">Select Program</option>
                                        <?php
                                            $sql = "SELECT 
                                            tblprogram.ProgramID, 
                                            tblmajor.MajorEN, 
                                            tblsemester.SemesterEN, 
                                            tblyear.YearEN,
                                            tblshift.ShiftEN,
                                            tblbatch.BatchEN,
                                            tblcampus.CampusEN
                                                    FROM tblprogram 
                                                    INNER JOIN tblmajor ON tblprogram.MajorID = tblmajor.MajorID 
                                                    INNER JOIN tblcampus ON tblprogram.CampusID = tblcampus.CampusID 
                                                    INNER JOIN tblshift ON tblprogram.ShiftID = tblshift.ShiftID 
                                                    INNER JOIN tblbatch ON tblprogram.BatchID = tblbatch.BatchID 
                                                    INNER JOIN tblsemester ON tblprogram.SemesterID = tblsemester.SemesterID 
                                                    INNER JOIN tblyear ON tblprogram.YearID = tblyear.YearID";
                                            $rs = $cn->query($sql);
                                            while ($row = $rs->fetch_assoc()) {
                                                echo '<option value="' . $row['ProgramID'] . '">' . $row['MajorEN'] . '/' . $row['YearEN'] . '/' . $row['SemesterEN'] . '/' . $row['ShiftEN'] . '/' . $row['BatchEN'] . '/' . $row['CampusEN'] . '</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" name="save" class="btn btn-primary mt-2">Save</button>
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
                                <table class="table" id="tbllecturerstatus">
                                    <thead>
                                        <tr>
                                            <th scope="col">Id</th>
                                            <th scope="col">Lecturer</th>
                                            <th scope="col">Assign</th>
                                        </tr>
                                    </thead>
                                    <tbody id="Lecturer_Status">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
    </div>
    <?php include("Footer.php"); ?>
    <?php include("Library_Javascript.php"); ?>
</div>