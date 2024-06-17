<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php include("Header.php");?>
<?php
    $cn= new mysqli("localhost","root","","student_portal_management");
    session_start();


// ------------- Family Background Student ---------------------


    function Add_Family(){
        global $cn;
        if(isset($_POST['Add_Family'])){
            $DadName = $_POST['DadName'];
            $DadAge = $_POST['DadAge'];
            $CountryDad = $_POST['CountryDad'];
            $NationalityDad = $_POST['NationalityDad'];
            $MomName = $_POST['MomName'];
            $MomAge = $_POST['MomAge'];
            $CountryMom = $_POST['CountryMom'];
            $NationalMom = $_POST['NationalMom'];
            $FatherOccupationID = $_POST['FatherOccupationID'];
            $MotherOccupationID = $_POST['MotherOccupationID'];
            $FamilyCurrentAddress = $_POST['FamilyCurrentAddress'];
            $SpouseName = $_POST['SpouseName'];
            $SpouseAge = $_POST['SpouseAge'];
            $GuardianPhoneNumber = $_POST['GuardianPhoneNumber'];
            $Student = $_POST['Student'];
            $sql = "INSERT INTO `tblfamilybackground`
            (`FatherName`, `FatherAge`, `FatherNationalityID`, 
             `FatherCountryID`, `FatherOccupationID`, 
             `MotherName`, `MotherAge`, 
             `MotherNationalityID`, 
             `MotherCountryID`, `MotherOccupationID`, 
             `FamilyCurrentAddress`, `SpouseName`, 
             `SpouseAge`, `GuardianPhoneNumber`, 
             `StudentID`) VALUES 
             ('$DadName','$DadAge','$NationalityDad',
             '$CountryDad','$FatherOccupationID','$MomName',
             '$MomAge','$NationalMom','$CountryMom',
             '$MotherOccupationID','$FamilyCurrentAddress','$SpouseName',
             '$SpouseAge','$GuardianPhoneNumber','$Student')";
              $rs = $cn->query($sql);
              if($rs){
                  echo "
                      <script>
                          swal('Successfull!', 'You clicked the button!', 'success');
                      </script>
                  ";  
              }
        }
    }
    Add_Family();
    
    function GetView_Family(){
        global $cn;
        $sql = "SELECT 
        tblfamilybackground.FamilyBackgroundID, 
        tblfamilybackground.FatherName, 
        tblfamilybackground.FatherAge,  
        tblfamilybackground.FatherOccupationID, 
        tblfamilybackground.MotherName, 
        tblfamilybackground.MotherAge, 
        tblfamilybackground.MotherOccupationID, 
        tblfamilybackground.FatherNationalityID,
        tblfamilybackground.FatherCountryID,
        tblfamilybackground.MotherNationalityID,
        tblfamilybackground.MotherCountryID,
        tblfamilybackground.FamilyCurrentAddress, 
        tblfamilybackground.SpouseName, 
        tblfamilybackground.SpouseAge, 
        tblfamilybackground.GuardianPhoneNumber, 
        fc.CountryEN AS FatherCountryName, 
        fn.NationalityEN AS FatherNationalName,
        mc.CountryEN AS MotherCountryName,  
        mn.NationalityEN AS MotherNationalityEN,
        tblstudentinfo.NameInLatin,
        tblstudentinfo.StudentID
    FROM 
        tblfamilybackground 
    INNER JOIN 
        tblcountry AS fc ON tblfamilybackground.FatherCountryID = fc.CountryID
    INNER JOIN 
        tblnationality AS fn ON tblfamilybackground.FatherNationalityID = fn.NationalityID
    INNER JOIN 
        tblcountry AS mc ON tblfamilybackground.MotherCountryID = mc.CountryID
    INNER JOIN 
        tblnationality AS mn ON tblfamilybackground.MotherNationalityID = mn.NationalityID
    INNER JOIN 
        tblstudentinfo ON tblfamilybackground.StudentID = tblstudentinfo.StudentID";
         $rs = $cn->query($sql);
         if($rs){
             while($row = $rs->fetch_assoc()){
                 $id = $row['FamilyBackgroundID'];
                 echo "<tr>";
                 echo "<td>".$row['FamilyBackgroundID']."</td>";
                 echo "<td data-student-id='".$row['StudentID']."'>".$row['NameInLatin']."</td>";
                 echo "<td>".$row['FatherName']."</td>";
                 echo "<td hidden>".$row['FatherAge']."</td>";
                 echo "<td hidden data-nationalitydad-id='".$row['FatherNationalityID']."'>".$row['FatherNationalName']."</td>";
                 echo "<td hidden data-countrydad-id='".$row['FatherCountryID']."'>".$row['FatherCountryName']."</td>";
                 echo "<td hidden>".$row['FatherOccupationID']."</td>";
                 echo "<td>".$row['MotherName']."</td>";
                 echo "<td hidden>".$row['MotherAge']."</td>";
                 echo "<td hidden data-nationalmom-id='".$row['MotherNationalityID']."'>".$row['MotherNationalityEN']."</td>";
                 echo "<td hidden data-countrymom-id='".$row['MotherCountryID']."'>".$row['MotherCountryName']."</td>";
                 echo "<td hidden>".$row['MotherOccupationID']."</td>";
                 echo "<td>".$row['FamilyCurrentAddress']."</td>";
                 echo "<td hidden>".$row['SpouseName']."</td>";
                 echo "<td hidden>".$row['SpouseAge']."</td>";
                 echo "<td>".$row['GuardianPhoneNumber']."</td>";
                 echo '
                 <td>
                 <div class="dropdown">
                     <button class="btn" type="button" id="dropdownMenuButton"
                         data-bs-toggle="dropdown" aria-expanded="false">
                         <i class="bi bi-three-dots-vertical"></i>
                     </button>
                     <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                         <li><a class="dropdown-item" href="#"><i class="bi bi-eye-fill"></i>
                                 View</a></li>
                         <li><a class="dropdown-item" id="UpdateFamily" href="#" data-bs-toggle="modal"
                         data-bs-target="#familyModal"><i
                                     class="bi bi-pencil-fill"></i> Update</a></li>
                        <li><a class="dropdown-item" href="#" onclick="deleteFamily('.$row['FamilyBackgroundID'].')"><i
                                     class="bi bi-trash-fill"></i>Delete</a></li>
                     </ul>
                 </div>
                 </td>
                 ';
                 echo "</tr>";
             }
         }
    }

    function Edit_Family(){
        global $cn;
        if(isset($_POST['Edit_Family'])){
            $id = $_POST['id'];
            $DadName = $_POST['DadName'];
            $DadAge = $_POST['DadAge'];
            $CountryDad = $_POST['CountryDad'];
            $NationalityDad = $_POST['NationalityDad'];
            $MomName = $_POST['MomName'];
            $MomAge = $_POST['MomAge'];
            $CountryMom = $_POST['CountryMom'];
            $NationalMom = $_POST['NationalMom'];
            $FatherOccupationID = $_POST['FatherOccupationID'];
            $MotherOccupationID = $_POST['MotherOccupationID'];
            $FamilyCurrentAddress = $_POST['FamilyCurrentAddress'];
            $SpouseName = $_POST['SpouseName'];
            $SpouseAge = $_POST['SpouseAge'];
            $GuardianPhoneNumber = $_POST['GuardianPhoneNumber'];
            $Student = $_POST['Student'];
            $sql = "UPDATE `tblfamilybackground` 
            SET 
            `FatherName`='$DadName',`FatherAge`='$DadAge',
            `FatherNationalityID`='$NationalityDad',
            `FatherCountryID`='$CountryDad',
            `FatherOccupationID`='$FatherOccupationID',
            `MotherName`='$MomName',
            `MotherAge`='$MomAge',
            `MotherNationalityID`='$NationalMom',
            `MotherCountryID`='$CountryMom',
            `MotherOccupationID`='$MotherOccupationID',
            `FamilyCurrentAddress`='$FamilyCurrentAddress',
            `SpouseName`='$SpouseName',
            `SpouseAge`='$SpouseAge',
            `GuardianPhoneNumber`='$GuardianPhoneNumber',
            `StudentID`='$Student' 
            WHERE `FamilyBackgroundID`=$id";
              $rs = $cn->query($sql);
              if($rs){
                  echo "
                      <script>
                          swal('Successfull!', 'You clicked the button!', 'success');
                      </script>
                  ";  
              }
        }
    }
    Edit_Family();

    function Delete_Family(){
        global $cn;
        if(isset($_GET['Remove_Family'])){
            $id = $_GET['Remove_Family'];
            $sql ="DELETE FROM `tblfamilybackground` WHERE FamilyBackgroundID=$id";
            $rs = $cn->query($sql);
    }
}
    Delete_Family();
