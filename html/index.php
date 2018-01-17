<DOCTYPE HTML>
<html lang="it">
<head>  
  <title>Progetto SD | HomePage</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <link rel="stylesheet" href="css/homepage.css" type="text/css" />
  <link rel="stylesheet" href="css/insert.css" type="text/css" />
 
  <!-- modernizr enables HTML5 elements and feature detects -->
  <script type="text/javascript" src="css/modernizr-1.5.min.js"></script> 
</head>

<script>

	function main(){
       
    	var file_upload = document.getElementById("uploadfile");
                
        	if (formValidate(file_upload.value)){    
            	var formData = new FormData();
                /* Add the file */ 
                formData.append("pub_key", file_upload.files[0]);                
                ajaxFileUpload(formData);
            }
            else {
            	document.getElementById("response").innerHTML = "Form non valido";
            }
    }
                
    function formValidate(str){     
                   
    	if (str !== ""){
        	return true
        }                       
        else { 
        	return false;                        
        }
    }
           
        
    function ajaxFileUpload(fd){
       
        if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
        	xmlhttp=new XMLHttpRequest();
        }
    	else{// code for IE6, IE5
        	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
                   
        xmlhttp.onreadystatechange=function(){
        	if (xmlhttp.readyState==4 && xmlhttp.status==200){
            	document.getElementById("response").innerHTML = this.responseText;
            }
        }                   
             
        xmlhttp.open("POST","upload.php",true);
        xmlhttp.send(fd);
	}
       
    function eseguiScript(str){
    	if (str==""){
        	document.getElementById("txtHint").innerHTML="";
        	return;
        } 

        if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
        	xmlhttp=new XMLHttpRequest();
        }
        else{// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
                   
        xmlhttp.onreadystatechange=function(){
        	if (xmlhttp.readyState==4 && xmlhttp.status==200){
            	var res = document.getElementById("response");
                res.innerHTML = this.responseText;
                var downloadButton = document.createElement("INPUT");
                downloadButton.addEventListener("click", download);
                downloadButton.setAttribute("type", "button");
                downloadButton.setAttribute("id", "download_button");
                downloadButton.setAttribute("value", "Download");
                downloadButton.setAttribute("tabindex", "5");
                downloadButton.style.width = "100px";
                downloadButton.style.backgroundColor = "#4CAF50";
                downloadButton.style.color = "white";
                downloadButton.style.hover = "";
                var bottoni = document.getElementById("bottoni");
                bottoni.appendChild(downloadButton);
                        
                var input = document.getElementsByTagName("INPUT");
                bottoni.removeChild(input[1]);
                bottoni.removeChild(input[1]);
            }
        }         
			xmlhttp.open("GET","script.php",true);
            xmlhttp.send();
	}  
	
	function download(){
		window.open('chiavePrivata.pem');
	}
	
	
	function resetForm(){
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
                   
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				location.reload();  
			}
		}
		                   
		xmlhttp.open("GET","reset.php",true);
		xmlhttp.send();

	}
		
</script>

<body>
	<div id="site_content">
    	<div class="content">
			<h1 class="home"> Inserisci chiave pubblica </h1>
            <div id="form-1" style="float:left;">
            	<form id="insert" name="f1">
                	<div class="form_settings">
                    	<p><span class="paragraph-content">File</span>
						<input type="file" id="uploadfile" name="image" tabindex="4"></p>
						<p id="bottoni" style="display:inline;float:right;margin-right:50px;">
							<input type="button"  name="insert" onclick="main()"  style="width:100px;" tabindex="5" value="Inserisci"/>
							<input type="button"  name="factor" onclick="eseguiScript()"  style="width:100px;" tabindex="6" value="Calcola"/>
							<input type="button"  name="reset" onclick="resetForm()"  style="width:100px;" tabindex="5" value="Reset"/>
						</p>
					</div>
				</form>
            </div>

        <div id="response"></div>
    	</div>
    </div>
</body>
</html>
	
	
	
	

	
	
	    
           
          

