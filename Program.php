<?php include("Function.php") ?>
<?php include("Header.php") ?>
<script>
$(document).ready(function() {
    $('#tblprogram').on('click', '#EditProgram', function() {
        $('#Edit_Program').show();
        $('#Add_Program').hide();
        $('#programModal').modal('show');
        var current_row = $(this).closest('tr');
        var ProgramID = current_row.find('td').eq(0).text();
        var Year = current_row.find('td').eq(1).data('year-id');
        var Semester = current_row.find('td').eq(2).data('semester-id');
        var Shift = current_row.find('td').eq(3).data('shift-id');
        var Degrees = current_row.find('td').eq(4).data('degree-id');
        var AcademicYear = current_row.find('td').eq(5).data('academicyear-id');
        var Major = current_row.find('td').eq(6).data('major-id');
        var Batch = current_row.find('td').eq(7).data('batch-id');
        var Campus = current_row.find('td').eq(8).data('campus-id');
        var StartDate = current_row.find('td').eq(9).text();
        var EndDate = current_row.find('td').eq(10).text();
        var DateIssue = current_row.find('td').eq(11).text();
        $('#ProgramID').val(ProgramID);
        $('#Year').val(Year);
        $('#Semester').val(Semester);
        $('#Shift').val(Shift);
        $('#Semester').val(Semester);
        $('#Degrees').val(Degrees);
        $('#AcademicYear').val(AcademicYear);
        $('#Major').val(Major);
        $('#Batch').val(Batch);
        $('#Campus').val(Campus);
        $('#StartDate').val(StartDate);
        $('#EndDate').val(EndDate);
        $('#DateIssue').val(DateIssue);
    });
    $('#Create_Program').click(function() {
        $('#Edit_Program').hide();
        $('#Add_Program').show();
        $('#ProgramID').val('');
        $('#Year').val('');
        $('#Semester').val('');
        $('#Shift').val('');
        $('#Semester').val('');
        $('#Degrees').val('');
        $('#AcademicYear').val('');
        $('#Major').val('');
        $('#Batch').val('');
        $('#Campus').val('');
        $('#StartDate').val('');
        $('#EndDate').val('');
        $('#DateIssue').val('');
    });
    $('#Searching').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#Table_Program tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});

function deleteProgram(id) {
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
            window.location.href = 'Program.php?Remove_Program=' + id;
        }
    });
}
</script>
<div class="container-xxl position-relative bg-white d-flex p-0">
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- --- sidebar ------ -->
    <?php include("Sidebar.php") ?>
    <!-- Content Start -->
    <div class="content">
        <!-- Navbar Start -->
        <?php include("Navbar.php") ?>
        <!-- Navbar End -->


        <!-- Blank Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-12">
                    <div class="bg-light rounded h-100 p-4">
                        <h6 class="mb-4">PROGRAM INFORMATION LISTS</h6>
                        <div class="m-n2">
                            <button type="button" id="Create_Program" class="btn btn-primary m-3" data-bs-toggle="modal"
                                data-bs-target="#programModal">Create New</button>
                        </div>
                        <div class="modal fade" id="programModal" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <form method="POST" enctype="multipart/form-data">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Form Create Program</h5>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">

                                                    <input name="ProgramID" hidden id="ProgramID"
                                                        class="form-control mb-3" type="number">
                                                </div>
                                                <div class="col-4">
                                                    <select id="Year" name="Year" class="form-select mb-3"
                                                        aria-label="Default select example">
                                                        <option value="">Select Year</option>
                                                        <?php 
                                                            $sql = "SELECT * FROM `tblyear`";
                                                            $rs = $cn->query($sql);
                                                        while($row = $rs->fetch_assoc()){
                                                            ?>
                                                        <option value="<?php echo $row['YearID'] ?>">
                                                            <?php echo $row['YearEN'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <select id="Semester" name="Semester" class="form-select mb-3"
                                                        aria-label="Default select example">
                                                        <option value="">Select Semester</option>
                                                        <?php 
                                                            $sql = "SELECT * FROM `tblsemester`";
                                                            $rs = $cn->query($sql);
                                                        while($row = $rs->fetch_assoc()){
                                                            ?>
                                                        <option value="<?php echo $row['SemesterID'] ?>">
                                                            <?php echo $row['SemesterEN'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <select name="Shift" id="Shift" class="form-select mb-3"
                                                        aria-label="Default select example">
                                                        <option value="">Select Shift</option>
                                                        <?php 
                                                            $sql = "SELECT * FROM `tblshift`";
                                                            $rs = $cn->query($sql);
                                                        while($row = $rs->fetch_assoc()){
                                                            ?>
                                                        <option value="<?php echo $row['ShiftID'] ?>">
                                                            <?php echo $row['ShiftEN'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <select name="Degrees" id="Degrees" class="form-select mb-3"
                                                        aria-label="Default select example">
                                                        <option value="">Select Degrees</option>
                                                        <?php 
                                                            $sql = "SELECT * FROM `tbldegree`";
                                                            $rs = $cn->query($sql);
                                                        while($row = $rs->fetch_assoc()){
                                                            ?>
                                                        <option value="<?php echo $row['DegreeID'] ?>">
                                                            <?php echo $row['DegreeNameEN'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <select name="AcademicYear" id="AcademicYear"
                                                        class="form-select mb-3" aria-label="Default select example">
                                                        <option value="">Select AcademicYear</option>
                                                        <?php 
                                                            $sql = "SELECT * FROM `tblacademicyear`";
                                                            $rs = $cn->query($sql);
                                                        while($row = $rs->fetch_assoc()){
                                                            ?>
                                                        <option value="<?php echo $row['AcademicYearID'] ?>">
                                                            <?php echo $row['AcademicYear'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <select id="Major" name="Major" class="form-select mb-3"
                                                        aria-label="Default select example">
                                                        <option value="">Select Major</option>
                                                        <?php 
                                                            $sql = "SELECT * FROM `tblmajor`";
                                                            $rs = $cn->query($sql);
                                                        while($row = $rs->fetch_assoc()){
                                                            ?>
                                                        <option value="<?php echo $row['MajorID'] ?>">
                                                            <?php echo $row['MajorEN'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-6">
                                                    <select name="Batch" id="Batch" class="form-select mb-3"
                                                        aria-label="Default select example">
                                                        <option value="">Select Batch</option>
                                                        <?php 
                                                            $sql = "SELECT * FROM `tblbatch`";
                                                            $rs = $cn->query($sql);
                                                        while($row = $rs->fetch_assoc()){
                                                            ?>
                                                        <option value="<?php echo $row['BatchID'] ?>">
                                                            <?php echo $row['BatchEN'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-6">
                                                    <select name="Campus" id="Campus" class="form-select mb-3"
                                                        aria-label="Default select example">
                                                        <option value="">Select Campus</option>
                                                        <?php 
                                                            $sql = "SELECT * FROM `tblcampus`";
                                                            $rs = $cn->query($sql);
                                                        while($row = $rs->fetch_assoc()){
                                                            ?>
                                                        <option value="<?php echo $row['CampusID'] ?>">
                                                            <?php echo $row['CampusEN'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <label for="">Start Date</label>
                                                    <input name="StartDate" id="StartDate" class="form-control mb-3"
                                                        type="date">
                                                </div>
                                                <div class="col-4">
                                                    <label for="">End Start</label>
                                                    <input name="EndStart" id="EndDate" class="form-control mb-3"
                                                        type="date">
                                                </div>
                                                <div class="col-4">
                                                    <label for="">Date Issue</label>
                                                    <input name="DateIssue" id="DateIssue" class="form-control mb-3"
                                                        type="date">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" id="Add_Program" name="Add_Program"
                                                    class="btn btn-primary">Save</button>
                                                <button type="submit" id="Edit_Program" name="Edit_Program"
                                                    class="btn btn-primary">Save
                                                    Change</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Large Modal-->
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tblprogram">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Year</th>
                                        <th scope="col">Semester</th>
                                        <th scope="col">Shift</th>
                                        <th scope="col">Degrees</th>
                                        <th scope="col">Academic</th>
                                        <th scope="col">Major</th>
                                        <th scope="col">Batch</th>
                                        <th scope="col">Campus</th>
                                        <!-- <th scope="col">Start-Date</th>
                                        <th scope="col">End-Date</th>
                                        <th scope="col">Date-Issue</th> -->
                                        <th scope="col">Active</th>
                                    </tr>
                                </thead>
                                <tbody id="Table_Program">
                                    <?php getView_Program(); ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- ---------- pagination ------------------ -->
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
        <!-- Blank End -->
        <!-- Footer Start -->
        <?php include("Footer.php") ?>
        <!-- Footer End -->
    </div>
    <!-- Content End -->


    <!-- Back to Top -->
    <a href="index.php" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>

<?php include("Library_Javascript.php") ?>