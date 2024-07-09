<?php include('Function.php'); ?>
<?php include("Header.php"); ?>
<script>
$(document).ready(function() {
    $('#Searching').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#Table_Lecturer tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });


    $('#ProgramFilter').on('change', function() {
        var selectedProgramId = $(this).val();
        if (selectedProgramId === '') {
            $('#Table_Lecturer tr').show();
        } else {
            $('#Table_Lecturer tr').each(function() {
                var programId = $(this).data('program-id');
                $(this).toggle(programId == selectedProgramId);
            });
        }
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
    })
}
</script>
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
                Swal.fire('Successful!', 'schedule deleted successfully!', 'success').then(() => {
                    refreshPage();
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire('Error!', 'Failed to delete schedule.', 'error');
              </script>";
    }
}
$sql_programs = "SELECT ProgramID, MajorEN FROM tblprogram p INNER JOIN tblmajor m ON p.MajorID = m.MajorID GROUP BY MajorEN";
$rs_programs = $cn->query($sql_programs);
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
                        <a href="Add_Schedule.php" class="btn btn-primary  mb-1">Create Schedule</a>
                        <button type="button" id="ExportToExcel" class="btn btn-success m-3"
                            onclick="window.location.href='export_schedule.php'">Export to Excel</button>
                        <!-- Program Filter Dropdown -->
                        <div class="col-6 float-end">
                            <select id="ProgramFilter" name="Program" class="form-select mb-3">
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
                                    echo '<option value="' . $row['ProgramID'] . '">' . $row['MajorEN'] . '/' . $row['YearEN'] . '/' . $row['SemesterEN'] . '/' . $row['ShiftEN'] . '/' . $row['BatchEN'] . '/' . $row['CampusEN'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tbllecturer">
                                <thead>
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Subject</th>
                                        <th scope="col">Lecturer</th>
                                        <th scope="col">Day</th>
                                        <th scope="col">Time</th>
                                        <th scope="col">Room</th>
                                        <th scope="col">Program</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>

                                <tbody id="Table_Lecturer">
                                    <?php
                            
                            $sql = "SELECT  
                                scd.ScheduleID,
                                l.LecturerName,
                                s.SubjectEN,
                                d.DayWeekName,
                                t.TimeName,
                                r.RoomName,
                                p.ProgramID,
                                m.MajorEN,
                                y.YearEN,
                                se.SemesterEN,
                                dg.DegreeNameEN,
                                b.BatchEN,
                                a.AcademicYear,
                                shi.ShiftEN
                            FROM tblschedule scd
                            INNER JOIN tblprogram p ON scd.ProgramID = p.ProgramID
                            INNER JOIN tblsubject s ON scd.SubjectID = s.SubjectID
                            INNER JOIN tbllecturer l ON scd.LecturerID = l.LecturerID
                            INNER JOIN tbldayweek d ON scd.DayWeekID = d.DayWeekID
                            INNER JOIN tbltime t ON scd.TimeID = t.TimeID
                            INNER JOIN tblroom r ON scd.RoomID = r.RoomID
                            INNER JOIN tblmajor m ON p.MajorID = m.MajorID
                            INNER JOIN tblyear y ON p.YearID = y.YearID
                            INNER JOIN tblsemester se ON p.SemesterID = se.SemesterID
                            INNER JOIN tbldegree dg ON p.DegreeID = dg.DegreeID
                            INNER JOIN tblbatch b ON p.BatchID = b.BatchID
                            INNER JOIN tblshift shi ON p.ShiftID = shi.ShiftID
                            INNER JOIN tblacademicyear a ON p.AcademicYearID = a.AcademicYearID
                            ORDER BY scd.ScheduleID DESC
                            ";
                            $rs = $cn->query($sql);
                            while($row = $rs->fetch_assoc()){
                                ?>
                                    <tr data-program-id="<?php echo $row['ProgramID'] ?>">
                                        <td><?php echo $row['ScheduleID'] ?></td>
                                        <td><?php echo $row['SubjectEN'] ?></td>
                                        <td><?php echo $row['LecturerName'] ?></td>
                                        <td><?php echo $row['DayWeekName'] ?></td>
                                        <td><?php echo $row['TimeName'] ?></td>
                                        <td><?php echo $row['RoomName'] ?></td>
                                        <td><?php echo $row['MajorEN'] .'-.-'. $row['ShiftEN'] .'<br>['. $row['YearEN'] .'-'. $row['SemesterEN'] .']'.'<br>'. $row['DegreeNameEN'] .'<br>'. $row['BatchEN'] .'-'. $row['AcademicYear'] ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn" type="button" id="dropdownMenuButton"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li><a href="Add_Schedule.php?ScheduleID=<?php echo $row['ScheduleID'] ?>"
                                                            class="dropdown-item"><i class="bi bi-pencil-fill"></i>
                                                            Update</a></li>
                                                    <li><a type="button" class="dropdown-item" href="#"
                                                            onclick="deleteSchedule(<?php echo $row['ScheduleID'] ?>)"><i
                                                                class="bi bi-trash-fill"></i> Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
    }
    ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Start -->