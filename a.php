<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js">
</script>
<script> 
$(document).ready(function(){
  $("#personalInfo").click(function(){
    $("#academicResultShow").hide("slow");
    $("#personalInfoShow").slideDown("slow");
  });
  $("#academicResult").click(function(){
    $("#personalInfoShow").hide("slow");
    $("#academicResultShow").slideDown("slow");
  });
});
</script>
 
<style type="text/css"> 
#personalInfoShow,#academicResultShow
{
display:none;
}
</style>
 
 

<div align="center">
<input id="personalInfo" type="button" style="width:200px;height:30px;" value="Personal Profile" >
<input id="academicResult" type="button" style="width:200px;height:30px;" value="SIIS(Academic Result)" >
</div>
</br>
<div id="personalInfoShow">
<?
echo "
<div class=gallery_box>
    <a href=images/students/$image class='pirobox gallery_img image_wrapper' title='$full ($nick)'><img src=images/students/$image width=200px; height=170px; alt='$full ($nick)' /></a>
    <div class=right>
     <h5>$full ($nick)</h5>
      <p><em>Registration No: $reg</em></p>
        <strong>Home Distict</strong>:<p  class=justify>$home</p>                       
       <strong>College</strong>:<p  class=justify>$college</p> 
    <strong>School</strong>:<p  class=justify>$school</p> ";
    if ($reg == 2010331001 || $reg == 2010331015 || $reg == 2010331022 || 
    $reg == 2010331027 || $reg == 2010331039 || $reg == 2010331042 || 
    $reg == 2010331045 || $reg == 2010331060 || $reg == 2010331068 )
    {
    echo "<strong>Mobile</strong>:<p  class=justify>$mobile [Your Number is hidden in Studnet Info Page]</p> ";
    }
    else
    {
    echo "<strong>Mobile</strong>:<p  class=justify>$mobile</p> ";
    }   
        echo"
    <strong>Email</strong>: <a href=mailto:$email>$email</a>
    
<h4 align=right ><a  href=javascript:Popup('students_info_edit.php')>Edit Your Info</a></h4>
  
  

     </div>
     
 <div class=cleaner></div>
</div>"; ?>
</div>

<div id="academicResultShow">
<script>
function graph()
{
newwindow=window.open('include/graph.php','Result Graph ','height=500,width=800,top=50,left=200');

}
</script>

<?
if ($_SESSION['valid'] == 1)
{
    $full=$_SESSION['full'];
    $reg=$_SESSION['reg'];
    echo "<h2 align=center >SUST Institutional Information System (SIIS)</h2>";
echo "<h4 align=center>$full || $reg</h4>"; 
echo"<div align=center><input type=button onclick='graph()' value='Show CGPA Vs Semester Result Graph' /></div>"; 
?>

<?
include("include/connect_result.php");
//~~~~~Result Process Starts...........>>>>


$final_total_credit=0;
$final_complete_credit=0;
$final_drop_credit=0;
$final_total_gpa=0;
$final_cgpa=0;


/////1st Year-1st Semester Result Calculation/////////

//@@@Subject Collect ####
$sub_11_sub;
$sub_11_name;
$sub_11_credit;
$count_11=0;
$sub_11="SELECT * FROM 1_1 where available=1 order by sub";
$sub_11_get_process=mysql_query($sub_11);
while($sub_11_get = mysql_fetch_array($sub_11_get_process))
        {
            $sub_11_sub[$count_11]=$sub_11_get['sub'];
            $sub_11_name[$count_11]=$sub_11_get['name'];
            $sub_11_credit[$count_11]=$sub_11_get['credit'];
            $count_11++;
        }
}


////@@ Result Collect ###
$reg=$_SESSION['reg'];
$result_11_sub;
$result_11_name;
$result_11_credit;
$result_11_gpa;
$j=0;
for ($i=0;$i<$count_11 ; $i++) {
    $sub_code=$sub_11_sub[$i];
    $sub_name=$sub_11_name[$i];
    $sub_credit=$sub_11_credit[$i];

    $sub_11_result_process=mysql_query("SELECT * FROM $sub_code WHERE reg= '$reg' ");
    $result_got=mysql_fetch_array($sub_11_result_process);
    if ($result_got['gpa'] != NULL)
    {
        $result_11_sub[$j]= $sub_code;
        $result_11_name[$j]=$sub_name;
        $result_11_credit[$j]=$sub_credit;
        $result_11_grade[$j]=$result_got['gpa'];
        $j++;
    }


}

////@@@ Result Publish Process

//######Credit Count & GPA Count
$total_credit_11=0;
$total_gpa_11=0;
$drop_credit_11=0;
$result_11_gpa;
for ($m=0;$m<$j;$m++){

    $total_credit_11=$total_credit_11+$result_11_credit[$m];
    $grade=$result_11_grade[$m];
    if ($grade == "A+")
    {
        $gpa=4.00;
        $result_11_gpa[$m]=4;
    }
    else if ($grade == "A")
    {
        $gpa=3.75;
        $result_11_gpa[$m]=3.75;
    }
    else if ($grade == "A-")
    {
        $gpa=3.50;
        $result_11_gpa[$m]=3.50;
    }
    if ($grade == "B+")
    {
        $gpa=3.25;
        $result_11_gpa[$m]=3.25;
    }
    else if ($grade == "B")
    {
        $gpa=3.00;
        $result_11_gpa[$m]=3;
    }
    else if ($grade == "B-")
    {
        $gpa=2.75;
        $result_11_gpa[$m]=2.75;
    }
    if ($grade == "C+")
    {
        $gpa=2.50;
        $result_11_gpa[$m]=2.5;
    }
    else if ($grade == "C")
    {
        $gpa=2.25;
        $result_11_gpa[$m]=2.25;
    }
    else if ($grade == "C-")
    {
        $gpa=2;
        $result_11_gpa[$m]=2;
    }
    else if ($grade == "F")
    {
        $gpa=0;
        $result_11_gpa[$m]=0;
        $drop_credit_11=$drop_credit_11+$result_11_credit[$m];
    }
    $indi_gpa=$gpa*$result_11_credit[$m];
    $total_gpa_11=$total_gpa_11+$indi_gpa;
}

//@@@ CGPA Calculation
$total_credit_pass_11=$total_credit_11-$drop_credit_11;
if ($total_credit_pass_11 != 0)
{
$gpa_11=$total_gpa_11/$total_credit_pass_11;
}
$gpa_11= round($gpa_11,2);
$_SESSION['gpa_11']=$gpa_11;

//@@@@ sum of total result
$final_total_credit=$final_total_credit+$total_credit_11;
$final_complete_credit=$final_complete_credit+$total_credit_pass_11;
$final_drop_credit=$final_drop_credit+$drop_credit_11;
$final_total_gpa=$final_total_gpa+$total_gpa_11;
$final_cgpa=$final_total_gpa/$final_complete_credit;
$_SESSION['cgpa_11']=round($final_cgpa,2);


/////1st Year-2nd Semester Result Calculation/////////

//@@@Subject Collect ####
$sub_12_sub;
$sub_12_name;
$sub_12_credit;
$count_12=0;
$sub_12="SELECT * FROM 1_2 where available=1 order by sub";
$sub_12_get_process=mysql_query($sub_12);
while($sub_12_get = mysql_fetch_array($sub_12_get_process))
{
    $sub_12_sub[$count_12]=$sub_12_get['sub'];
    $sub_12_name[$count_12]=$sub_12_get['name'];
    $sub_12_credit[$count_12]=$sub_12_get['credit'];
    $count_12++;
}