// ------------- End background Family ---------------------

// ------------- background study ---------------------

    function Add_Background(){
        global $cn;
        if(isset($_POST['Add_Background'])){
            $SchoolName = $_POST['Schoolname'];
            $Province = $_POST['Province'];
            $SchoolType = $_POST['SchoolType'];
            $AcademicYear = $_POST['AcademicYear'];
            $Student = $_POST['Student'];
            $sql = "INSERT INTO 
            `tbleducationalbackground`(`SchoolTypeID`, `NameSchool`, `AcademicYear`, `Province`, `StudentID`) 
            VALUES ('$SchoolType','$SchoolName','$AcademicYear','$Province','$Student')";
             $rs = $cn->query($sql);
             if($rs){
                echo "<script>
                        Swal.fire('Successful!', 'Lecturer added successfully!', 'success');
                      </script>";  
            } else {
                echo "<script>
                        Swal.fire('Error!', 'Failed to add lecturer.', 'error');
                      </script>";
            }
        }
    }
    Add_Background();

    function GetView_Background(){
        global $cn;
        $sql = "SELECT 
        EducationalBackgroundID,NameSchool,
        Province,AcademicYear,
        tblstudentinfo.NameInLatin,
        tblschooltype.SchoolTypeEN,
        tblschooltype.SchoolTypeID,
        tblstudentinfo.StudentID
        FROM tbleducationalbackground
        INNER JOIN tblstudentinfo ON tbleducationalbackground.StudentID = tblstudentinfo.StudentID
        INNER JOIN tblschooltype ON tbleducationalbackground.SchoolTypeID = tblschooltype.SchoolTypeID";
                $rs = $cn->query($sql);
                if($rs){
                    while($row = $rs->fetch_assoc()){
                    $id = $row['EducationalBackgroundID'];
                    echo "<tr>";
                    echo "<td>".$row['EducationalBackgroundID']."</td>";
                    echo "<td data-student-id='".$row['StudentID']."'>".$row['NameInLatin']."</td>";
                    echo "<td data-schooltype-id='".$row['SchoolTypeID']."'>".$row['SchoolTypeEN']."</td>";
                    echo "<td>".$row['NameSchool']."</td>";
                    echo "<td>".$row['AcademicYear']."</td>";
                    echo "<td>".$row['Province']."</td>";
                    echo "
                    <td>
                        <a href='#' data-bs-toggle='modal' data-bs-target='#backgroundModal' id='UpdateBackground'><i class='bi bi-pencil-fill' style='color: green;font-size: 20px;'></i></a>
                        <a  href='#' onclick='deleteBackground(".$row['EducationalBackgroundID'].")'>
                        <i class='bi bi-trash-fill' style='color: red;font-size: 20px;'></i>
                    </a>
                    </td>
                    ";
                    echo "</tr>";
                    }
                }
    }

    function Edit_Background(){
        global $cn;
        if(isset($_POST['Edit_Background'])){
            $id = $_POST['BackgroundID'];
            $SchoolName = $_POST['Schoolname'];
            $Province = $_POST['Province'];
            $SchoolType = $_POST['SchoolType'];
            $AcademicYear = $_POST['AcademicYear'];
            $Student = $_POST['Student'];
            $sql = "UPDATE `tbleducationalbackground` 
            SET `SchoolTypeID`='$SchoolType',
            `NameSchool`='$SchoolName',
            `AcademicYear`='$AcademicYear',
            `Province`='$Province',
            `StudentID`='$Student' 
            WHERE EducationalBackgroundID = $id";
             $rs = $cn->query($sql);
             if($rs){
                echo "<script>
                        Swal.fire('Successful!', 'Lecturer added successfully!', 'success');
                      </script>";  
            } else {
                echo "<script>
                        Swal.fire('Error!', 'Failed to add lecturer.', 'error');
                      </script>";
            }
        }
    }
    Edit_Background();
    
    function Delete_Background(){
        global $cn;
        if(isset($_GET['Remove_Background'])){
            $id = $_GET['Remove_Background'];
            $sql ="DELETE FROM `tbleducationalbackground` WHERE EducationalBackgroundID=$id";
            $rs = $cn->query($sql);
        }
    }
    Delete_Background();
