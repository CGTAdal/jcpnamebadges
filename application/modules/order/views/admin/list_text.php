<?php 
	if($badges){
		foreach($badges as $badge) {
			if(isset($badge['name'])){
				echo $badge['name'];
			}
			if(isset($badge['title'])){
				echo ($badge['title']=='no title included')?'':"\t".$badge['title'];
			}
			if(isset($badge['license'])){
				echo ($badge['license']=='')?'':"\t".$badge['license'];
			}
			if(isset($badge['spk_spanish']) && $badge['spk_spanish']!=""){
				echo ($badge['spk_spanish']=='Yes')?"\thablo español":'';	
			}
            if(isset($badge['hearing_impaired']) && $badge['hearing_impaired']!=""){
                echo ($badge['hearing_impaired']=='Yes')?"\thearing impaired":'';
            }
            if(isset($badge['dasl']) && $badge['dasl']!=""){
                echo ($badge['dasl']=='Yes')?"\tDeaf-ASL":'';
            }
			echo "\r\n";
 		}
	}
?>