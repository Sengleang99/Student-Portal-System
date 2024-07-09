<?php include("Header.php") ?>
<?php 
include("Function.php") ?>

<div class="container-xxl position-relative bg-white d-flex p-0">
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Sign In Start -->
    <div class="container-fluid">
        <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                    <!-- <div class="d-flex align-items-center justify-content-between mb-3">
                        <a href="index.php" class="">
                            <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>DASHMIN</h3>
                        </a>
                        <h3>Sign In</h3>
                    </div> -->
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-floating mb-3">
                            <input type="text" name="Name_Email" class="form-control" id="floatingInput"
                                placeholder="Username or Email">
                            <label for="floatingInput">Username or Email</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" name="Password" class="form-control" id="floatingPassword"
                                placeholder="Password">
                            <label for="floatingPassword">Password</label>
                        </div>

                        <button type="submit" name="SignIn" class="btn btn-primary py-3 w-100 mb-4">Sign In</button>
                        <p class="text-center mb-0">Don't have an Account? <a href="signup.php">Sign Up</a></p>
                    </form>


                </div>
            </div>
        </div>
    </div>
    <!-- Sign In End -->
</div>