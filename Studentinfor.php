<?php include("Header.php") ?>

<script>
$(function() {
    $('#tblstudents').on('click', '#UpdateStudent', function() {
        $('#Save_Change').show();
        $('#Insert_Student').hide();
        var current_row = $(this).closest('tr');
        var id = current_row.find('td').eq(0).text();
        var NameKhmer = current_row.find('td').eq(1).text();
        var NameLatin = current_row.find('td').eq(2).text();
        var Gender = current_row.find('td').eq(3).data('gender-id');
        var PhoneNumber = current_row.find('td').eq(4).text();
        var Email = current_row.find('td').eq(5).text();
        var CurrentAdress = current_row.find('td').eq(6).text();
        var CurrentAdressPP = current_row.find('td').eq(7).text();
        var DOB = current_row.find('td').eq(8).text();
        var POB = current_row.find('td').eq(9).text();
        var Country = current_row.find('td').eq(10).data('country-id');
        var Nationality = current_row.find('td').eq(11).data('nationality-id');
        var RegisterDate = current_row.find('td').eq(12).text();
        var Profile = current_row.find('td:eq(13) img').attr('alt');

        $('#id').val(id);
        $('#NameKhmer').val(NameKhmer);
        $('#NameLatin').val(NameLatin);
        $('#Gender').val(Gender);
        $('#PhoneNumber').val(PhoneNumber);
        $('#Email').val(Email);
        $('#CurrentAdress').val(CurrentAdress);
        $('#CurrentAdressPP').val(CurrentAdressPP);
        $('#DOB').val(DOB);
        $('#POB').val(POB);
        $('#Country').val(Country);
        $('#Nationality').val(Nationality);
        $('#RegisterDate').val(RegisterDate);
        $('#Profile').val(Profile);
        $('#studentModal').modal('show');
        $("#btn-close").click();
    });
    $('#CreateNew').click(function() {
        $('#Save_Change').hide();
        $('#Insert_Student').show();
        $('#id').val('');
        $('#NameKhmer').val('');
        $('#NameLatin').val('');
        $('#Gender').val('');
        $('#PhoneNumber').val('');
        $('#Email').val('');
        $('#CurrentAdress').val('');
        $('#CurrentAdressPP').val('');
        $('#DOB').val('');
        $('#POB').val('');
        $('#Country').val('');
        $('#Nationality').val('');
        $('#RegisterDate').val('');
        $('#Profile').val('');
    });
    $('#Searching').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#Tble_Student tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});
</script>

<?php include("Function.php") ?>

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



        <!-- Button trigger modal -->



        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-12">
                    <div class="bg-light rounded h-100 p-4">
                        <h4 class="mb-4 text-primary text-decoration-underline text-center">TABLE STUDENTS LIST
                            INFORMATION</h4>
                        <div class="m-n2">
                            <button type="button" id="CreateNew" class="btn btn-primary m-3" data-bs-toggle="modal"
                                data-bs-target="#studentModal">Create New</button>
                        </div>
                        <div class="modal fade" id="studentModal" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-body" id="FormStudent">
                                        <form method="POST" enctype="multipart/form-data">
                                            <div class="modal-header d-flex">
                                                <h5 class="modal-title">Form Create Students</h5>
                                                <div class="modal-footer">
                                                    <button type="submit" name="Insert_Student" id="Insert_Student"
                                                        class="btn btn-primary">Save</button>
                                                    <button type="submit" name="Save_Change" id="Save_Change"
                                                        class="btn btn-primary">Save Change</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <input name="id" hidden id="id" class="form-control mb-3"
                                                        type="text" aria-label="default input example">
                                                </div>
                                                <div class="col-4">
                                                    <label for="">Name Khmer</label>
                                                    <input name="NameKhmer" id="NameKhmer" class="form-control mb-3"
                                                        type="text" aria-label="default input example">
                                                </div>
                                                <div class="col-4">
                                                    <label for="">Name Latin</label>
                                                    <input name="NameLatin" id="NameLatin" class="form-control mb-3"
                                                        type="text" aria-label="default input example">
                                                </div>
                                                <div class="col-4">
                                                    <label for="">Famaly Name</label>
                                                    <input name="FamalyName" id="FamalyName" class="form-control mb-3"
                                                        type="text" aria-label="default input example">
                                                </div>
                                                <div class="col-4">
                                                    <label for="">GivenName</label>
                                                    <input name="GivenName" id="GivenName" class="form-control mb-3"
                                                        type="text" aria-label="default input example">
                                                </div>
                                                <div class="col-4">
                                                    <label for="">ID Passport No</label>
                                                    <input name="Passport" class="form-control mb-3" type="text"
                                                        aria-label="default input example">
                                                </div>
                                                <div class="col-4">
                                                    <label for="">Phone number</label>
                                                    <input name="PhoneNumber" id="PhoneNumber" class="form-control mb-3"
                                                        type="number" aria-label="default input example">
                                                </div>
                                                <div class="col-4">
                                                    <label for="">Email</label>
                                                    <input name="Email" id="Email" class="form-control mb-3"
                                                        type="email" aria-label="default input example">
                                                </div>
                                                <div class="col-4">
                                                    <label for="">Current Address</label>
                                                    <input name="CurrentAdress" id="CurrentAdress"
                                                        class="form-control mb-3" type="text"
                                                        aria-label="default input example">
                                                </div>
                                                <div class="col-4">
                                                    <label for="">Current Address Phnom Penh</label>
                                                    <input name="CurrentAdressPP" id="CurrentAdressPP"
                                                        class="form-control mb-3" type="text"
                                                        aria-label="default input example">
                                                </div>
                                                <div class="col-4">
                                                    <select name="Gender" id="Gender" class="form-select mb-3"
                                                        aria-label="Default select example">
                                                        <option value="">Gender</option>
                                                        <?php 
                                                            $cn= new mysqli("localhost","root","","student_portal_management");
                                                            $sql = "SELECT * FROM `tblsex`";
                                                            $rs = $cn->query($sql);
                                                        while($row = $rs->fetch_assoc()){
                                                            ?>
                                                        <option value="<?php echo $row['SexID'] ?>">
                                                            <?php echo $row['SexEN'] ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <select id="Country" name="Country" class="form-select mb-3"
                                                        aria-label="Default select example">
                                                        <option value="">Country</option>
                                                        <?php 
                                                            $cn= new mysqli("localhost","root","","student_portal_management");
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
                                                <div class="col-4">
                                                    <select id="Nationality" name="Nationality" class="form-select mb-3"
                                                        aria-label="Default select example">
                                                        <option value="">Country</option>
                                                        <?php 
                                                            $cn= new mysqli("localhost","root","","student_portal_management");
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
                                                    <label for="">Date of Birth</label>
                                                    <input id="DOB" name="DOB" class="form-control mb-3" type="date">
                                                </div>
                                                <div class="col-3">
                                                    <label for="">POB</label>
                                                    <input id="POB" name="POB" class="form-control mb-3" type="date">
                                                </div>
                                                <div class="col-3">
                                                    <label for="">Date Register</label>
                                                    <input name="RegisterDate" id="RegisterDate"
                                                        class="form-control mb-3" type="date">
                                                </div>
                                                <div class="col-3">
                                                    <label for="formFile" class="form-label">Image
                                                    </label>
                                                    <input name="Profile" class="form-control" type="file" id="Profile">
                                                </div>

                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div><!-- End Large Modal-->
                        <div class="table-responsive">
                            <table class="table" id="tblstudents">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th hidden scope="col">NameKhmer</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Gender</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Address</th>
                                        <th scope="col" hidden>CurrentPP</th>
                                        <th scope="col" hidden>DOB</th>
                                        <th scope="col" hidden>POB</th>
                                        <th scope="col" hidden>Nationality</th>
                                        <th scope="col" hidden>Country</th>
                                        <th scope="col" hidden>RegisterDate</th>
                                        <th scope="col" hidden>Photo</th>
                                        <th scope="col">Active</th>
                                    </tr>
                                </thead>
                                <tbody id="Tble_Student">
                                    <?php Getview_Student() ?>
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