////@@ Result Collect ###
$reg=$_SESSION['reg'];
$result_12_sub;
$result_12_name;
$result_12_credit;
$result_12_gpa;
$k=0;
for ($i=0;$i<$count_12 ; $i++) {
    $sub_code=$sub_12_sub[$i];
    $sub_name=$sub_12_name[$i];
    $sub_credit=$sub_12_credit[$i];

    $sub_12_result_process=mysql_query("SELECT * FROM $sub_code WHERE reg= '$reg' ");
    $result_got=mysql_fetch_array($sub_12_result_process);
    if ($result_got['gpa'] != NULL)
    {
        $result_12_sub[$k]= $sub_code;
        $result_12_name[$k]=$sub_name;
        $result_12_credit[$k]=$sub_credit;
        $result_12_grade[$k]=$result_got['gpa'];
        $k++;
    }


}

////@@@ Result Publish Process

//######Credit Count & GPA Count
$m=0;
$total_credit_12=0;
$total_gpa_12=0;
$drop_credit_12=0;
$result_12_gpa;
for ($m=0;$m<$k;$m++){

    $total_credit_12=$total_credit_12+$result_12_credit[$m];
    $grade=$result_12_grade[$m];
    if ($grade == "A+")
    {
        $gpa=4.00;
        $result_12_gpa[$m]=4;
    }
    else if ($grade == "A")
    {
        $gpa=3.75;
        $result_12_gpa[$m]=3.75;
    }
    else if ($grade == "A-")
    {
        $gpa=3.50;
        $result_12_gpa[$m]=3.50;
    }
    if ($grade == "B+")
    {
        $gpa=3.25;
        $result_12_gpa[$m]=3.25;
    }
    else if ($grade == "B")
    {
        $gpa=3.00;
        $result_12_gpa[$m]=3;
    }
    else if ($grade == "B-")
    {
        $gpa=2.75;
        $result_12_gpa[$m]=2.75;
    }
    if ($grade == "C+")
    {
        $gpa=2.50;
        $result_12_gpa[$m]=2.5;
    }
    else if ($grade == "C")
    {
        $gpa=2.25;
        $result_12_gpa[$m]=2.25;
    }
    else if ($grade == "C-")
    {
        $gpa=2;
        $result_12_gpa[$m]=2;
    }
    else if ($grade == "F")
    {
        $gpa=0;
        $result_12_gpa[$m]=0;
        $drop_credit_12=$drop_credit_12+$result_12_credit[$m];
    }
    $indi_gpa=$gpa*$result_12_credit[$m];
    $total_gpa_12=$total_gpa_12+$indi_gpa;
}

//@@@ CGPA Calculation
$total_credit_pass_12=$total_credit_12-$drop_credit_12;
if ($total_credit_pass_12 != 0)
{
$gpa_12=$total_gpa_12/$total_credit_pass_12;
}
$gpa_12= round($gpa_12,2);
$_SESSION['gpa_12']=$gpa_12;

//@@@@ sum of total result
$final_total_credit=$final_total_credit+$total_credit_12;
$final_complete_credit=$final_complete_credit+$total_credit_pass_12;
$final_drop_credit=$final_drop_credit+$drop_credit_12;
$final_total_gpa=$final_total_gpa+$total_gpa_12;
$final_cgpa=$final_total_gpa/$final_complete_credit;
$_SESSION['cgpa_12']=round($final_cgpa,2);


///////Drop Result Collection/////////
//////****** ALL SEMESTER *******////////

$drop_dilam=0;
$drop_get_process=mysql_query("SELECT * FROM `drop` WHERE reg='$reg' ");
while($drop_get = mysql_fetch_array($drop_get_process))
{
    $drop_sub[$drop_dilam]=$drop_get['sub'];
    $drop_semester[$drop_dilam]=$drop_get['semester'];
    $drop_name[$drop_dilam]=$drop_get['name'];
    $drop_credit[$drop_dilam]=$drop_get['credit'];
    $drop_grade[$drop_dilam]=$drop_get['grade'];
    $drop_gpa[$drop_dilam]=$drop_get['gpa'];
    if ($drop_grade[$drop_dilam] != "F")
    {
        //@@@@ sum of total result
        $final_complete_credit=$final_complete_credit+$drop_credit[$drop_dilam];
        $final_drop_credit=$final_drop_credit-$drop_credit[$drop_dilam];
        $final_total_gpa=$final_total_gpa+($drop_credit[$drop_dilam]*$drop_gpa[$drop_dilam]);
    }
    
    $drop_dilam++;
}







/////2nd Year-1st Semester Result Calculation/////////

//@@@Subject Collect ####
$sub_21_sub;
$sub_21_name;
$sub_21_credit;
$count_21=0;
$sub_21="SELECT * FROM 2_1 where available=1 order by sub";
$sub_21_get_process=mysql_query($sub_21);
while($sub_21_get = mysql_fetch_array($sub_21_get_process))
{
    $sub_21_sub[$count_21]=$sub_21_get['sub'];
    $sub_21_name[$count_21]=$sub_21_get['name'];
    $sub_21_credit[$count_21]=$sub_21_get['credit'];
    $count_21++;
}



////@@ Result Collect ###
$result_21_sub;
$result_21_name;
$result_21_credit;
$result_21_gpa;
$l=0;
for ($i=0;$i<$count_21 ; $i++) {
    $sub_code=$sub_21_sub[$i];
    $sub_name=$sub_21_name[$i];
    $sub_credit=$sub_21_credit[$i];

    $sub_21_result_process=mysql_query("SELECT * FROM $sub_code WHERE reg= '$reg' ");
    $result_got=mysql_fetch_array($sub_21_result_process);
    if ($result_got['gpa'] != NULL)
    {
        $result_21_sub[$l]= $sub_code;
        $result_21_name[$l]=$sub_name;
        $result_21_credit[$l]=$sub_credit;
        $result_21_grade[$l]=$result_got['gpa'];
        $l++;
    }


}

////@@@ Result Publish Process

//######Credit Count & GPA Count
$m=0;
$total_credit_21=0;
$total_gpa_21=0;
$drop_credit_21=0;
$result_21_gpa;
for ($m=0;$m<$l;$m++){

    $total_credit_21=$total_credit_21+$result_21_credit[$m];
    $grade=$result_21_grade[$m];
    if ($grade == "A+")
    {
        $gpa=4.00;
        $result_21_gpa[$m]=4;
    }
    else if ($grade == "A")
    {
        $gpa=3.75;
        $result_21_gpa[$m]=3.75;
    }
    else if ($grade == "A-")
    {
        $gpa=3.50;
        $result_21_gpa[$m]=3.50;
    }
    if ($grade == "B+")
    {
        $gpa=3.25;
        $result_21_gpa[$m]=3.25;
    }
    else if ($grade == "B")
    {
        $gpa=3.00;
        $result_21_gpa[$m]=3;
    }
    else if ($grade == "B-")
    {
        $gpa=2.75;
        $result_21_gpa[$m]=2.75;
    }
    if ($grade == "C+")
    {
        $gpa=2.50;
        $result_21_gpa[$m]=2.5;
    }
    else if ($grade == "C")
    {
        $gpa=2.25;
        $result_21_gpa[$m]=2.25;
    }
    else if ($grade == "C-")
    {
        $gpa=2;
        $result_21_gpa[$m]=2;
    }
    else if ($grade == "F")
    {
        $gpa=0;
        $result_21_gpa[$m]=0;
        $drop_credit_21=$drop_credit_21+$result_21_credit[$m];
    }
    $indi_gpa=$gpa*$result_21_credit[$m];
    $total_gpa_21=$total_gpa_21+$indi_gpa;
}

