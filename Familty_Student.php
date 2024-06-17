<?php include("Function.php") ?>
<?php include ('Header.php') ?>

<script>
$(document).ready(function() {
    $('#tblfamily').on('click', '#UpdateFamily', function() {
        $('#Edit_Family').show();
        $('#Add_Family').hide();
        $('#familyModal').modal('show');

        var current_row = $(this).closest('tr');
        var id = current_row.find('td').eq(0).text();
        var Student = current_row.find('td').eq(1).data('student-id');
        var DadName = current_row.find('td').eq(2).text();
        var DadAge = current_row.find('td').eq(3).text();
        var NationalityDad = current_row.find('td').eq(4).data('nationalitydad-id');
        var CountryDad = current_row.find('td').eq(5).data('countrydad-id');
        var FatherOccupationID = current_row.find('td').eq(6).text();
        var MomName = current_row.find('td').eq(7).text();
        var MomAge = current_row.find('td').eq(8).text();
        var NationalMom = current_row.find('td').eq(9).data('nationalmom-id');
        var CountryMom = current_row.find('td').eq(10).data('countrymom-id');
        var MotherOccupationID = current_row.find('td').eq(11).text();
        var FamilyCurrentAddress = current_row.find('td').eq(12).text();
        var SpouseName = current_row.find('td').eq(13).text();
        var SpouseAge = current_row.find('td').eq(14).text();
        var GuardianPhoneNumber = current_row.find('td').eq(15).text();

        $('#id').val(id);
        $('#DadName').val(DadName);
        $('#DadAge').val(DadAge);
        $('#CountryDad').val(CountryDad);
        $('#NationalityDad').val(NationalityDad);
        $('#MomName').val(MomName);
        $('#MomAge').val(MomAge);
        $('#CountryMom').val(CountryMom);
        $('#NationalMom').val(NationalMom);
        $('#FatherOccupationID').val(FatherOccupationID);
        $('#MotherOccupationID').val(MotherOccupationID);
        $('#FamilyCurrentAddress').val(FamilyCurrentAddress);
        $('#SpouseName').val(SpouseName);
        $('#SpouseAge').val(SpouseAge);
        $('#GuardianPhoneNumber').val(GuardianPhoneNumber);
        $('#Student').val(Student);
    });

    $('#Create_Family').click(function() {
        $('#Edit_Family').hide();
        $('#Add_Family').show();
        $('#familyModal').modal('show');

        $('#id').val('');
        $('#DadName').val('');
        $('#DadAge').val('');
        $('#CountryDad').val('');
        $('#NationalityDad').val('');
        $('#MomName').val('');
        $('#MomAge').val('');
        $('#CountryMom').val('');
        $('#NationalMom').val('');
        $('#FatherOccupationID').val('');
        $('#MotherOccupationID').val('');
        $('#FamilyCurrentAddress').val('');
        $('#SpouseName').val('');
        $('#SpouseAge').val('');
        $('#GuardianPhoneNumber').val('');
        $('#Student').val('');
    });

    $('#Searching').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#Table_Family tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});

function deleteFamily(id) {
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
            window.location.href = 'Familty_Student.php.php?Remove_Family=' + id;
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
                        <h6 class="mb-4">Information Familty Background</h6>
                        <div class="m-n2">
                            <button type="button" id="Create_Family" class="btn btn-primary m-3" data-bs-toggle="modal"
                                data-bs-target="#familyModal">Create New</button>
                        </div>
                        <div class="modal fade" id="familyModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Form Create Student Status</h5>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-12">
                                                    <input hidden name="id" id="id" class="form-control mb-3"
                                                        type="number">
                                                </div>
                                                <div class="col-3">
                                                    <label for="">Father name</label>
                                                    <input name="DadName" id="DadName" class="form-control mb-3"
                                                        type="text">
                                                </div>
                                                <div class="col-3">
                                                    <label for="">Age</label>
                                                    <input name="DadAge" id="DadAge" class="form-control mb-3"
                                                        type="text">
                                                </div>
                                                <div class="col-3">
                                                    <label for="">Country</label>
                                                    <select id="CountryDad" name="CountryDad" class="form-select mb-3"
                                                        aria-label="Default select example">

                                                        <?php 
                                                            $sql = "SELECT * FROM `tblcountry`";
                                                            $rs = $cn->query($sql);
                                                        while($row = $rs->fetch_assoc()){
                                                            ?>
                                                        <option value="<?php echo $row['CountryID'] ?>">
                                                            <?php echo $row['CountryEN'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-3">
                                                    <label for="">National</label>
                                                    <select id="NationalityDad" name="NationalityDad"
                                                        class="form-select mb-3" aria-label="Default select example">
                                                        <?php 
                                                            $sql = "SELECT * FROM `tblnationality`";
                                                            $rs = $cn->query($sql);
                                                        while($row = $rs->fetch_assoc()){
                                                            ?>
                                                        <option value="<?php echo $row['NationalityID'] ?>">
                                                            <?php echo $row['NationalityEN'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-3">
                                                    <label for="">Mother name</label>
                                                    <input name="MomName" id="MomName" class="form-control mb-3"
                                                        type="text">
                                                </div>
                                                <div class="col-3">
                                                    <label for="">Age</label>
                                                    <input name="MomAge" id="DadAge" class="form-control mb-3"
                                                        type="text">
                                                </div>
                                                <div class="col-3">
                                                    <label for="">Country</label>
                                                    <select id="CountryMom" name="CountryMom" class="form-select mb-3"
                                                        aria-label="Default select example">
                                                        <?php 
                                                            $sql = "SELECT * FROM `tblcountry`";
                                                            $rs = $cn->query($sql);
                                                        while($row = $rs->fetch_assoc()){
                                                            ?>
                                                        <option value="<?php echo $row['CountryID'] ?>">
                                                            <?php echo $row['CountryEN'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-3">
                                                    <label for="">National</label>
                                                    <select id="NationalMom" name="NationalMom" class="form-select mb-3"
                                                        aria-label="Default select example">
                                                        <?php 
                                                            $sql = "SELECT * FROM `tblnationality`";
                                                            $rs = $cn->query($sql);
                                                        while($row = $rs->fetch_assoc()){
                                                            ?>
                                                        <option value="<?php echo $row['NationalityID'] ?>">
                                                            <?php echo $row['NationalityEN'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-3">
                                                    <label for="">FatherOccupationID</label>
                                                    <input name="FatherOccupationID" id="FatherOccupationID"
                                                        class="form-control mb-3" type="text">
                                                </div>
                                                <div class="col-3">
                                                    <label for="">MotherOccupationID</label>
                                                    <input name="MotherOccupationID" id="MotherOccupationID"
                                                        class="form-control mb-3" type="text">
                                                </div>
                                                <div class="col-3">
                                                    <label for="">FamilyCurrentAddress</label>
                                                    <input name="FamilyCurrentAddress" id="FamilyCurrentAddress"
                                                        class="form-control mb-3" type="text">
                                                </div>
                                                <div class="col-3">
                                                    <label for="">SpouseName</label>
                                                    <input name="SpouseName" id="SpouseName" class="form-control mb-3"
                                                        type="text">
                                                </div>
                                                <div class="col-3">
                                                    <label for="">SpouseAge</label>
                                                    <input name="SpouseAge" id="SpouseAge" class="form-control mb-3"
                                                        type="number">
                                                </div>
                                                <div class="col-3">
                                                    <label for="">GuardianPhoneNumber</label>
                                                    <input name="GuardianPhoneNumber" id="GuardianPhoneNumber"
                                                        class="form-control mb-3" type="number">
                                                </div>
                                                <div class="col-3">
                                                    <label for="">Student</label>
                                                    <select id="Student" name="Student" class="form-select mb-3"
                                                        aria-label="Default select example">
                                                        <option value="">Select student</option>
                                                        <?php 
                                                            $sql = "SELECT * FROM `tblstudentinfo`";
                                                            $rs = $cn->query($sql);
                                                        while($row = $rs->fetch_assoc()){
                                                            ?>
                                                        <option value="<?php echo $row['StudentID'] ?>">
                                                            <?php echo $row['NameInLatin'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" id="Add_Family" name="Add_Family"
                                                    class="btn btn-primary">Save</button>
                                                <button type="submit" id="Edit_Family" name="Edit_Family"
                                                    class="btn btn-primary">Save
                                                    Change</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Large Modal-->
                        <div class="table-responsive">
                            <table class="table" id="tblfamily">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Student</th>
                                        <th scope="col">Father</th>
                                        <th scope="col">Mother</th>
                                        <th scope="col">Adress</th>
                                        <th scope="col">Mobile</th>
                                        <th scope="col">Active</th>
                                    </tr>
                                </thead>
                                <tbody id="Table_Family">
                                    <?php GetView_Family() ?>
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

            <!-- Footer Start -->
            <?php include("Footer.php") ?>
            <!-- Footer End -->
        </div>
    </div>
    <!-- Content End -->
    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>
<?php include("Library_Javascript.php") ?>