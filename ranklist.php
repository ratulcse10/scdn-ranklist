<?php
ini_set('max_execution_time', 300);
?>
<html lang="en">
  <head>
    <title>SCDN ::. Developer Ranklist</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="description" content="SUST CSE Developer Network,Dept of CSE,SUST" />
        <meta name="author" content="Abu Shahriar Ratul" />
 
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link href="css/ripples.min.css" rel="stylesheet">
        <link href="css/material-wfont.min.css" rel="stylesheet">
        <link href="css/snackbar.min.css" rel="stylesheet">
       
    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <script src="//fezvrasta.github.io/bootstrap-material-design/dist/js/ripples.min.js"></script>
        <script src="//fezvrasta.github.io/bootstrap-material-design/dist/js/material.min.js"></script>
        <script src="//fezvrasta.github.io/snackbarjs/dist/snackbar.min.js"></script>


        <script src="//cdnjs.cloudflare.com/ajax/libs/noUiSlider/6.2.0/jquery.nouislider.min.js"></script>
  </head>  

<body>


    <div class="container">

     

      <!-- Navbar
      ================================================== -->
      <div class="bs-docs-section clearfix">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
              <h1 style="font-size:40px"  id="navbar" align=center >SCDN</h1>
              
              <h4 align=center > <b>S</b>UST <b>C</b>SE <b>D</b>eveloper <b>N</b>etwork </h4>

            </div>

          </div>
        </div>
      </div>


<style>
.table td  {
   text-align: center;   
}
.table th  {
   text-align: center;   
}
a {
    color: inherit;
}

a:hover {
    font-weight: bold;
    color: white;
}

a.developerID:hover {
    font-weight: bold;
    color: black;
}
</style>



<div class="row" >
                    <div class="col-md-10 col-md-offset-1">
                        <div class="bs-component">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h2 class="panel-title" align="center" style="font-size:22px">Developer Ranklist</h2><h3 class="panel-title" align="center"> [Based on <b>Github Repo</b> Contribution using 
                                    <a href="#rankingCriteria" data-toggle="modal">Ranking Criteria</a> & <a href="#colorCriteria" data-toggle="modal">Color Criteria</a>]</h3>
                                </div>
                                <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>Name</th>
                                        <th>Batch</th>
                                        <th>Current Streak</th>
                                        <th>Longest Streak</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php
 
 function getStatus($username){

$url = "https://github.com/".$username;

$options = array(
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => false,    // don't return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING       => "",       // handle all encodings
        CURLOPT_USERAGENT      => "spider", // who am i
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
        CURLOPT_TIMEOUT        => 120,      // timeout on response
        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
    );

$ch      = curl_init( $url );
curl_setopt_array( $ch, $options );


$page = curl_exec($ch);

$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML($page);
libxml_clear_errors();
$xpath = new DOMXpath($dom);

$data = array();
// get all table rows and rows which are not headers
$table_rows = $xpath->query('//span[@class="contrib-number"]');

foreach($table_rows as $row => $tr) {
    foreach($tr->childNodes as $td) {
        $data[$row][] = preg_replace('~[\r\n]+~', '', trim($td->nodeValue));
    }
    $data[$row] = array_values(array_filter($data[$row]));
}
return $data;
}


function getName($username){

$url = "https://github.com/".$username;

$options = array(
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => false,    // don't return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING       => "",       // handle all encodings
        CURLOPT_USERAGENT      => "spider", // who am i
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
        CURLOPT_TIMEOUT        => 120,      // timeout on response
        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
    );

$ch      = curl_init( $url );
curl_setopt_array( $ch, $options );


$page = curl_exec($ch);

$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML($page);
libxml_clear_errors();
$xpath = new DOMXpath($dom);

$data = array();
// get all table rows and rows which are not headers
$table_rows = $xpath->query('//span[@class="vcard-fullname"]');

foreach($table_rows as $row => $tr) {
    foreach($tr->childNodes as $td) {
        $data[$row][] = preg_replace('~[\r\n]+~', '', trim($td->nodeValue));
    }
    $data[$row] = array_values(array_filter($data[$row]));
}


if($data[0][0] == NULL){
$data = array();
// get all table rows and rows which are not headers
$table_rows = $xpath->query('//span[@class="vcard-username"]');

foreach($table_rows as $row => $tr) {
    foreach($tr->childNodes as $td) {
        $data[$row][] = preg_replace('~[\r\n]+~', '', trim($td->nodeValue));
    }
    $data[$row] = array_values(array_filter($data[$row]));
}
return $data;

}
else{
return $data;
}
}

