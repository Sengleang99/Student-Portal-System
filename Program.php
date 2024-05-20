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
                        <h6 class="mb-4">Program Study</h6>
                        <div class="m-n2">
                            <button type="button" class="btn btn-primary m-3" data-bs-toggle="modal"
                                data-bs-target="#programModal">Create New</button>
                        </div>
                        <div class="modal fade" id="programModal" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Form Create Program</h5>
                                        <div class="modal-footer">
                                            <button type="submit" name="btn-save" class="btn btn-primary">Save</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>

                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-4">
                                                    <select name="Year" class="form-select mb-3"
                                                        aria-label="Default select example">
                                                        <option selected>Year</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <select name="Semester" class="form-select mb-3"
                                                        aria-label="Default select example">
                                                        <option selected>Semester</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <select name="Shift" class="form-select mb-3"
                                                        aria-label="Default select example">
                                                        <option selected>Shift</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <select name="Degrees" class="form-select mb-3"
                                                        aria-label="Default select example">
                                                        <option selected>Degrees</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <select name="AcademicYear" class="form-select mb-3"
                                                        aria-label="Default select example">
                                                        <option selected>AcademicYear</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <select name="Major" class="form-select mb-3"
                                                        aria-label="Default select example">
                                                        <option selected>Major</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                                <div class="col-6">
                                                    <select name="Batch" class="form-select mb-3"
                                                        aria-label="Default select example">
                                                        <option selected>Batch</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                                <div class="col-6">
                                                    <select name="Campus" class="form-select mb-3"
                                                        aria-label="Default select example">
                                                        <option selected>Campus</option>
                                                        <option value="1">BELTEI International University(Toul Slaeng)
                                                        </option>
                                                        <option value="2">BELTEI International University(Chom Chav)
                                                        </option>

                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <label for="">Start Date</label>
                                                    <input name="StartDate" class="form-control mb-3" type="date">
                                                </div>
                                                <div class="col-4">
                                                    <label for="">End Start</label>
                                                    <input name="EndStart" class="form-control mb-3" type="date">
                                                </div>
                                                <div class="col-4">
                                                    <label for="">Date Issue</label>
                                                    <input name="DateIssue" class="form-control mb-3" type="date">
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div><!-- End Large Modal-->
                        <div class="table-responsive">
                            <table class="table table-bordered">
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
                                        <th scope="col">Start-Date</th>
                                        <th scope="col">End-Date</th>
                                        <th scope="col">Date-Issue</th>
                                        <th scope="col">Active</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>First Year</td>
                                        <td>Semester 1</td>
                                        <td> Moring</td>
                                        <td>Associate Degrees</td>
                                        <td>2024-2025</td>
                                        <td>Software Engineering</td>
                                        <td>Batch 1</td>
                                        <td>BIU1</td>
                                        <td>09-09-2020</td>
                                        <td>09-09-2021</td>
                                        <td>09-09-2024</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn" type="button" id="dropdownMenuButton"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-eye-fill"></i>
                                                            View</a></li>
                                                    <li><a class="dropdown-item" href="#"><i
                                                                class="bi bi-pencil-fill"></i> Update</a></li>
                                                    <li><a class="dropdown-item" href="#"><i
                                                                class="bi bi-trash-fill"></i> Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

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