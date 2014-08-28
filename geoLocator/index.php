<?php 

	function getGeoLocation($address)
	{
		$returnData = array();
		$map = "$address";
	  	//header('Content-type: application/json');
	  	$mapa = preg_replace('/\s+/', '+', $map);
		$map = "http://maps.googleapis.com/maps/api/geocode/json?address=$mapa&sensor=true";
		$map = file_get_contents($map);
		$map = json_decode($map,true);
		$returnData['data'] = $map['results'];
		/*var_dump($map);
		$returnData['lat'] = $map['results'][0]['geometry']['location']['lat'];
		$returnData['lng'] = $map['results'][0]['geometry']['location']['lng'];*/
		$returnData['map'] = '<iframe width="98%" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=sr&amp;geocode=&amp;q='.$mapa.'&amp;aq=&amp;ie=UTF8&amp;hq=&amp;hnear='.$mapa.'&amp;t=m&amp;z=15&amp;output=embed"></iframe><br />';
		
		return $returnData;
		
	}

	$addres = array(
		'12 Bulevar Kralja Aleksandra, Serbia, Belgrade ',
		'12 Cara Dusana, Serbia, Vojka ',
		'Germmany, Freilassing, Alpenstraße 1',
		'Germmany, Munich, Brienner Straße 40',
		'United Kingdom, Glasgow, 150 Saint Vincent Street',
		'12 Bulevar Kralja Aleksandra, Serbia, Belgrade ',
		'12 Cara Dusana, Serbia, Vojka ',
		'Germmany, Freilassing, Alpenstraße 1',
		'Germmany, Munich, Brienner Straße 40',
		'United Kingdom, Glasgow, 150 Saint Vincent Street',
		'12 Bulevar Kralja Aleksandra, Serbia, Belgrade ',
		'12 Cara Dusana, Serbia, Vojka ',
		'Germmany, Freilassing, Alpenstraße 1',
		'Germmany, Munich, Brienner Straße 40',
		'United Kingdom, Glasgow, 150 Saint Vincent Street',
		'12 Bulevar Kralja Aleksandra, Serbia, Belgrade ',
		'12 Cara Dusana, Serbia, Vojka ',
		'Germmany, Freilassing, Alpenstraße 1',
		'Germmany, Munich, Brienner Straße 40',
		'United Kingdom, Glasgow, 150 Saint Vincent Street',
		);
	
?> 

<html>
<head><title>Geo Location</title></head>
<body>
<?php
	$i = 0;
	foreach ($addres as  $value) {
		
		echo $i;
		$geoData = getGeoLocation($value);
		//echo $geoData['map'];
		//var_dump($geoData['data'][0]['address_components']);
		foreach ($geoData['data'] as $index => $values) {
		//echo $index;
		//var_dump($values);
			echo key($values);
			if($values == 'address_components'){
				//echo 'test 111111';
				/*foreach ($values as $indexItem => $valueItem) {
					if($valueItem['types'][0] == 'street_number') { echo $valueItem['long_name']; }
					if($valueItem['types'][0] == 'route') { echo $valueItem['long_name']; }
					if($valueItem['types'][0] == 'locality') { echo $valueItem['long_name']; }
					if($valueItem['types'][0] == 'country') { echo $valueItem['long_name']; }
					# code...
				}*/
			}
		
		
		}
		echo "<hr/>";
	//echo $geoData['data'][0]['address_components'][0]['long_name']; // Str Number
	//echo $geoData['data'][0]['address_components'][1]['long_name']; // Str Name / Route
	//echo $geoData['data'][0]['address_components'][2]['long_name']; // City
	//echo $geoData['data'][0]['address_components'][5]['long_name']; // Country
	//var_dump($geoData['data'][0]['geometry']['location']);
	$i++;
	usleep(200000);
	}
?>
</body>
</html>