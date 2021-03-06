<?php
/**
 * PHP Server-Side Example for Fine Uploader S3.
 * Maintained by Widen Enterprises.
 *
 * Note: This is the exact server-side code used by the S3 example
 * on fineuploader.com.
 *
 * This example:
 *  - handles both CORS and non-CORS environments
 *  - handles delete file requests for both DELETE and POST methods
 *  - Performs basic inspections on the policy documents and REST headers before signing them
 *  - Ensures again the file size does not exceed the max (after file is in S3)
 *  - signs policy documents (simple uploads) and REST requests
 *    (chunked/multipart uploads)
 *  - returns a thumbnailUrl in the response for older browsers so thumbnails can be displayed next to the file
 *
 * Requirements:
 *  - PHP 5.3 or newer
 *  - Amazon PHP SDK (only if utilizing the AWS SDK for deleting files or otherwise examining them)
 *
 * If you need to install the AWS SDK, see http://docs.aws.amazon.com/aws-sdk-php-2/guide/latest/installation.html.
 */

// You can remove these two lines if you are not using Fine Uploader's
// delete file feature
// require 'aws-autoloader.php';
// use Aws\S3\S3Client;

// These assume you have the associated AWS keys stored in
// the associated system environment variables

// User IAM
// $clientPrivateKey = $_SERVER['BIsYDPrOfWyWeUXueJaiaAem7he3R5THnil57Iqn'];
$clientPrivateKey = 'vwcIZ3k+ORUISiXhP//iswr2S8GbKULPRNS0UrFk';

// Security Credentials
// $clientPrivateKey = $_SERVER['fDs8XQgNoW/XdGEVJDsr+cxVYyTTZFMt9qxtRJfh'];

// These two keys are only needed if the delete file feature is enabled
// or if you are, for example, confirming the file size in a successEndpoint
// handler via S3's SDK, as we are doing in this example.
// $serverPublicKey = $_SERVER['PARAM1'];
// $serverPrivateKey = $_SERVER['PARAM2'];

// The following variables are used when validating the policy document
// sent by the uploader: 
$expectedBucketName = "devwahapi";
// $expectedMaxSize is the value you set the sizeLimit property of the 
// validation option. We assume it is `null` here. If you are performing
// validation, then change this to match the integer value you specified
// otherwise your policy document will be invalid.
// http://docs.fineuploader.com/branch/develop/api/options.html#validation-option
$expectedMaxSize = 5242880;

$method = getRequestMethod();

// This first conditional will only ever evaluate to true in a
// CORS environment
if ($method == 'OPTIONS') {
    handlePreflight();
}
// This second conditional will only ever evaluate to true if
// the delete file feature is enabled
else if ($method == "DELETE") {
    handlePreflightedRequest(); // only needed in a CORS environment
    deleteObject();
}
// This is all you really need if not using the delete file feature
// and not working in a CORS environment
else if	($method == 'POST') {
    handlePreflightedRequest();

    // Assumes the successEndpoint has a parameter of "success" associated with it,
    // to allow the server to differentiate between a successEndpoint request
    // and other POST requests (all requests are sent to the same endpoint in this example).
    // This condition is not needed if you don't require a callback on upload success.
    if (isset($_REQUEST["success"])) {
        verifyFileInS3(shouldIncludeThumbnail());
    }
    else {
        signRequest();
    }
}

// This will retrieve the "intended" request method.  Normally, this is the
// actual method of the request.  Sometimes, though, the intended request method
// must be hidden in the parameters of the request.  For example, when attempting to
// send a DELETE request in a cross-origin environment in IE9 or older, it is not
// possible to send a DELETE request.  So, we send a POST with the intended method,
// DELETE, in a "_method" parameter.
function getRequestMethod() {
    global $HTTP_RAW_POST_DATA;

    // This should only evaluate to true if the Content-Type is undefined
    // or unrecognized, such as when XDomainRequest has been used to
    // send the request.
    if(isset($HTTP_RAW_POST_DATA)) {
    	parse_str($HTTP_RAW_POST_DATA, $_POST);
    }

    if ($_POST['_method'] != null) {
        return $_POST['_method'];
    }

    return $_SERVER['REQUEST_METHOD'];
}

// Only needed in cross-origin setups
function handlePreflightedRequest() {
    // If you are relying on CORS, you will need to adjust the allowed domain here.
    header('Access-Control-Allow-Origin: http://ec2-54-201-118-178.us-west-2.compute.amazonaws.com');
}

// Only needed in cross-origin setups
function handlePreflight() {
    handlePreflightedRequest();
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Content-Type');
}

function getS3Client() {
    global $serverPublicKey, $serverPrivateKey;

    return S3Client::factory(array(
        'key' => $serverPublicKey,
        'secret' => $serverPrivateKey
    ));
}