$allDataSet;
 
/*
$users[0]="ratulcse10";$batch[0]=2010;
$users[1]="ratulcse27";$batch[1]=2010;
$users[2]="Nishikanto";$batch[2]=2012;
$users[3]="anindya-dhruba";$batch[3]=2010;
$users[4]="fahadsust";$batch[4]=2010;
$users[5]="nurcse";$batch[5]=2011;
$users[6]="prium";$batch[6]=2010;
$users[7]="MahadiHasanNahid";$batch[7]=2010;
$users[8]="masiur";$batch[8]=2012;
$users[9]="nayeemjoy";$batch[9]=2011;
$users[10]="BluePandora";$batch[10]=2011;
*/


$dev_2010 = array("ratulcse10","ratulcse27","anindya-dhruba","fahadsust","prium","MahadiHasanNahid");
$dev_2011 = array("nurcse","nayeemjoy","coderbdsust","BluePandora","shafinmahmud");
$dev_2012 = array("Nishikanto","masiur","nowshad-sust","nebir");


$dev_count=0;
//2010
for($dev_2010_count=0;$dev_2010_count<sizeof($dev_2010);$dev_2010_count++){
$users[$dev_count] = $dev_2010[$dev_2010_count];
$batch[$dev_count] = 2010;
$dev_count++;
}

//2011
for($dev_2011_count=0;$dev_2011_count<sizeof($dev_2011);$dev_2011_count++){
$users[$dev_count] = $dev_2011[$dev_2011_count];
$batch[$dev_count] = 2011;
$dev_count++;
}

//2012
for($dev_2012_count=0;$dev_2012_count<sizeof($dev_2012);$dev_2012_count++){
$users[$dev_count] = $dev_2012[$dev_2012_count];
$batch[$dev_count] = 2012;
$dev_count++;
}


                                
$Latest=0;
$Longest=0;                               
for($i=0;$i<sizeof($users);$i++){
$data = getStatus($users[$i]);
$data_name = getName($users[$i]);

if($data[2][0]>0)
{
$allDataSetLatest[$Latest]["longest_rank"]=str_replace($reaplce = array(" days"," day"), "", $data[1][0]);
$allDataSetLatest[$Latest]["latest_rank"]=str_replace($reaplce = array(" days"," day"), "", $data[2][0]);
$allDataSetLatest[$Latest]["longest"]=$data[1][0];
$allDataSetLatest[$Latest]["latest"]= $data[2][0];
$allDataSetLatest[$Latest]["name"]=$data_name[0][0];
$allDataSetLatest[$Latest]["username"]=$users[$i];
$allDataSetLatest[$Latest]["batch"]=$batch[$i];
$Latest++;
}
else
{
$allDataSetLongest[$Longest]["longest_rank"]= str_replace($reaplce = array(" days"," day"), "", $data[1][0]);
$allDataSetLongest[$Longest]["latest_rank"]=str_replace($reaplce = array(" days"," day"), "", $data[2][0]);
$allDataSetLongest[$Longest]["longest"]= $data[1][0];
$allDataSetLongest[$Longest]["latest"]= $data[2][0];
$allDataSetLongest[$Longest]["name"]=$data_name[0][0];
$allDataSetLongest[$Longest]["username"]=$users[$i];
$allDataSetLongest[$Longest]["batch"]=$batch[$i];
$Longest++;
}

}

usort($allDataSetLatest, function($a, $b) {
    if($a['latest_rank']==$b['latest_rank']) return 0;
    return $a['latest_rank'] < $b['latest_rank']?1:-1;
});

usort($allDataSetLongest, function($a, $b) {
    if($a['longest_rank']==$b['longest_rank']) return 0;
    return $a['longest_rank'] < $b['longest_rank']?1:-1;
});



