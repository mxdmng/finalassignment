<!DOCTYPE HTML>  
<html>
<head>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>  

<?php
include 'mail/sendmail.php';
include 'sendsms.php';

// define variables and set to empty values
$nameErr = $emailErr = $phoneErr= $genderErr = $websiteErr = "";
$name = $email = $phoneErr = $gender = $comment = $website = $mailresult = ""; $urgent= "No";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z -]*$/",$name)) {
      $nameErr = "Only letters, hyphen and white spaces are allowed"; 
    }
  }
  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format"; 
    }
  }
    
  if (empty($_POST["website"])) {
    $website = "";
  } else {
    $website = test_input($_POST["website"]);
    // check if URL address syntax is valid 
    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
      $websiteErr = "Invalid URL"; 
    }
  }

  if (empty($_POST["phone"])) {
    $phone = "";
  } else {
    $phone = test_input($_POST["phone"]);
  }

  if (empty($_POST["comment"])) {
    $comment = "";
  } else {
    $comment = test_input($_POST["comment"]);
  }

  if (empty($_POST["gender"])) {
    $genderErr = "Gender is required";
  } else {
    $gender = test_input($_POST["gender"]);
  }
  
  $urgent = $_POST["urgent"];
  
	if (empty($nameErr) && empty($emailErr) && empty($phoneErr) && empty($genderErr) && empty( $websiteErr)) {		
		$mailresult = sendmail($email,"Website auto mailer",$comment);  //[from], [subject], [body], [to]
		if ($urgent=="Yes"){
		$mailresult =$mailresult . "<br>SMS " . sendsms("Website contact:" . PHP_EOL . $comment); //[text],[to]
		}
	}
} // if posted

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h1>PHP Form Validation Example</h1>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
<label><span class="error">* indicates required field.</span></label>
  <label>Name: <span class="error">* <?php echo $nameErr;?></span></label> <input type="text" class = "text" name="name" value="<?php echo $name;?>">

  <br>
  <label>E-mail:  <span class="error">* <?php echo $emailErr;?></span></label> <input type="email" class = "text" name="email" value="<?php echo $email;?>">

  <br>
  <label>Phone: <span class="error"><?php echo $phoneErr;?></span></label> <input type="tel" class = "text" name="phone" value="<?php echo $phone;?>">
  
  <br>
  <label>Website: <span class="error"><?php echo $websiteErr;?></span></label> <input type="url" class = "text"name="website" value="<?php echo $website;?>">
  
  <br>
  <label>Comment:</label> <textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea>

  <br>
  <label>Gender: <span class="error">* <?php echo $genderErr;?></span></label>
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female"> <span class="radiolabel">Female</span>
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="male"><span class="radiolabel">Male</span>

  <br>  
  <input type="checkbox" name="urgent" id="urgentid"  value="Yes"
   <?php if ($urgent=="Yes") echo "checked";?> 
   >
  <span class="checkboxlabel">Urgent</span>
  
  <br>  
  <input type="submit" name="submit" value="Submit">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo "<h2>Your Input:</h2>";
	echo "Name: " . $name . "<br>";
	echo "E-mail: " . $email . "<br>";
	echo "Phone: " . $phone .  "<br>";
	echo "Website: " . $website . "<br>";
	echo "Comment: " . $comment . "<br>";
	echo "Gender: " . $gender . "<br>";
	echo "Urgent: " . $urgent;
	if (empty($urgent)) {echo "No";	}
	echo "<br>" . $mailresult;
}  // if posted
?>

</body>
</html>