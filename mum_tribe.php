<?php
/* Simple sample USSD registration application
 * USSD gateway that is being used is Africa's Talking USSD gateway
 */

// Print the response as plain text so that the gateway can read it
header('Content-type: text/plain');

// Get the parameters provided by Africa's Talking USSD gateway
$phone = $_GET['phoneNumber'];
$session_id = $_GET['sessionId'];
$service_code = $_GET['serviceCode'];
$ussd_string= $_GET['text'];

//set default level to zero
$level = 0;

/* Split text input based on asteriks(*)
 * Africa's talking appends asteriks for after every menu level or input
 * One needs to split the response from Africa's Talking in order to determine
 * the menu level and input for each level
 * */
$ussd_string_exploded = explode ("*",$ussd_string);

// Get menu level from ussd_string reply
$level = count($ussd_string_exploded);

if($level == 1 or $level == 0){
    
    display_menu(); // show the home/first menu
}

if ($level > 1)
{

    if ($ussd_string_exploded[0] == "1")
    {
        // If user selected 1 send them to the registration menu
        register($ussd_string_exploded,$phone, $dbh);
    }

  else if ($ussd_string_exploded[0] == "2"){
        //If user selected 2, send them to the about menu
        about($ussd_string_exploded);
    }
}

/* The ussd_proceed function appends CON to the USSD response your application gives.
 * This informs Africa's Talking USSD gateway and consecuently Safaricom's
 * USSD gateway that the USSD session is till in session or should still continue
 * Use this when you want the application USSD session to continue
*/
function ussd_proceed($ussd_text){
    echo "CON $ussd_text";
}

/* This ussd_stop function appends END to the USSD response your application gives.
 * This informs Africa's Talking USSD gateway and consecuently Safaricom's
 * USSD gateway that the USSD session should end.
 * Use this when you to want the application session to terminate/end the application
*/
function ussd_stop($ussd_text){
    echo "END $ussd_text";
}

//This is the home menu function
function display_menu()
{
    $ussd_text =    "1. Dont Just Frustrate and Humiliate me Rossie \n 2. Dont Just Frustrate and Humiliate me Rossie \n"; // add \n so that the menu has new lines
    ussd_proceed($ussd_text);
}


// Function that hanldles About menu
function about($ussd_text)
{
    $ussd_text =    "I am really sorry";
    ussd_stop($ussd_text);
}


# close the pdo connection  
$dbh = null;
?>
