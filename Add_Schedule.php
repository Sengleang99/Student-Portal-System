<?php include('Function.php'); ?>
<?php include("Header.php"); ?>
<script>
$(document).ready(function() {
    $('#tbllecturer').on('click', '.dropdown-item[href*="ScheduleID"]', function(e) {
        e.preventDefault(); // Prevent the default link behavior
        $('#Edit_Schedule').show();
        $('#Add_Schedule').hide();
        $('#staticBackdrop').modal('show');

        var scheduleID = $(this).attr('href').split('=')[1];

        // Fetch schedule details via AJAX
        $.ajax({
            url: 'Schedule.php',
            type: 'GET',
            data: {
                ScheduleID: scheduleID
            },
            dataType: 'json',
            success: function(data) {
                if (data) {
                    $('#id').val(data.ScheduleID);
                    $('#Program').val(data.ProgramID);
                    $('#Subject').val(data.SubjectID);
                    $('#Lecturer').val(data.LecturerID);
                    $('#Week').val(data.DayWeekID);
                    $('#Time').val(data.TimeID);
                    $('#Room').val(data.RoomID);
                    $('#StartDate').val(data.DateStart);
                    $('#EndDate').val(data.DateEnd);
                    $('#ScheduleDate').val(data.ScheduleDate);
                }
            },
            error: function(xhr, status, error) {
                console.error("Failed to fetch schedule details: " + error);
            }
        });
    });

    $('#Create_Lecturer').click(function() {
        $('#Edit_Schedule').hide();
        $('#Add_Schedule').show();
        $('#id').val('');
        $('#Program').val('');
        $('#Subject').val('');
        $('#Lecturer').val('');
        $('#Week').val('');
        $('#Time').val('');
        $('#Room').val('');
        $('#StartDate').val('');
        $('#EndDate').val('');
        $('#ScheduleDate').val('');
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
   if(isset($_GET['fetchSchedule'])){
       $ScheduleID = $_GET['ScheduleID'];
       $sql ="SELECT * FROM `tblschedule` WHERE ScheduleID=$ScheduleID";
       $rs = $cn->query($sql);
       if($row = $rs->fetch_assoc()){
           echo json_encode($row);
       }
       exit;
   }

   // Other PHP code for handling Add, Edit, and Delete actions
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
                        <form action="Schedule.php" method="POST" enctype="multipart/form-data">

                            <div class="row">
                                <div class="col-12">
                                    <input name="id" hidden id="id" value="<?php echo $row['ScheduleID'] ?>"
                                        class="form-control mb-3" type="number" aria-label="default input example">
                                </div>
                                <div class="col-12 mb-3">
                                    <select id="Program" name="Program" class="form-select">
                                        <option value="">Select Program</option>
                                        <?php
                                $sql = "SELECT 
                                tblprogram.ProgramID, 
                                tblmajor.MajorEN, 
                                tblsemester.SemesterEN, 
                                tblyear.YearEN,
                                tblshift.ShiftEN,
                                tblbatch.BatchEN,
                                tblcampus.CampusEN
                                        FROM tblprogram 
                                        INNER JOIN tblmajor ON tblprogram.MajorID = tblmajor.MajorID 
                                        INNER JOIN tblcampus ON tblprogram.CampusID = tblcampus.CampusID 
                                        INNER JOIN tblshift ON tblprogram.ShiftID = tblshift.ShiftID 
                                        INNER JOIN tblbatch ON tblprogram.BatchID = tblbatch.BatchID 
                                        INNER JOIN tblsemester ON tblprogram.SemesterID = tblsemester.SemesterID 
                                        INNER JOIN tblyear ON tblprogram.YearID = tblyear.YearID";
                                $rs = $cn->query($sql);
                                while ($row = $rs->fetch_assoc()) {
                                    echo '<option value="' . $row['ProgramID'] . '">' . $row['MajorEN'] . '/' . $row['YearEN'] . '/' . $row['SemesterEN'] . '/' . $row['ShiftEN'] . $row['SemesterEN'] . '/' . $row['BatchEN'] . $row['CampusEN'] .'</option>';
                                }
                                    ?>
                                    </select>
                                </div>
                                <div class=" col-4">
                                    <select name="Subject" id="Subject" class="form-select mb-3"
                                        aria-label="Default select example">
                                        <option value="">Select Subject</option>
                                        <?php 
                                $sql = "SELECT
                                tblsubject.SubjectID,
                                tblsubject.SubjectEN,
                                tblsubject.CreditNumber,
                                tblsubject.Hours,
                                tblfaculty.FacultyEN,
                                tblmajor.MajorEN,
                                tblyear.YearEN,
                                tblsemester.SemesterEN
                                FROM tblsubject
                                INNER JOIN tblfaculty ON tblsubject.FacultyID = tblfaculty.FacultyID
                                INNER JOIN tblmajor ON tblsubject.MajorID = tblmajor.MajorID
                                INNER JOIN tblyear ON tblsubject.YearID = tblyear.YearID
                                INNER JOIN tblsemester ON tblsubject.SemesterID = tblsemester.SemesterID";
                                $rs = $cn->query($sql);
                                while($row = $rs->fetch_assoc()){
                                ?>
                                        <option value="<?php echo $row['SubjectID'] ?>">
                                            <?php echo $row['SubjectEN'] ?>
                                        </option>
                                        <?php
                                }
                                ?>

                                    </select>
                                </div>
                                <div class="col-4">
                                    <select name="Lecturer" id="Lecturer" class="form-select mb-3"
                                        aria-label="Default select example">
                                        <option value="">Select Lecturer</option>
                                        <?php 
                                            $sql = "SELECT * FROM tbllecturer";
                                            $rs = $cn->query($sql);
                                        while($row = $rs->fetch_assoc()){
                                            ?>
                                        <option value="<?php echo $row['LecturerID'] ?>">
                                            <?php echo $row['LecturerName'] ?>
                                        </option>
                                        <?php
                                        }
                                    ?>

                                    </select>
                                </div>
                                <div class="col-4">
                                    <select name="Week" id="Week" class="form-select mb-3"
                                        aria-label="Default select example">
                                        <option value="">Select Week</option>
                                        <?php 
                                        $sql = "SELECT
                                        DayWeekID,
                                        tbldayweek.DayWeekName,
                                        tblshift.ShiftEN
                                        FROM tbldayweek
                                        INNER JOIN tblshift ON tbldayweek.ShiftID = tblshift.ShiftID";
                                        $rs = $cn->query($sql);
                                    while($row = $rs->fetch_assoc()){
                                        ?>
                                        <option value="<?php echo $row['DayWeekID']?> ">
                                            <?php echo $row['DayWeekName'] ?>
                                        </option>
                                        <?php
                                    }
                                    ?>

                                    </select>
                                </div>

                                <div class="col-6">
                                    <select name="Time" id="Time" class="form-select mb-3"
                                        aria-label="Default select example">
                                        <option value="">Select Time</option>
                                        <?php 
                                                $sql = "SELECT
                                                tbltime.TimeID,
                                                tbltime.TimeName,
                                                tblshift.ShiftEN
                                                FROM tbltime
                                                INNER JOIN tblshift ON tbltime.ShiftID = tblshift.ShiftID";
                                                $rs = $cn->query($sql);
                                            while($row = $rs->fetch_assoc()){
                                                ?>
                                        <option value="<?php echo $row['TimeID']?> ">
                                            <?php echo $row['TimeName'] ?>
                                        </option>
                                        <?php
                                            }
                                            ?>

                                    </select>
                                </div>

                                <div class="col-6">
                                    <select name="Room" id="Room" class="form-select mb-3"
                                        aria-label="Default select example">
                                        <option value="">Select Room</option>
                                        <?php 
                                            $sql = "SELECT
                                            tblroom.RoomID,
                                            tblroom.RoomName,
                                            tblcampus.CampusEN
                                            FROM tblroom
                                            INNER JOIN tblcampus ON tblroom.CampusID = tblcampus.CampusID";
                                            $rs = $cn->query($sql);
                                        while($row = $rs->fetch_assoc()){
                                            ?>
                                        <option value="<?php echo $row['RoomID']?> ">
                                            <?php echo $row['RoomName']?>
                                        </option>
                                        <?php
                                        }
                                        ?>

                                    </select>
                                </div>

                                <div class="col-4">
                                    <label for="">Start Date</label>
                                    <input id="StartDate" value="<?php echo $row['DateStart']  ?>" name="StartDate"
                                        class="form-control mb-3" type="date">
                                </div>
                                <div class="col-4">
                                    <label for="">End Date</label>
                                    <input id="EndDate" name="EndDate" class="form-control mb-3" type="date">
                                </div>
                                <div class="col-4">
                                    <label for="">Schedule Date</label>
                                    <input name="ScheduleDate" id="ScheduleDate" class="form-control mb-3" type="date">
                                </div>
                            </div>

                            <button type="submit" name="Add_Schedule" id="Add_Schedule"
                                class="btn btn-primary">Save</button>

                        </form>


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
    <a href=" #" class="btn btn-lg btn-primary btn-lg-square back