//Color Decision
function developerColor($longest_streak){
if($longest_streak>=60){
	return "red";
}
else if($longest_streak>=50 && $longest_streak<=59){
	return "orange";
}
else if($longest_streak>=40 && $longest_streak<=49){
	return "yellow";
}
else if($longest_streak>=30 && $longest_streak<=39){
	return "green";
}
else if($longest_streak>=20 && $longest_streak<=29){
	return "brown";
}
else if($longest_streak>=10 && $longest_streak<=19){
	return "blue";
}
else if($longest_streak>=5 && $longest_streak<=9){
	return "violet";
}
else{
	return "black";
}

}

                                
?>



                                <?php

                                $real_rank=0;

                                for($rank=0;$rank<$Latest;$rank++)
                                {
                                $real_rank=$real_rank+1;
								$color = developerColor($allDataSetLatest[$rank]["longest"]);
                                echo"
                                <tr style='color:$color'>
                                        <td>".$real_rank."</td>
                                        <td><a class='developerID' title='$color developer' href='https://github.com/".$allDataSetLatest[$rank]["username"]."' target=_blank>".$allDataSetLatest[$rank]["name"]."</a><span class='glyphicon glyphicon-flash' style='color:$color'></span></td>
                                        <td>".$allDataSetLatest[$rank]["batch"]."</td>
                                        <td>".$allDataSetLatest[$rank]["latest"]."</td>
                                        <td>".$allDataSetLatest[$rank]["longest"]."</td>    
                                    </tr>";
                                } 

                                for($rank_post=0;$rank_post<$Longest;$rank_post++)
                                {
                                $real_rank=$real_rank+1;
                                
								$color = developerColor($allDataSetLongest[$rank_post]["longest"]);
                                echo"
                                <tr style='color:$color'>
                                        <td>".$real_rank."</td>
                                        <td><a class='developerID' title='$color developer' href='https://github.com/".$allDataSetLongest[$rank_post]["username"]."' target=_blank>".$allDataSetLongest[$rank_post]["name"]."</a><span class='glyphicon glyphicon-flash' style='color:$color'></span></td>
                                        <td>".$allDataSetLongest[$rank_post]["batch"]."</td>
                                        <td>".$allDataSetLongest[$rank_post]["latest"]."</td>
                                        <td>".$allDataSetLongest[$rank_post]["longest"]."</td>    
                                    </tr>";
                                } 

                                ?>
                                    
                                   
                                </tbody>
                            </table>
                            </div>

                        </div>
                    </div>
                    
    </div>
   



<div class="modal fade" id="rankingCriteria" tabindex="-1" role="dialog" aria-labelledby="AboutLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Ranking Criteria</h4>
      </div>
      <div class="modal-body">
        <ol>
            <li>Ranklist is Based on Developers' <b>Github Public/Private(Own) Repo</b> Contribution</li>
            <li>Any Contribution to <b>another Developers' Github Private Repo</b> will not be counted</li>
            <li>Ranking is based on <b>Longest Current Streak</b></li>
            <li>If there are more than one Developer having <b>Current Streak 0</b> , then Ranking is based on <b>Longest Streak</b></li>
        </ol>

    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="colorCriteria" tabindex="-1" role="dialog" aria-labelledby="AboutLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Color Criteria [Based on Longest Streak]</h4>
      </div>
      <div class="modal-body">
        <ol>
			<li><p style="color:red">Red Developer [<b>60 +</b>]</p></li>
			<li><p style="color:orange">Orange Developer [<b>50-59</b>]</p></li>
			<li><p style="color:yellow">Yellow Developer [<b>40-49</b>]</p></li>
			<li><p style="color:green">Green Developer [<b>30-39</b>]</p></li>
			<li><p style="color:brown">Brown Developer [<b>20-29</b>]</p></li>
			<li><p style="color:blue">Blue Developer [<b>10-19</b>]</p></li>
			<li><p style="color:violet">Violet Developer [<b>5-9</b>]</p></li>
			<li><p style="color:black">Black Developer [<b>5-9</b>]</p></li>
        </ol>

    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
      




     

      <footer>
        <div align="center">
       <div  >
                        
                <small class="copyright">SUST CSE Developer Network - SCDN (2014-<?php echo date('Y'); ?>)</br> Department of <b style="color:black">C</b>omputer <b style="color:black">S</b>cience and <b style="color:black">E</b>ngineering, <b style="color:black">S</b>hahjalal <b style="color:black">U</b>niversity of <b style="color:black">S</b>cience and <b style="color:black">T</b>echnology, Sylhet</small>

      </div>
    </div>
        
      </footer>
    

    </div>

</body>
 

 </html>