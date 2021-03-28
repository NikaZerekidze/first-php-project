<style>
    .content
    {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        margin: 50px;
    }
    .product
    {
        border: 2px solid black;
        width: 200px;
        font-size: 15px;
        text-align:center;
        position: relative;
        padding: 10px;
        gap: 3px;
    }
    .checkbox
    {
        position: absolute;
        left: 5px;
        top: 5px;        
    }
    .productType
    {
        position:relative;
    }
    .productType p
    {
        display: inline-block;
    }
    
    .head
    {
        width:100%;
        display:flex;
    }
    h1
    {
      margin-top:20px;
      margin-left:20px;
    }
    .massDel
    {
        position: absolute;
        right: 10px;
        top: 10px;
    }
   
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
</head>
<body>
<form method="POST" action="<?= htmlspecialchars("Delete.php")?>" >
    <div div="head">
        <h1>Product List</h1>
        <div class="massDel">
                <button  class="btn btn-primary" type="submit" name="Delete" id="Delete" >Delete</button>
                <button  type="submit" name="massDelete" id="massDelete"  class="btn btn-primary">Mass Deletion</button>
                <a href="Upload.php" class="btn btn-primary">Create</a>
        </div>
    </div>    
    <hr>
    
    <?php

    require_once "Database.php";

    $sql="SELECT * FROM productdata";

    if($result= mysqli_query($conn,$sql))
    {
        if(mysqli_num_rows($result)>0): ?>
        <form>
            <table>
                <div class="content">
                <?php
                    while($row=mysqli_fetch_array($result)): ?>
                        <div class="product">
                                    <input class="checkbox" type="checkbox" name="checkbox[]" value="<?= $row["id"] ?>">
                                    <p><?= $row["sku"] ?></p>
                                    <p><?= $row["productName"] ?></p>
                                    <p><?= $row["price"] ?>$</p>
                                    <div class="productType">
                                        <p><?= $row["productType"] ?></p>
                                        <p>:</p>
                                        <p ><?= $row["parametrs"] ?></p>
                                    </div>
                        </div>
                    <?php      
                    endwhile;   
                ?>
                </div>
            </table>
    
    <?php 
        else: "<p>No records</p>";
    endif;
    }
    else
    {
        echo "ERROR: could not execute database query".mysqli_error($conn);
    }
  
    ?>
</form>    
</body>
</html>