// -------------End background study -------------------


    // ----------------- Start Section Status ----------

    function Add_Status(){
        global $cn;
        if (isset($_POST['Add_Status'])) {
            $Program = $_POST['Program'];
            $AssignDate = $_POST['AssignDate'];
            $Note = $_POST['Note'];
        
            // Check if students are selected
            if (isset($_POST['assigned']) && is_array($_POST['assigned'])) {
                $assignedStudents = $_POST['assigned'];
        
                foreach ($assignedStudents as $Student) {
                    $sql = "INSERT INTO tblstudentstatus (StudentID, ProgramID, Note, AssignDate) 
                            VALUES ('$Student', '$Program', '$Note', '$AssignDate')";
                    $rs = $cn->query($sql);
                    
                    if (!$rs) {
                        // Show error if insertion fails for any student
                        echo "<script>
                                Swal.fire('Error!', 'Failed to add student ID: $Student.', 'error');
                              </script>";
                        break; // Exit the loop on first error
                    }
                }
        
                // Show success message if all insertions are successful
                if ($rs) {
                    echo "<script>
                            Swal.fire('Successful!', 'Students added successfully!', 'success');
                          </script>";
                }
            } else {
                // No students selected
                echo "<script>
                        Swal.fire('Error!', 'No students selected.', 'error');
                      </script>";
            }
        }
    }
    Add_Status();

    function GetView_Status(){
        global $cn;
        $sql = "SELECT
            tblstudentstatus.StudentStatusID,
            tblstudentstatus.StudentID,
            tblstudentstatus.ProgramID,
            tblstudentstatus.Assigned,
            tblstudentstatus.Note,
            tblstudentstatus.AssignDate,
            tblstudentinfo.NameInLatin,
            tblsemester.SemesterEN,
            tblshift.ShiftEN,
            tbldegree.DegreeNameEN,
            tblacademicyear.AcademicYear,
            tblprogram.StartDate,
            tblprogram.EndDate,
            tblprogram.DateIssue,
            tblmajor.MajorEN,
            tblyear.YearEN,
            tblbatch.BatchEN
        FROM tblstudentstatus
        JOIN tblstudentinfo ON tblstudentstatus.StudentID = tblstudentinfo.StudentID
        JOIN tblprogram ON tblstudentstatus.ProgramID = tblprogram.ProgramID
        JOIN tblmajor ON tblprogram.MajorID = tblmajor.MajorID
        JOIN tblyear ON tblprogram.YearID = tblyear.YearID
        JOIN tblsemester ON tblprogram.SemesterID = tblsemester.SemesterID
        JOIN tblshift ON tblprogram.ShiftID = tblshift.ShiftID
        JOIN tbldegree ON tblprogram.DegreeID = tbldegree.DegreeID
        JOIN tblacademicyear ON tblprogram.AcademicYearID = tblacademicyear.AcademicYearID
        JOIN tblbatch ON tblprogram.BatchID = tblbatch.BatchID";
        $rs = $cn->query($sql);
        if($rs){
            while($row = $rs->fetch_assoc()){
                $id = $row['StudentStatusID'];
                echo "<tr>";
                echo "<td>".$row['StudentStatusID']."</td>";
                echo "<td data-student-id='".$row['StudentID']."'>".$row['NameInLatin']."</td>";
                echo "<td data-program-id='".$row['ProgramID']."'>"
                    .$row['YearEN'] . '/' .$row['SemesterEN'] . '/' 
                    .$row['MajorEN']. '<br/>' .$row['ShiftEN']. '/' 
                    .$row['DegreeNameEN']. '/' .$row['AcademicYear']. '/' 
                    .$row['BatchEN']."</td>"; 
                echo "<td>".$row['Note']."</td>";
                echo "<td hidden>".$row['AssignDate']."</td>";
                echo "<td>"; 
                if($row['Assigned']==1){
                    echo "<p><a class='btn btn-success' href='Status.php?StudentStatusID=".$row['StudentStatusID']."&Assigned=0'>Active</a></p> ";
                } else {
                    echo "<p><a class='btn btn-danger' href='Status.php?StudentStatusID=".$row['StudentStatusID']."&Assigned=1'>Disable</a></p> ";
                }
                echo "</td>";
                echo "
                <td>
                    <a href='#' data-bs-toggle='modal' data-bs-target='#statusModal' id='Update_Status'>
                        <i class='bi bi-pencil-fill' style='color: green;font-size: 20px;'></i>
                    </a>
                  
                        <a  href='#' onclick='deleteStatus(".$row['StudentStatusID'].")'>
                            <i class='bi bi-trash-fill' style='color: red;font-size: 20px;'></i>
                        </a>
                </td>";
                echo "</tr>";
            }
        }
    }
    
    function GetAssign(){
        global $cn;
        if(isset($_GET['StudentStatusID']) && isset($_GET['Assigned'])){
            $id = $_GET['StudentStatusID'];
            $Assigned = $_GET['Assigned'];
            $sql ="UPDATE `tblstudentstatus` SET Assigned=$Assigned WHERE StudentStatusID=$id";
            $rs = $cn->query($sql);
        }
    }
    GetAssign();

    function Edit_Status(){
        global $cn;
        if(isset($_POST['Edit_Status'])){
            $id = $_POST['StatusID'];
            $Student = $_POST['Student'];
            $Program = $_POST['Program'];
            $AssignDate = $_POST['AssignDate'];
            $Note = $_POST['Note'];
            $sql = "UPDATE `tblstudentstatus` SET 
            `StudentID`='$Student',
            `ProgramID`='$Program',
            `Note`='$Note',
            `AssignDate`='$AssignDate'
            WHERE StudentStatusID=$id";
            $rs = $cn->query($sql);
                if($rs){
                    echo "
                        <script>
                            swal('Successfull!', 'You clicked the button!', 'success');
                        </script>
                    ";  
                }
        }
    }
    Edit_Status();

    function Delete_Status(){
        global $cn;
        if(isset($_GET['Remove_Status'])){
            $id = $_GET['Remove_Status'];
            $sql ="DELETE FROM `tblstudentstatus` WHERE StudentStatusID=$id";
            $rs = $cn->query($sql);
        }
    }
    Delete_Status();
    // ----------------- End Status -----------------

    // ----------------- Register Program ---------------

    function Add_Program(){
    global $cn;
    if(isset($_POST['Add_Program'])){
        $Year = $_POST['Year'];
        $Semester = $_POST['Semester'];
        $Shift = $_POST['Shift'];
        $Degrees = $_POST['Degrees'];
        $AcademicYear = $_POST['AcademicYear'];
        $Major = $_POST['Major'];
        $Batch = $_POST['Batch'];
        $Campus = $_POST['Campus'];
        $StartDate = $_POST['StartDate'];
        $EndStart = $_POST['EndStart'];
        $DateIssue = $_POST['DateIssue'];
        $sql = "INSERT INTO `tblprogram`(`YearID`, `SemesterID`, `ShiftID`, `DegreeID`, 
        `AcademicYearID`, `MajorID`, `BatchID`, `CampusID`, `StartDate`, `EndDate`, `DateIssue`) 
        VALUES ('$Year','$Semester','$Shift','$Degrees','$AcademicYear',
        '$Major','$Batch','$Campus','$StartDate','$EndStart','$DateIssue')";
        $rs = $cn->query($sql);
        if($rs){
            echo "<script>
                    Swal.fire('Successful!', 'Lecturer added successfully!', 'success');
                  </script>";  
        } else {
            echo "<script>
                    Swal.fire('Error!', 'Failed to add lecturer.', 'error');
                  </script>";
        }
    }
    }
    Add_Program();

    function Edit_Program(){
    global $cn;
    if(isset($_POST['Edit_Program'])){
        $id = $_POST['ProgramID'];
        $Year = $_POST['Year'];
        $Semester = $_POST['Semester'];
        $Shift = $_POST['Shift'];
        $Degrees = $_POST['Degrees'];
        $AcademicYear = $_POST['AcademicYear'];
        $Major = $_POST['Major'];
        $Batch = $_POST['Batch'];
        $Campus = $_POST['Campus'];
        $StartDate = $_POST['StartDate'];
        $EndStart = $_POST['EndStart'];
        $DateIssue = $_POST['DateIssue'];
        $sql = "UPDATE `tblprogram` SET `YearID`='$Year',`SemesterID`='$Semester',
        `ShiftID`='$Shift',`DegreeID`='$Degrees',`AcademicYearID`='$AcademicYear',`MajorID`='$Major',
        `BatchID`='$Batch',`CampusID`='$Campus',`StartDate`='$StartDate',`EndDate`='$EndStart',
        `DateIssue`='$DateIssue' WHERE `ProgramID`=$id";
        $rs = $cn->query($sql);
        if($rs){
            echo "<script>
                    Swal.fire('Successful!', 'Lecturer added successfully!', 'success');
                  </script>";  
        } else {
            echo "<script>
                    Swal.fire('Error!', 'Failed to add lecturer.', 'error');
                  </script>";
        }
    }
}
    Edit_Program();

    function getView_Program() {
    global $cn;
    $sql = "SELECT 
    tblprogram.ProgramID,tblprogram.StartDate, 
    tblprogram.EndDate,tblprogram.DateIssue,
    tblyear.YearID,tblyear.YearEN, 
    tblsemester.SemesterID,tblsemester.SemesterEN, 
    tblmajor.MajorID,tblmajor.MajorEN, 
    tblshift.ShiftID,tblshift.ShiftEN, 
    tbldegree.DegreeID,tbldegree.DegreeNameEN, 
    tblacademicyear.AcademicYearID, 
    tblacademicyear.AcademicYear, 
    tblbatch.BatchID,tblbatch.BatchEN, 
    tblcampus.CampusID,tblcampus.CampusEN
    FROM tblprogram
    INNER JOIN tblmajor ON tblprogram.MajorID = tblmajor.MajorID
    INNER JOIN tblsemester ON tblprogram.SemesterID = tblsemester.SemesterID
    INNER JOIN tblyear ON tblprogram.YearID = tblyear.YearID
    INNER JOIN tblshift ON tblprogram.ShiftID = tblshift.ShiftID
    INNER JOIN tbldegree ON tblprogram.DegreeID = tbldegree.DegreeID
    INNER JOIN tblacademicyear ON tblprogram.AcademicYearID = tblacademicyear.AcademicYearID
    INNER JOIN tblbatch ON tblprogram.BatchID = tblbatch.BatchID
    INNER JOIN tblcampus ON tblprogram.CampusID = tblcampus.CampusID"; 
    $rs = $cn->query($sql);
    if ($rs) {
        while ($row = $rs->fetch_assoc()) {
            $id = $row['ProgramID'];
            echo "<tr>";
            echo "<td>".$row['ProgramID']."</td>";
            echo "<td data-year-id='".$row['YearID']."'>".$row['YearEN']."</td>";
            echo "<td data-semester-id='".$row['SemesterID']."'>".$row['SemesterEN']."</td>";
            echo "<td data-shift-id='".$row['ShiftID']."'>".$row['ShiftEN']."</td>";
            echo "<td data-degree-id='".$row['DegreeID']."'>".$row['DegreeNameEN']."</td>";
            echo "<td data-academicyear-id='".$row['AcademicYearID']."'>".$row['AcademicYear']."</td>";
            echo "<td data-major-id='".$row['MajorID']."'>".$row['MajorEN']."</td>";
            echo "<td data-batch-id='".$row['BatchID']."'>".$row['BatchEN']."</td>";
            echo "<td data-campus-id='".$row['CampusID']."'>".$row['CampusEN']."</td>";
            echo "<td hidden>".$row['StartDate']."</td>";
            echo "<td hidden>".$row['EndDate']."</td>";
            echo "<td hidden>".$row['DateIssue']."</td>";
            echo '
                <td>
                <div class="dropdown">
                    <button class="btn" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="ViewDetail.php"><i class="bi bi-eye-fill"></i>
                                View</a></li>
                        <li><a class="dropdown-item" id="EditProgram" href="#" data-bs-toggle="modal"
                        data-bs-target="#programModal"><i
                                    class="bi bi-pencil-fill"></i> Update</a></li>
                        <li><a class="dropdown-item" href="#" onclick="deleteProgram('.$row['ProgramID'].')"><i
                                    class="bi bi-trash-fill"></i> Delete</a></li>
                    </ul>
                </div>
                </td>
            ';
            echo "</tr>";
        }
    }
    }

    function Delete_Program(){
    global $cn;
    if(isset($_GET['Remove_Program'])){
        $id = $_GET['Remove_Program'];
        $sql ="DELETE FROM `tblprogram` WHERE ProgramID=$id";
        $rs = $cn->query($sql);
    }
    }
    Delete_Program();