//@@@ CGPA Calculation
$total_credit_pass_21=$total_credit_21-$drop_credit_21;
if ($total_credit_pass_21 != 0)
{
$gpa_21=$total_gpa_21/$total_credit_pass_21;
}
$gpa_21= round($gpa_21,2);
$_SESSION['gpa_21']=$gpa_21;

//@@@@ sum of total result
$final_total_credit=$final_total_credit+$total_credit_21;
$final_complete_credit=$final_complete_credit+$total_credit_pass_21;
$final_drop_credit=$final_drop_credit+$drop_credit_21;
$final_total_gpa=$final_total_gpa+$total_gpa_21;
$final_cgpa=$final_total_gpa/$final_complete_credit;
$final_cgpa=round($final_cgpa,2);
$_SESSION['cgpa_21']=$final_cgpa;




/////2nd Year-2nd Semester Result Calculation/////////

//@@@Subject Collect ####
$sub_22_sub;
$sub_22_name;
$sub_22_credit;
$count_22=0;
$sub_22="SELECT * FROM 2_2 where available=1 order by sub";
$sub_22_get_process=mysql_query($sub_22);
while($sub_22_get = mysql_fetch_array($sub_22_get_process))
{
    $sub_22_sub[$count_22]=$sub_22_get['sub'];
    $sub_22_name[$count_22]=$sub_22_get['name'];
    $sub_22_credit[$count_22]=$sub_22_get['credit'];
    $count_22++;
}



////@@ Result Collect ###
$result_22_sub;
$result_22_name;
$result_22_credit;
$result_22_gpa;
$z=0;
for ($i=0;$i<$count_22 ; $i++) {
    $sub_code=$sub_22_sub[$i];
    $sub_name=$sub_22_name[$i];
    $sub_credit=$sub_22_credit[$i];

    $sub_22_result_process=mysql_query("SELECT * FROM $sub_code WHERE reg= '$reg' ");
    $result_got=mysql_fetch_array($sub_22_result_process);
    if ($result_got['gpa'] != NULL)
    {
        $result_22_sub[$z]= $sub_code;
        $result_22_name[$z]=$sub_name;
        $result_22_credit[$z]=$sub_credit;
        $result_22_grade[$z]=$result_got['gpa'];
        $z++;
    }


}

////@@@ Result Publish Process

//######Credit Count & GPA Count
$m=0;
$total_credit_22=0;
$total_gpa_22=0;
$drop_credit_22=0;
$result_22_gpa;
for ($m=0;$m<$z;$m++){

    $total_credit_22=$total_credit_22+$result_22_credit[$m];
    $grade=$result_22_grade[$m];
    if ($grade == "A+")
    {
        $gpa=4.00;
        $result_22_gpa[$m]=4;
    }
    else if ($grade == "A")
    {
        $gpa=3.75;
        $result_22_gpa[$m]=3.75;
    }
    else if ($grade == "A-")
    {
        $gpa=3.50;
        $result_22_gpa[$m]=3.50;
    }
    if ($grade == "B+")
    {
        $gpa=3.25;
        $result_22_gpa[$m]=3.25;
    }
    else if ($grade == "B")
    {
        $gpa=3.00;
        $result_22_gpa[$m]=3;
    }
    else if ($grade == "B-")
    {
        $gpa=2.75;
        $result_22_gpa[$m]=2.75;
    }
    if ($grade == "C+")
    {
        $gpa=2.50;
        $result_22_gpa[$m]=2.5;
    }
    else if ($grade == "C")
    {
        $gpa=2.25;
        $result_22_gpa[$m]=2.25;
    }
    else if ($grade == "C-")
    {
        $gpa=2;
        $result_22_gpa[$m]=2;
    }
    else if ($grade == "F")
    {
        $gpa=0;
        $result_22_gpa[$m]=0;
        $drop_credit_22=$drop_credit_22+$result_22_credit[$m];
    }
    $indi_gpa=$gpa*$result_22_credit[$m];
    $total_gpa_22=$total_gpa_22+$indi_gpa;
}

//@@@ CGPA Calculation
$total_credit_pass_22=$total_credit_22-$drop_credit_22;
if ($total_credit_pass_22 != 0)
{
$gpa_22=$total_gpa_22/$total_credit_pass_22;
}
$gpa_22= round($gpa_22,2);
$_SESSION['gpa_22']=$gpa_22;

//@@@@ sum of total result
$final_total_credit=$final_total_credit+$total_credit_22;
$final_complete_credit=$final_complete_credit+$total_credit_pass_22;
$final_drop_credit=$final_drop_credit+$drop_credit_22;
$final_total_gpa=$final_total_gpa+$total_gpa_22;
$final_cgpa=$final_total_gpa/$final_complete_credit;
$final_cgpa=round($final_cgpa,2);
$_SESSION['cgpa_22']=$final_cgpa;




/////3rd Year-1st Semester Result Calculation/////////

//@@@Subject Collect ####
$sub_31_sub;
$sub_31_name;
$sub_31_credit;
$count_31=0;
$sub_31="SELECT * FROM 3_1 where available=1 order by sub";
$sub_31_get_process=mysql_query($sub_31);
while($sub_31_get = mysql_fetch_array($sub_31_get_process))
{
    $sub_31_sub[$count_31]=$sub_31_get['sub'];
    $sub_31_name[$count_31]=$sub_31_get['name'];
    $sub_31_credit[$count_31]=$sub_31_get['credit'];
    $count_31++;
}



////@@ Result Collect ###
$result_31_sub;
$result_31_name;
$result_31_credit;
$result_31_gpa;
$ll=0;
for ($i=0;$i<$count_31 ; $i++) {
    $sub_code=$sub_31_sub[$i];
    $sub_name=$sub_31_name[$i];
    $sub_credit=$sub_31_credit[$i];

    $sub_31_result_process=mysql_query("SELECT * FROM $sub_code WHERE reg= '$reg' ");
    $result_got=mysql_fetch_array($sub_31_result_process);
    if ($result_got['gpa'] != NULL)
    {
        $result_31_sub[$ll]= $sub_code;
        $result_31_name[$ll]=$sub_name;
        $result_31_credit[$ll]=$sub_credit;
        $result_31_grade[$ll]=$result_got['gpa'];
        $ll++;
    }


}

////@@@ Result Publish Process

//######Credit Count & GPA Count
$m=0;
$total_credit_31=0;
$total_gpa_31=0;
$drop_credit_31=0;
$result_31_gpa;
for ($m=0;$m<$ll;$m++){

    $total_credit_31=$total_credit_31+$result_31_credit[$m];
    $grade=$result_31_grade[$m];
    if ($grade == "A+")
    {
        $gpa=4.00;
        $result_31_gpa[$m]=4;
    }
    else if ($grade == "A")
    {
        $gpa=3.75;
        $result_31_gpa[$m]=3.75;
    }
    else if ($grade == "A-")
    {
        $gpa=3.50;
        $result_31_gpa[$m]=3.50;
    }
    if ($grade == "B+")
    {
        $gpa=3.25;
        $result_31_gpa[$m]=3.25;
    }
    else if ($grade == "B")
    {
        $gpa=3.00;
        $result_31_gpa[$m]=3;
    }
    else if ($grade == "B-")
    {
        $gpa=2.75;
        $result_31_gpa[$m]=2.75;
    }
    if ($grade == "C+")
    {
        $gpa=2.50;
        $result_31_gpa[$m]=2.5;
    }
    else if ($grade == "C")
    {
        $gpa=2.25;
        $result_31_gpa[$m]=2.25;
    }
    else if ($grade == "C-")
    {
        $gpa=2;
        $result_31_gpa[$m]=2;
    }
    else if ($grade == "F")
    {
        $gpa=0;
        $result_31_gpa[$m]=0;
        $drop_credit_31=$drop_credit_31+$result_31_credit[$m];
    }
    $indi_gpa=$gpa*$result_31_credit[$m];
    $total_gpa_31=$total_gpa_31+$indi_gpa;
}

