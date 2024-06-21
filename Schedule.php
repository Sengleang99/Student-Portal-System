<?php include("Function.php") ?>
<?php include ('Header.php') ?>
<?php 
    if(isset($_POST['Add_Schedule'])){
        $Subject = $_POST['Subject'];
        $Lecturer = $_POST['Lecturer'];
        $Week = $_POST['Week'];
        $Time = $_POST['Time'];
        $Room = $_POST['Room'];
        $Program = $_POST['Program'];
        $StartDate = $_POST['StartDate'];
        $EndDate = $_POST['EndDate'];
        $ScheduleDate = $_POST['ScheduleDate'];
        $sql = "INSERT INTO `tblschedule`
        (`SubjectID`, `LecturerID`, 
        `DayWeekID`, `TimeID`, `RoomID`, `ProgramID`,
        `DateStart`, `DateEnd`, `ScheduleDate`) 
        VALUES ('$Subject','$Lecturer',
        '$Week','$Time','$Room','$Program',
        '$StartDate','$EndDate','$ScheduleDate')";
         $rs = $cn->query($sql);
         if($rs){
             echo "
             <script>
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

    if(isset($_POST['Edit_Schedule'])){
        $id = $_POST['id'];
        $Subject = $_POST['Subject'];
        $Lecturer = $_POST['Lecturer'];
        $Week = $_POST['Week'];
        $Time = $_POST['Time'];
        $Room = $_POST['Room'];
        $Program = $_POST['Program'];
        $StartDate = $_POST['StartDate'];
        $EndDate = $_POST['EndDate'];
        $ScheduleDate = $_POST['ScheduleDate'];
        $sql = "UPDATE `tblschedule` SET `SubjectID`='$Subject',
        `LecturerID`='$Lecturer',`DayWeekID`='$Week',
        `TimeID`='$Time',`RoomID`='$Room',
        `ProgramID`='$Program',`DateStart`='$StartDate',
        `DateEnd`='$EndDate',`ScheduleDate`='$ScheduleDate'
         WHERE ScheduleID = $id";
          $rs = $cn->query($sql);
          if($rs){
              echo "<script>
                      Swal.fire('Successful!', 'Lecturer edit successfully!', 'success').then(() => {
                          refreshPage();
                      });
                    </script>";  
          } else {
              echo "<script>
                      Swal.fire('Error!', 'Failed to edit lecturer.', 'error');
                    </script>";
          }
    }

    if(isset($_GET['Remove_Schedule'])){
        $id = $_GET['Remove_Schedule'];
        $sql ="DELETE FROM `tblschedule` WHERE ScheduleID=$id";
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
<script>
$(function() {
    $('#tblschedule').on('click', '#UpdateSchedule', function() {
        $('#Edit_Schedule').show();
        $('#Add_Schedule').hide();
        var current_row = $(this).closest('tr');
        var id = current_row.find('td').eq(0).text();
        var Subject = current_row.find('td').eq(1).data('subject-id');
        var Lecturer = current_row.find('td').eq(2).data('lecturer-id');
        var Week = current_row.find('td').eq(3).data('week-id');
        var Time = current_row.find('td').eq(4).data('time-id');
        var Room = current_row.find('td').eq(5).data('room-id');
        var Program = current_row.find('td').eq(6).data('program-id');
        var StartDate = current_row.find('td').eq(7).text();
        var EndDate = current_row.find('td').eq(8).text();
        var ScheduleDate = current_row.find('td').eq(9).text();
        $('#id').val(id);
        $('#Subject').val(Subejct);
        $('#Lecturer').val(Lecturer);
        $('#Week').val(Week);
        $('#Time').val(Time);
        $('#Room').val(Room);
        $('#Program').val(Program);
        $('#StartDate').val(StartDate);
        $('#EndDate').val(EndDate);
        $('#ScheduleDate').val(EnScheduleDatedDate);
        $('#scheduleModal').modal('show');
        $("#btn-close").click();
    });
    $('#CreateNew').click(function() {
        $('#Edit_Schedule').hide();
        $('#Add_Schedule').show();
        $('#id').val('');
        $('#Subject').val('');
        $('#Lecturer').val('');
        $('#Week').val('');
        $('#Time').val('');
        $('#Room').val('');
        $('#Program').val('');
        $('#StartDate').val('');
        $('#EndDate').val('');
        $('#ScheduleDate').val('');
    });
    $('#Searching').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#Tble_Student tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

});

function deleteSchedule(id) {
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
            window.location.href = 'Schedule.php?Remove_Schedule=' + id;
        }
    });
}

