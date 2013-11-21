<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta content="text/html; charset=windows-1252" http-equiv="Content-Type" />
    <title>Test XHR / Ajax Streaming without polling
</title>
    <script>
     
    function doClear()
    {
        document.getElementById("divProgress").innerHTML = "";
    }
     
    function log_message(message)
    {
        document.getElementById("divProgress").innerHTML += message + '<br />';
    }
     
    function ajax_stream()
    {
        if (!window.XMLHttpRequest)
        {
            log_message("Your browser does not support the native XMLHttpRequest object.");
            return;
        }
         
        try
        {
            var xhr = new XMLHttpRequest();  
            xhr.previous_text = '';
             
            //xhr.onload = function() { log_message("[XHR] Done. responseText: <i>" + xhr.responseText + "</i>"); };
            xhr.onerror = function() { log_message("[XHR] Fatal Error."); };
            xhr.onreadystatechange = function() 
            {
                try
                {
                    if (xhr.readyState > 2)
                    {
                        var new_response = xhr.responseText.substring(xhr.previous_text.length);
                        var result = JSON.parse( new_response );
                        log_message(result.message);
                        //update the progressbar
                        document.getElementById('progressor').style.width = result.progress + "%";
                        xhr.previous_text = xhr.responseText;
                    }   
                }
                catch (e)
                {
                    //log_message("<b>[XHR] Exception: " + e + "</b>");
                }
                 
                 
            };
     
            xhr.open("GET", "ftp_connect.php", true);
            xhr.send("Making request...");      
        }
        catch (e)
        {
            log_message("<b>[XHR] Exception: " + e + "</b>");
        }
    }
 
    </script>
</head>
 
<body>
    Ajax based streaming without polling
    <br /><br />
    <button onclick="ajax_stream();">Start Ajax Streaming</button>
    <button onclick="doClear();">Clear Log</button>
    <br />
    Results
    <br />
    <div style="border:1px solid #000; padding:10px; width:300px; height:200px; overflow:auto; background:#eee;" id="divProgress"></div>
    <br />
    <div style="border:1px solid #ccc; width:300px; height:20px; overflow:auto; background:#eee;">
        <div id="progressor" style="background:#07c; width:0%; height:100%;"></div>
    </div>
</body>
</html>