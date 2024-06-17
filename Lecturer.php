<?php include('Function.php'); ?>
<?php include("Header.php"); ?>
<script>
$(document).ready(function() {
    $('#tbllecturer').on('click', '#EditLecturer', function() {
        $('#Edit_Lecturer').show();
        $('#Add_Lecture').hide();
        $('#staticBackdrop').modal('show');
        var current_row = $(this).closest('tr');
        var id = current_row.find('td').eq(0).text();
        var Lecturer = current_row.find('td').eq(1).text();
        $('#id').val(id);
        $('#Lecturer').val(Lecturer);
    });
    $('#Create_Lecturer').click(function() {
        $('#Edit_Lecturer').hide();
        $('#Add_Lecturer').show();
        $('#id').val('');
        $('#Lecturer').val('');
    });
    $('#Searching').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#Table_Lecturer tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});

function deleteLecturer(id) {
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
            window.location.href = 'Lecturer.php?Remove_Lecturer=' + id;
        }
    })
}
</script>
<?php
    if(isset($_POST['Add_Lecturer'])){
        $Lecturer = $_POST['Lecturer'];
        $sql = "INSERT INTO `tbllecturer`(`LecturerName`) VALUES ('$Lecturer')";
        $rs = $cn->query($sql);
        if($rs){
            echo "<script>
                    Swal.fire('Successful!', 'Lecturer added successfully!', 'success').then(() => {
                        refreshPage();
                    });
                  </script>";  
        } else {
            echo "<script>
                    Swal.fire('Error!', 'Failed to add lecturer.', 'error');
                  </script>";
        }
        
    }

    if(isset($_POST['Edit_Lecturer'])){
        $id = $_POST['id'];
        $Lecturer = $_POST['Lecturer'];
        $sql = "UPDATE `tbllecturer` SET `LecturerName`='$Lecturer' WHERE LecturerID = $id";
        $rs = $cn->query($sql);
        if($rs){
            echo "<script>
                    Swal.fire('Successful!', 'Lecturer edited successfully!', 'success').then(() => {
                        refreshPage();
                    });
                  </script>";  
        } else {
            echo "<script>
                    Swal.fire('Error!', 'Failed to edit lecturer.', 'error');
                  </script>";
        }
    }

    if(isset($_GET['Remove_Lecturer'])){
        $id = $_GET['Remove_Lecturer'];
        $sql ="DELETE FROM `tbllecturer` WHERE LecturerID=$id";
        $rs = $cn->query($sql);
        if($rs){
            echo "<script>
                    Swal.fire('Successful!', 'Lecturer deleted successfully!', 'success').then(() => {
                        refreshPage();
                    });
                  </script>";
        } else {
            echo "<script>
                    Swal.fire('Error!', 'Failed to delete lecturer.', 'error');
                  </script>";
        }
    }
?>

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
    <?php include("Sidebar.php"); ?>

    <div class="content">
        <!-- Navbar Start -->
        <?php include("Navbar.php"); ?>
        <!-- Navbar End -->

        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-12">
                    <div class="bg-light rounded h-100 p-4">
                        <h6 class="mb-4">LECTURER LISTS</h6>

                        <!-- Button trigger modal -->
                        <button type="button" id="Create_Lecturer" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
                            Create New
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Lecturer</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-12">
                                                    <input hidden class="form-control" name="id" id="id" type="number">
                                                </div>
                                                <div class="col-12">
                                                    <label for="Lecturer">Name</label>
                                                    <input class="form-control" name="Lecturer" id="Lecturer"
                                                        type="text" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" name="Add_Lecturer" class="btn btn-primary"
                                                    id="Add_Lecturer">Save</button>
                                                <button type="submit" id="Edit_Lecturer" name="Edit_Lecturer"
                                                    class="btn btn-primary">Save Change</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table" id="tbllecturer">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Lecturer</th>
                                        <th scope="col">Active</th>
                                    </tr>
                                </thead>

                                <tbody id="Table_Lecturer">

                                    <?php
                                        $sql = "SELECT * FROM `tbllecturer`";
                                        $rs = $cn->query($sql);
                                        while($row = $rs->fetch_assoc()){
                                            ?>
                                    <tr>
                                        <td><?php echo $row['LecturerID'] ?></td>
                                        <td><?php echo $row['LecturerName'] ?></td>
                                        <td>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                                id="EditLecturer"><i class="bi bi-pencil-fill"
                                                    style="color: green;font-size: 20px;"></i></a>
                                            <a href="#" onclick="deleteLecturer(<?php echo $row['LecturerID']; ?>)"><i
                                                    class="bi bi-trash-fill"
                                                    style="color: red; font-size: 20px;"></i></a>

                                        </td>
                                    </tr>
                                    <?php
                                          }
                                    ?>


                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <section class="float-end">
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
                            </nav>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Start -->
        <?php include("Footer.php"); ?>
        <!-- Footer End -->
    </div>
    <!-- Content End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back