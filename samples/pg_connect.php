<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include_once 'dbconnect.php';
        
        pg_query($conn, "select * from users");
        /*pg_query($conn, "copy bar from stdin");
        pg_put_line($conn, "3\thello world\t4.5\n");
        pg_put_line($conn, "4\tgoodbye world\t7.11\n");
        pg_put_line($conn, "\\.\n");
        pg_end_copy($conn);*/
        
        $query = "SELECT * FROM users";   

        $result = pg_exec($conn, $query);   

        echo "Number of rows: " . pg_numrows($result);   

        pg_freeresult($result);   

        pg_close($conn);   

        ?>
    </body>
</html>
