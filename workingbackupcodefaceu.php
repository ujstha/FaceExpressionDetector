<?php
    // Replace <Subscription Key> with a valid subscription key.
    $ocpApimSubscriptionKey = '97c12755f25643109c2e855a1fbcc230';

    // You must use the same location in your REST call as you used to obtain
    // your subscription keys. For example, if you obtained your subscription keys
    // from westus, replace "westcentralus" in the URL below with "westus".
    $uriBase = 'https://westeurope.api.cognitive.microsoft.com/face/v1.0/';
?>

<?php
    require "vendor/autoload.php";
    require "config-cloud.php";
    require_once 'HTTP/Request2.php';
    // This sample uses the PHP5 HTTP_Request2 package
    // (https://pear.php.net/package/HTTP_Request2).

    if (isset($_POST['click'])) {
        $img = $_POST['image'];
        $folderPath = "uploads/";

        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);

        $f = uniqid();
        $fileName = $f . '.jpg';

        $file = $folderPath . $fileName;
        file_put_contents($file, $image_base64);


        \Cloudinary\Uploader::upload($img, array("public_id" => $f));
        $imageUrl = 'http://res.cloudinary.com/doo4zgtkg/image/upload/'.$fileName; 

    ?>
        <!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-md-6 pt-3" style="height: 800px; background-color: red;">
                <div class="card">
                    <div class="card-body row">
                        <h5 class="card-title col-md-3">Card title</h5>
                        <p class="card-text col-md-9">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <h5 class="card-title col-md-3">Card title</h5>
                        <p class="card-text col-md-9">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 pt-3" style="height: 800px; background-color: green;">
                <div class="card">
                    <img src="<?php echo $imageUrl; ?>" alt="Image">
                    <div class="card-body row">
                        <h5 class="card-title col-12">Card title</h5>
                    </div>
                    <div class="col-lg-8 offset-lg-2">
                        <div class="row">
                            <div class="col-lg-3">hello</div>
                            <div class="col-lg-9">hello paragraph</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 pt-3" style="height: 800px; background-color: blue;">
                
            </div>
        </div>
    </div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
    <?php

        //echo "<img src='".$imageUrl."' /><br/>";
        //print_r($fileName);

        $request = new Http_Request2($uriBase . 'detect');
        $url = $request->getUrl();

        $headers = array(
            // Request headers
            'Content-Type' => 'application/json',
            'Ocp-Apim-Subscription-Key' => $ocpApimSubscriptionKey
        );
        $request->setHeader($headers);

        $parameters = array(
            // Request parameters
            'returnFaceId' => 'true',
            'returnFaceLandmarks' => 'false',
            'returnFaceAttributes' => 'age,gender,headPose,smile,facialHair,glasses,' .
                'emotion,hair,makeup,occlusion,accessories,blur,exposure,noise');
        $url->setQueryVariables($parameters);

        $request->setMethod(HTTP_Request2::METHOD_POST);

        // Request body parameters
        $body = json_encode(array('url' => $imageUrl));
        echo $body;

        // Request body
        $request->setBody($body);
        function printValues($arr) {
    global $count;
    global $values;
    global $keys;
    
    // Check input is an array
    if(!is_array($arr)){
        die("ERROR: Input is not an array");
    }
    
    /*
    Loop through array, if value is itself an array recursively call the
    function else add the value found to the output items array,
    and increment counter by 1 for each value found
    */
    foreach($arr as $key=>$value){
        if(is_array($value)){
            printValues($value);
        } else{
            $values[] = $value;
            $count++;
            $keys[] = $key;
        }
    }
    
    // Return total count and values found in array
    return array('total' => $count, 'keys' => $keys, 'values' => $values);
}
 



        try
        {
            $response = $request->send();
            //to print all results $result1
            $result1 = json_encode(json_decode($response->getBody()), JSON_PRETTY_PRINT);
            $result = json_decode($response->getBody(), true);
            echo "<pre>" .$result1. "</pre>";
            // Decode JSON data into PHP associative array format
$arr = $result;
 
// Call the function and print all the values
$results = printValues($arr);
//echo "<h3>" . $result["total"] . " value(s) found: </h3>";
//echo implode("<br>", $result["values"]);
 
echo "<hr>";
 
// Print a single value
//echo $arr["faceId"] . "<br>";  // Output: J. K. Rowling
//echo $arr["faceRectangle"]["top"] . "<br>";  // Output: Harry Potter
//echo $arr["book"]["price"]["hardcover"];  // Output: $20.32

            echo "<pre>" .$results["keys"][2]. ' -> ' .$results["values"][2]. "</pre>";
            //to print in array style
            echo "<pre>" .json_encode($results, JSON_PRETTY_PRINT). "</pre>";

            //$result = json_encode($response->getBody());
            //echo $result;
        }
        catch (HttpException $ex)
        {
            echo "<pre>" . $ex . "</pre>";
        }
    } else {
        echo "<script>alert('no data entered.');</script>";
        echo "<script> document.location.href='index.php';</script>";
    }
?>