// Only needed if the delete file feature is enabled
function deleteObject() {
    getS3Client()->deleteObject(array(
        'Bucket' => $_POST['bucket'],
        'Key' => $_POST['key']
    ));
}

function signRequest() {
    header('Content-Type: application/json');

    $responseBody = file_get_contents('php://input');
    $contentAsObject = json_decode($responseBody, true);
    $jsonContent = json_encode($contentAsObject);

    $headersStr = $contentAsObject["headers"];
    if ($headersStr) {
        signRestRequest($headersStr);
    }
    else {
        signPolicy($jsonContent);
    }
}

function signRestRequest($headersStr) {
    if (isValidRestRequest($headersStr)) {
        $response = array('signature' => sign($headersStr));
        echo json_encode($response);
    }
    else {
        echo json_encode(array("invalid" => true));
    }
}

function isValidRestRequest($headersStr) {
    global $expectedBucketName;

    $pattern = "/\/$expectedBucketName\/.+$/";
    preg_match($pattern, $headersStr, $matches);

    return count($matches) > 0;
}

function signPolicy($policyStr) {
    $policyObj = json_decode($policyStr, true);

    if (isPolicyValid($policyObj)) {
        $encodedPolicy = base64_encode($policyStr);
        $response = array('policy' => $encodedPolicy, 'signature' => sign($encodedPolicy));
        echo json_encode($response);
    }
    else {
        echo json_encode(array("invalid" => true));
    }
}

function isPolicyValid($policy) {
    global $expectedMaxSize, $expectedBucketName;

    $conditions = $policy["conditions"];
    $bucket = null;
    $parsedMaxSize = null;

    for ($i = 0; $i < count($conditions); ++$i) {
        $condition = $conditions[$i];

        if (isset($condition["bucket"])) {
            $bucket = $condition["bucket"];
        }
        else if (isset($condition[0]) && $condition[0] == "content-length-range") {
            $parsedMaxSize = $condition[2];
        }
    }

    return $bucket == $expectedBucketName && $parsedMaxSize == (string)$expectedMaxSize;
}

function sign($stringToSign) {
    global $clientPrivateKey;

    return base64_encode(hash_hmac(
            'sha1',
            $stringToSign,
            $clientPrivateKey,
            true
        ));
}

// This is not needed if you don't require a callback on upload success.
function verifyFileInS3($includeThumbnail) {
    global $expectedMaxSize;

    $bucket = $_POST["bucket"];
    $key = $_POST["key"];

    // If utilizing CORS, we return a 200 response with the error message in the body
    // to ensure Fine Uploader can parse the error message in IE9 and IE8,
    // since XDomainRequest is used on those browsers for CORS requests.  XDomainRequest
    // does not allow access to the response body for non-success responses.
    if (getObjectSize($bucket, $key) > $expectedMaxSize) {
        // You can safely uncomment this next line if you are not depending on CORS
        //header("HTTP/1.0 500 Internal Server Error");
        deleteObject();
        echo json_encode(array("error" => "File is too big!"));
    }
    else {
        $link = getTempLink($bucket, $key);
        $response = array("tempLink" => $link);

        if ($includeThumbnail) {
            $response["thumbnailUrl"] = $link;
        }

       	echo json_encode($response);
    }
}

// Provide a time-bombed public link to the file.
function getTempLink($bucket, $key) {
    $client = getS3Client();
    $url = "{$bucket}/{$key}";
    $request = $client->get($url);

    return $client->createPresignedUrl($request, '+15 minutes');
}

function getObjectSize($bucket, $key) {
    $objInfo = getS3Client()->headObject(array(
            'Bucket' => $bucket,
            'Key' => $key
        ));
    return $objInfo['ContentLength'];
}

// Return true if it's likely that the associate file is natively
// viewable in a browser.  For simplicity, just uses the file extension
// to make this determination, along with an array of extensions that one
// would expect all supported browsers are able to render natively.
function isFileViewableImage($filename) {
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $viewableExtensions = array("jpeg", "jpg", "gif", "png");

    return in_array($ext, $viewableExtensions);
}

// Returns true if we should attempt to include a link
// to a thumbnail in the uploadSuccess response.  In it's simplest form
// (which is our goal here - keep it simple) we only include a link to
// a viewable image and only if the browser is not capable of generating a client-side preview.
function shouldIncludeThumbnail() {
    $filename = $_POST["name"];
    $isPreviewCapable = $_POST["isBrowserPreviewCapable"] == "true";
    $isFileViewableImage = isFileViewableImage($filename);

    return !$isPreviewCapable && $isFileViewableImage;
}
?>