//@@@ CGPA Calculation
$total_credit_pass_31=$total_credit_31-$drop_credit_31;
if ($total_credit_pass_31 != 0)
{
$gpa_31=$total_gpa_31/$total_credit_pass_31;
}
$gpa_31= round($gpa_31,2);
$_SESSION['gpa_31']=$gpa_31;

//@@@@ sum of total result
$final_total_credit=$final_total_credit+$total_credit_31;
$final_complete_credit=$final_complete_credit+$total_credit_pass_31;
$final_drop_credit=$final_drop_credit+$drop_credit_31;
$final_total_gpa=$final_total_gpa+$total_gpa_31;
$final_cgpa=$final_total_gpa/$final_complete_credit;
$final_cgpa=round($final_cgpa,2);
$_SESSION['cgpa_31']=$final_cgpa;




/////3rd Year-2nd Semester Result Calculation/////////

//@@@Subject Collect ####
$sub_32_sub;
$sub_32_name;
$sub_32_credit;
$count_32=0;
$sub_32="SELECT * FROM 3_2 where available=1 order by sub";
$sub_32_get_process=mysql_query($sub_32);
while($sub_32_get = mysql_fetch_array($sub_32_get_process))
{
    $sub_32_sub[$count_32]=$sub_32_get['sub'];
    $sub_32_name[$count_32]=$sub_32_get['name'];
    $sub_32_credit[$count_32]=$sub_32_get['credit'];
    $count_32++;
}


////@@ Result Collect ###
$result_32_sub;
$result_32_name;
$result_32_credit;
$result_32_gpa;
$zz=0;
for ($i=0;$i<$count_32 ; $i++) {
    $sub_code=$sub_32_sub[$i];
    $sub_name=$sub_32_name[$i];
    $sub_credit=$sub_32_credit[$i];

    $sub_32_result_process=mysql_query("SELECT * FROM $sub_code WHERE reg= '$reg' ");
    $result_got=mysql_fetch_array($sub_32_result_process);
    if ($result_got['gpa'] != NULL)
    {
        $result_32_sub[$zz]= $sub_code;
        $result_32_name[$zz]=$sub_name;
        $result_32_credit[$zz]=$sub_credit;
        $result_32_grade[$zz]=$result_got['gpa'];
        $zz++;
    }


}

////@@@ Result Publish Process

//######Credit Count & GPA Count
$m=0;
$total_credit_32=0;
$total_gpa_32=0;
$drop_credit_32=0;
$result_32_gpa;
for ($m=0;$m<$zz;$m++){

    $total_credit_32=$total_credit_32+$result_32_credit[$m];
    $grade=$result_32_grade[$m];
    if ($grade == "A+")
    {
        $gpa=4.00;
        $result_32_gpa[$m]=4;
    }
    else if ($grade == "A")
    {
        $gpa=3.75;
        $result_32_gpa[$m]=3.75;
    }
    else if ($grade == "A-")
    {
        $gpa=3.50;
        $result_32_gpa[$m]=3.50;
    }
    if ($grade == "B+")
    {
        $gpa=3.25;
        $result_32_gpa[$m]=3.25;
    }
    else if ($grade == "B")
    {
        $gpa=3.00;
        $result_32_gpa[$m]=3;
    }
    else if ($grade == "B-")
    {
        $gpa=2.75;
        $result_32_gpa[$m]=2.75;
    }
    if ($grade == "C+")
    {
        $gpa=2.50;
        $result_32_gpa[$m]=2.5;
    }
    else if ($grade == "C")
    {
        $gpa=2.25;
        $result_32_gpa[$m]=2.25;
    }
    else if ($grade == "C-")
    {
        $gpa=2;
        $result_32_gpa[$m]=2;
    }
    else if ($grade == "F")
    {
        $gpa=0;
        $result_32_gpa[$m]=0;
        $drop_credit_32=$drop_credit_32+$result_32_credit[$m];
    }
    $indi_gpa=$gpa*$result_32_credit[$m];
    $total_gpa_32=$total_gpa_32+$indi_gpa;
}


//@@@ CGPA Calculation
$total_credit_pass_32=$total_credit_32-$drop_credit_32;
if ($total_credit_pass_32 != 0)
{
$gpa_32=$total_gpa_32/$total_credit_pass_32;
}
$gpa_32= round($gpa_32,2);
$_SESSION['gpa_32']=$gpa_32;

//@@@@ sum of total result
$final_total_credit=$final_total_credit+$total_credit_32;
$final_complete_credit=$final_complete_credit+$total_credit_pass_32;
$final_drop_credit=$final_drop_credit+$drop_credit_32;
$final_total_gpa=$final_total_gpa+$total_gpa_32;
$final_cgpa=$final_total_gpa/$final_complete_credit;
$final_cgpa=round($final_cgpa,2);
$_SESSION['cgpa_32']=$final_cgpa;



/////4th Year-1st Semester Result Calculation/////////

//@@@Subject Collect ####
$sub_41_sub;
$sub_41_name;
$sub_41_credit;
$count_41=0;
$sub_41="SELECT * FROM 4_1_option where available=1 order by sub";
 $sub_41_get_process=mysql_query($sub_41);
 while($sub_41_get = mysql_fetch_array($sub_41_get_process))
 {
    $sub_41_sub[$count_41]=$sub_41_get['sub'];
    $sub_41_name[$count_41]=$sub_41_get['name'];
    $sub_41_credit[$count_41]=$sub_41_get['credit'];
    $count_41++;
 }
 $sub_41="SELECT * FROM 4_1 where available=1 order by sub";
 $sub_41_get_process=mysql_query($sub_41);
 while($sub_41_get = mysql_fetch_array($sub_41_get_process))
 {
    $sub_41_sub[$count_41]=$sub_41_get['sub'];
    $sub_41_name[$count_41]=$sub_41_get['name'];
    $sub_41_credit[$count_41]=$sub_41_get['credit'];
    $count_41++;
 }



////@@ Result Collect ###
$result_41_sub;
$result_41_name;
$result_41_credit;
$result_41_gpa;
$lll=0;
for ($i=0;$i<$count_41 ; $i++) {
    $sub_code=$sub_41_sub[$i];
    $sub_name=$sub_41_name[$i];
    $sub_credit=$sub_41_credit[$i];

     $sub_41_result_process=mysql_query("SELECT * FROM $sub_code WHERE reg= '$reg' ");
     $result_got=mysql_fetch_array($sub_41_result_process);
     if ($result_got['gpa'] != NULL)
     {
        $result_41_sub[$lll]= $sub_code;
        $result_41_name[$lll]=$sub_name;
        $result_41_credit[$lll]=$sub_credit;
        $result_41_grade[$lll]=$result_got['gpa'];
        $lll++;
     }


}

