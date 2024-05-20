<?php include("Header.php") ?>
<?php include('Function.php') ?>
<script>
$(document).ready(function() {
    $('#Faculty').change(function() {
        var FacultyID = $('#Faculty').val();
        $.ajax({
            type: 'POST',
            url: 'Function.php',
            data: {
                id: FacultyID
            },
            success: function(data) {
                $('#show').html(data);
            }
        });
    });
    $('#tblsubject').on('click', '#UpdateSubject', function() {
        $('#Sub_SaveChange').show();
        $('#Subject_Insert').hide();
        $('#subjectModal').modal('show');
        var current_row = $(this).closest('tr');
        var Subject_id = current_row.find('td').eq(0).text();
        var SubjectEN = current_row.find('td').eq(1).text();
        var Faculty = current_row.find('td').eq(2).data('faculty-id');
        var Year = current_row.find('td').eq(3).data('year-id');
        var Semester = current_row.find('td').eq(4).data('semester-id');
        var Major = current_row.find('td').eq(5).data('major-id');
        var Credit = current_row.find('td').eq(6).text();
        var Hour = current_row.find('td').eq(7).text();
        $('#Subject_id').val(Subject_id);
        $('#SubjectEN').val(SubjectEN);
        $('#Faculty').val(Faculty);
        $('#Year').val(Year);
        $('#Semester').val(Semester);
        $('#show').val(Major);
        $('#Credit').val(Credit);
        $('#Hour').val(Hour);
        $.ajax({
            type: 'POST',
            url: 'Function.php',
            data: {
                id: FacultyID
            },
            success: function(data) {
                $('#show').html(data);
            }
        });
    });
    $('#Create_Subject').click(function() {
        $('#Sub_SaveChange').hide();
        $('#Subject_Insert').show();
        $('#Subject_id').val('');
        $('#SubjectKH').val('');
        $('#SubjectEN').val('');
        $('#Credit').val('');
        $('#Hour').val('');
        $('#Faculty').val('');
        $('#Semester').val('');
        $('#Year').val('');
        $('#show').val('');
    });
    $('#Searching').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#Table_Subject tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});
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

    <!-- Sidebar Start -->
    <?php include("Sidebar.php") ?>

    <div class="content">
        <!-- Navbar Start -->
        <?php include("Navbar.php") ?>
        <!-- Navbar End -->


        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-12">
                    <div class="bg-light rounded h-100 p-4">
                        <h4 class="mb-4 text-primary text-decoration-underline text-center">TABLE LIST SUBJECT</h4>
                        <div class="m-n2">
                            <button type="button" id="Create_Subject" class="btn btn-primary m-3" data-bs-toggle="modal"
                                data-bs-target="#subjectModal">Create New</button>
                        </div>
                        <div class="modal fade" id="subjectModal" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Form Create Subject</h5>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-12">
                                                    <input name="Subject_id" hidden id="Subject_id"
                                                        class="form-control mb-3" type="number"
                                                        aria-label="default input example">
                                                </div>
                                                <div class="col-6">
                                                    <label for="">Subject Khmer</label>
                                                    <input name="SubjectKH" id="SubjectKH" class="form-control mb-3"
                                                        type="text" aria-label="default input example">
                                                </div>
                                                <div class="col-6">
                                                    <label for="">Subject English</label>
                                                    <input name="SubjectEN" id="SubjectEN" class="form-control mb-3"
                                                        type="text" aria-label="default input example">
                                                </div>
                                                <div class="col-6">
                                                    <label for="">Credit</label>
                                                    <input name="Credit" id="Credit" class="form-control mb-3"
                                                        type="number" aria-label="default input example">
                                                </div>
                                                <div class="col-6">
                                                    <label for="">Hour</label>
                                                    <input name="Hour" id="Hour" class="form-control mb-3" type="number"
                                                        aria-label="default input example">
                                                </div>
                                                <div class="col-6">
                                                    <select id="Faculty" name="Faculty" class="form-select mb-3"
                                                        aria-label="Default select example">
                                                        <option value="">Select Faculty</option>
                                                        <?php 
                                                            $cn= new mysqli("localhost","root","","student_portal_management");
                                                            $sql = "SELECT * FROM `tblfaculty`";
                                                            $rs = $cn->query($sql);
                                                        while($row = $rs->fetch_assoc()){
                                                            ?>
                                                        <option value="<?php echo $row['FacultyID'] ?>">
                                                            <?php echo $row['FacultyEN'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-6">
                                                    <select id="Semester" name="Semester" class="form-select mb-3"
                                                        aria-label="Default select example">
                                                        <option value="">Select Semester</option>
                                                        <?php 
                                                            $cn= new mysqli("localhost","root","","student_portal_management");
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
                                                <div class="col-6">
                                                    <select id="Year" name="Year" class="form-select mb-3"
                                                        aria-label="Default select example">
                                                        <option value="">Select Year</option>
                                                        <?php 
                                                            $cn= new mysqli("localhost","root","","student_portal_management");
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
                                                <div class="col-6">

                                                    <select id="show" name="Major" class="form-select mb-3"
                                                        aria-label="Default select example">
                                                        <option value="">Select Major</option>
                                                        <?php 
                                                            $cn= new mysqli("localhost","root","","student_portal_management");
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
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" id="Subject_Insert" name="Subject_Insert"
                                                    class="btn btn-primary">Save</button>
                                                <button type="submit" id="Sub_SaveChange" name="Subject_Update"
                                                    class="btn btn-primary">Save Change</button>
                                                <button type="button" id="btn-close" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div><!-- End Large Modal-->
                        <div class="table-responsive">
                            <table class="table" id="tblsubject">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Subject</th>
                                        <th scope="col">Faculty</th>
                                        <th scope="col">Year</th>
                                        <th scope="col">Semester</th>
                                        <th scope="col">Major</th>
                                        <th scope="col">Credit</th>
                                        <th scope="col">Hour</th>
                                        <th scope="col">Active</th>
                                    </tr>
                                </thead>
                                <tbody id="Table_Subject">
                                    <?php GetView_Subject(); ?>
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
        <!-- Footer Start -->
        <?php include("Footer.php") ?>
        <!-- Footer End -->
    </div>
    <!-- Content End -->
    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>
<?php include("Library_Javascript.php") ?>