$('#Filter_Program').change(function() {
    var programId = $(this).val();
    $.ajax({
        url: 'Schedule.php', // Create a new file 'filter_schedule.php' for filtering
        type: 'POST',
        data: {
            programId: programId
        },
        success: function(response) {
            $('#tblschedule tbody').html(response);
        }
    });
});
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
                        <h6 class="mb-4">SCHEDULE INFORMATION LISTS</h6>
                        <div class="col-12 mb-3 d-flex">
                            <span class="btn btn-primary m-1 ">Filter</span>
                            <select id="Filter_Program m-1" name="Filter_Program" class="form-select">
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
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Create New
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" enctype="multipart/form-data">

                                            <div class="row">
                                                <div class="col-12">
                                                    <input name="id" hidden id="id" class="form-control mb-3"
                                                        type="number" aria-label="default input example">
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
                                                <div class="col-4">
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
                                                    <input id="StartDate" name="StartDate" class="form-control mb-3"
                                                        type="date">
                                                </div>
                                                <div class="col-4">
                                                    <label for="">End Date</label>
                                                    <input id="EndDate" name="EndDate" class="form-control mb-3"
                                                        type="date">
                                                </div>
                                                <div class="col-4">
                                                    <label for="">Schedule Date</label>
                                                    <input name="ScheduleDate" id="ScheduleDate"
                                                        class="form-control mb-3" type="date">
                                                </div>
                                            </div>

                                            <button type="submit" name="Add_Schedule" id="Add_Schedule"
                                                class="btn btn-primary">Save</button>
                                            <buCtton type="submit" name="Edit_Schedule" id="Edit_Schedule"
                                                class="btn btn-primary">Save Change</buCtton>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="container mt-5">
                            <?php 
                            $sql = "SELECT
                            scd.ScheduleID,
                            scd.ProgramID,
                            p.ProgramID,
                            y.YearEN,
                            s.SemesterEN,
                            b.BatchEN,
                            acdy.AcademicYear,
                            cp.CampusEN,
                            sh.ShiftEN,
                            r.RoomName,
                            m.MajorEN,
                            d.DegreeNameEN
                            FROM tblschedule scd
                            JOIN tblprogram p ON scd.ProgramID = p.ProgramID 
                            JOIN tblyear y ON p.YearID = y.YearID
                            JOIN tblsemester s ON p.SemesterID = s.SemesterID
                            JOIN tblbatch b ON p.BatchID = b.BatchID
                            JOIN tblacademicyear acdy ON p.AcademicYearID = acdy.AcademicYearID
                            JOIN tblcampus cp ON p.CampusID = cp.CampusID
                            JOIN tblshift sh ON p.ShiftID = sh.ShiftID
                            JOIN tblroom r ON scd.RoomID = r.RoomID
                            JOIN tblmajor m ON p.MajorID = m.MajorID
                            JOIN tbldegree d ON p.DegreeID = d.DegreeID";
                            $rs = $cn->query($sql);
                            $row = $rs->fetch_assoc();
                            echo "<p>" . $row['MajorEN'] . '/' . $row['DegreeNameEN'] . '/' . $row['YearEN'] . '/' . $row['SemesterEN'] . '/' . $row['BatchEN'] . '/' . $row['AcademicYear'] . "</p>";

                            ?>
                            <table class="table table-bordered text-center" id="tblschedule" style=" font-size: 13px;">
                                <thead>
                                    <tr>
                                        <th>Time</th>
                                        <?php 
                                $sql = "SELECT * FROM tbldayweek";
                                $rs = $cn->query($sql);
                                while($row = $rs->fetch_assoc()){
                                    echo "<th>{$row['DayWeekName']}</th>";
                                }
                                ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                        $sqlTime = "SELECT * FROM tbltime";
                        $rsTime = $cn->query($sqlTime);
                            while($rowTime = $rsTime->fetch_assoc()){
                                echo "<tr>";
                                echo "<th>{$rowTime['TimeName']}</th>";
                                
                            $sqlDayWeek = "SELECT * FROM tbldayweek";
                            $rsDayWeek = $cn->query($sqlDayWeek);
                                while($rowDayWeek = $rsDayWeek->fetch_assoc()){
                        $sqlSchedule = "SELECT
                            scd.ScheduleID,
                            scd.LecturerID,
                            scd.SubjectID,
                            sj.SubjectEN,
                            lr.LecturerName,
                            scd.ProgramID,
                            p.ProgramID,
                            y.YearEN,
                            r.RoomName
                            FROM tblschedule scd 
                            JOIN tblprogram p ON scd.ProgramID = p.ProgramID
                            JOIN tblyear y ON p.YearID = y.YearID 
                            JOIN tblsubject sj ON scd.SubjectID = sj.SubjectID
                            JOIN tbllecturer lr ON scd.LecturerID = lr.LecturerID
                            JOIN tblroom r ON scd.RoomID = r.RoomID
                            WHERE scd.DayWeekID = {$rowDayWeek['DayWeekID']}
                            AND scd.TimeID = {$rowTime['TimeID']}
                        ";
                        $rsSchedule = $cn->query($sqlSchedule);
                        $scheduleData = $rsSchedule->fetch_assoc();
                        if($scheduleData){
                            echo "<td data-subject-id='{$scheduleData['SubjectID']}' data-lecturer-id='{$scheduleData['LecturerID']}'>
                                    <p>{$scheduleData['SubjectEN']}<br/>{$scheduleData['LecturerName']}<br/>{$scheduleData['RoomName']}</p>
                                    <p>
                                        <a href='#'><i class='bi bi-pencil-fill' data-bs-toggle='modal'
                            data-bs-target='#exampleModal' id='UpdateSchedule'></i></a>
                                        <a href='#' onclick='deleteSchedule({$scheduleData['ScheduleID']})'><i class='bi bi-trash'></i></a>
                                    </p>
                                  </td>";
                        } else {
                            echo "<td></td>";
                        }
                }
                
                echo "</tr>";
                
                } ?>
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