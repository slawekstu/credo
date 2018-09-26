<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
echo '<style>';
echo '* {box-sizing: border-box;        }';
echo 'body {margin: 0;font-family: Arial;        }';
echo '.columnWaza {float: left;width: 10%;padding: 10px;        }';
echo '.columnWaza img {opacity: 0.8;cursor: pointer;        }';
echo '.columnWaza img:hover {opacity: 1;        }';
echo '.rowHow:after {content: "";display: table;clear: both;        }';
echo '.containerHere {position: relative;display: none;        }';
echo '#imgtext {bottom: 15px;left: 15px;color: blue;position: relative;text-align: centerHuston;margin-top: 2%;bottom: 3%;font-size: 20px;        }';
echo '.closebtnExit {position: absolute;top: 10px;right: 15px;color: white;font-size: 35px;cursor: pointer;        }';
echo '.centerHuston {width:100%;height: 100%;display: block;margin-left: auto;margin-right: auto;width: 50%;        }';
echo '.myImg {    border-radius: 5px;    cursor: pointer;    transition: 0.3s;}';
echo '.myImg:hover {opacity: 0.7;}';
    
echo '.modal {    display: none;    position: fixed;     z-index: 1;     padding-top: 1%;    left: 0;    top: 0;    width: 100%;     height: 100%;     overflow: auto;     background-color: rgb(0,0,0);     background-color: rgba(0,0,0,0.9);}';
echo '.modal-content {    margin: auto;    display: block;    width: 60%;    max-width: 100%;}';
echo '#caption {    margin: auto;    display: block;    width: 80%;    max-width: 700px;    text-align: center;    color: #ccc;padding: 10px 0;    height: 150px;}';
echo '.modal-content, #caption {    -webkit-animation-name: zoom;    -webkit-animation-duration: 0.6s;    animation-name: zoom;animation-duration: 0.6s;}';
echo '@-webkit-keyframes zoom {    from {-webkit-transform:scale(0)}     to {-webkit-transform:scale(1)}}';
echo '@keyframes zoom {    from {transform:scale(0)}     to {transform:scale(1)}}';
echo '.close {    position: absolute;    top: 15px;    right: 35px;    color: #f1f1f1;    font-size: 40px;    font-weight: bold;transition: 0.3s;}';
echo '.close:hover,.close:focus {    color: #bbb;    text-decoration: none;    cursor: pointer;}';
echo '@media only screen and (max-width: 700px){    .modal-content {        width: 100%;    }}';
echo '</style></head>';
?>



<body onload="myFunction()">
    <?php 
    
    $url = "https://github.com/slawekstu/credo/tree/master/images/";
    $urlDisplay = "https://raw.githubusercontent.com/slawekstu/credo/master/images/";

    
    function getUrlsImgs($url,$urlDisplay){
        $html = file_get_contents($url);
        $dom = new DOMDocument;
        @$dom->loadHTML($html);
        $links = $dom->getElementsByTagName('a');

        $files = array();
        $files2 = array();
        $endSign = null;
        
        foreach ($links as $link){
$linkA = $link->getAttribute('href');
if(preg_match("/\.png$/", $link->nodeValue)){$files[]=$link->nodeValue; }
        }
        
        foreach ($files as $file) {
    $files2[] = substr_after_nth($file, "-");}
     
        rsort($files2);
        $output = array_slice($files2, 0, 10);
        $files = null;
        
        $mainImg = null;
        
        
        $id = 0;
        foreach ($output as $file)
        {

$endSign = null;
$endSign = substr($file, -1);
if($endSign==='b'){
    $file = substr($file,1,strlen($file)-2);
}
else{} 

echo "<div class='columnWaza' style='width:10%;float:left;padding:0.5%;'>";

$idImg = 'myImg'.$id;

if($id === 0){$idImg = 'first';} else{;}

echo "<a href=$urlDisplay$file target='blank'><img id=$idImg onmouseover=myFunction2(this) class='myImg' src=$urlDisplay$file style='opacity:0.8;cursor:pointer;width:100%;height:100%;' alt=$file></a>";
echo "</div>";
$id++;
        }
    }

    function substr_after_nth($str, $needle) 
    {
        $array = explode($needle, $str);
        $temp = array();
        for ($i = 0; $i < count($array); $i++) {$temp[] = $array[$i];}
        $test = substr($temp[2],0,2);
        $pos = strpos($test,'_',0);
        if(strlen($temp[2])===1 ||$pos){
$incorrect = ($temp[0] . '-' . $temp[1] . '-0' . $temp[2]).'b'; 
return $incorrect;
        }else{return $str;}         
    }


error_reporting(E_ERROR | E_PARSE);
//getUrlsImgs($url,$urlDisplay);
?>

    <div style="text-align:centerHuston">
        <h2>Tabbed Image Gallery</h2>
        <p>Click on the images below:</p>
    </div>

    <div class="containerHere" style="display: block;margin-left: auto;margin-right: auto;width: 50%;">
        <img id="expandedImg" />
        <div id="imgtext"></div>
    </div>

    <div class="rowHow">
        <?php getUrlsImgs($url,$urlDisplay); ?>
    </div>

    <div id="myModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="img01">
        <div id="caption"></div>
    </div>
<?php
echo '<script type="text/javascript">';
echo 'function myFunction() {';
echo 'var expandImg = document.getElementById("expandedImg");';
echo 'var imgText = document.getElementById("imgtext");';
echo "expandImg.src = document.getElementById('first').src;";
echo "imgText.innerHTML = document.getElementById('first').alt;";
echo 'expandImg.parentElement.style.display = "block";';
echo 'imgText.parentElement.style.textAlign = "center";';
echo 'imgText.parentElement.style.padding = "1%";';
echo '        };';
echo 'function myFunction2(id) {';
echo "var modal = document.getElementById('myModal');";
echo 'var modalImg = document.getElementById("img01");';
echo 'var captionText = document.getElementById("caption");';
echo 'modal.style.display = "block";';
echo 'modalImg.src = id.src;';
echo 'captionText.innerHTML = id.alt;';
echo 'var span = document.getElementsByClassName("close")[0];';
echo 'span.onclick = function() {modal.style.display = "none";}       ';
echo '};';
echo '</script>';
?>
</body>
</html>