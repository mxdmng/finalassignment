<!DOCTYPE HTML>  
<html>
<head>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
    <title>&amp;count | Dance Tutorial App</title>
</head>
<body>  
<header>
    <nav class="header-menu">
        <a href="index.html"><img src="/images/andcount-logo.png" alt="&amp;count andcount logo"></a>
        <ul>
            <a href="index.html"><li>Home</li></a>
            <a href="tech.html"><li>About</li></a>
            <a href="contact.php"><li>Contact</li></a>
        </ul>
    </nav>
</header>
<div id="index">
    <div>
        <div class="index-headings">
            <h1 class="title">Contact <i><span>&amp;</span>count</i></h1>
        </div>
        <div class="about-more">
            <h2>Get in touch</h2>
        </div>
      <?php
      include 'mail/sendmail.php';
      // include 'sendsms.php';

      // define variables and set to empty values
      $nameErr = $emailErr = $subscriptionsErr = $websiteErr = "";
      $name = $email = $subscriptions = $comment = $website = $mailresult = ""; $urgent= "No";

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

      if (empty($_POST["comment"])) {
        $comment = "";
      } else {
        $comment = test_input($_POST["comment"]);
      }

      if (empty($_POST["subscriptions"])) {
        $subscriptionsErr = "subscriptions is required";
      } else {
        $subscriptions = test_input($_POST["subscriptions"]);
      }

      $urgent = $_POST["urgent"];

      if (empty($nameErr) && empty($emailErr) && empty($subscriptionsErr) && empty( $websiteErr)) {    
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

      <form class="contact-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
        <label><span class="error">* Indicates required field.</span></label>
        <br>

        <label>Name: <span class="error">* <?php echo $nameErr;?></span></label> <input type="text" class = "text" name="name" value="<?php echo $name;?>">
        <br>

        <label>E-mail:  <span class="error">* <?php echo $emailErr;?></span></label> <input type="email" class = "text" name="email" value="<?php echo $email;?>">
        <br>

        <label>Website: <span class="error"><?php echo $websiteErr;?></span></label> <input type="url" class = "text" name="website" value="<?php echo $website;?>">
        <br>

        <label>Comment:</label><textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea>
        <br>

        <label>Subscribe to our newsletter and be notified about any updates or new classes!<span class="error">* <?php echo $subscriptionsErr;?></span></label>
        <label>Yes</label><input type="radio" name="subscriptions" <?php if (isset($subscriptions) && $subscriptions=="yes") echo "checked";?> value="yes">
        <label>No</label><input type="radio" name="subscriptions" <?php if (isset($subscriptions) && $subscriptions=="no") echo "checked";?> value="no">
        <br>  

        <label>Is this message urgent?</label><input type="checkbox" name="urgent" id="urgentid"  value="Yes"
        <?php if ($urgent=="Yes") echo "checked";?>>
        <br>  

        <input class="button btn button-1" type="submit" name="submit" value="Submit">
      </form>

      <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
      echo "<h2>Your Input:</h2>";
      echo "Name: " . $name . "<br>";
      echo "E-mail: " . $email . "<br>";
      echo "Phone: " . $phone .  "<br>";
      echo "Website: " . $website . "<br>";
      echo "Comment: " . $comment . "<br>";
      echo "Subscriptions: " . $subscriptions . "<br>";
      echo "Urgent: " . $urgent;
      if (empty($urgent)) {echo "No"; }
      echo "<br>" . $mailresult;
      }  // if posted
      ?>
    </div>
</div>
</body>
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="slick/slick.min.js"></script>
<script>
    var app = {
        init: function() {
            console.log("App Started!");
            app.slider.init();
        }
    }

    app.slider = {
        init: function() {
            console.log("app.slider.init");
            $(".index-main").slick({
                arrows: false,
                autoplay: true,
            });
        }
    }
</script>
<script type="text/javascript">app.slider.init();</script>
</html>