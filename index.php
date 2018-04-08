<html>
	<body>
    
    		<?php
    
    			$clientID = "5dbc4164710244928730667baf07ee91";
    			$redictURI = "https://workspace-jlyashko.c9users.io/Hackathon/ig.html";
    			$token = "46891593.5dbc416.06c0b9b834fb4828b3f5099d3eb9e0a6";
    
   			 $igUrl = "https://api.instagram.com/v1/users/self/media/recent/?access_token=".$token;
    
   			 //Initialize cURL.
    			$ch = curl_init($igUrl);
 
    			//Set the URL that you want to GET by using the CURLOPT_URL option.
   			 curl_setopt($ch, CURLOPT_URL, $igUrl);
 
   			 //Set CURLOPT_RETURNTRANSFER so that the content is returned as a variable.
    			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
    			//Set CURLOPT_FOLLOWLOCATION to true to follow redirects.
    			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
 
    			//Execute the request.
    			$data = (string) curl_exec($ch);
 
			//Close the cURL handle.
    			curl_close($ch);

    
    			$content = json_decode($data, true);

			$numPixels = 0;
			$standardColors = array(
    				array(0, 0, 0),         //black
    				array(255, 255, 255),   //white
				array(255, 0, 0),       // red
				array(0,255,0),         // green
				array(0,0,255),         //blue
				array(255,255,0),       // yellow
				array(0,255,255),       //cyan
				array(255,165,0),       //orange
				array(255,0,255)       //magenta
    
    			);
			$occurences = array(0,0,0,0,0,0,0,0,0);


			$pics = array(
			    $content["data"][0]["images"]["low_resolution"]["url"],
			    $content["data"][1]["images"]["low_resolution"]["url"],
			    $content["data"][2]["images"]["low_resolution"]["url"],
			    $content["data"][3]["images"]["low_resolution"]["url"],
			    $content["data"][4]["images"]["low_resolution"]["url"],
			    $content["data"][5]["images"]["low_resolution"]["url"]
  	 		);
   

    
    			for($j = 0;$j<6;$j++){
        			echo "<img src='".$pics[$j]."'/>";
				
    				$c = file_get_contents($pics[$j]);
    				$image = imagecreatefromstring($c);// imagecreatefromjpeg/png/
    				$width = imagesx($image);
				$height = imagesy($image);
				echo $j;
				for ($y = 0; $y < $height; $y++) {
		
					for ($x = 0; $x < $width; $x++) {
    
    						$leastDiff = 255*3;
    						$toAdd = 0;
						$rgb = imagecolorat($image, $x, $y);
						$r = ($rgb >> 16) & 0xFF;
						$g = ($rgb >> 8) & 0xFF;
						$b = $rgb & 0xFF;

        					for ($i = 0; $i < 9; $i++) {
            						$diff = abs($standardColors[$i][0] - $r) + abs($standardColors[$i][1] - $g) + abs($standardColors[$i][2] - $b);
                
                					if($diff<$leastDiff){
                    					$leastDiff = $diff;
                    					$toAdd=$i;  
                					}
             
           				 	}
         					$occurences[$toAdd]++;

    					} 

				}

				$numPixels += $height * $width;
			}


			echo "Black: " , ($occurences[0] / $numPixels * 100) , "<br></br>";
			echo "White: " , ($occurences[1] / $numPixels * 100) , "<br></br>";
			echo "Red: " , ($occurences[2] / $numPixels * 100) , "<br></br>";
			echo "Green: " , ($occurences[3] / $numPixels * 100) , "<br></br>";
			echo "Blue: " , ($occurences[4] / $numPixels * 100) , "<br></br>";
			echo "Yellow: " , ($occurences[5] / $numPixels * 100) , "<br></br>";
			echo "Cyan: " , ($occurences[6] / $numPixels * 100) , "<br></br>";
			echo "Orang: " , ($occurences[7] / $numPixels * 100) , "<br></br>";
			echo "Magenta: " , ($occurences[8] / $numPixels * 100) , "<br></br>";
    
    		?>

	</body>

</html>
