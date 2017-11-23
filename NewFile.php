<html>
    <head></head>
    <body>
        <b>
            <?php 
            
            $str = $_GET["comment"];
            $str1 = $str;
            $text = str_replace(array("<script>", "alert(", "<img", ), array("",  "", ""), $str);
            echo $text;


            echo "<br />";
            echo $str;
            echo "<br />";

            echo '<form id="form1" name="form1" method="post" action="">'. 
            '<input type="text" name="name0" id="text" value="' . $str . '" /><br><br>'.
            '</form>';
            
            
            ?>
        </b>
    </body>
</html>