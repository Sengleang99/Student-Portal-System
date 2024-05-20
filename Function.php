<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
    include('Header.php');
    $cn= new mysqli("localhost","root","","student_portal_management");
// ----------------- end section ---------------

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
            $Profile = $_FILES['Photo']['name'];
            $Profile = rand(1,9999).'-'. $_FILES['Photo']['name'];
            $part = "image/".$Profile;
            move_uploaded_file($_FILES['Photo']['tmp_name'],$part);
                $sql = "INSERT INTO `tblstudentinfo` (`NameInLatin`,`NameInKhmer`,`GivenName`, `FamilyName`, `SexID`, `IDPassportNo`, `NationalityID`, `CountryID`, `DOB`,`POB`,`PhoneNumber`, `Email`, `CurrentAddress`, `CurrentAddressPP`, `Photo`, `RegisterDate`) 
                VALUES ('$NameLatin','$NameInKhmer','$FamilyName','$GivenName','$Gender','$Passport','$Nationality','$Country','$DOB','$POB','$PhoneNumber','$Email','$CurrentAdress','$CurrentAdressPP','$Profile','$RegisterDate')";
                $rs = $cn->query($sql);
                if($rs){
                    echo '
                        <script>
                            swal("Success!", "You clicked the button!", "success");
                        </script>
                    ';
                }else{
                    echo '
                        <script>
                            swal("Error");
                        </script>
                    ';
                   
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
            $sql = "UPDATE `tblstudentinfo` SET `NameInKhmer`='$NameInKhmer',`NameInLatin`='$NameLatin',`FamilyName`='$FamilyName',`GivenName`='$GivenName',`SexID`='$Gender',`IDPassportNo`='$Passport',`NationalityID`='$Nationality',`CountryID`='$Country',`DOB`='$DOB',`POB`='$POB',`PhoneNumber`='$PhoneNumber',`Email`='$Email',`CurrentAddress`='$CurrentAdress',`CurrentAddressPP`='$CurrentAdressPP',`RegisterDate`='$RegisterDate' WHERE `StudentID`=$id";
            $rs = $cn->query($sql);
                if($rs){
                    echo '
                        <script>
                            swal("Success!", "You clicked the button!", "Update successfullly!");
                        </script>
                    ';
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
    function Getview_Student(){
        global $cn;
        $sql = "SELECT tblstudentinfo.StudentID, tblstudentinfo.NameInLatin,tblstudentinfo.NameInKhmer,
        tblstudentinfo.Email, tblstudentinfo.PhoneNumber, tblstudentinfo.DOB, 
        tblstudentinfo.CurrentAddress, tblstudentinfo.CurrentAddressPP, tblsex.SexEN, tblcountry.CountryEN, 
        tblnationality.NationalityEN,tblsex.SexID,tblstudentinfo.RegisterDate,tblstudentinfo.Photo,
        tblcountry.CountryID,tblnationality.NationalityID,tblstudentinfo.POB
        FROM tblstudentinfo
            INNER JOIN tblsex ON tblstudentinfo.SexID = tblsex.SexID
            INNER JOIN tblcountry ON tblstudentinfo.CountryID = tblcountry.CountryID
            INNER JOIN tblnationality ON tblstudentinfo.NationalityID = tblnationality.NationalityID";
        $rs = $cn->query($sql);
        if($rs){
            while($row = $rs->fetch_assoc()){
                $id = $row['StudentID'];
                echo "<tr>";
                echo "<td>".$row['StudentID']."</td>";
                echo "<td hidden>".$row['NameInKhmer']."</td>";
                echo "<td>".$row['NameInLatin']."</td>";
                echo "<td data-gender-id='".$row['SexID']."'>".$row['SexEN']."</td>";
                echo "<td>".$row['PhoneNumber']."</td>";
                echo "<td>".$row['Email']."</td>";
                echo "<td>".$row['CurrentAddress']."</td>";
                echo "<td hidden>".$row['CurrentAddressPP']."</td>";
                echo "<td hidden>".$row['DOB']."</td>";
                echo "<td hidden>".$row['POB']."</td>";
                echo "<td hidden data-country-id='".$row['CountryID']."'>".$row['CountryEN']."</td>";
                echo "<td hidden data-nationality-id='".$row['NationalityID']."'>".$row['NationalityEN']."</td>";
                echo "<td hidden>".$row['RegisterDate']."</td>";
                echo "<td hidden>".$row['Photo']."</td>";
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
                        <li><a class="dropdown-item" id="UpdateStudent" href="#" data-bs-toggle="modal"
                        data-bs-target="#studentModal"><i
                                    class="bi bi-pencil-fill"></i> Update</a></li>
                        <li><a type="submit" class="dropdown-item" href="Studentinfor.php?Remove_Student='.$id.'"><i
                                    class="bi bi-trash-fill"></i> Delete</a></li>
                    </ul>
                </div>
                </td>
                ';
                echo "</tr>";
            }
        }
    }
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
            $sql = "INSERT INTO `tblsubject`(`SubjectKH`, `SubjectEN`, `CreditNumber`, `Hours`, `FacultyID`, `MajorID`, `YearID`, `SemesterID`) 
            VALUES ('$SubjectKH','$SubjectEN',$Credit,$Hour,'$Faculty','$Major','$Year','$Semester')";
            $rs = $cn->query($sql);
            if($rs){
                echo '
                <script>
                    swal("Success!", "You clicked the button!", "success");
                </script>
            ';
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
            $sql = "UPDATE `tblsubject` SET `SubjectKH`='$SubjectKH',`SubjectEN`='$SubjectEN',`CreditNumber`=$Credit,`Hours`=$Hour,`FacultyID`='$Faculty',`MajorID`='$Major',`YearID`='$Year',`SemesterID`='$Semester' 
            WHERE `SubjectID`=$id";
            $rs = $cn->query($sql);
            if($rs){
                echo '
                    <script>
                        swal("Success!", "You clicked the button!", "Edit successfullly!");
                    </script>
                ';
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
        $sql = "SELECT tblsubject.SubjectID,tblsubject.SubjectKH,tblsubject.SubjectEN,tblsubject.CreditNumber,
        tblsubject.Hours,tblfaculty.FacultyEN,tblsemester.SemesterEN,tblmajor.MajorEN,tblyear.YearEN,
        tblfaculty.FacultyID,tblmajor.MajorID,tblyear.YearID,tblsemester.SemesterID
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
                             <li><a type="submit" class="dropdown-item" href="Subject.php?Remove_Subject='.$id.'"><i
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
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $sql="SELECT * FROM `tblmajor` WHERE `FacultyID` = $id";
        $rs = $cn->query($sql);      
            $out = '';        
            while ($row = $rs->fetch_assoc()) {
                $out .= '<option value="'.$row['MajorID'].'">'.$row['MajorEN'].'</option>';
            }   
            echo $out;
    }
    // -------------- dependent select dropdown query --------------------

// ------------ javascript ------------
include("Library_Javascript.php");
// ------------------------------------
?>