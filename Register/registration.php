<?php include('../Layout/header.php'); ?>
        <center>
        <div class="container">

            <form method='POST' action=''>
                <label for='Firstname'>First name:</label><br>
                <input type='text' id='Firstname' name='Firstname' autocomplete='cc-Firstname'>
                

                <label for='Middlename'>Middle name: (empty if none)</label><br>
                <input type='text' id='Middlename' name='Middlename' autocomplete='cc-Middlename'>
               
                
                <label for='Lastname'>Last name:</label><br>
                <input type='text' id='Lastname' name='Lastname' autocomplete='cc-Lastname'>
                
                
                <label for='Email'>Email:</label><br>
                <input type='email' id='Email' name='Email' autocomplete='cc-Email'>
                    

                <label for='Password'>Password:</label><br>
                <input type='password' id='Password' name='Password' autocomplete='cc-Password'>
               
                
                <label for='Birthday'>Birthday(mm/dd/yyyy):</label><br>
                <input type='text' id='Birthday' name='Birthday' autocomplete='cc-Birthday'>
              
                
                <label for='Birthplace'>Birth place:</label><br>
                <input type='text' id='Birthplace' name='Birthplace' autocomplete='cc-Birthplace'>
               

                <input type='submit' value='REGISTER' name='REGISTER'>
            </form>
            <a href='../'>Back to login</a>
        </div>
        </center>
        <?php include('../Layout/footer.php');?>