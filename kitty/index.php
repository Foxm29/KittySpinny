<!DOCTYPE html>
<html>
<head>

<title>Creating Dynamic Data Graph using PHP and Chart.js</title>
<link rel="stylesheet" href="./CSS/main.css">
<link rel="stylesheet" href="./CSS/form.css">

<script type="text/javascript" src="js/moment.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/Chart.min.js"></script>



</head>


<body>
        <?php 
        session_start();
        $pdo = new PDO('mysql:host=localhost;dbname=test', 'testuser', '12345');
         
        if(isset($_GET['login'])) {
            $email = $_POST['email'];
            $passwort = $_POST['passwort'];
            
            $statement = $pdo->prepare("SELECT * FROM user WHERE email = :email");
            $result = $statement->execute(array('email' => $email));
            $user = $statement->fetch();
                
            //Überprüfung des Passworts
            if ($user !== false && password_verify($passwort, $user['passwort'])) {
                $_SESSION['userid'] = $user['id'];
                die('Login erfolgreich. Weiter zu <a href="week.php">internen Bereich</a>');
            } else {
                $errorMessage = "E-Mail oder Passwort war ungültig<br>";
            }
            
        }
        ?>

        <div id="mynav" class="nav">
            <ul>
                <li><a  class="active" href="./index.php">Home</a></li>
                <li><a href="./week.php">This week</a></li>
                <li><a href="./year.php">This year</a></li>
                <li><a href="./total.php">Total</a></li>
                <li><a href="#about">About</a></li>
              </ul> 
              </div>
    <div class="main" id ="main">
            <form id="myForm" action="?login=1" method="post">
                <fieldset>
                    <legend> Login </legend>
                    <div>
                        <label for="email"> E-Mail: </label> <input type="email"
                            name="email" id="email" size="35" maxlength="35" required>
                        <span></span>
                    </div>
                    <br>
                    <div>
                        <label for="passwort"> Passwort: </label> <input type="password"
                            name="passwort" id="passwort" size="30" maxlength="30" required>
                        <span></span>
                    </div>
                    <p>* Eingabe erforderlich</p>
                    <?php 
if(isset($errorMessage)) {
    echo $errorMessage;
}
?>

				<div>
					<button type="submit" name="sendButton" value="submit">Einloggen</button>
                </div>
                
                </fieldset>

		</form>
        
                    

    
        
         

   
    
    
    
</div>
   
    

</body>
</html>