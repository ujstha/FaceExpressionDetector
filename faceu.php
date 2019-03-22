

<?php
// Replace <Subscription Key> with a valid subscription key.
$ocpApimSubscriptionKey = '97c12755f25643109c2e855a1fbcc230';

// You must use the same location in your REST call as you used to obtain
// your subscription keys. For example, if you obtained your subscription keys
// from westus, replace "westcentralus" in the URL below with "westus".
$uriBase = 'https://westeurope.api.cognitive.microsoft.com/face/v1.0/';


?>

<?php
/*
if(isset($_POST["upload"])) {
    $cn=makeconnection();
    $i = 0;
    $target_dir = "uploads/";
    //img
    $target_file = $target_dir.basename($_FILES["faceu"]["name"]);
    $uploadok = 1;
    $imagefiletype = pathinfo($target_file, PATHINFO_EXTENSION);
    //check if image file is a actual image or fake image
    $check=getimagesize($_FILES["faceu"]["tmp_name"]);
    if($check!==false) {
        $uploadok = 1;
    } else {
        $imgMsg = "File is not an image.";
        $imgMsgClass = 'alert-danger';
        $uploadok=0;
    }
    //check if file already exists
    if(file_exists($target_file)){
        $uploadok=1;
    }
    //check file size
    if($_FILES["faceu"]["size"]>500000){
        $uploadok=1;
    }
    //allow certain file formats
    if($imagefiletype != "jpg" && $imagefiletype !="png" && $imagefiletype !="jpeg" && $imagefileype !="gif"){
        $imgMsg = "Sorry, only jpg, jpeg, png & gif files are allowed.";
        $imgMsgClass = 'alert-danger';
        $uploadok=0;
    } else {
        if(move_uploaded_file($_FILES["faceu"]["tmp_name"], $target_file)){
            $i = 1; 
        } else {
            $imgMsg = "Sorry, there was an error uploading your file.";
            $imgMsgClass = 'alert-danger';
        }
    }
    if ($i > 0) {
        $s="INSERT INTO snapshot (`Image`) VALUES ('" . basename($_FILES["faceu"]["name"]) . "')";
        if (mysqli_query($cn,$s)) {
            echo "<script>alert('photo uploaded')</script>";
        } else {
            echo "<script>alert('upload error')</script>";
        }
        mysqli_close($cn);
    }           
}
*/
/*
    
    $img = $_POST['image'];
    $folderPath = "uploads/";
  
    $image_parts = explode(";base64,", $img);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
  
    $image_base64 = base64_decode($image_parts[1]);
    $fileName = uniqid() . '.jpg';
  
    $file = $folderPath . $fileName;
    file_put_contents($file, $image_base64);
  
    print_r($fileName);
    print_r($image_base64.'base64');
    print_r($image_type.'hoolatype');
    print_r($image_type_aux.'type aux');
    print_r($image_parts.'img parts');
    print_r($img.'img');

/*
<!--<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
    <div class="">
        <input type="file" name="faceu" required=""/>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" name="upload" class="btn" id="submit">Add</button>
    </div>
</form>


<?php
    
   //$cn=makeconnection();
        //$s="SELECT * FROM snapshot where id=1";
        //$q=mysqli_query($cn,$s);
        //$r=mysqli_num_rows($q);
        //while ($data = mysqli_fetch_array($q)) {
        //        $imageUrl = $data['Image'];
       ?>

       <img src="http://localhost/faceu/uploads/<?php echo $imageUrl;?>">
   <?php }?>
   -->
*/

   require "vendor/autoload.php";
    require "config-cloud.php";
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
  
    print_r($fileName);

        \Cloudinary\Uploader::upload($img, array("public_id" => $f));
$imageUrl = 'http://res.cloudinary.com/doo4zgtkg/image/upload/'.$fileName; 


// This sample uses the PHP5 HTTP_Request2 package
// (https://pear.php.net/package/HTTP_Request2).
require_once 'HTTP/Request2.php';

$request = new Http_Request2($uriBase . '/detect');
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

// Request body
$request->setBody($body);

try
{
    $response = $request->send();
    echo "<pre>" .
        json_encode(json_decode($response->getBody()), JSON_PRETTY_PRINT) . "</pre>";
}
catch (HttpException $ex)
{
    echo "<pre>" . $ex . "</pre>";
}
?>