    <?php
    $cn= new mysqli("localhost","root","","student_portal_management");
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="students.xls"');
    header('Cache-Control: max-age=0');

    // Fetch data from the database
    $sql = "SELECT 
        tblstudentinfo.StudentID,
        tblstudentinfo.NameInLatin,
        tblstudentinfo.NameInKhmer,
        tblstudentinfo.Email, 
        tblstudentinfo.PhoneNumber, 
        tblstudentinfo.DOB,
        tblstudentinfo.POB,
        tblstudentinfo.CurrentAddress, 
        tblstudentinfo.CurrentAddressPP, 
        tblsex.SexEN,
        tblcountry.CountryEN, 
        tblnationality.NationalityEN,
        tblstudentinfo.RegisterDate
        FROM tblstudentinfo 
        INNER JOIN tblsex ON tblstudentinfo.SexID = tblsex.SexID
        INNER JOIN tblcountry ON tblstudentinfo.CountryID = tblcountry.CountryID
        INNER JOIN tblnationality ON tblstudentinfo.NationalityID = tblnationality.NationalityID
        ORDER BY tblstudentinfo.StudentID DESC";
    $result = $cn->query($sql);

    echo "<table border='1'>";
    echo "<tr>
        <th>ID</th>
        <th>Name Khmer</th>
        <th>Name Latin</th>
        <th>Email</th>
        <th>Phone Number</th>
        <th>DOB</th>
        <th>POB</th>
        <th>Current Address</th>
        <th>Current Address PP</th>
        <th>Gender</th>
        <th>Country</th>
        <th>Nationality</th>
        <th>Register Date</th>
    </tr>";

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['StudentID']}</td>
                <td>{$row['NameInKhmer']}</td>
                <td>{$row['NameInLatin']}</td>
                <td>{$row['Email']}</td>
                <td>{$row['PhoneNumber']}</td>
                <td>{$row['DOB']}</td>
                <td>{$row['POB']}</td>
                <td>{$row['CurrentAddress']}</td>
                <td>{$row['CurrentAddressPP']}</td>
                <td>{$row['SexEN']}</td>
                <td>{$row['CountryEN']}</td>
                <td>{$row['NationalityEN']}</td>
                <td>{$row['RegisterDate']}</td>
            </tr>";
        }
    }
    echo "</table>";



    ?>