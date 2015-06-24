//DONE: My Function Get Google Map
	function getGeoLocation($country, $city, $address)
	{
		$map = "$address, $city, $country";
	  	//header('Content-type: application/json');
	  	$mapa = preg_replace('/\s+/', '+', $map);
		$map = "http://maps.googleapis.com/maps/api/geocode/json?address=$mapa&sensor=true";
		$map = file_get_contents($map);
		$map = json_decode($map,true);
		
		$data['lat'] = $map['results'][0]['geometry']['location']['lat'];
		$data['lng'] = $map['results'][0]['geometry']['location']['lng'];
		$data['map'] = '<iframe width="98%" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=sr&amp;geocode=&amp;q='.$mapa.'&amp;aq=&amp;ie=UTF8&amp;hq=&amp;hnear='.$mapa.'&amp;t=m&amp;z=15&amp;output=embed"></iframe><br />';
		
		return (object) $data;
		
	} t ds
