<?php
/*** Path Configurations ***/
define('DS', '/');
define('ROOT', '../');
define('LIBS_PATH', ROOT.DS.'libs');

session_start();
include(LIBS_PATH.'/csrf.class.php');
if ( isset( $_POST[ 'field' ] ) )
{
    try
    {
        // Run CSRF check, on POST data, in exception mode, for 10 minutes, in one-time mode.
        csrf::check( 'token', $_POST, true, 60*10, false );
        // form parsing, DB inserts, etc.
        // ...
        $result = 'CSRF check passed. Form parsed.';
    }
    catch ( Exception $e )
    {
        // CSRF attack detected
        $result = $e->getMessage() . ' Form ignored.';
    }
}
else
{
    $result = 'No post data yet.';
}
// Generate CSRF token to use in form hidden field
$token = csrf::generate( 'token' );
//print_r($_SESSION);
?>


<h1>CSRF sandbox</h1>
<pre style="color: red"><?php echo $result; ?></pre>
<div>CSRF Token at server: <?php echo $token; ?></div>
<div>Passed Token from client: 
<?php 
if(isset($_POST['csrf_token'])){
    echo $_POST['csrf_token'];
}
else{
    echo "Not passed";
}
?>
</div>
<form name="csrf_form" action="#" method="post">
    <h2>Form using generated token.</h2>
    <input type="text" name="csrf_token" value="<?php echo $token; ?>">
    <input type="text" name="field" value="somevalue">
    <input type="submit" value="Send form">
</form>
<form name="csrf_form" action="#" method="post">
    <h2>Copied form simulating CSRF attack.</h2>
    <input type="hidden" name="csrf_token" value="whateverkey">
    <input type="text" name="field" value="somevalue">
    <input type="submit" value="Send form">
</form>