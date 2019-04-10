<?php
    include "func.php";
    // Replace <Subscription Key> with a valid subscription key.
    $ocpApimSubscriptionKey = '97c12755f25643109c2e855a1fbcc230';

    // You must use the same location in your REST call as you used to obtain
    // your subscription keys. For example, if you obtained your subscription keys
    // from westus, replace "westcentralus" in the URL below with "westus".
    $uriBase = 'https://westeurope.api.cognitive.microsoft.com/face/v1.0/';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Face Expression Detector</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">


        <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Srisakdi" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="./styles/style.css">

        <style type="text/css">
            body {
                background: #373B44;
                background: -webkit-linear-gradient(to right, #4286f4, #373B44);
                background: linear-gradient(to right, #4286f4, #373B44);
            }
            .card {
                background-color: rgba(0,0,0,.6);
            }
            .panel-collapse {
                background-color: rgba(0,0,0,.5);
            }
            #results { 
                padding:20px; border:1px solid; background:#ccc; 
            }
            a.nav-item {
                padding: 3px 10px 3px 10px;
                text-transform: uppercase;
                margin-right: 10px;
            }
            .nav-link.sub:hover, .nav-link.sub.active {
                border-left-color: whitesmoke;
                background-color: rgba(0,0,0,.3);
            }
            a.nav-link.sub {
                padding: 10px;
                padding-left: 15px;
                margin-top: 10px;
            }
            .fas {
                color: white;
            }
            .card > h3 {
                font-family: 'Srisakdi', cursive;
            }
            .panel-default > .panel-heading {
                background-color: rgba(0,0,0,.7);
                border-color: white;
            }
            .card-box {
                background-color: whitesmoke;
                box-shadow: 0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22);
                border-bottom-left-radius: 50%;
                border-bottom-right-radius: 50%;
            }
            .card-box h1 {
                font-size: 50px;
            }
            .card-box p {
                font-size: 25px;
            }
            .panel-title a {
                font-size: 18px;
                color: white;
                font-family: 'Raleway', sans-serif;
            }
            .row.general {
                margin-top: 10px;
            }
            .row.general button {
                margin-top: 25px;
                width: 10em;
            }
            .btn {
                border-radius: 0;
                text-transform: uppercase;
            }
            .form-control {
                display: block;
                width: 100%;
                padding: 0.4375rem;
                font-size: 1rem;
                line-height: 1.5;
                color: #495057;
                background-color: rgba(255, 255, 255, 1);
                background-clip: padding-box;
                border: 1px solid #d2d2d2;
                border-radius: 0;
                box-shadow: none;
                transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            }
            .form-control::-ms-expand {
                background-color: transparent;
                border: 0;
            }
            .form-control:focus {
                color: white;
                background-color: rgba(0, 0, 0, .5);
                border-color: #9acffa;
                outline: 0;
                box-shadow: none, 0 0 0 0.2rem rgba(33, 150, 243, 0.25);
            }
            .form-control:not(:placeholder-shown) {
               background-color:  rgba(0, 0, 0, .5) !important;
               color: white;
            }
            .form-control::placeholder {
                color: #6c757d;
                opacity: 1;
            }
            .form-group label {
                padding: 0;
                margin: 0;
                color: whitesmoke;
            }
            /* width */
            ::-webkit-scrollbar {
                width: 5px;
            }

            /* Track */
            ::-webkit-scrollbar-track {
                box-shadow: inset 0 0 5px grey; 
            }
             
            /* Handle */
            ::-webkit-scrollbar-thumb {
                background: grey; 
            }

            /* Handle on hover */
            ::-webkit-scrollbar-thumb:hover {
                background: navy; 
            }
        </style>
    </head>
    <body>
        <?php
            require "vendor/autoload.php";
            require "config-cloud.php";
            require 'HTTP/Request2.php';

            if (isset($_POST["submit"])) {
                $cn=makeconnection();
                $s="INSERT INTO facedetect (`Image`,
                                            `Name`,
                                            `InputAge`,
                                            `FaceId`,
                                            `PupilLeftX`,
                                            `PupilLeftY`,
                                            `PupilRightX`,
                                            `PupilRightY`,
                                            `NoseTipX`,
                                            `NoseTipY`,
                                            `MouthLeftX`,
                                            `MouthLeftY`,
                                            `MouthRightX`,
                                            `MouthRightY`,
                                            `EyeBrowLeftOuterX`,
                                            `EyeBrowLeftOuterY`,
                                            `EyeBrowLeftInnerX`,
                                            `EyeBrowLeftInnerY`,
                                            `EyeLeftOuterX`,
                                            `EyeLeftOuterY`,
                                            `EyeLeftTopX`,
                                            `EyeLeftTopY`,
                                            `EyeLeftBottomX`,
                                            `EyeLeftBottomY`,
                                            `EyeLeftInnerX`,
                                            `EyeLeftInnerY`,
                                            `EyeBrowRightInnerX`,
                                            `EyeBrowRightInnerY`,
                                            `EyeBrowRightOuterX`,
                                            `EyeBrowRightOuterY`,
                                            `EyeRightInnerX`,
                                            `EyeRightInnerY`,
                                            `EyeRightTopX`,
                                            `EyeRightTopY`,
                                            `EyeRIghtbottomX`,
                                            `EyeRIghtbottomY`,
                                            `EyeRightOuterX`,
                                            `EyeRightOuterY`,
                                            `NoseRootLeftX`,
                                            `NoseRootLeftY`,
                                            `NoseRootRightX`,
                                            `NoseRootRightY`,
                                            `NoseLeftAlarTopX`,
                                            `NoseLeftAlarTopY`,
                                            `NoseRightAlarTopX`,
                                            `NoseRightAlarTopY`,
                                            `NoseLeftAlarOutTipX`,
                                            `NoseLeftAlarOutTipY`,
                                            `NoseRightAlarOutTipX`,
                                            `NoseRightAlarOutTipY`,
                                            `UpperLipTopX`,
                                            `UpperLipTopY`,
                                            `UpperLipBottomX`,
                                            `UpperLipBottomY`,
                                            `UnderLipTopX`,
                                            `UnderLipTopY`,
                                            `UnderLipBottomX`,
                                            `UnderLipBottomY`,
                                            `Smile`,
                                            `Pitch`,
                                            `Roll`,
                                            `Yaw`,
                                            `Gender`,
                                            `Age`,
                                            `Moustache`,
                                            `Beard`,
                                            `Sideburns`,
                                            `Glasses`,  
                                            `Anger`,
                                            `Contempt`,
                                            `Disgust`,
                                            `Fear`,
                                            `Happiness`,
                                            `Neutral`,
                                            `Sadness`,
                                            `Surprise`) VALUES ('" . $_POST["imageurl"] . "',
                                                    '" . $_POST["personname"] . "',
                                                    '" . $_POST["personage"] . "',
                                                    '" . $_POST["faceid"] . "',
                                                    '" . $_POST["pupilleftx"] . "',
                                                    '" . $_POST["pupillefty"] . "',
                                                    '" . $_POST["pupilrightx"] . "',
                                                    '" . $_POST["pupilrighty"] . "',
                                                    '" . $_POST["nosetipx"] . "',
                                                    '" . $_POST["nosetipy"] . "',
                                                    '" . $_POST["mouthleftx"] . "',
                                                    '" . $_POST["mouthlefty"] . "',
                                                    '" . $_POST["mouthrightx"] . "',
                                                    '" . $_POST["mouthrighty"] . "',
                                                    '" . $_POST["eyebrowleftouterx"] . "',
                                                    '" . $_POST["eyebrowleftoutery"] . "',
                                                    '" . $_POST["eyebrowleftinnerx"] . "',
                                                    '" . $_POST["eyebrowleftinnery"] . "',
                                                    '" . $_POST["eyeleftouterx"] . "',
                                                    '" . $_POST["eyeleftoutery"] . "',
                                                    '" . $_POST["eyelefttopx"] . "',
                                                    '" . $_POST["eyelefttopy"] . "',
                                                    '" . $_POST["eyeleftbottomx"] . "',
                                                    '" . $_POST["eyeleftbottomy"] . "',
                                                    '" . $_POST["eyeleftinnerx"] . "',
                                                    '" . $_POST["eyeleftinnery"] . "',
                                                    '" . $_POST["eyebrowrightinnerx"] . "',
                                                    '" . $_POST["eyebrowrightinnery"] . "',
                                                    '" . $_POST["eyebrowrightouterx"] . "',
                                                    '" . $_POST["eyebrowrightoutery"] . "',
                                                    '" . $_POST["eyerightinnerx"] . "',
                                                    '" . $_POST["eyerightinnery"] . "',
                                                    '" . $_POST["eyerighttopx"] . "',
                                                    '" . $_POST["eyerighttopy"] . "',
                                                    '" . $_POST["eyerightbottomx"] . "',
                                                    '" . $_POST["eyerightbottomy"] . "',
                                                    '" . $_POST["eyerightouterx"] . "',
                                                    '" . $_POST["eyerightoutery"] . "',
                                                    '" . $_POST["noserootleftx"] . "',
                                                    '" . $_POST["noserootlefty"] . "',
                                                    '" . $_POST["noserootrightx"] . "',
                                                    '" . $_POST["noserootrighty"] . "',
                                                    '" . $_POST["noseleftalartopx"] . "',
                                                    '" . $_POST["noseleftalartopy"] . "',
                                                    '" . $_POST["noserightalartopx"] . "',
                                                    '" . $_POST["noserightalartopy"] . "',
                                                    '" . $_POST["noseleftalarouttipx"] . "',
                                                    '" . $_POST["noseleftalarouttipy"] . "',
                                                    '" . $_POST["noserightalarouttipx"] . "',
                                                    '" . $_POST["noserightalarouttipy"] . "',
                                                    '" . $_POST["upperliptopx"] . "',
                                                    '" . $_POST["upperliptopy"] . "',
                                                    '" . $_POST["upperlipbottomx"] . "',
                                                    '" . $_POST["upperlipbottomy"] . "',
                                                    '" . $_POST["underliptopx"] . "',
                                                    '" . $_POST["underliptopy"] . "',
                                                    '" . $_POST["underlipbottomx"] . "',
                                                    '" . $_POST["underlipbottomy"] . "',
                                                    '" . $_POST["smile"] . "',
                                                    '" . $_POST["pitch"] . "',
                                                    '" . $_POST["roll"] . "',
                                                    '" . $_POST["yaw"] . "',
                                                    '" . $_POST["gender"] . "',
                                                    '" . $_POST["age"] . "',
                                                    '" . $_POST["moustache"] . "',
                                                    '" . $_POST["beard"] . "',
                                                    '" . $_POST["sideburns"] . "',
                                                    '" . $_POST["glasses"] . "',
                                                    '" . $_POST["anger"] . "',
                                                    '" . $_POST["contempt"] . "',
                                                    '" . $_POST["disgust"] . "',
                                                    '" . $_POST["fear"] . "',
                                                    '" . $_POST["happiness"] . "',
                                                    '" . $_POST["neutral"] . "',
                                                    '" . $_POST["sadness"] . "',
                                                    '" . $_POST["surprise"] . "')";
                if (mysqli_query($cn,$s)) {
                    echo "<script>alert('You have successfully added an value.');</script>";
                } else {
                    echo "<script>alert('Adding value was unsuccessful. Please Try Again.');</script>";
                }   
                mysqli_close($cn);
            }
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
                /*$imageUrl = 'https://sarojbartaula.com.np/FaceExpressionDetector/uploads/'.$fileName; */

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
                //echo $body;

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
                    //echo "<pre>" .$result1. "</pre>";
                    // Decode JSON data into PHP associative array format
                     
                    // Call the function and print all the values
                    $results = printValues($result);
                    //echo "<h3>" . $result["total"] . " value(s) found: </h3>";
                    //echo implode("<br>", $result["values"]);
                    //to print in array style
                    //echo "<pre>" .json_encode($results, JSON_PRETTY_PRINT). "</pre>";

                    //$result = json_encode($response->getBody());
                    //echo $result;
                }
                catch (HttpException $ex)
                {
                    echo "<pre>" . $ex . "</pre>";
                }
            ?>

            <div class="container-fluid">
                <div class="card card-box">
                    <h1 class="text-center" style="font-family: 'Srisakdi', cursive;">Face Expression Detector</h1>
                    <p class="text-center">Webcam, Cloudinary, PHP and Face API</p>
                </div>
                <div class="row py-5 my-4">
                    <div class="col-xl-5 col-lg-12 col-md-12">
                        <img src="<?php echo $imageUrl; ?>" alt="Image">
                    </div>
                    <div class="col-xl-7 col-lg-12 col-md-12">
                        <div class="row general" style="font-size: 25px; color: whitesmoke;">
                            <div class="col-2">
                                <strong>Name</strong>
                            </div>
                            <div class="col-10 text-capitalize">
                                <?php echo $_POST["firstname"]; ?> <?php echo $_POST["lastname"]; ?>
                            </div>
                        </div>
                        <div class="row general" style="font-size: 25px; color: whitesmoke;">
                            <div class="col-2">
                                <strong>Age</strong>
                            </div>
                            <div class="col-10">
                                <?php echo $_POST["inputage"]; ?>
                            </div> 
                        </div>
                        <div class="row general">
                            <div class="col-12">
                                <?php include('hiddenform.php'); ?>
                            </div>
                        </div>                           
                        <nav class="mt-5">
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
                                                <div class="panel-collapse">
                                                    <div class="panel-body p-2">
                                                        &nbsp; <?php echo $results["values"][0]; ?>
                                                    </div>
                                                </div>
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
                                            <a class="nav-link sub" id="v-pills-lip-tab" data-toggle="pill" href="#v-pills-lip" role="tab" aria-controls="v-pills-lip" aria-selected="false">
                                                Lip
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="tab-content my-2" id="v-pills-tabContent">
                                            <div class="tab-pane fade show active" id="v-pills-pupil" role="tabpanel" aria-labelledby="v-pills-pupil-tab">
                                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingPupilLeft">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapsePupilLeft" aria-expanded="true" aria-controls="collapsePupilLeft">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Pupil Left
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapsePupilLeft" data-parent="#accordion" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingPupilLeft">
                                                            <div class="panel-body p-2">
                                                                <strong> &nbsp; x &nbsp; : &nbsp; </strong><?php echo $results["values"][5]; ?>
                                                                <br />
                                                                <strong> &nbsp; y &nbsp; : &nbsp; </strong><?php echo $results["values"][6]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingPupilRight">
                                                            <h4 class="panel-title">
                                                                <a class="collapsed" role="button" data-toggle="collapse" href="#collapsePupilRight" aria-expanded="false" aria-controls="collapsePupilRight">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Pupil Right
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapsePupilRight" data-parent="#accordion" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingPupilRight">
                                                            <div class="panel-body p-2">
                                                                <strong> &nbsp; x &nbsp; : &nbsp; </strong><?php echo $results["values"][7]; ?>
                                                                <br />
                                                                <strong> &nbsp; y &nbsp; : &nbsp; </strong><?php echo $results["values"][8]; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- panel-group -->
                                            </div>

                                            <div class="tab-pane fade" id="v-pills-nose" role="tabpanel" aria-labelledby="v-pills-nose-tab">
                                                <div class="panel-group" id="accordionNose" role="tablist" aria-multiselectable="true">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingNose">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseNose" aria-expanded="true" aria-controls="collapseNose">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Nose Tip
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseNose" data-parent="#accordionNose" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingNose">
                                                            <div class="panel-body p-2">
                                                                <strong> &nbsp; x &nbsp; : &nbsp; </strong><?php echo $results["values"][9]; ?>
                                                                <br />
                                                                <strong> &nbsp; y &nbsp; : &nbsp; </strong><?php echo $results["values"][10]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingNoseRootLeft">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseNoseRootLeft" aria-expanded="true" aria-controls="collapseNoseRootLeft">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Nose Root Left
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseNoseRootLeft" data-parent="#accordionNose" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingNoseRootLeft">
                                                            <div class="panel-body p-2">
                                                                <strong> &nbsp; x &nbsp; : &nbsp; </strong><?php echo $results["values"][39]; ?>
                                                                <br />
                                                                <strong> &nbsp; y &nbsp; : &nbsp; </strong><?php echo $results["values"][40]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingNoseRootRight">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseNoseRootRight" aria-expanded="true" aria-controls="collapseNoseRootRight">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Nose Root Right
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseNoseRootRight" data-parent="#accordionNose" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingNoseRootRight">
                                                            <div class="panel-body p-2">
                                                                <strong> &nbsp; x &nbsp; : &nbsp; </strong><?php echo $results["values"][41]; ?>
                                                                <br />
                                                                <strong> &nbsp; y &nbsp; : &nbsp; </strong><?php echo $results["values"][42]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingNoseLeftAlarTop">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseNoseLeftAlarTop" aria-expanded="true" aria-controls="collapseNoseLeftAlarTop">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Nose Left Alar Top
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseNoseLeftAlarTop" data-parent="#accordionNose" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingNoseLeftAlarTop">
                                                            <div class="panel-body p-2">
                                                                <strong> &nbsp; x &nbsp; : &nbsp; </strong><?php echo $results["values"][43]; ?>
                                                                <br />
                                                                <strong> &nbsp; y &nbsp; : &nbsp; </strong><?php echo $results["values"][44]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingNoseRightAlarTop">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseNoseRightAlarTop" aria-expanded="true" aria-controls="collapseNoseRightAlarTop">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Nose Right Alar Top
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseNoseRightAlarTop" data-parent="#accordionNose" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingNoseRightAlarTop">
                                                            <div class="panel-body p-2">
                                                                <strong> &nbsp; x &nbsp; : &nbsp; </strong><?php echo $results["values"][45]; ?>
                                                                <br />
                                                                <strong> &nbsp; y &nbsp; : &nbsp; </strong><?php echo $results["values"][46]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingNoseLeftAlarOutTip">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseNoseLeftAlarOutTip" aria-expanded="true" aria-controls="collapseNoseLeftAlarOutTip">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Nose Left Alar Out Tip
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseNoseLeftAlarOutTip" data-parent="#accordionNose" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingNoseLeftAlarOutTip">
                                                            <div class="panel-body p-2">
                                                                <strong> &nbsp; x &nbsp; : &nbsp; </strong><?php echo $results["values"][47]; ?>
                                                                <br />
                                                                <strong> &nbsp; y &nbsp; : &nbsp; </strong><?php echo $results["values"][48]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingNoseRightAlarOutTip">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseNoseRightAlarOutTip" aria-expanded="true" aria-controls="collapseNoseRightAlarOutTip">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Nose Right Alar Out Tip
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseNoseRightAlarOutTip" data-parent="#accordionNose" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingNoseRightAlarOutTip">
                                                            <div class="panel-body p-2">
                                                                <strong> &nbsp; x &nbsp; : &nbsp; </strong><?php echo $results["values"][49]; ?>
                                                                <br />
                                                                <strong> &nbsp; y &nbsp; : &nbsp; </strong><?php echo $results["values"][50]; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- panel-group -->
                                            </div>

                                            <div class="tab-pane fade" id="v-pills-mouth" role="tabpanel" aria-labelledby="v-pills-mouth-tab">
                                                <div class="panel-group" id="accordionMouth" role="tablist" aria-multiselectable="true">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingMouthLeft">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseMouthLeft" aria-expanded="true" aria-controls="collapseMouthLeft">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Mouth Left
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseMouthLeft" data-parent="#accordionMouth" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingMouthLeft">
                                                            <div class="panel-body p-2">
                                                                <strong> &nbsp; x &nbsp; : &nbsp; </strong><?php echo $results["values"][11]; ?>
                                                                <br />
                                                                <strong> &nbsp; y &nbsp; : &nbsp; </strong><?php echo $results["values"][12]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingMouthRight">
                                                            <h4 class="panel-title">
                                                                <a class="collapsed" role="button" data-toggle="collapse" href="#collapseMouthRight" aria-expanded="false" aria-controls="collapseMouthRight">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Mouth Right
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseMouthRight" data-parent="#accordionMouth" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingMouthRight">
                                                            <div class="panel-body p-2">
                                                                <strong> &nbsp; x &nbsp; : &nbsp; </strong><?php echo $results["values"][13]; ?>
                                                                <br />
                                                                <strong> &nbsp; y &nbsp; : &nbsp; </strong><?php echo $results["values"][14]; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- panel-group -->
                                            </div>

                                            <div class="tab-pane fade" id="v-pills-eyebrow" role="tabpanel" aria-labelledby="v-pills-eyebrow-tab">
                                                <div class="panel-group" id="accordionEyebrow" role="tablist" aria-multiselectable="true">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingEyebrowLeftOuter">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseEyebrowLeftOuter" aria-expanded="true" aria-controls="collapseEyebrowLeftOuter">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Eyebrow Left Outer
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseEyebrowLeftOuter" data-parent="#accordionEyebrow" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEyebrowLeftOuter">
                                                            <div class="panel-body p-2">
                                                                <strong> &nbsp; x &nbsp; : &nbsp; </strong><?php echo $results["values"][15]; ?>
                                                                <br />
                                                                <strong> &nbsp; y &nbsp; : &nbsp; </strong><?php echo $results["values"][16]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingEyebrowLeftInner">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseEyebrowLeftInner" aria-expanded="true" aria-controls="collapseEyebrowLeftInner">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Eyebrow Left Inner
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseEyebrowLeftInner" data-parent="#accordionEyebrow" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEyebrowLeftInner">
                                                            <div class="panel-body p-2">
                                                                <strong> &nbsp; x &nbsp; : &nbsp; </strong><?php echo $results["values"][17]; ?>
                                                                <br />
                                                                <strong> &nbsp; y &nbsp; : &nbsp; </strong><?php echo $results["values"][18]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingEyebrowRightOuter">
                                                            <h4 class="panel-title">
                                                                <a class="collapsed" role="button" data-toggle="collapse" href="#collapseEyebrowRightOuter" aria-expanded="false" aria-controls="collapseEyebrowRightOuter">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Eyebrow Right Outer
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseEyebrowRightOuter" data-parent="#accordionEyebrow" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEyebrowRightOuter">
                                                            <div class="panel-body p-2">
                                                                <strong> &nbsp; x &nbsp; : &nbsp; </strong><?php echo $results["values"][29]; ?>
                                                                <br />
                                                                <strong> &nbsp; y &nbsp; : &nbsp; </strong><?php echo $results["values"][30]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingEyebrowRightInner">
                                                            <h4 class="panel-title">
                                                                <a class="collapsed" role="button" data-toggle="collapse" href="#collapseEyebrowRightInner" aria-expanded="false" aria-controls="collapseEyebrowRightInner">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Eyebrow Right Inner
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseEyebrowRightInner" data-parent="#accordionEyebrow" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEyebrowRightInner">
                                                            <div class="panel-body p-2">
                                                                <strong> &nbsp; x &nbsp; : &nbsp; </strong><?php echo $results["values"][27]; ?>
                                                                <br />
                                                                <strong> &nbsp; y &nbsp; : &nbsp; </strong><?php echo $results["values"][28]; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- panel-group -->
                                            </div>

                                            <div class="tab-pane fade" id="v-pills-eye" role="tabpanel" aria-labelledby="v-pills-eye-tab">
                                                <div class="panel-group" id="accordionEye" role="tablist" aria-multiselectable="true">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingEyeLeftOuter">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseEyeLeftOuter" aria-expanded="true" aria-controls="collapseEyeLeftOuter">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Eye Left Outer
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseEyeLeftOuter" data-parent="#accordionEye" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEyeLeftOuter">
                                                            <div class="panel-body p-2">
                                                                <strong> &nbsp; x &nbsp; : &nbsp; </strong><?php echo $results["values"][19]; ?>
                                                                <br />
                                                                <strong> &nbsp; y &nbsp; : &nbsp; </strong><?php echo $results["values"][20]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingEyeLeftTop">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseEyeLeftTop" aria-expanded="true" aria-controls="collapseEyeLeftTop">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Eye Left Top
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseEyeLeftTop" data-parent="#accordionEye" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEyeLeftTop">
                                                            <div class="panel-body p-2">
                                                                <strong> &nbsp; x &nbsp; : &nbsp; </strong><?php echo $results["values"][21]; ?>
                                                                <br />
                                                                <strong> &nbsp; y &nbsp; : &nbsp; </strong><?php echo $results["values"][22]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingEyeLeftBottom">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseEyeLeftBottom" aria-expanded="true" aria-controls="collapseEyeLeftBottom">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Eye Left Bottom
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseEyeLeftBottom" data-parent="#accordionEye" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEyeLeftBottom">
                                                            <div class="panel-body p-2">
                                                                <strong> &nbsp; x &nbsp; : &nbsp; </strong><?php echo $results["values"][23]; ?>
                                                                <br />
                                                                <strong> &nbsp; y &nbsp; : &nbsp; </strong><?php echo $results["values"][24]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingEyeLeftInner">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseEyeLeftInner" aria-expanded="true" aria-controls="collapseEyeLeftInner">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Eye Left Inner
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseEyeLeftInner" data-parent="#accordionEye" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEyeLeftInner">
                                                            <div class="panel-body p-2">
                                                                <strong> &nbsp; x &nbsp; : &nbsp; </strong><?php echo $results["values"][25]; ?>
                                                                <br />
                                                                <strong> &nbsp; y &nbsp; : &nbsp; </strong><?php echo $results["values"][26]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingEyeRightOuter">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseEyeRightOuter" aria-expanded="true" aria-controls="collapseEyeRightOuter">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Eye Right Outer
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseEyeRightOuter" data-parent="#accordionEye" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEyeRightOuter">
                                                            <div class="panel-body p-2">
                                                                <strong> &nbsp; x &nbsp; : &nbsp; </strong><?php echo $results["values"][37]; ?>
                                                                <br />
                                                                <strong> &nbsp; y &nbsp; : &nbsp; </strong><?php echo $results["values"][38]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingEyeRightTop">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseEyeRightTop" aria-expanded="true" aria-controls="collapseEyeRightTop">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Eye Right Top
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseEyeRightTop" data-parent="#accordionEye" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEyeRightTop">
                                                            <div class="panel-body p-2">
                                                                <strong> &nbsp; x &nbsp; : &nbsp; </strong><?php echo $results["values"][33]; ?>
                                                                <br />
                                                                <strong> &nbsp; y &nbsp; : &nbsp; </strong><?php echo $results["values"][34]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingEyeRightBottom">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseEyeRightBottom" aria-expanded="true" aria-controls="collapseEyeRightBottom">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Eye Right Bottom
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseEyeRightBottom" data-parent="#accordionEye" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEyeRightBottom">
                                                            <div class="panel-body p-2">
                                                                <strong> &nbsp; x &nbsp; : &nbsp; </strong><?php echo $results["values"][35]; ?>
                                                                <br />
                                                                <strong> &nbsp; y &nbsp; : &nbsp; </strong><?php echo $results["values"][36]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingEyeRightInner">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseEyeRightInner" aria-expanded="true" aria-controls="collapseEyeRightInner">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Eye Right Inner
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseEyeRightInner" data-parent="#accordionEye" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEyeRightInner">
                                                            <div class="panel-body p-2">
                                                                <strong> &nbsp; x &nbsp; : &nbsp; </strong><?php echo $results["values"][31]; ?>
                                                                <br />
                                                                <strong> &nbsp; y &nbsp; : &nbsp; </strong><?php echo $results["values"][32]; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- panel-group -->
                                            </div>

                                            <div class="tab-pane fade" id="v-pills-lip" role="tabpanel" aria-labelledby="v-pills-lip-tab">
                                                <div class="panel-group" id="accordionLip" role="tablist" aria-multiselectable="true">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingUpperLipTop">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseUpperLipTop" aria-expanded="true" aria-controls="collapseUpperLipTop">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Upper Lip Top
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseUpperLipTop" data-parent="#accordionLip" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingUpperLipTop">
                                                            <div class="panel-body p-2">
                                                                <strong> &nbsp; x &nbsp; : &nbsp; </strong><?php echo $results["values"][51]; ?>
                                                                <br />
                                                                <strong> &nbsp; y &nbsp; : &nbsp; </strong><?php echo $results["values"][52]; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingUpperLipBottom">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseUpperLipBottom" aria-expanded="true" aria-controls="collapseUpperLipBottom">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Upper Lip Bottom
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseUpperLipBottom" data-parent="#accordionLip" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingUpperLipBottom">
                                                            <div class="panel-body p-2">
                                                                <strong> &nbsp; x &nbsp; : &nbsp; </strong><?php echo $results["values"][53]; ?>
                                                                <br />
                                                                <strong> &nbsp; y &nbsp; : &nbsp; </strong><?php echo $results["values"][54]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingUnderLipTop">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseUnderLipTop" aria-expanded="true" aria-controls="collapseUnderLipTop">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Under Lip Top
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseUnderLipTop" data-parent="#accordionLip" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingUnderLipTop">
                                                            <div class="panel-body p-2">
                                                                <strong> &nbsp; x &nbsp; : &nbsp; </strong><?php echo $results["values"][55]; ?>
                                                                <br />
                                                                <strong> &nbsp; y &nbsp; : &nbsp; </strong><?php echo $results["values"][56]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingUnderLipBottom">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseUnderLipBottom" aria-expanded="true" aria-controls="collapseUnderLipBottom">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Under Lip Bottom
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseUnderLipBottom" data-parent="#accordionLip" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingUnderLipBottom">
                                                            <div class="panel-body p-2">
                                                                <strong> &nbsp; x &nbsp; : &nbsp; </strong><?php echo $results["values"][57]; ?>
                                                                <br />
                                                                <strong> &nbsp; y &nbsp; : &nbsp; </strong><?php echo $results["values"][58]; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- panel-group -->
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
                                                <div class="panel-collapse">
                                                    <div class="panel-body p-2">
                                                        &nbsp; <?php echo $results["values"][59]; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-headpose" role="tabpanel" aria-labelledby="v-pills-headpose-tab">
                                                <div class="panel-group" id="accordionHeadpose" role="tablist" aria-multiselectable="true">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingPitch">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapsePitch" aria-expanded="true" aria-controls="collapsePitch">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Pitch
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapsePitch" data-parent="#accordionHeadpose" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingPitch">
                                                            <div class="panel-body p-2">
                                                                &nbsp; <?php echo $results["values"][60]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingRoll">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseRoll" aria-expanded="true" aria-controls="collapseRoll">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Roll
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseRoll" data-parent="#accordionHeadpose" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingRoll">
                                                            <div class="panel-body p-2">
                                                                &nbsp; <?php echo $results["values"][61]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingYaw">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseYaw" aria-expanded="true" aria-controls="collapseYaw">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Yaw
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseYaw" data-parent="#accordionHeadpose" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingYaw">
                                                            <div class="panel-body p-2">
                                                                &nbsp; <?php echo $results["values"][62]; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- panel-group -->
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-gender" role="tabpanel" aria-labelledby="v-pills-gender-tab">
                                                <div class="panel-collapse">
                                                    <div class="panel-body p-2 text-capitalize">
                                                        &nbsp; <?php echo $results["values"][63]; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-age" role="tabpanel" aria-labelledby="v-pills-age-tab">
                                                <div class="panel-collapse">
                                                    <div class="panel-body p-2">
                                                        &nbsp; <?php echo $results["values"][64]; ?>
                                                        &nbsp; &nbsp; &nbsp;
                                                        ( <?php 
                                                            $iage = $_POST["inputage"];
                                                            $gage = $results["values"][64];
                                                            if ($iage > $gage) {
                                                                echo "You look younger than you are.";
                                                            } elseif ($iage == $gage) {
                                                                echo "You are just as old as you look.";
                                                            } elseif ($iage < $gage) {
                                                                echo "You are younger than you look.";
                                                            }
                                                        ?> )
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-facialhair" role="tabpanel" aria-labelledby="v-pills-facialhair-tab">
                                                <div class="panel-group" id="accordionFacialhair" role="tablist" aria-multiselectable="true">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingMoustache">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseMoustache" aria-expanded="true" aria-controls="collapseMoustache">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Moustache
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseMoustache" data-parent="#accordionFacialhair" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingMoustache">
                                                            <div class="panel-body p-2">
                                                                &nbsp; <?php echo $results["values"][65]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingBeard">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseBeard" aria-expanded="true" aria-controls="collapseBeard">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Beard
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseBeard" data-parent="#accordionFacialhair" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingBeard">
                                                            <div class="panel-body p-2">
                                                                &nbsp; <?php echo $results["values"][66]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingSideburns">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseSideburns" aria-expanded="true" aria-controls="collapseSideburns">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Sideburns
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseSideburns" data-parent="#accordionFacialhair" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSideburns">
                                                            <div class="panel-body p-2">
                                                                &nbsp; <?php echo $results["values"][67]; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- panel-group -->
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-glasses" role="tabpanel" aria-labelledby="v-pills-glasses-tab">
                                                <div class="panel-collapse">
                                                    <div class="panel-body p-2">
                                                        &nbsp; <?php echo $results["values"][68]; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-emotion" role="tabpanel" aria-labelledby="v-pills-emotion-tab">
                                                <div class="panel-group" id="accordionEmotion" role="tablist" aria-multiselectable="true">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingAnger">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseAnger" aria-expanded="true" aria-controls="collapseAnger">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Anger
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseAnger" data-parent="#accordionEmotion" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingAnger">
                                                            <div class="panel-body p-2">
                                                                &nbsp; <?php echo $results["values"][69]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingContempt">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseContempt" aria-expanded="true" aria-controls="collapseContempt">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Contempt
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseContempt" data-parent="#accordionEmotion" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingContempt">
                                                            <div class="panel-body p-2">
                                                                &nbsp; <?php echo $results["values"][70]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingDisgust">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseDisgust" aria-expanded="true" aria-controls="collapseDisgust">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Disgust
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseDisgust" data-parent="#accordionEmotion" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingDisgust">
                                                            <div class="panel-body p-2">
                                                                &nbsp; <?php echo $results["values"][71]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingFear">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseFear" aria-expanded="true" aria-controls="collapseFear">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Fear
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseFear" data-parent="#accordionEmotion" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFear">
                                                            <div class="panel-body p-2">
                                                                &nbsp; <?php echo $results["values"][72]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingHappiness">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseHappiness" aria-expanded="true" aria-controls="collapseHappiness">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Happiness
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseHappiness" data-parent="#accordionEmotion" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingHappiness">
                                                            <div class="panel-body p-2">
                                                                &nbsp; <?php echo $results["values"][73]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingNeutral">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseNeutral" aria-expanded="true" aria-controls="collapseNeutral">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Neutral
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseNeutral" data-parent="#accordionEmotion" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingNeutral">
                                                            <div class="panel-body p-2">
                                                                &nbsp; <?php echo $results["values"][74]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingSadness">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseSadness" aria-expanded="true" aria-controls="collapseSadness">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Sadness
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseSadness" data-parent="#accordionEmotion" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSadness">
                                                            <div class="panel-body p-2">
                                                                &nbsp; <?php echo $results["values"][75]; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingSurprise">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse" href="#collapseSurprise" aria-expanded="true" aria-controls="collapseSurprise">
                                                                    <i class="more-less fas fa-angle-down"></i>
                                                                    Surprise
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseSurprise" data-parent="#accordionEmotion" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSurprise">
                                                            <div class="panel-body p-2">
                                                                &nbsp; <?php echo $results["values"][76]; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- panel-group -->
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
            <script type="text/javascript" src="./scripts/accordion.js"></script>
            
        <?php } else { ?>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>

            <div class="container-fluid">
                <div class="card card-box">
                    <h1 class="text-center" style="font-family: 'Srisakdi', cursive;">Face Expression Detector</h1>
                    <p class="text-center">Webcam, Cloudinary, PHP and Face API</p>
                </div>
               
                <form method="POST" action="faceu.php">
                    <div class="row py-5">
                        <div class="col-xl-6 col-lg-12">
                            <div id="my_camera"></div>
                            <br/>
                            <input type="hidden" name="image" class="image-tag">
                        </div>
                        <!--
                        <div class="col-lg-6 col-md-12">
                            <div id="results">Your captured image will appear here.....</div>
                        </div>
                        -->
                        <div class="col-xl-6 col-lg-12 personal-detail">
                            <div class="form-group col-6">
                                <label for="firstname" >First Name</label>
                                <input type="text" name="firstname" class="form-control" id="firstname" placeholder="First Name" onkeyup="toggleButton(this,'submitsnap');">
                            </div>
                            <div class="form-group col-6">
                                <label for="lastname" >Last Name</label>
                                <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Last Name" onkeyup="toggleButton(this,'submitsnap');">
                            </div>
                            <div class="form-group col-6">
                                <label for="age">Age</label>
                                <input type="number" min="0" name="inputage" class="form-control" id="inputage" placeholder="Your Age" required="required">
                            </div>
                            <div class="form-group col-6">
                                <button class="btn btn-success btn-lg mt-3" style="width: 100%;" disabled='disabled' id='submitsnap' onClick="take_snapshot()" name="click">Get Data</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
              
            <!-- Configure a few settings and attach camera -->
            <script language="JavaScript">
                Webcam.set({
                    width: 550,
                    height: 450,
                    image_format: 'jpeg',
                    jpeg_quality: 100
                });
              
                Webcam.attach( '#my_camera' );
              
                function take_snapshot() {
                    Webcam.snap( function(data_uri) {
                        $(".image-tag").val(data_uri);
                        //document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
                    } );
                }
            </script>
            <script>
                //prevents from resubmission when reload button is pressed
                if ( window.history.replaceState ) {
                    window.history.replaceState( null, null, window.location.href );
                }
            </script>
            <script type="text/javascript" src="./scripts/btn-hideshow.js"></script>
         
        <?php } ?>
        <div class="container-fluid footer">
            <div class="row">
                <div class="col-12 bg-dark">
                    <p class="text-center text-light" style="margin: 20px auto;">Copyright &copy; 2019. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </body>
</html>
