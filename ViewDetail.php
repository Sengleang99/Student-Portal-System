<?php include('Function.php') ?>
<?php include("Header.php") ?>
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
            <div class="row vh-100 bg-light rounded justify-content-center mx-3">
                <div class="col-12 text-center">
                    <div class="col-12">
                        <nav aria-label="breadcrumb"
                            class="justify-content-center bg-white rounded-3 p-3 mb-4 mt-3 mx-4">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="Studentinfor.php">Student</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Student Profile</li>
                            </ol>
                        </nav>
                    </div>
                    <?php 
                        $Get_Detail = $_GET['Get_Detail'];
                        $sql = "SELECT 
                        tblstudentinfo.StudentID, 
                        tblstudentinfo.NameInLatin,
                        tblstudentinfo.NameInKhmer,
                        tblstudentinfo.Email, 
                        tblstudentinfo.PhoneNumber, 
                        tblstudentinfo.DOB, 
                        tblstudentinfo.CurrentAddress, 
                        tblstudentinfo.CurrentAddressPP, 
                        tblsex.SexEN, tblcountry.CountryEN, 
                        tblnationality.NationalityEN,
                        tblsex.SexID,tblstudentinfo.RegisterDate,
                        tblstudentinfo.Photo,
                        tblcountry.CountryID,
                        tblnationality.NationalityID,
                        tblstudentinfo.POB
                        FROM tblstudentinfo
                        INNER JOIN tblsex ON tblstudentinfo.SexID = tblsex.SexID
                        INNER JOIN tblcountry ON tblstudentinfo.CountryID = tblcountry.CountryID
                        INNER JOIN tblnationality ON tblstudentinfo.NationalityID = tblnationality.NationalityID
                        WHERE StudentID = $Get_Detail";
                         $rs = $cn->query($sql);
                         $row = mysqli_fetch_assoc($rs);
                    ?>
                    <div class="row mx-3 justify-content-center">
                        <div class="col-4 card mb-4">
                            <div class="card-body text-center">
                                <?php
                                    $photo = !empty($row['Photo']) ? 'img/' . $row['Photo'] : 'img/download.png';
                                ?>
                                <img src="<?php echo $photo; ?>" width="100%" height="230px" alt="Photo"
                                    class="rounded-circle">
                                <h5 class="my-3">
                                    <?php echo $row['NameInLatin'] ?></h5>
                                <h5 class="my-3">ID: <span><?php echo $row['StudentID'] ?></span></h5>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0" id="FullName">Full Name</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0"><?php echo $row['NameInLatin'] ?></p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Gender</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0"><?php echo $row['SexEN'] ?></p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Mobile</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0"><?php echo $row['PhoneNumber'] ?></p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Email</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0"><?php echo $row['Email'] ?></p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Address</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0"><?php echo $row['CurrentAddress'] ?></p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Nationality</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0"><?php echo $row['NationalityEN'] ?></p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Country</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0"><?php echo $row['CountryEN'] ?></p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Date of Birth</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0"><?php echo $row['DOB'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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