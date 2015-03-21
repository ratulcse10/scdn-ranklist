<html lang="en">
  <head>
    <title>SUST CSE Developer Network ::. SCDN</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="description" content="SUST CSE Developer Network,Dept of CSE,SUST" />
        <meta name="author" content="Abu Shahriar Ratul" />
 
    <link href="css/bootstrap.min.css" rel="stylesheet">
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
</style>



<div class="row" >
                    <div class="col-md-10 col-md-offset-1">
                        <div class="bs-component">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h3 class="panel-title" align="center">Developer Ranklist [Based on <b>Github Public Repo</b> Contribution]</h3>
                                </div>
                               	<table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>Name</th>
                                        <th>Reg</th>
                                   
                                        <th>Longest streak</th>
                                        <th>Current streak</th>
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
								
								$users[0]="ratulcse10";
								$users[1]="ratulcse27";
								
								for($i=0;$i<2;$i++){
								$data = getStatus($users[$i]);
								//print_r($data);
								echo"
								<tr class='active'>
                                        <td>1</td>
                                        <td>Md. Yousuf Ali</td>
                                        <td>2010331020</td>
                                        
                                        <td>".$data[1][0]."</td>
                                        <td>".$data[2][0]."</td>
                                    </tr>";
								
								}
								
								
								?>
                                    
                                   
                                </tbody>
                            </table>
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