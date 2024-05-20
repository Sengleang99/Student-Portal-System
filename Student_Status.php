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
            <div class="row g-4">
                <div class="col-12">
                    <div class="bg-light rounded h-100 p-4">
                        <h6 class="mb-4">Subject List</h6>
                        <div class="m-n2">
                            <button type="button" class="btn btn-primary m-3" data-bs-toggle="modal"
                                data-bs-target="#studentModal">Create New</button>
                        </div>
                        <div class="modal fade" id="studentModal" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Form Create Student Status</h5>
                                        <div class="modal-footer">
                                            <button type="submit" name="btn-save" class="btn btn-primary">Save</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>

                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="">AssignDate</label>
                                                    <input name="AssignDate" id="AssignDate" class="form-control mb-3"
                                                        type="date" aria-label="default input example">
                                                </div>
                                                <div class="col-12">
                                                    <label for="">Note</label>
                                                    <input name="Note" id="Note" class="form-control mb-3" type="text"
                                                        aria-label="default input example">
                                                </div>
                                                <div class="col-12">
                                                    <select id="Student" name="Student" class="form-select mb-3"
                                                        aria-label="Default select example">
                                                        <option selected>Student</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <select id="Semester" name="Semester" class="form-select mb-3"
                                                        aria-label="Default select example">
                                                        <option selected>Program</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <select id="Assign" name="Assign" class="form-select mb-3"
                                                        aria-label="Default select example">
                                                        <option selected>Assign</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>

                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div><!-- End Large Modal-->
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Student ID</th>
                                        <th scope="col">Program</th>
                                        <th scope="col">Assign</th>
                                        <th scope="col">Note</th>
                                        <th scope="col">Assign-Date</th>
                                        <th scope="col">Active</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td></td>
                                        <td>IT/Y1/S1/SE</td>
                                        <td>jhon@email.com</td>
                                        <td>USA</td>
                                        <td>123</td>
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


        <!-- Footer Start -->
        <?php include("Footer.php") ?>
        <!-- Footer End -->
    </div>
    <!-- Content End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>


<?php include("Library_Javascript.php") ?>