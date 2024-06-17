<?php include("Function.php") ?>
<?php include ('Header.php') ?>
<script>
$(document).ready(function() {
    $('#tblBackground').on('click', '#UpdateBackground', function() {
        $('#Edit_Background').show();
        $('#Add_Background').hide();
        $('#backgroundModal').modal('show');
        var current_row = $(this).closest('tr');
        var BackgroundID = current_row.find('td').eq(0).text();
        var Student = current_row.find('td').eq(1).data('student-id')
        var SchoolType = current_row.find('td').eq(2).data('schooltype-id');
        var Schoolname = current_row.find('td').eq(3).text();
        var AcademicYear = current_row.find('td').eq(4).text();
        var Province = current_row.find('td').eq(5).text();
        $('#BackgroundID').val(BackgroundID);
        $('#Student').val(Student);
        $('#SchoolType').val(SchoolType);
        $('#Schoolname').val(Schoolname);
        $('#AcademicYear').val(AcademicYear);
        $('#Province').val(Province);
    });
    $('#Create_Background').click(function() {
        $('#Edit_Background').hide();
        $('#Add_Background').show();
        $('#BackgroundID').val('');
        $('#Student').val('');
        $('#SchoolType').val('');
        $('#Schoolname').val('');
        $('#AcademicYear').val('');
        $('#Province').val('');
    });
    $('#Searching').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#Table_Background tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});

function deleteBackground(id) {
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
            window.location.href = 'Background_Study.php?Remove_Background=' + id;
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
                        <h6 class="mb-4">BACKGROUND EDUCATION</h6>
                        <div class="m-n2">
                            <button id="Create_Background" type="button" class="btn btn-primary m-3"
                                data-bs-toggle="modal" data-bs-target="#backgroundModal">Create New</button>
                        </div>
                        <div class="modal fade" id="backgroundModal" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Form Create Student Status</h5>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label hidden for="BackgroundID">ID</label>
                                                    <input hidden name="BackgroundID" id="BackgroundID"
                                                        class="form-control mb-3" type="number"
                                                        aria-label="default input example">
                                                </div>

                                                <div class="col-6 mb-3">
                                                    <label for="Student">Student</label>
                                                    <select id="Student" name="Student" class="form-select">
                                                        <option value="">Select Student</option>
                                                        <?php
                                                            $sql = "SELECT * FROM tblstudentinfo";
                                                            $rs = $cn->query($sql);
                                                            while ($row = $rs->fetch_assoc()) {
                                                            echo '<option value="' . $row['StudentID'] . '">' . $row['NameInLatin'] . '</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="col-6 mb-3">
                                                    <label for="SchoolType">School Type</label>
                                                    <select id="SchoolType" name="SchoolType" class="form-select">
                                                        <option value="">---Select School Type---</option>
                                                        <?php
                                                            $sql = "SELECT * FROM tblschooltype";
                                                            $rs = $cn->query($sql);
                                                            while ($row = $rs->fetch_assoc()) {
                                                            echo '<option value="' . $row['SchoolTypeID'] . '">' . $row['SchoolTypeEN'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="col-6 mb-3">
                                                    <label for="Schoolname">School Name</label>
                                                    <input name="Schoolname" id="Schoolname" class="form-control"
                                                        type="text" aria-label="default input example">
                                                </div>

                                                <div class="col-6 mb-3">
                                                    <label for="Province">Province</label>
                                                    <input name="Province" id="Province" class="form-control"
                                                        type="text" aria-label="default input example">
                                                </div>

                                                <div class="col-6 mb-3">
                                                    <label for="AcademicYear">Academic Year</label>
                                                    <input name="AcademicYear" id="AcademicYear" class="form-control"
                                                        type="text" aria-label="default input example">
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="submit" name="Add_Background"
                                                    class="btn btn-primary">Save</button>
                                                <button type="submit" id="Edit_Background" name="Edit_Background"
                                                    class="btn btn-primary">SaveChange</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div><!-- End Large Modal-->
                        <div class="table-responsive">
                            <table class="table" id="tblBackground">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Student</th>
                                        <th scope="col">SchoolType</th>
                                        <th scope="col">School</th>
                                        <th scope="col">AcademicYear</th>
                                        <th scope="col">Province</th>
                                        <th scope="col">Active</th>
                                    </tr>
                                </thead>
                                <tbody id="Table_Background">
                                    <?php GetView_Background(); ?>
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