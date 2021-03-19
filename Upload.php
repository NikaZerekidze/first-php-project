<style>
    .form div
    {
        display: flex;
        margin: 30px;    
    }
    input
    {
        margin: 20px;
    }
    select
    {
        margin: 20px;
    }
    .special
    {
        height: 100px;
        width:auto;
        border: 1px dashed #999;
        font-size: 20px;    
    }
    .error
    {
        color: red;
    }

</style>


<?php
    require_once "Database.php";

    $sku="";
    $name="";
    $price="";
    $selection="";
    $property="";
    $sku_err=$name_err=$price_err=$select_err=$property_err="";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $sku = test_input($_POST["sku"]);
        if(empty($sku))
        {
            $sku_err="please enter a sku code";
        }

        $name = test_input($_POST["name"]);
        if(empty($name))
        {
            $name_err="please enter a name";
        }
        elseif(!filter_var($name, FILTER_VALIDATE_REGEXP, array("options"=>["regexp"=>"/^([a-zA-Z' ]+)$/"]) ) )
        {
            $name_err="please valid a name";
        }

        $price = test_input($_POST["price"]);
        if(empty($price))
        {
            $price_err="please enter a price";
        }
        elseif(!ctype_digit($price))
        {
            $price_err="please enter a positive integer value";
        }

        $selection = test_input($_POST["selection"]);

        //////

        
        // if(class_exists('foo')) {
        // $html = file_get_html('http://localhost/firstPHPproject/Upload.php');
        // $Dimensions = $html->find("div#Dimensions");

        $funitureProp=array();

        if(isset($_POST['Dimensions']))
        {
            // if(!ctype_digit($property))
            // {
            //     $property_err="please enter a positive integer value";
            // }

            array_push($funitureProp,$_POST['property'],$_POST['property'],$_POST['property']);
            
            list($a, $b, $c) = $funitureProp;
            $props="$a X $b X $c";
            $property=$props;
            
            if(empty($property))
            {
                $property_err="please enter property";
            }  

        }
        else
        {
            $property=test_input($_POST["property"]);
            if(empty($property))
            {
                $property_err="please enter property";
            }
            elseif(!ctype_digit($property))
            {
                $property_err="please enter a positive integer value";
            }

        }

      ///////problema!!! poroperty is marto bolo mnishvnelobas achvenebs,
      //// gaertianeba daxatvashi iqneba problema gamosavali?

        if(empty($sku_err) && empty($name_err) && empty($price_err) && empty($property_err) && empty($property_err))
        {
            $sql="INSERT INTO productdata (sku, productName, price, productType, parametrs) VALUE (?,?,?,?,?)";
            if($stmt=mysqli_prepare($conn, $sql))
            {
                mysqli_stmt_bind_param($stmt,"sssss",$sku,$name,$price,$selection,$property);
                if(mysqli_stmt_execute($stmt))
                {
                    header("location: Index.php");
                    exit();
                }
                else
                {
                    echo "somthing went wrong";
                }
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_close($conn);
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }


?>

<!DOCTYPE html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
    <body>

        <h1>Product Add</h1>
        <hr>
        <form class="form" action="<?= htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST">
            <div class="form-group">
                <h2>SKU</h2> 
                <input class="form-control" type="text" name="sku" value="<?= $sku ?>">
                <span class="error">* <?= $sku_err ?></span>
              
            </div>
            <div class="form-group">
                <h2>Name</h2> 
                <input class="form-control"  type="text" name="name" value="<?= $name ?>">
                <span class="error">*<?= $name_err ?></span>
            </div>
            <div class="form-group">
                <h2>Price</h2> 
                <input  class="form-control"  type="text" name="price" value="<?= $price ?>">
                <span class="error">* <?= $price_err ?></span>
            </div>
            <div class="form-group">
                <h2>Type</h2> 
                <select name="selection"  class="form-control" >
                    <option value="Weight">Book</option>
                    <option value="Dimensions">Furniture</option>
                    <option value="Size">DVD-disc</option>
                </select>
                <span class="error">* <?= $select_err ?> </span>

            </div>

            <div class='special' id="special">
                                <div  class="form-group" id="Weight" >
                                    <h2>Weight</h2>
                                    <input  class="form-control"  type="text"  name="property" >
                                    <span class="error"> * <?= $property_err ?></span>
                                </div>
            </div>

            <input class="btn btn-primary" type="submit" value="save">

        </form>

        <script>

                let Size=  '<div class="form-group" id="Size" >'+
                                '<h2>Size</h2>'+
                                '<input  class="form-control"  type="text" name="property"  value="<?= $property ?>" >'+
                                '<span class="error"> *<?= $property_err ?></span>'+

                            '</div>'
                
                let Weight=   '<div  class="form-group" id="Weight"  >'+
                                    '<h2>Weight</h2>'+
                                    '<input  class="form-control"  type="text"  name="property" value="<?= $property ?>">'+
                                    '<span class="error"> * <?= $property_err ?></span>'+
                               '</div>' 
                
                let Dimensions=  '<div   class="form-group" id="Dimensions"  >'+
                                        '<input type="hidden" name="Dimensions" >'+
                                        '<h2>Height</h2>'+
                                        '<input  class="form-control"  type="text"  value="" name="property"  value="<?= $property ?>">'+
                                        '<h2>Width</h2>'+
                                        '<input  class="form-control"  type="text"  value="" name="property"  value="<?= $property ?>">'+
                                        '<h2>Length</h2>'+
                                        '<input  class="form-control"  type="text" value="" name="property"  value="<?= $property ?>">'+
                                        '<span class="error"> * <?= $property_err ?></span>'+
                                 '</div>'
                
                // $('#special').append($(Weight));


                $('select').on('change', function(e) {
                let value = $(this).val();
                let val = value.toString();

                $( "#special" ).empty();

                switch (val){
                    case 'Size':
                        $('#special').append($(Size));
                        break;
                    case 'Weight':
                        $('#special').append($(Weight));
                        break;
                    case 'Dimensions':
                        $('#special').append($(Dimensions));
                        break;
                    default:
                        $('#special').append($(weight));
                }
            
     
    });

        </script>
    </body>
</html>