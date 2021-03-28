<?php
    require_once "Database.php";

    $sku="";
    $name="";
    $price="";
    $selection="";
    $property="";
    $sku_err=$name_err=$price_err=$select_err=$property_err=$err="";
    
    if(isset($_POST['sku']))
    {       
        $sku = test_input($_POST["sku"]);
        
        if(empty($sku))
        {
            $sku_err="please enter sku value";
        }
    }

    if(isset($_POST['name']))
    {       
        $name = test_input($_POST["name"]);
        
        if(empty($name))
        {
            $name_err="please enter name value";
        }
        elseif(!filter_var($name, FILTER_VALIDATE_REGEXP, array("options"=>["regexp"=>"/^([a-zA-Z' ]+)$/"]) ) )
        {
            $name_err="please enter valid a name";
        }
    }

    if(isset($_POST['price']))
    {       
        $price = test_input($_POST["price"]);
        
        if(empty($price))
        {
            $price_err="please enter price value";
        }
        elseif(!ctype_digit($price))
        {
            $price_err="please enter a positive integer value";
        }
    }
    
    $selection = test_input($_POST["selection"]);

    if(isset($_POST['property']))
    {
            $property= test_input($_POST["property"]);

            $prop=json_decode($property,true);


            if(gettype($prop)==="array")
            {
                $funitureProp=array();

               foreach($prop as $key => $value)
               {
                    if(empty($value))
                    {
                        $property_err="please enter property we are in dimensions";
                        break;
                    } 
                    elseif(!ctype_digit($value))
                    {
                        $property_err="please enter a positive integer value we are in dimensions";
                        break;
                    }
                    array_push($funitureProp,$value);
                                
               }

               list($a, $b, $c) = $funitureProp;
               $props="$a X $b X $c";
               $property=$props;
            }
            

            else
            {   
                // $property_err=$property;
                if(empty($property))
                {
                    $property_err="please enter  property";
                }  
                elseif(!ctype_digit($property))
                {
                    $property_err="please enter a positive integer  value sda";
                }
               
            }
           

    }

   


    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        // $data = htmlspecialchars($data);
        return $data;
    }
   
    if(empty($sku_err) && empty($name_err) && empty($price_err) && empty($property_err))
    {
        $sql="INSERT INTO productdata (sku, productName, price, productType, parametrs) VALUE (?,?,?,?,?)";
        if($stmt=mysqli_prepare($conn, $sql))
        {

            mysqli_stmt_bind_param($stmt,"sssss",$sku,$name,$price,$selection,$property);

            if(!mysqli_stmt_execute($stmt))
            {
                
                $err="somthing went wrong";
                // header("location: Index.php");
            }
          
        }
       
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);

    echo json_encode(array("sku_err"=>$sku_err,"name_err"=>$name_err, "price_err"=>$price_err,"property_err"=>$property_err,"err"=>$err));


?>