////@@@ Result Publish Process

//######Credit Count & GPA Count
$m=0;
$total_credit_41=0;
$total_gpa_41=0;
$drop_credit_41=0;
$result_41_gpa;
for ($m=0;$m<$lll;$m++){

    $total_credit_41=$total_credit_41+$result_41_credit[$m];
    $grade=$result_41_grade[$m];
    if ($grade == "A+")
    {
        $gpa=4.00;
        $result_41_gpa[$m]=4;
    }
    else if ($grade == "A")
    {
        $gpa=3.75;
        $result_41_gpa[$m]=3.75;
    }
    else if ($grade == "A-")
    {
        $gpa=3.50;
        $result_41_gpa[$m]=3.50;
    }
    if ($grade == "B+")
    {
        $gpa=3.25;
        $result_41_gpa[$m]=3.25;
    }
    else if ($grade == "B")
    {
        $gpa=3.00;
        $result_41_gpa[$m]=3;
    }
    else if ($grade == "B-")
    {
        $gpa=2.75;
        $result_41_gpa[$m]=2.75;
    }
    if ($grade == "C+")
    {
        $gpa=2.50;
        $result_41_gpa[$m]=2.5;
    }
    else if ($grade == "C")
    {
        $gpa=2.25;
        $result_41_gpa[$m]=2.25;
    }
    else if ($grade == "C-")
    {
        $gpa=2;
        $result_41_gpa[$m]=2;
    }
    else if ($grade == "F")
    {
        $gpa=0;
        $result_41_gpa[$m]=0;
        $drop_credit_41=$drop_credit_41+$result_41_credit[$m];
    }
    $indi_gpa=$gpa*$result_41_credit[$m];
    $total_gpa_41=$total_gpa_41+$indi_gpa;
}

//@@@ CGPA Calculation
$total_credit_pass_41=$total_credit_41-$drop_credit_41;
if ($total_credit_pass_41 != 0)
{
$gpa_41=$total_gpa_41/$total_credit_pass_41;
}
$gpa_41= round($gpa_41,2);
$_SESSION['gpa_41']=$gpa_41;

//@@@@ sum of total result
$final_total_credit=$final_total_credit+$total_credit_41;
$final_complete_credit=$final_complete_credit+$total_credit_pass_41;
$final_drop_credit=$final_drop_credit+$drop_credit_41;
$final_total_gpa=$final_total_gpa+$total_gpa_41;
$final_cgpa=$final_total_gpa/$final_complete_credit;
$final_cgpa=round($final_cgpa,2);
$_SESSION['cgpa_41']=$final_cgpa;



//@@@Extra Year Calculation
$drop_uthano_hoice=0;
$first_semster_drop=$drop_credit_11+$drop_credit_21+$drop_credit_31;

for ($dcu=0;$dcu<$drop_dilam;$dcu++)
{
   if (($drop_semester[$dcu] == "11") || ($drop_semester[$dcu] == "21"))
        {
            if($drop_gpa[$dcu] > 0)
            {
               $drop_uthano_hoice=$drop_uthano_hoice+$drop_credit[$dcu]; 
            }
            
        } 
}


if((($first_semster_drop-$drop_uthano_hoice) + 18.5) > 30 )
{
    echo "</br><h4 align=center style='color:red'>Sorry you have a less possibility to complete 160 Credit within 4 Years</h4>";
}
else{
    echo "</br><h4 align=center style='color:green'>You have a possibility to complete 160 Credit within 4 Years</h4>";
}



///#### Print All Result >>>>>>>>>
echo
    "<fieldset>
    <legend><h5 style=color:yellow;font-size:18px;>Combined Status</h5></legend>
    <table align=center border='1' width='95%' style=font-size:16px;color:white>
        <tr align=center>
        <th align=center>Total Credit</th>
        <th align=center>Complete Credit</th>
        <th align=center>Drop Credit</th>
        <th align=center>CGPA</th>


        </tr><tr><td align=center>$final_total_credit</td>
        <td align=center>$final_complete_credit</td>
        <td align=center>$final_drop_credit</td>
        <td align=center>$final_cgpa</td>
        </tr>
</table>


</legend>
</fieldset>
</br>";


//Remaining Drop Course List:

if ($final_drop_credit>0)
{
echo"
<fieldset>
    <legend><h5 style=color:red;font-size:18px;>Remaining Drop Courses</h5></legend>
    <table align=center border='1' width='95%' style=font-size:16px;color:#b0c4de;>
        <tr align=center>
        <th align=center>Total Remaining Drop Credit</th>


        </tr><tr><td align=center>$final_drop_credit</td>
        </tr>
</table>
<table align=center border='1' width='95%' style=font-size:16px;color:#f5f5f5;>
        <tr align=center>
        <th align=center>No</th>
        <th align=center>Subject</th>
        <th align=center>Name</th>
        <th align=center>Credit</th>
        <th align=center>Semester</th>
        


        </tr>";
$drop_remain_count=0;
    for ($w=0;$w<$j;$w++){
        $flag_drop=0;
        if($result_11_grade[$w]=="F")
        {
            for($drop_reduce=0;$drop_reduce<$drop_dilam;$drop_reduce++){
                if($drop_sub[$drop_reduce]==$result_11_sub[$w] && $drop_grade[$drop_reduce]!="F")
                {
                    $flag_drop=1;
                    break;
                }
            }
        if($flag_drop==0){
            $drop_remain_count++;
        echo"<tr style='color:red'>
        <td align=center>$drop_remain_count</td>
        <td align=center >$result_11_sub[$w]</td>
        <td align=center>$result_11_name[$w]</td>
        <td align=center>$result_11_credit[$w]</td>
        <td align=center>11</td>
        
        </tr>";
        }
        $flag_drop=0;    
     
        }
    }

    for ($w=0;$w<$k;$w++){

    $flag_drop=0;
    if($result_12_grade[$w]=="F")
    {

        for($drop_reduce=0;$drop_reduce<$drop_dilam;$drop_reduce++){
                if(($drop_sub[$drop_reduce]==$result_12_sub[$w] && $drop_grade[$drop_reduce]!="F") || ($result_12_sub[$w]=="EEE107Q" && $drop_sub[$drop_reduce]=="EEE109Q" && $drop_grade[$drop_reduce]!="F") || ($result_12_sub[$w]=="EEE107Q" && $drop_sub[$drop_reduce]=="EEE203Q" && $drop_grade[$drop_reduce]!="F"))
                {
                    $flag_drop=1;
                    break;
                }
            }
    if($flag_drop==0){
    $drop_remain_count++;
        echo"<tr style='color:red'>
        <td align=center>$drop_remain_count</td>
    <td align=center>$result_12_sub[$w]</td>
        <td align=center>$result_12_name[$w]</td>
        <td align=center>$result_12_credit[$w]</td>
        <td align=center>12</td>
        
        </tr>";
    }
    $flag_drop=0;  

    }
}
for ($w=0;$w<$l;$w++){

    $flag_drop=0; 
   if($result_21_grade[$w]=="F")
   {
    for($drop_reduce=0;$drop_reduce<$drop_dilam;$drop_reduce++){
                if($drop_sub[$drop_reduce]==$result_21_sub[$w] && $drop_grade[$drop_reduce]!="F")
                {
                    $flag_drop=1;
                    break;
                }
            }
    if($flag_drop==0){
    $drop_remain_count++;
        echo"<tr style='color:red'>
        <td align=center>$drop_remain_count</td>
    <td align=center>$result_21_sub[$w]</td>
        <td align=center>$result_21_name[$w]</td>
        <td align=center>$result_21_credit[$w]</td>
        <td align=center>21</td>
       
        </tr>";
    }
    $flag_drop=0; 

   }
}
for ($w=0;$w<$z;$w++){

    $flag_drop=0; 
    if($result_22_grade[$w]=="F"){
        for($drop_reduce=0;$drop_reduce<$drop_dilam;$drop_reduce++){
                if( ($drop_sub[$drop_reduce]==$result_22_sub[$w] && $drop_grade[$drop_reduce]!="F") || ($result_22_sub[$w]=="CSE339" && $drop_sub[$drop_reduce]=="CSE243" && $drop_grade[$drop_reduce]!="F"))
                {
                    $flag_drop=1;
                    break;
                }
            }

    if($flag_drop==0){
    $drop_remain_count++;
        echo"<tr style='color:red'>
        <td align=center>$drop_remain_count</td>
    <td align=center>$result_22_sub[$w]</td>
        <td align=center>$result_22_name[$w]</td>
        <td align=center>$result_22_credit[$w]</td>
        <td align=center>22</td>
      
        </tr>";
    }
    $flag_drop=0;

    }
}
for ($w=0;$w<$ll;$w++){
    $flag_drop=0;
   if($result_31_grade[$w]=="F")
   {
    for($drop_reduce=0;$drop_reduce<$drop_dilam;$drop_reduce++){
                 if($drop_sub[$drop_reduce]==$result_31_sub[$w] && $drop_grade[$drop_reduce]!="F")
                {
                    $flag_drop=1;
                    break;
                }
            }
    if($flag_drop==0){
     $link = "include/dropUpdate/form.php?subjectCode=".$result_31_sub[$w];
    $drop_remain_count++;
        echo"<tr style='color:red'>
        <td align=center>$drop_remain_count</td>
    <td align=center>$result_31_sub[$w]</td>
        <td align=center>$result_31_name[$w]</td>
        <td align=center>$result_31_credit[$w]</td>
        <td align=center>31</td>
      
        </tr>";
        }
    $flag_drop=0;
     

   }
}
for ($w=0;$w<$zz;$w++){
    $flag_drop=0;
   if($result_32_grade[$w]=="F")
   {

    for($drop_reduce=0;$drop_reduce<$drop_dilam;$drop_reduce++){
                 if($drop_sub[$drop_reduce]==$result_32_sub[$w] && $drop_grade[$drop_reduce]!="F")
                {
                    $flag_drop=1;
                    break;
                }
            }

    if($flag_drop==0){
        $link = "include/dropUpdate/form.php?subjectCode=".$result_3_sub[$w];
   $drop_remain_count++;
        echo"<tr style='color:red'>
        <td align=center>$drop_remain_count</td>
    <td align=center>$result_32_sub[$w]</td>
        <td align=center>$result_32_name[$w]</td>
        <td align=center>$result_32_credit[$w]</td>
        <td align=center>32</td>
        
        </tr>";
        }
    $flag_drop=0;
   }
}
    echo"
</table></br>
<p style='color:white'>**EEE109Q/EEE203Q(Current Course)[3 Credit] is Equivalent to EEE107Q(Old Course)[4 Credit]
If you Drop EEE107Q and later Pass the Equivalent EEE109Q/EEE203Q, you will always be in Short of 1 Credit</p>
<p style='color:white'>**CSE243(Current Course)[3 Credit] is Equivalent to CSE339(Old Course)[2 Credit]
If you Drop CSE339 and later Pass the Equivalent CSE243, you will always have an extra 1 Credit completed</p>

</legend>
</fieldset></br>";
}



echo"
<fieldset>
    <legend><h5 style=color:yellow;font-size:18px;>1st Year-1st Semester</h5></legend>
    <table align=center border='1' width='95%' style=font-size:16px;color:#b0c4de;>
        <tr align=center>
        <th align=center>Total Credit</th>
        <th align=center>Complete Credit</th>
        <th align=center>Drop Credit</th>
        <th align=center>CGPA</th>


        </tr><tr><td align=center>$total_credit_11</td>
        <td align=center>$total_credit_pass_11</td>
        <td align=center>$drop_credit_11</td>
        <td align=center>$gpa_11</td>
        </tr>
</table>
<table align=center border='1' width='95%' style=font-size:16px;color:#f5f5f5;>
        <tr align=center>
        <th align=center>Subject</th>
        <th align=center>Name</th>
        <th align=center>Credit</th>
        <th align=center>Grade</th>
        <th align=center>GPA</th>


        </tr>";

    for ($w=0;$w<$j;$w++){
        if($result_11_grade[$w]=="F")
        {
        echo"<tr style='color:red'><td align=center >$result_11_sub[$w]</td>
        <td align=center>$result_11_name[$w]</td>
        <td align=center>$result_11_credit[$w]</td>
        <td align=center>$result_11_grade[$w]</td>
        <td align=center>$result_11_gpa[$w]</td>
        </tr>";
        }
        else {
               echo"<tr><td align=center>$result_11_sub[$w]</td>
        <td align=center>$result_11_name[$w]</td>
        <td align=center>$result_11_credit[$w]</td>
        <td align=center>$result_11_grade[$w]</td>
        <td align=center>$result_11_gpa[$w]</td>
        </tr>";
        }
 
    }
    echo"
</table>


</legend>
</fieldset>";




echo"
<fieldset>
    <legend><h5 style=color:yellow;font-size:18px;>1st Year-2nd Semester</h5></legend>
    <table align=center border='1' width='95%' style=font-size:16px;color:#b0c4de;>
        <tr align=center>
        <th align=center>Total Credit</th>
        <th align=center>Complete Credit</th>
        <th align=center>Drop Credit</th>
        <th align=center>CGPA</th>


        </tr><tr><td align=center>$total_credit_12</td>
        <td align=center>$total_credit_pass_12</td>
        <td align=center>$drop_credit_12</td>
        <td align=center>$gpa_12</td>
        </tr>
</table>
<table align=center border='1' width='95%' style=font-size:16px;color:#f5f5f5;>
        <tr align=center>
        <th align=center>Subject</th>
        <th align=center>Name</th>
        <th align=center>Credit</th>
        <th align=center>Grade</th>
        <th align=center>GPA</th>


        </tr>";

for ($w=0;$w<$k;$w++){
    if($result_12_grade[$w]=="F")
    {
    echo"<tr style='color:red'><td align=center>$result_12_sub[$w]</td>
        <td align=center>$result_12_name[$w]</td>
        <td align=center>$result_12_credit[$w]</td>
        <td align=center>$result_12_grade[$w]</td>
        <td align=center>$result_12_gpa[$w]</td>
        </tr>";
    }
    else
    {
        echo"<tr><td align=center>$result_12_sub[$w]</td>
        <td align=center>$result_12_name[$w]</td>
        <td align=center>$result_12_credit[$w]</td>
        <td align=center>$result_12_grade[$w]</td>
        <td align=center>$result_12_gpa[$w]</td>
        </tr>";
    }
}
echo"
</table>


</legend>
</fieldset>";