// ----------------- End Section Program ---------------


// ----------------- Register login logout ---------------

    function SignUp(){
    global $cn;
    if(isset($_POST['SignUp'])){
        $Username = $_POST['Username'];
        $Email = $_POST['Email'];
        $Password = $_POST['Password'];
        $Profile = $_FILES['Image']['name'];
        if(!empty($Username) && !empty($Email) && !empty($Password) && !empty($Profile)){
            $profile = rand(1,9999).'-'.$Profile;
            $part = "img/".$Profile;
            move_uploaded_file($_FILES['Image']['tmp_name'],$part);
            $Password = md5($_POST['Password']);
            $sql = "INSERT INTO `tbluser`(`Username`, `Email`, `Password`, `Photo`)
            VALUES ('$Username','$Email','$Password','$Profile')";
            $rs = $cn->query($sql);
            if($rs){
                echo "
                <script>
                    swal('Successfull!', 'You clicked the button!', 'success');
                </scrip>
                ";
                
            }
        }
       
    }
    }
    SignUp();

    function SignIn() {
    global $cn;
    if (isset($_POST['SignIn'])) {
        $Name_Email = $_POST['Name_Email'];
        $Password = $_POST['Password'];

        if (!empty($Name_Email) && !empty($Password)) {
            $Password = md5($Password);
            $sql = "SELECT * FROM `tbluser` WHERE (`Username`='$Name_Email' OR `Email`='$Name_Email') AND `Password`='$Password'";
            $rs = $cn->query($sql);
            $row = $rs->fetch_assoc();

            if ($row) {
                $_SESSION['id'] = $row['SignupID'];
                header("location:index.php");
                exit();
            } else {
                echo "<script>swal('Please Enter again!', 'Invalid username/email or password.', 'error');</script>";
            }
        } else {
            echo "<script>swal('Error!', 'All fields are required.', 'error');</script>";
        }
    }
    }

