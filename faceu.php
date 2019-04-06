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
                                <a class="nav-item nav-link active" id="nav-id-tab" data-toggle="tab" href="#nav-id" role="tab" aria-controls="nav-id" aria-selected="true">
                                    Face Id
                                </a>
                                <a class="nav-item nav-link" id="nav-facelandmark-tab" data-toggle="tab" href="#nav-facelandmark" role="tab" aria-controls="nav-facelandmark" aria-selected="false">
                                    Face Landmark
                                </a>
                                <a class="nav-item nav-link" id="nav-faceattributes-tab" data-toggle="tab" href="#nav-faceattributes" role="tab" aria-controls="nav-faceattributes" aria-selected="false">
                                    Face Attributes
                                </a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-id" role="tabpanel" aria-labelledby="nav-id-tab">
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="card">
                                            <h3 class="ml-3 mt-2">Face Id</h3>
                                        </div>
                                    </div>
                                    <div class="col-3" style="border-right: 1px solid whitesmoke;">
                                        <div class="nav flex-column nav-pills my-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                            <a class="nav-link active sub" id="v-pills-faceid-tab" data-toggle="pill" href="#v-pills-faceid" role="tab" aria-controls="v-pills-faceid" aria-selected="true">
                                                ID
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="tab-content my-2" id="v-pills-tabContent">
                                            <div class="tab-pane fade show active" id="v-pills-faceid" role="tabpanel" aria-labelledby="v-pills-faceid-tab">
                                                <?php echo $results["values"][0]; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-facelandmark" role="tabpanel" aria-labelledby="nav-facelandmark-tab">
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="card">
                                            <h3 class="ml-3 mt-2">Face Landmark</h3>
                                        </div>
                                    </div>
                                    <div class="col-3" style="border-right: 1px solid whitesmoke;">
                                        <div class="nav flex-column nav-pills my-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                            <a class="nav-link active sub" id="v-pills-pupil-tab" data-toggle="pill" href="#v-pills-pupil" role="tab" aria-controls="v-pills-pupil" aria-selected="true">
                                                Pupil
                                            </a>
                                            <a class="nav-link sub" id="v-pills-nose-tab" data-toggle="pill" href="#v-pills-nose" role="tab" aria-controls="v-pills-nose" aria-selected="false">
                                                Nose
                                            </a>
                                            <a class="nav-link sub" id="v-pills-mouth-tab" data-toggle="pill" href="#v-pills-mouth" role="tab" aria-controls="v-pills-mouth" aria-selected="false">
                                                Mouth
                                            </a>
                                            <a class="nav-link sub" id="v-pills-eyebrow-tab" data-toggle="pill" href="#v-pills-eyebrow" role="tab" aria-controls="v-pills-eyebrow" aria-selected="false">
                                                Eyebrow
                                            </a>
                                            <a class="nav-link sub" id="v-pills-eye-tab" data-toggle="pill" href="#v-pills-eye" role="tab" aria-controls="v-pills-eye" aria-selected="false">
                                                Eye
                                            </a>
                                            <a class="nav-link sub" id="v-pills-noseroot-tab" data-toggle="pill" href="#v-pills-noseroot" role="tab" aria-controls="v-pills-noseroot" aria-selected="false">
                                                Nose Root
                                            </a>
                                            <a class="nav-link sub" id="v-pills-nosealar-tab" data-toggle="pill" href="#v-pills-nosealar" role="tab" aria-controls="v-pills-nosealar" aria-selected="false">
                                                Nose Alar
                                            </a>
                                            <a class="nav-link sub" id="v-pills-nosealarout-tab" data-toggle="pill" href="#v-pills-nosealarout" role="tab" aria-controls="v-pills-nosealarout" aria-selected="false">
                                                Nose Alarout
                                            </a>
                                            <a class="nav-link sub" id="v-pills-upperlip-tab" data-toggle="pill" href="#v-pills-upperlip" role="tab" aria-controls="v-pills-upperlip" aria-selected="false">
                                                Upper Lip
                                            </a>
                                            <a class="nav-link sub" id="v-pills-underlip-tab" data-toggle="pill" href="#v-pills-underlip" role="tab" aria-controls="v-pills-underlip" aria-selected="false">
                                                Under Lip
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="tab-content my-2" id="v-pills-tabContent">
                                            <div class="tab-pane fade show active" id="v-pills-pupil" role="tabpanel" aria-labelledby="v-pills-pupil-tab">
                                                pupil
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-nose" role="tabpanel" aria-labelledby="v-pills-nose-tab">
                                                nose
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-mouth" role="tabpanel" aria-labelledby="v-pills-mouth-tab">
                                                mouth
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-eyebrow" role="tabpanel" aria-labelledby="v-pills-eyebrow-tab">
                                                eyebrow
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-eye" role="tabpanel" aria-labelledby="v-pills-eye-tab">
                                                eye
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-noseroot" role="tabpanel" aria-labelledby="v-pills-noseroot-tab">
                                                nose root
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-nosealar" role="tabpanel" aria-labelledby="v-pills-nosealar-tab">
                                                nose alar
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-nosealarout" role="tabpanel" aria-labelledby="v-pills-nosealarout-tab">
                                                nose alarout
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-upperlip" role="tabpanel" aria-labelledby="v-pills-upperlip-tab">
                                                upper lip
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-underlip" role="tabpanel" aria-labelledby="v-pills-underlip-tab">
                                                under lip
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-faceattributes" role="tabpanel" aria-labelledby="nav-faceattributes-tab">
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="card">
                                            <h3 class="ml-3 mt-2">Face Attributes</h3>
                                        </div>
                                    </div>
                                    <div class="col-3" style="border-right: 1px solid whitesmoke;">
                                        <div class="nav flex-column nav-pills my-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                            <a class="nav-link active sub" id="v-pills-smile-tab" data-toggle="pill" href="#v-pills-smile" role="tab" aria-controls="v-pills-smile" aria-selected="true">
                                                Smile
                                            </a>
                                            <a class="nav-link sub" id="v-pills-headpose-tab" data-toggle="pill" href="#v-pills-headpose" role="tab" aria-controls="v-pills-headpose" aria-selected="true">
                                                Headpose
                                            </a>
                                            <a class="nav-link sub" id="v-pills-gender-tab" data-toggle="pill" href="#v-pills-gender" role="tab" aria-controls="v-pills-gender" aria-selected="true">
                                                Gender
                                            </a>
                                            <a class="nav-link sub" id="v-pills-age-tab" data-toggle="pill" href="#v-pills-age" role="tab" aria-controls="v-pills-age" aria-selected="true">
                                                Age
                                            </a>
                                            <a class="nav-link sub" id="v-pills-facialhair-tab" data-toggle="pill" href="#v-pills-facialhair" role="tab" aria-controls="v-pills-facialhair" aria-selected="true">
                                                Facial hair
                                            </a>
                                            <a class="nav-link sub" id="v-pills-glasses-tab" data-toggle="pill" href="#v-pills-glasses" role="tab" aria-controls="v-pills-glasses" aria-selected="true">
                                                Glasses
                                            </a>
                                            <a class="nav-link sub" id="v-pills-emotion-tab" data-toggle="pill" href="#v-pills-emotion" role="tab" aria-controls="v-pills-emotion" aria-selected="true">
                                                Emotion
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="tab-content my-2" id="v-pills-tabContent">
                                            <div class="tab-pane fade show active" id="v-pills-smile" role="tabpanel" aria-labelledby="v-pills-smile-tab">
                                                smile
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-headpose" role="tabpanel" aria-labelledby="v-pills-headpose-tab">
                                                headpose
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-gender" role="tabpanel" aria-labelledby="v-pills-gender-tab">
                                                gender
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-age" role="tabpanel" aria-labelledby="v-pills-age-tab">
                                                age
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-facialhair" role="tabpanel" aria-labelledby="v-pills-facialhair-tab">
                                                facialhair
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-glasses" role="tabpanel" aria-labelledby="v-pills-glasses-tab">
                                                glasses
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-emotion" role="tabpanel" aria-labelledby="v-pills-emotion-tab">
                                                emotion
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
