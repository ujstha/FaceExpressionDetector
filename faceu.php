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
            'returnFaceLandmarks' => 'true',
            'returnFaceAttributes' => 'age,gender,headPose,smile,facialHair,glasses,' .
                'emotion,hair,makeup,occlusion,accessories,blur,exposure,noise');
        $url->setQueryVariables($parameters);

        $request->setMethod(HTTP_Request2::METHOD_POST);

        // Request body parameters
        $body = json_encode(array('url' => $imageUrl));
        echo $body;

        // Request body
        $request->setBody($body);
        //function to extract the value of the data
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
            foreach($arr as $key => $value){
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
             
            // Call the function and print all the values
            $results = printValues($result);
            //echo "<h3>" . $result["total"] . " value(s) found: </h3>";
            //echo implode("<br>", $result["values"]);
 
            echo "<hr>";

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
    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <title>Face Expression Detector</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
            <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css?family=Srisakdi" rel="stylesheet">

            <link rel="stylesheet" type="text/css" href="./styles/style.css">
        </head>
        <body>
            <div class="container-fluid">
                <div class="row mb-3" style="background-color: rgba(44, 62, 80, 1);">
                    <div class="col-lg-5 col-md-6 py-3">
                        <img src="<?php echo $imageUrl; ?>" alt="Image">
                    </div>
                    <div class="col-lg-7 col-md-6 pt-3">
                        <div class="row general" style="font-size: 25px; color: whitesmoke;">
                            <div class="col-lg-2">
                                <strong>Name</strong>
                            </div>
                            <div class="col-lg-10">
                                Ujjawal Shrestha
                            </div>
                            <br/>
                            <div class="col-lg-2">
                                <strong>Age</strong>
                            </div>
                            <div class="col-lg-10">
                                23
                            </div>
                        </div>
                        <nav class="mt-5" style="margin-left: 5em;">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                                    Home
                                </a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
                                    Profile
                                </a>
                                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">
                                    Contact
                                </a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="card">
                                            <h3 class="ml-3 mt-2">Face id</h3>
                                        </div>
                                    </div>
                                    <div class="col-3" style="border-right: 1px solid whitesmoke;">
                                        <div class="nav flex-column nav-pills my-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                            <a class="nav-link active sub" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">
                                                Home
                                            </a>
                                            <a class="nav-link sub" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                                                Profile
                                            </a>
                                            <a class="nav-link sub" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">
                                                Messages
                                            </a>
                                            <a class="nav-link sub" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">
                                                Settings
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="tab-content" id="v-pills-tabContent">
                                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                                ...
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                                ...
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                                ...
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                                ...
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                ...
                            </div>
                            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                ...
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        </body>
    </html>

    <?php
        } else {
        echo "<script>alert('no data entered.');</script>";
        echo "<script> document.location.href='index.php';</script>";
    }
?>
