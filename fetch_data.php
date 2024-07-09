<?php 


      $cn= new mysqli("localhost","root","","student_portal_management");
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

   

?>