echo"
<fieldset>
    <legend><h5 style=color:yellow;font-size:18px;>2nd Year-1st Semester</h5></legend>
    <table align=center border='1' width='95%' style=font-size:16px;color:#b0c4de;>
        <tr align=center>
        <th align=center>Total Credit</th>
        <th align=center>Complete Credit</th>
        <th align=center>Drop Credit</th>
        <th align=center>CGPA</th>


        </tr><tr><td align=center>$total_credit_21</td>
        <td align=center>$total_credit_pass_21</td>
        <td align=center>$drop_credit_21</td>
        <td align=center>$gpa_21</td>
        </tr>
</table>
<table align=center border='1' width='95%' style=font-size:16px;color:#f5f5f5;>
        <tr align=center>
        <th align=center>Subject</th>
        <th align=center>Name</th>
        <th align=center>Credit</th>
        <th align=center>Grade</th>
        <th align=center>GPA</th>


        </tr>";

for ($w=0;$w<$l;$w++){
   if($result_21_grade[$w]=="F")
   {
    echo"<tr style='color:red'><td align=center>$result_21_sub[$w]</td>
        <td align=center>$result_21_name[$w]</td>
        <td align=center>$result_21_credit[$w]</td>
        <td align=center>$result_21_grade[$w]</td>
        <td align=center>$result_21_gpa[$w]</td>
        </tr>";
   }
   else {
    echo"<tr><td align=center>$result_21_sub[$w]</td>
        <td align=center>$result_21_name[$w]</td>
        <td align=center>$result_21_credit[$w]</td>
        <td align=center>$result_21_grade[$w]</td>
        <td align=center>$result_21_gpa[$w]</td>
        </tr>";
        }
}
echo"
</table>";
///1st year-1st semester drop result
if ($drop_sub[0] != NULL)
{
echo "<h4 align=center style=color:green>Drop Course Result (Only effects on Combined Status)</h4>
";
echo"
<table align=center border='1' width='95%' style=font-size:16px;color:#f5f5f5;>
        <tr align=center>
        <th align=center>Subject</th>
        <th align=center>Name</th>
        <th align=center>Credit</th>
        <th align=center>Grade</th>
        <th align=center>GPA</th>
        </tr>";

for ($w=0;$w<$drop_dilam;$w++){
    if ($drop_semester[$w] == "11")
    {
    if($drop_grade[$w]=="F"){
        echo"<tr style='color:red'><td align=center>$drop_sub[$w]</td>
        <td align=center>$drop_name[$w]</td>
        <td align=center>$drop_credit[$w]</td>
        <td align=center>$drop_grade[$w]</td>
        <td align=center>$drop_gpa[$w]</td>
        </tr>";
    }
    else{
    echo"<tr><td align=center>$drop_sub[$w]</td>
        <td align=center>$drop_name[$w]</td>
        <td align=center>$drop_credit[$w]</td>
        <td align=center>$drop_grade[$w]</td>
        <td align=center>$drop_gpa[$w]</td>
        </tr>";
        }
    }
}
echo"
</table>";
}
echo"
</legend>
</fieldset>";


echo"
<fieldset>
    <legend><h5 style=color:yellow;font-size:18px;>2nd Year-2nd Semester</h5></legend>
    <table align=center border='1' width='95%' style=font-size:16px;color:#b0c4de;>
        <tr align=center>
        <th align=center>Total Credit</th>
        <th align=center>Complete Credit</th>
        <th align=center>Drop Credit</th>
        <th align=center>CGPA</th>


        </tr><tr><td align=center>$total_credit_22</td>
        <td align=center>$total_credit_pass_22</td>
        <td align=center>$drop_credit_22</td>
        <td align=center>$gpa_22</td>
        </tr>
</table>
<table align=center border='1' width='95%' style=font-size:16px;color:#f5f5f5;>
        <tr align=center>
        <th align=center>Subject</th>
        <th align=center>Name</th>
        <th align=center>Credit</th>
        <th align=center>Grade</th>
        <th align=center>GPA</th>


        </tr>";

for ($w=0;$w<$z;$w++){
    if($result_22_grade[$w]=="F"){
    echo"<tr style='color:red'><td align=center>$result_22_sub[$w]</td>
        <td align=center>$result_22_name[$w]</td>
        <td align=center>$result_22_credit[$w]</td>
        <td align=center>$result_22_grade[$w]</td>
        <td align=center>$result_22_gpa[$w]</td>
        </tr>";
    }
    else {
    echo"<tr><td align=center>$result_22_sub[$w]</td>
        <td align=center>$result_22_name[$w]</td>
        <td align=center>$result_22_credit[$w]</td>
        <td align=center>$result_22_grade[$w]</td>
        <td align=center>$result_22_gpa[$w]</td>
        </tr>";
    }
}
echo"
</table>";
///1st year-2nd semester drop result

if ($drop_sub[0] != NULL)
{
echo "<h4 align=center style=color:green>Drop Course Result (Only effects on Combined Status)</h4>
";
echo"
<table align=center border='1' width='95%' style=font-size:16px;color:#f5f5f5;>
        <tr align=center>
        <th align=center>Subject</th>
        <th align=center>Name</th>
        <th align=center>Credit</th>
        <th align=center>Grade</th>
        <th align=center>GPA</th>
        </tr>";

for ($w=0;$w<$drop_dilam;$w++){
    if ($drop_semester[$w] == "12")
    {
    echo"<tr><td align=center>$drop_sub[$w]</td>
        <td align=center>$drop_name[$w]</td>
        <td align=center>$drop_credit[$w]</td>
        <td align=center>$drop_grade[$w]</td>
        <td align=center>$drop_gpa[$w]</td>
        </tr>";
    }
}
echo"
</table>";
}

echo"
</legend>
</fieldset>";



echo"
<fieldset>
    <legend><h5 style=color:yellow;font-size:18px;>3rd Year-1st Semester</h5></legend>
    <table align=center border='1' width='95%' style=font-size:16px;color:#b0c4de;>
        <tr align=center>
        <th align=center>Total Credit</th>
        <th align=center>Complete Credit</th>
        <th align=center>Drop Credit</th>
        <th align=center>CGPA</th>


        </tr><tr><td align=center>$total_credit_31</td>
        <td align=center>$total_credit_pass_31</td>
        <td align=center>$drop_credit_31</td>
        <td align=center>$gpa_31</td>
        </tr>
</table>
<table align=center border='1' width='95%' style=font-size:16px;color:#f5f5f5;>
        <tr align=center>
        <th align=center>Subject</th>
        <th align=center>Name</th>
        <th align=center>Credit</th>
        <th align=center>Grade</th>
        <th align=center>GPA</th>


        </tr>";

