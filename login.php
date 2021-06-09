<?php include('./Layout/header.php');?>
        <center>
            <form method='POST' action=''>
                <label for='Email'>Email:</label><br>
                <input type='text' id='Email' name='Email' autocomplete='cc-email'>
                <br>

                <label for='Password'>Password:</label><br>
                <input type='password' id='Password' name='Password' autocomplete='cc-password'>
                <br><br>
        </div>
                
                <input type='submit' value='LOGIN' name='LOGIN'>
            </form>
            <a href='./Register/'>REGISTER</a>
        </center>
        

<?php include('./Layout/footer.php');?>

