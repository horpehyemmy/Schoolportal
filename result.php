<!DOCTYPE html>
<html>
    <head>
            <link rel="stylesheet" type="text/css" href="stylesheets/sheet.css"/>
    </head>
<body>




    <div>

        <div id= "header">
            <h1 id=header>PECULIAR COLLEGE</h1>
            <p id=header>....Knowledge comes, but wisdom linger </p>

        </div>



                <div id= sidebar>
                </div>


        <div class="box">
                <?php include("connection.php"); ?>
            <div id= "main">
                <?php $post_username=$_POST['username']; ?>
                <?php $result = mysql_query("SELECT                                                                        students.id,students.last_name,students.first_name,students.other_name,students.matric_number,departments.name
                FROM students
                JOIN departments ON students.department_id=departments.id
                WHERE matric_number= '$post_username'")  or die(mysql_error()) ;
                $num_rows = mysql_num_rows($result);
                if($num_rows == 0){
                    echo "<h2>matric number not in our database</h2>";
                    echo "<b><h3><a href='login.php'>return to login page</a></h3></b>";
                    exit();
                }
                $std_details = mysql_fetch_array($result);

                if(isset($_POST['check'])){
                 $session = $_POST['session_id'];
                 $semester=$_POST['semester_id'];
                 

            $result =  mysql_query("SELECT students.matric_number, sessions.name AS session,semesters.name AS semester,courses.code,courses.title,courses.unit,assessments.id,assessments.name,assessment_id,max_score,score 
            FROM student_results
            JOIN sessions ON student_results.session_id=sessions.id
            JOIN semesters ON student_results.semester_id=semesters.id
            JOIN courses ON student_results.course_id=courses.id
            JOIN assessments ON student_results.assessment_id=assessments.id
            JOIN students ON student_results.student_id=students.id
            WHERE students.matric_number = '$post_username'
            AND sessions.id = $session
            AND   semesters.id = $semester ORDER BY student_results.course_id ASC") or die(mysql_error());

              }


                ?>


                <h1>Result</h1>
                <br>



                                                 <br>

        <form action="" method="post">
            <h4>
            <?php  if(isset($std_details)){ ?>
          <b class="change">Name :-</b><?php echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp".$std_details{'last_name'}."   ".$std_details{'first_name'}."   ".$std_details{'last_name'}."<br><br><hr>";?>
           <b class="change">Matric-Number :-</b><?php  echo "&nbsp&nbsp&nbsp&nbsp".$std_details{'matric_number'}."<br><br><hr>";?>
           <b class="change">Department :-</b> <?php  echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp".$std_details{'name'}."<br><br><hr>";?>

            <?php } ?>

            <?php 
            if(isset($_POST['check'])){
            $sql=  mysql_query("SELECT sessions.name AS session,semesters.name AS semester,students.matric_number
            FROM student_results
            JOIN sessions ON student_results.session_id=sessions.id
            JOIN semesters ON student_results.semester_id=semesters.id
            JOIN students ON student_results.student_id=students.id
            WHERE students.matric_number = '$post_username'
            AND sessions.id = $session
            AND   semesters.id = $semester") or die(mysql_error());
           $fetch=mysql_fetch_array($sql);
          echo "<b class='change'>Session :-</b>  
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp".$fetch{'session'}."<br><br><hr>";
            echo "<b class='change'>Semester :-</b>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp".$fetch{'semester'}."<br><br><hr>";
}?>

            </h4>
        </form>

                <br>

                 <form action="<?php $_POST['username']?>" method="post">
                <b>Session =></b>
                       <select name="session_id">
                       <?php $sess_pick= mysql_query("SELECT * FROM sessions ORDER BY name DESC");
                           while ($row = mysql_fetch_array($sess_pick)){
                           echo "<option value=\"{$row['id']}\">".$row{'name'}."</option>";
                           }?>
                       </select>
                    &nbsp; &nbsp;
                <b>Semester =></b>
                       <select name="semester_id">
                       <?php $seme_pick= mysql_query("SELECT * FROM semesters");
                           while($row = mysql_fetch_array($seme_pick)){
                               echo "<option value=\"{$row['id']}\">".$row{'name'}."</option>";
                           }?>


                        </select>
                    <input type="hidden" name="username" value="<?php echo $_POST['username']?>" />
                    <input class="tt" type="submit" name="check" value="Check"/>
                   </form>



                <table>
            <tr>


                 <?php $student_results = array();
                    if(mysql_num_rows($result) > 0){
                    while($row = mysql_fetch_array($result)){
                        $student_results[] = $row;//outputs the result row by row
                    }
                    }
                    else{
                    echo "<td colspan='6'>.No records for this session</td></tr>";
                    exit();
                        }
                    $result_display = array();
                    foreach($student_results as $student_result){
                    $course_code = $student_result['code'];
                    $course_title = $student_result['title'];
                    $course_unit = $student_result['unit'];
                    $new = $course_code." ,".$course_title." ,".$course_unit;
                    $result_display[$new][] = $student_result;
                                                                }

                ?>
                <?php
                    $query = mysql_query("SELECT * FROM assessments ORDER BY id ASC");
                    $assessments = array();
                    if(mysql_num_rows($query) > 0){
                    while($row = mysql_fetch_array($query)){
                    $assessments[] = $row; //outputs the result row by row
                    }

                        }
                        else{
                          echo "<td>no assessments</td>";
                        }
                ?>
                
                <?php
                
                ?>




                <?php  if(isset($_POST['check'])){?>
                <th class="">S/No</th>
                <th>COURSE CODE</th>
                <th>COURSE TITLE</th>
                <?php
			    foreach($assessments as $assessment){
				 echo "<th>".$assessment['name']. "</th>";
                }
			     ?>
                <th>TOTAL (100)</th>
                <th>GRADE</th>
                <th>UNIT</th></tr>
               <?php } ?>




                    <tr>
                        <?php
                           
                            $counter=1;
                            $total =0;
                        $qq =0;
                         
                            foreach($result_display as $new => $values){
                                $add = 0;
                                list($course_code,$course_unit) = explode(",",$new);
                            $display = explode(",",$new);
                           echo "<td class='y'>".$counter."</td>";
                            echo"<td>".$display[0]."</td>";
                                echo"<td>".$display[1]."</td>";
                                 $total += $display[2];

                            foreach($assessments as $assessment){
                            foreach($values as $val){
                                
                                if($val['assessment_id'] == $assessment['id']){
                                    echo "<td>".$val['score']."</td>";
                                   
                                    $add += $val['score'];
                                    
                    

                                }
                               

                            }
                                
                                
                                

                        }
                        
                             
                                
                                
                                
                    echo "<td>".$add."</td>" ;
                              $val++;
                         $result = mysql_query("SELECT * FROM grades");
                                
                                
                                if(mysql_num_rows($result) > 0){
                            while($row = mysql_fetch_array($result)){
                                global $add;
                                
                                if ($add >= $row{'lower_limit'} && $add <= $row{'upper_limit'}){
                                echo "<td>".$row{'name'}."</td>";
                                    $qwer = $row{'points'} * $display[2];
                                    
                                
                                   
                                    $qq += $qwer;
                                    $gp = $qq / $total;
                                   
                                     }
                            
                                
                            
                                }    
                                
                                }
                                
                        echo"<td>".$display[2]."</td>";
                                $counter++;
                              echo"</tr>";
                           
                        

                       
                      
                                
}
                        echo  "<tr>";
                    
                            
                        
                            echo "<td colspan='100' class='explicit'><br></td>"; 
                            
                            
                       echo "</tr>";
                        ?>
                </table>

        <br><br>

            <br> <br>
            <br> <br>
                <?php if (isset($_POST['check'])){ ?>
            <marquee><h3>Grade Point Average (GPA) ==> &nbsp;<?php echo number_format($gp,2);?>
                <?php  ?></h3></marquee>
            <?php } ?>
        </div>
            <br><br>
            <div id="link">
            <a href="#" onclick="window.print()">Print</a> &nbsp;|
                &nbsp;<a href="login.php">Logout</a>
            </div>
                </div>
    </div>
     <p class="clear" />


            <div id="footer"><p>&copy;peculiar university</p></div>
    <?php
            if(isset($connection))
            {
            mysql_close($connection);
            }
        ?>
    </body>
</html>