for ($w=0;$w<$ll;$w++){
   if($result_31_grade[$w]=="F")
   {
    echo"<tr style='color:red'><td align=center>$result_31_sub[$w]</td>
        <td align=center>$result_31_name[$w]</td>
        <td align=center>$result_31_credit[$w]</td>
        <td align=center>$result_31_grade[$w]</td>
        <td align=center>$result_31_gpa[$w]</td>
        </tr>";
   }
   else {
    echo"<tr><td align=center>$result_31_sub[$w]</td>
        <td align=center>$result_31_name[$w]</td>
        <td align=center>$result_31_credit[$w]</td>
        <td align=center>$result_31_grade[$w]</td>
        <td align=center>$result_31_gpa[$w]</td>
        </tr>";
        }
}
echo"
</table>";
///2nd year-1st semester && 1st Year 1st Semester drop result
if ($drop_sub[0] != NULL)
{
echo "<h4 align=center style=color:green>Drop Course Result (Only effects on Combined Status)</h4>
";
echo"
<table align=center border='1' width='95%' style=font-size:16px;color:#f5f5f5;>
        <tr align=center>
        <th align=center>Subject</th>
        <th align=center>Name</th>
        <th align=center>Credit</th>
        <th align=center>Grade</th>
        <th align=center>GPA</th>
        </tr>";

for ($w=0;$w<$drop_dilam;$w++){
    if ($drop_semester[$w] == "21")
    {
    if($drop_grade[$w]=="F"){
        echo"<tr style='color:red'><td align=center>$drop_sub[$w]</td>
        <td align=center>$drop_name[$w]</td>
        <td align=center>$drop_credit[$w]</td>
        <td align=center>$drop_grade[$w]</td>
        <td align=center>$drop_gpa[$w]</td>
        </tr>";
    }
    else{
    echo"<tr><td align=center>$drop_sub[$w]</td>
        <td align=center>$drop_name[$w]</td>
        <td align=center>$drop_credit[$w]</td>
        <td align=center>$drop_grade[$w]</td>
        <td align=center>$drop_gpa[$w]</td>
        </tr>";
        }
    }
}
echo"
</table>";
}
echo"
</legend>
</fieldset>";


echo"
<fieldset>
    <legend><h5 style=color:yellow;font-size:18px;>3rd Year-2nd Semester</h5></legend>
    <table align=center border='1' width='95%' style=font-size:16px;color:#b0c4de;>
        <tr align=center>
        <th align=center>Total Credit</th>
        <th align=center>Complete Credit</th>
        <th align=center>Drop Credit</th>
        <th align=center>CGPA</th>


        </tr><tr><td align=center>$total_credit_32</td>
        <td align=center>$total_credit_pass_32</td>
        <td align=center>$drop_credit_32</td>
        <td align=center>$gpa_32</td>
        </tr>
</table>
<table align=center border='1' width='95%' style=font-size:16px;color:#f5f5f5;>
        <tr align=center>
        <th align=center>Subject</th>
        <th align=center>Name</th>
        <th align=center>Credit</th>
        <th align=center>Grade</th>
        <th align=center>GPA</th>


        </tr>";

for ($w=0;$w<$zz;$w++){
   if($result_32_grade[$w]=="F")
   {
    echo"<tr style='color:red'><td align=center>$result_32_sub[$w]</td>
        <td align=center>$result_32_name[$w]</td>
        <td align=center>$result_32_credit[$w]</td>
        <td align=center>$result_32_grade[$w]</td>
        <td align=center>$result_32_gpa[$w]</td>
        </tr>";
   }
   else {
    echo"<tr><td align=center>$result_32_sub[$w]</td>
        <td align=center>$result_32_name[$w]</td>
        <td align=center>$result_32_credit[$w]</td>
        <td align=center>$result_32_grade[$w]</td>
        <td align=center>$result_32_gpa[$w]</td>
        </tr>";
        }
}
echo"
</table>";
///2nd year-2nd semester && 1st Year 2nd Semester drop result
if ($drop_sub[0] != NULL)
{
echo "<h4 align=center style=color:green>Drop Course Result (Only effects on Combined Status)</h4>
";
echo"
<table align=center border='1' width='95%' style=font-size:16px;color:#f5f5f5;>
        <tr align=center>
        <th align=center>Subject</th>
        <th align=center>Name</th>
        <th align=center>Credit</th>
        <th align=center>Grade</th>
        <th align=center>GPA</th>
        </tr>";

for ($w=0;$w<$drop_dilam;$w++){
    if ($drop_semester[$w] == "22")
    {
    if($drop_grade[$w]=="F"){
        echo"<tr style='color:red'><td align=center>$drop_sub[$w]</td>
        <td align=center>$drop_name[$w]</td>
        <td align=center>$drop_credit[$w]</td>
        <td align=center>$drop_grade[$w]</td>
        <td align=center>$drop_gpa[$w]</td>
        </tr>";
    }
    else{
    echo"<tr><td align=center>$drop_sub[$w]</td>
        <td align=center>$drop_name[$w]</td>
        <td align=center>$drop_credit[$w]</td>
        <td align=center>$drop_grade[$w]</td>
        <td align=center>$drop_gpa[$w]</td>
        </tr>";
        }
    }
}
echo"
</table>";
}
echo"
</legend>
</fieldset>";


echo"
<fieldset>
    <legend><h5 style=color:yellow;font-size:18px;>4th Year-1st Semester</h5></legend>
    <table align=center border='1' width='95%' style=font-size:16px;color:#b0c4de;>
        <tr align=center>
        <th align=center>Total Credit</th>
        <th align=center>Complete Credit</th>
        <th align=center>Drop Credit</th>
        <th align=center>CGPA</th>


        </tr><tr><td align=center>$total_credit_41</td>
        <td align=center>$total_credit_pass_41</td>
        <td align=center>$drop_credit_41</td>
        <td align=center>$gpa_41</td>
        </tr>
</table>
<table align=center border='1' width='95%' style=font-size:16px;color:#f5f5f5;>
        <tr align=center>
        <th align=center>Subject</th>
        <th align=center>Name</th>
        <th align=center>Credit</th>
        <th align=center>Grade</th>
        <th align=center>GPA</th>


        </tr>";

for ($w=0;$w<$lll;$w++){
   if($result_41_grade[$w]=="F")
   {
    echo"<tr style='color:red'><td align=center>$result_41_sub[$w]</td>
        <td align=center>$result_41_name[$w]</td>
        <td align=center>$result_41_credit[$w]</td>
        <td align=center>$result_41_grade[$w]</td>
        <td align=center>$result_41_gpa[$w]</td>
        </tr>";
   }
   else {
    echo"<tr><td align=center>$result_41_sub[$w]</td>
        <td align=center>$result_41_name[$w]</td>
        <td align=center>$result_41_credit[$w]</td>
        <td align=center>$result_41_grade[$w]</td>
        <td align=center>$result_41_gpa[$w]</td>
        </tr>";
        }
}
echo"
</table>";
///3rd year-1st semeter && 2nd year-1st semester && 1st Year 1st Semester drop result
if ($drop_sub[0] != NULL)
{
echo "<h4 align=center style=color:green>Drop Course Result (Only effects on Combined Status)</h4>
";
echo"
<table align=center border='1' width='95%' style=font-size:16px;color:#f5f5f5;>
        <tr align=center>
        <th align=center>Subject</th>
        <th align=center>Name</th>
        <th align=center>Credit</th>
        <th align=center>Grade</th>
        <th align=center>GPA</th>
        </tr>";

for ($w=0;$w<$drop_dilam;$w++){
    if ($drop_semester[$w] == "31")
    {
    if($drop_grade[$w]=="F"){
        echo"<tr style='color:red'><td align=center>$drop_sub[$w]</td>
        <td align=center>$drop_name[$w]</td>
        <td align=center>$drop_credit[$w]</td>
        <td align=center>$drop_grade[$w]</td>
        <td align=center>$drop_gpa[$w]</td>
        </tr>";
    }
    else{
    echo"<tr><td align=center>$drop_sub[$w]</td>
        <td align=center>$drop_name[$w]</td>
        <td align=center>$drop_credit[$w]</td>
        <td align=center>$drop_grade[$w]</td>
        <td align=center>$drop_gpa[$w]</td>
        </tr>";
        }
    }
}
echo"
</table>";
}
echo"
</legend>
</fieldset>";

//include("include/graph.php");
?>

<div class="cleaner"></div>
    </div>

    