<html>
    <head>
        <title>Registration</title>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    </head>
    <body>
        <center>
            <form method='POST' action=''>
                <label for='Firstname'>First name:</label><br>
                <input type='text' id='Firstname' name='Firstname' autocomplete='cc-Firstname'>
                <br>

                <label for='Middlename'>Middle name: (empty if none)</label><br>
                <input type='text' id='Middlename' name='Middlename' autocomplete='cc-Middlename'>
                <br>
                
                <label for='Lastname'>Last name:</label><br>
                <input type='text' id='Lastname' name='Lastname' autocomplete='cc-Lastname'>
                <br>
                
                <label for='Email'>Email:</label><br>
                <input type='email' id='Email' name='Email' autocomplete='cc-Email'>
                <br>      

                <label for='Password'>Password:</label><br>
                <input type='password' id='Password' name='Password' autocomplete='cc-Password'>
                <br>
                
                <label for='Birthday'>Birthday(mm-dd-yyyy):</label><br>
                <input type='text' id='Birthday' name='Birthday' autocomplete='cc-Birthday'>
                <br>
                
                <label for='Birthplace'>Birth place:</label><br>
                <input type='text' id='Birthplace' name='Birthplace' autocomplete='cc-Birthplace'>
                <br><br>

                <input type='submit' value='REGISTER' name='REGISTER'>
            </form>
            <a href='../'>Back to login</a>
        </center>
    </body>
</html>