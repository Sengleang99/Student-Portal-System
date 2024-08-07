<?php include("Header.php") ?>
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="index.php" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>DASHMIN</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <!-- <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;"> -->
                <div
                    class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
                </div>
            </div>
            <div class="ms-3">
                <!-- <h6 class="mb-0">Jhon Doe</h6> -->
                <h3>Admin</h3>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="index.php" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                        class="fas fa-user-graduate me-2"></i>Student</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <ul class="sidebar-nav">
                        <li class="nav-item">
                            <a href="Studentinfor.php" class="dropdown-item">Student-Register</a>
                        </li>
                        <li class="nav-item">
                            <a href="Background_Study.php" class="dropdown-item">Student-Education</a>
                        </li>
                        <li class="nav-item">
                            <a href="Familty_Student.php" class="dropdown-item">Student-Family</a>
                        </li>
                    </ul>
                </div>
            </div>
            <a href="Subject.php" class="nav-item nav-link"><i class="bi bi-book me-2"></i>Subject</a>
            <a href="Program.php" class="nav-item nav-link">
                <i class="bi bi-file-text me-2"></i>Program
            </a>
            <a href="Status.php" class="nav-item nav-link"><i class="bi bi-journal-check me-2"></i>Student Status</a>
            <a href="Schedule.php" class="nav-item nav-link"><i class="bi bi-calendar4-week me-2"></i>Schedule</a>
            <a href="Subject_Fail.php" class="nav-item nav-link"><i class="bi bi-arrow-down-circle me-2"></i>Fall
                Subject</a>
            <form method="post" enctype="multipart/form-data">
                <button type="submit" name="logout" class="btn btn-link p-0">
                    <i class="bi bi-box-arrow-left me-2"></i>
                    Logout
                </button>
            </form>
        </div>
    </nav>
</div>
<?php include("Library_Javascript.php") ?>