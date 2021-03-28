<style>
   
    .form div
    {
        display: flex;
        margin: 30px;   
    }
    h2
    {
        margin-right: 20px;
    }
    input
    {
        margin: 20px;
        width: 100px;
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
    #submit
    {
        margin-left: 30px;
    }
    

</style>



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
        <form id="form" class="form " action="" method="POST">
            <div class="form-group w-50">
                <h2>SKU</h2> 
                <input class="form-control " id="sku" type="text" name="sku" action="<?= htmlspecialchars($_SERVER["PHP_SELF"])?>" >
                <span id="skuerror" class="error">*</span>
              
            </div>
            <div class="form-group w-50">
                <h2>Name</h2> 
                <input class="form-control"  id="name" type="text" name="name" >
                <span id="nameerror" class="error">*</span>
            </div>
            <div class="form-group w-50">
                <h2>Price</h2> 
                <input  class="form-control"  id="price"  type="text" name="price" >
                <span id="priceerror" class="error"></span>
            </div>
            <div class="form-group w-50">
                <h2>Type</h2> 
                <select id="selection" name="selection"  class="form-control" >
                    <option id="default" value="Choose">choose</option>
                    <option value="Weight">Book</option>
                    <option value="Dimensions">Furniture</option>
                    <option value="Size">DVD-disc</option>
                </select>
                <span id="selecterror" class="error">*  </span>

            </div>

            <div class='special' id="special">
                              
            </div>

            <input class="btn btn-primary" id="submit" type="submit" value="save">
            <span id="err" class="error"></span>

        </form>
        <form id="cancelform" class="form">
            <input class="btn btn-primary" id="submit" type="submit" value="cancel">
        </form>
        <span id="reslut"></span>
        <script>

                $("#cancelform").submit(function(event){ 
                    event.preventDefault();
                    window.location.replace("http://localhost/firstPHPproject/Index.php");
                 })
        

        

                let Size=  '<div class="form-group w-50" id="SizeDiv" >'+
                                '<h2>Size</h2>'+
                                '<input id="Size" class="form-control"  type="text" name="property"   >'+
                                '<span id="propertyerror" class="error"> *</span>'+

                            '</div>'
                
                let Weight=   '<div  class="form-group w-50" id="WeightDiv"  >'+
                                    '<h2>Weight</h2>'+
                                    '<input  id="Weight"  class="form-control"  type="text"  name="property" >'+
                                    '<span  id="propertyerror" class="error"> * </span>'+
                               '</div>' 
                
                let Dimensions=  '<div   class="form-group " id="DimensionsDiv"  >'+
                                        '<input type="hidden" name="prop" >'+
                                        '<h2>Height</h2>'+
                                        '<input  id="Height" class="form-control"  type="text"  value="" name="property" >'+
                                        '<h2>Width</h2>'+
                                        '<input id="Width" class="form-control"  type="text"  value="" name="property"  >'+
                                        '<h2>Length</h2>'+
                                        '<input id="Length" class="form-control"  type="text" value="" name="property">'+
                                        '<span id="propertyerror" class="error"> * </span>'+
                                 '</div>'
                
                var property="";
                $('select').on('change', function(e) {
                let value = $(this).val();
                let val = value.toString();

                $( "#special" ).empty();

                switch (val){
                    case 'Size':
                        $('#special').append($(Size));
                        var property = "Size";
                        break;
                    case 'Weight':
                        $('#special').append($(Weight));
                        var property = "Weight";

                        break;
                    case 'Dimensions':
                        $('#special').append($(Dimensions));
                        break;
                    default:
                        $('#default');
                }
                $(document).ready(function(){
                    $("#form").submit(function(event){     

                        if($("#DimensionsDiv").length !== 0)
                        {
                            let inputvalue= {"Height":$("#Height").val(),"Width":$("#Width").val(),"Length":$("#Length").val()};
                            var inputVal =JSON.stringify(inputvalue);
                            console.log(inputVal);
                        }
                        else
                        {   
                            var inputVal = $( "#"+ property).val();
                            console.log(inputVal);
                            console.log(typeof(inputVal))

                        }

      

                        event.preventDefault();
                        $.ajax({
                            url:"Validate.php",
                            type:"post",
                            cache: false,
                            data: {sku: $( "#sku" ).val(), name: $( "#name" ).val(), price: $( "#price" ).val(), property : inputVal, selection: $( "#selection" ).val()},
                            success:function(result)
                            {           
                               try{ 
                                   var errors = JSON.parse(result);
                                   $("#skuerror").html(errors.sku_err);
                                    $("#nameerror").html(errors.name_err);
                                    $("#priceerror").html(errors.price_err);
                                    $("#propertyerror").html(errors.property_err);
                                    $("#err").html(errors.err);
                               }catch(error){
                                    console.log('Error happened here!');
                                    console.log(error);

                               }

                                if (!errors.sku_err && !errors.name_err && !errors.price_err  && !errors.property_err && !errors.err) 
                                {
                                    window.location.replace("http://localhost/firstPHPproject/Index.php");

                                }
                      
                            }
                        })

                      
                    })

                });

    });

        </script>
    </body>
</html>