<?php 
    require_once "Database.php";

    if(isset($_POST["Delete"]))
    {
        $deletion=$_POST["checkbox"];

        foreach($deletion as $id)
        {
            mysqli_query($conn , "DELETE FROM productdata WHERE id=".$id);
        }
        header("location: Index.php");
    }

    if(isset($_POST["massDelete"]))
    {
        
        
        mysqli_query($conn , "DELETE FROM productdata WHERE id");
        
        header("location: Index.php");
    }

    mysqli_close($conn);

?>