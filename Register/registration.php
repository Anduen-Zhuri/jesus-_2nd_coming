<?php include('../Layout/header.php'); ?>
<div class="container">
        <center>
        <div class="container" >

            <form method='POST' action=''>
                <input type='text' id='Firstname' name='Firstname' autocomplete='cc-Firstname' class="form-control" type="text" placeholder="First Name" style="margin-bottom: 2px;">
                <input type='text' id='Middlename' name='Middlename' autocomplete='cc-Middlename' class="form-control" type="text" placeholder="Middle Name" style="margin-bottom: 2px;">
                <input type='text' id='Lastname' name='Lastname' autocomplete='cc-Lastname' class="form-control" type="text" placeholder="Last Name" style="margin-bottom: 2px;">
                <input type='email' id='Email' name='Email' autocomplete='cc-Email' class="form-control" type="text" placeholder="Email Address" style="margin-bottom: 2px;">
                <input type='password' id='Password' name='Password' autocomplete='cc-Password' class="form-control" placeholder="Password" style="margin-bottom: 2px;">
                <input type='text' id='Birthday' name='Birthday' autocomplete='cc-Birthday' class="form-control" type="text" placeholder="Birth Date (mm/dd/yyyy)" style="margin-bottom: 2px;">
                <input type='text' id='Birthplace' name='Birthplace' autocomplete='cc-Birthplace' class="form-control" type="text" placeholder="Birth Place" style="margin-bottom: 2px;">
                <input type='submit' value='REGISTER' name='REGISTER' class="btn btn-primary">
               
            </form>
            <a href='../'>Back to login</a>
        </div>
        </center>
        
        
        
        </div>
<?php include('../Layout/footer.php');?>