<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link href="main.css" rel="stylesheet">
  <title>Meteo</title>
  <meta name="description" content="The HTML5 Herald">
  <meta name="author" content="SitePoint">

</head>

<body>

<?php

$ville = $_POST['meteo'];

//turning off low level notices
error_reporting(E_ALL ^ E_NOTICE);

//instantiate the class
include('weatherstack.class.php');
$weather = new weatherStack();

//set the end point to use
//free plan uses the 'current' endpoint
//we can set it with 'current' or 'c' shorthand
$weather->setEndPoint('c');

//set the query parameter
$weather->setParam('query',$ville);

//optionally set the units
$weather->setParam('units','m');

//get the response
$weather->getResponse();

//show specific response data
echo 'La température actuelle à '.$weather->response->location->name.', '
    .$weather->response->location->region.' est de '
    .$weather->response->current->temperature
    .' degrés ('.$weather->response->request->unit.') la date : '
    .$weather->response->location->localtime;
    

echo '<hr>';

?><u><?php echo 'Informations sur le vent :';?></u><br><br><?php echo 'La Vitesse du vent est de ' .$weather->response->current->wind_speed. 'Km/h et un vent qui vient du ' .$weather->response->current->wind_dir.' avec un un axe de '.$weather->response->current->wind_degree.'°';
?><br><hr><?php echo 'L\'indice UV est de '.$weather->response->current->uv_index;

?>

<script  type="text/javascript"  charset="utf-8">  
    (function(w,d,t,f){  w[f]=w[f]||function(c,k,n){s=w[f],k=s['k']=(s['k']||(k?('&k='+k):''));s['c']=  
    c=(c  instanceof  Array)?c:[c];s['n']=n=n||0;L=d.createElement(t),e=d.getElementsByTagName(t)[0];  
    L.async=1;L.src='//feed.aqicn.org/feed/'+(c[n].city)+'/'+(c[n].lang||'')+'/feed.v1.js?n='+n+k;  
    e.parentNode.insertBefore(L,e);  };  })(  window,document,'script','_aqiFeed'  );    
</script>
<span  id="city-aqi-container"></span>  
  
  <script  type="text/javascript"  charset="utf-8">  
       var ville = <?php echo json_encode($ville); ?>;
      _aqiFeed({  container:"city-aqi-container",  city: ville, display:"La qualité de l'air à %cityname est de %aqi<br><small>on  %date</small>", lang:"fr" });
        
  </script>

  
</body>
</html>