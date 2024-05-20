<?php include("Header.php") ?>
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="index.php" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>DASHMIN</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                <div
                    class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
                </div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">Jhon Doe</h6>
                <span>Admin</span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="index.php" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
            <a href="Studentinfor.php" class="nav-item nav-link"> <i class="fas fa-user-graduate me-2"></i> Students</a>
            <a href="Subject.php" class="nav-item nav-link"><i class="bi bi-book me-2"></i>Subject</a>
            <a href="Program.php" class="nav-item nav-link">
                <i class="bi bi-file-text me-2"></i>Program
            </a>

            <!-- <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                        class="fa fa-laptop me-2"></i>Program</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <ul class="sidebar-nav">
                        <li class="nav-item">
                            <a href="Subject.php" class="dropdown-item">Subject</a>
                        </li>
                        <li class="nav-item">
                            <a href="Student_Status.php" class="dropdown-item">Student Status</a>
                        </li>
                        <li class="nav-item">
                            <a href="Program.php" class="dropdown-item">Program</a>
                        </li>
                    </ul>
                </div>
            </div> -->

            <a href="#" name="SignOut" type="submit" class="nav-item nav-link"><i
                    class="bi bi-box-arrow-in-left"></i>SignOut</a>
        </div>
    </nav>
</div>