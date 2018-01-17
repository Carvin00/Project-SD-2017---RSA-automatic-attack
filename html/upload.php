<?php

		$name_file = $_FILES['pub_key']['name'];

		$chiave = "chiavepub.pem";	
		//Nelle versioni di PHP precedenti alla 4.1.0 si deve utilizzare  $HTTP_POST_FILES anzichè
						// $_FILES.

			
			$uploadfile =  basename($_FILES['pub_key']['name']);



			if (move_uploaded_file($_FILES['pub_key']['tmp_name'], $chiave)) { 
				echo "Successo";	
			}
			
			else {
				echo "Possibile attacco tramite file upload";
			}
		
?>