SignIn();

    function logout(){
    
    if(isset($_POST['btn-logout'])){
       unset($_SESSION['id']);
       header("location:login.php");
    }
    }
// ----------------- End section ---------------

    // -------------- Start Section Student ----------------

    function Student_Register(){
        global $cn;
        if(isset($_POST['Insert_Student'])){
            $NameLatin = $_POST['NameLatin'];
            $NameInKhmer = $_POST['NameKhmer'];
            $FamilyName = $_POST['FamalyName'];
            $PhoneNumber = $_POST['PhoneNumber'];
            $Passport = $_POST['Passport'];
            $Email = $_POST['Email'];
            $CurrentAdress = $_POST['CurrentAdress'];
            $CurrentAdressPP = $_POST['CurrentAdressPP'];
            $Gender = $_POST['Gender'];
            $GivenName = $_POST['GivenName'];
            $Country = $_POST['Country'];
            $Nationality = $_POST['Nationality'];
            $DOB = $_POST['DOB'];
            $POB = $_POST['POB'];
            $RegisterDate = $_POST['RegisterDate'];
            $Profile = $_FILES['Profile']['name'];
            $Profile = rand(1,9999).'-'. $_FILES['Profile']['name'];
            $part = "img/".$Profile;
            move_uploaded_file($_FILES['Profile']['tmp_name'],$part);
                $sql = "INSERT INTO `tblstudentinfo` (`NameInLatin`,`NameInKhmer`,`GivenName`, `FamilyName`,
                `SexID`, `IDPassportNo`, `NationalityID`, `CountryID`, `DOB`,`POB`,`PhoneNumber`, `Email`,
                `CurrentAddress`, `CurrentAddressPP`, `Photo`, `RegisterDate`) 
                VALUES ('$NameLatin','$NameInKhmer','$FamilyName','$GivenName','$Gender','$Passport',
                '$Nationality','$Country','$DOB','$POB','$PhoneNumber','$Email','$CurrentAdress',
                '$CurrentAdressPP','$Profile','$RegisterDate')";
                $rs = $cn->query($sql);
                if($rs){
                    echo "<script>
                            Swal.fire('Successful!', 'Lecturer added successfully!', 'success');
                          </script>";  
                } else {
                    echo "<script>
                            Swal.fire('Error!', 'Failed to add lecturer.', 'error');
                          </script>";
                }
        }
    }
    Student_Register();

    function Update_Student(){
        global $cn;
        if(isset($_POST['Save_Change'])){
            $id = $_POST['id'];
            $NameLatin = $_POST['NameLatin'];
            $NameInKhmer = $_POST['NameKhmer'];
            $FamilyName = $_POST['FamalyName'];
            $PhoneNumber = $_POST['PhoneNumber'];
            $Passport = $_POST['Passport'];
            $Email = $_POST['Email'];
            $CurrentAdress = $_POST['CurrentAdress'];
            $CurrentAdressPP = $_POST['CurrentAdressPP'];
            $Gender = $_POST['Gender'];
            $GivenName = $_POST['GivenName'];
            $Country = $_POST['Country'];
            $Nationality = $_POST['Nationality'];
            $DOB = $_POST['DOB'];
            $POB = $_POST['POB'];
            $RegisterDate = $_POST['RegisterDate'];
            $Profile = $_FILES['Profile']['name'];
            $Profile = rand(1,9999).'-'. $_FILES['Profile']['name'];
            $part = "img/".$Profile;
            move_uploaded_file($_FILES['Profile']['tmp_name'],$part);
            $sql = "UPDATE `tblstudentinfo` SET `NameInKhmer`='$NameInKhmer',`NameInLatin`='$NameLatin',
            `FamilyName`='$FamilyName',`GivenName`='$GivenName',`SexID`='$Gender',`IDPassportNo`='$Passport',
            `NationalityID`='$Nationality',`CountryID`='$Country',`DOB`='$DOB',`POB`='$POB',
            `PhoneNumber`='$PhoneNumber',`Email`='$Email',`CurrentAddress`='$CurrentAdress',
            `CurrentAddressPP`='$CurrentAdressPP',`Photo`='$Profile',`RegisterDate`='$RegisterDate' WHERE `StudentID`=$id";
            $rs = $cn->query($sql);
            if($rs){
                echo "<script>
                        Swal.fire('Successful!', 'Lecturer added successfully!', 'success');
                      </script>";  
            } else {
                echo "<script>
                        Swal.fire('Error!', 'Failed to add lecturer.', 'error');
                      </script>";
            }
        }
    }
    Update_Student();

    function Delete_Student(){
        global $cn;
        if(isset($_GET['Remove_Student'])){
            $id = $_GET['Remove_Student'];
            $sql ="DELETE FROM `tblstudentinfo` WHERE StudentID=$id";
            $rs = $cn->query($sql);
        }
    }
    Delete_Student();
    function Get_Detail(){
        global $cn;
        if(isset($_GET['Get_Detail'])){
            $id = $_GET['Get_Detail'];
            $sql = "SELECT * FROM tblstudentinfo WHERE StudentID = $id";
            $rs = $cn->query($sql);
        }
    }
    Get_Detail();

    // <-------------- End Section Student ----------------|

    // -------------- Start Section Subject ---------------->
    
    function Insert_Subject(){
        global $cn;
        if(isset($_POST['Subject_Insert'])){
            $SubjectKH = $_POST['SubjectKH'];
            $SubjectEN = $_POST['SubjectEN'];
            $Credit = $_POST['Credit'];
            $Hour = $_POST['Hour'];
            $Faculty = $_POST['Faculty'];
            $Semester = $_POST['Semester'];
            $Year = $_POST['Year'];
            $Major = $_POST['Major'];
            $sql = "INSERT INTO `tblsubject`(`SubjectKH`, `SubjectEN`, `CreditNumber`, 
            `Hours`, `FacultyID`, `MajorID`, `YearID`, `SemesterID`) 
            VALUES ('$SubjectKH','$SubjectEN',$Credit,$Hour,'$Faculty',
            '$Major','$Year','$Semester')";
            $rs = $cn->query($sql);
            if($rs){
                echo "<script>
                        Swal.fire('Successful!', 'Lecturer added successfully!', 'success');
                      </script>";  
            } else {
                echo "<script>
                        Swal.fire('Error!', 'Failed to add lecturer.', 'error');
                      </script>";
            }
        }
    }
    Insert_Subject();

    function Update_Subject(){
        global $cn;
        if(isset($_POST['Subject_Update'])){
            $id = $_POST['Subject_id'];
            $SubjectKH = $_POST['SubjectKH'];
            $SubjectEN = $_POST['SubjectEN'];
            $Credit = $_POST['Credit'];
            $Hour = $_POST['Hour'];
            $Faculty = $_POST['Faculty'];
            $Semester = $_POST['Semester'];
            $Year = $_POST['Year'];
            $Major = $_POST['Major'];
            $sql = "UPDATE `tblsubject` SET `SubjectKH`='$SubjectKH',`SubjectEN`='$SubjectEN',
            `CreditNumber`=$Credit,`Hours`=$Hour,`FacultyID`='$Faculty',`MajorID`='$Major',
            `YearID`='$Year',`SemesterID`='$Semester' 
            WHERE `SubjectID`=$id";
            $rs = $cn->query($sql);
            if($rs){
                echo "<script>
                        Swal.fire('Successful!', 'Lecturer added successfully!', 'success');
                      </script>";  
            } else {
                echo "<script>
                        Swal.fire('Error!', 'Failed to add lecturer.', 'error');
                      </script>";
            }
        }
    }
    Update_Subject();   

    function Deleted_Subject(){
        global $cn;
        if(isset($_GET['Remove_Subject'])){
            $id = $_GET['Remove_Subject'];
            $sql ="DELETE FROM `tblsubject` WHERE SubjectID=$id";
            $rs = $cn->query($sql);
        }
    }
    Deleted_Subject();
    
    function GetView_Subject(){
        global $cn;
        $sql = "SELECT 
        tblsubject.SubjectID,
        tblsubject.SubjectKH,
        tblsubject.SubjectEN,
        tblsubject.CreditNumber,
        tblsubject.Hours,
        tblfaculty.FacultyEN,
        tblsemester.SemesterEN,
        tblmajor.MajorEN,tblyear.YearEN,
        tblfaculty.FacultyID,
        tblmajor.MajorID,tblyear.YearID,
        tblsemester.SemesterID
        FROM tblsubject
            INNER JOIN tblfaculty ON tblsubject.FacultyID = tblfaculty.FacultyID
            INNER JOIN tblmajor ON tblsubject.MajorID = tblmajor.MajorID
            INNER JOIN tblsemester ON tblsubject.SemesterID = tblsemester.SemesterID
            INNER JOIN tblyear ON tblsubject.YearID = tblyear.YearID";
             $rs = $cn->query($sql);
             if($rs){
                 while($row = $rs->fetch_assoc()){
                     $id = $row['SubjectID'];
                     echo "<tr>";
                     echo "<td>".$row['SubjectID']."</td>";
                     echo "<td>".$row['SubjectEN']."</td>";
                     echo "<td data-faculty-id='".$row['FacultyID']."'>".$row['FacultyEN']."</td>";
                     echo "<td data-year-id='".$row['YearID']."'>".$row['YearEN']."</td>";
                     echo "<td data-semester-id='".$row['SemesterID']."'>".$row['SemesterEN']."</td>";
                     echo "<td data-major-id='".$row['MajorID']."'>".$row['MajorEN']."</td>";
                     echo "<td>".$row['CreditNumber']."</td>";
                     echo "<td>".$row['Hours']."</td>";
                     echo '
                     <td>
                     <div class="dropdown">
                         <button class="btn" type="button" id="dropdownMenuButton"
                             data-bs-toggle="dropdown" aria-expanded="false">
                             <i class="bi bi-three-dots-vertical"></i>
                         </button>
                         <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                             <li><a class="dropdown-item" href="ViewDetail.php"><i class="bi bi-eye-fill"></i>
                                     View</a></li>
                             <li><a class="dropdown-item" id="UpdateSubject" href="#" data-bs-toggle="modal"
                             data-bs-target="#subjectModal"><i
                                         class="bi bi-pencil-fill"></i> Update</a></li>
                             <li><a class="dropdown-item" href="#" onclick="deleteSubject('.$row['SubjectID'].')"><i
                                         class="bi bi-trash-fill"></i> Delete</a></li>
                         </ul>
                     </div>
                     </td>
                     ';
                     echo "</tr>";
                 }
             }
    }
    // <--------------- End Section Subject -----------------
    // ------------ javascript ------------
    include("Library_Javascript.php");
    // ------------------------------------
?>