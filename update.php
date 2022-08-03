<!--Test Oracle file for UBC CPSC304 2018 Winter Term 1
  Created by Jiemin Zhang
  Modified by Simona Radu
  Modified by Jessica Wong (2018-06-22)
  This file shows the very basics of how to execute PHP commands
  on Oracle.
  Specifically, it will drop a table, create a table, insert values
  update values, and then query for values

  IF YOU HAVE A TABLE CALLED "demoTable" IT WILL BE DESTROYED

  The script assumes you already have a server set up
  All OCI commands are commands to the Oracle libraries
  To get the file to work, you must place it somewhere where your
  Apache server can run it, and you must rename it to have a ".php"
  extension.  You must also change the username and password on the
  OCILogon below to be your ORACLE username and password -->

  <html>

    <body>
        <h2>Reset</h2>
        <p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>

        <form method="POST" action="update.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
            <p><input type="submit" value="Reset" name="reset"></p>
        </form>

        <hr />
          <!-- create -->
        <h2>Create New My Recipes</h2>
        <form method="POST" action="update.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">

            RecipeID: <input type="number" name="insID"> <br /><br />
            UserName: <input type="text" name="insUserName"> <br /><br />
            RecipeName: <input type="text" name="insRecipeName"> <br /><br />
            Difficulty: <input type="number" name="insDifficulty"> <br /><br />
            Instruction: <input type="text" name="insInstruction"> <br /><br />
            Time: <input type="number" name="insTime"> <br /><br />

            <input type="submit" value="Create" name="insertSubmit"></p>
        </form>

        <hr />

            <!-- update -->
        <h2>Update recipe's name in table</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

        <form method="POST" action="update.php"> <!--refresh page when submitted-->
            <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
            Old Name: <input type="text" name="oldName"> <br /><br />
            New Name: <input type="text" name="newName"> <br /><br />

            <input type="submit" value="Update" name="updateSubmit"></p>
        </form>

        <hr />



            <!-- selection -->
        <h2> Filter recipes according to difficulty level</h2>
        <p> The difficulty level ranges from 1 to 5, entering numbers out of range is illegal input. </p>
        <form method="POST" action="update.php"> <!--refresh page when submitted-->
            <input type="hidden" id="selectQueryRequest" name="selectQueryRequest">

            Difficulty level: <input type="text" name="difficulty"> <br /><br />

            <input type="submit" value="Search" name="searchSubmit"></p>
        </form>

          <!-- join -->
          <h2> Display recipe's allergy information</h2>   
           <p> Enter the recipe name below find out its allergy information </p>
        <form method="POST" action="update.php"> <!--refresh page when submitted-->
            <input type="hidden" id="joinQueryRequest" name="joinQueryRequest">

             Recipe Name: <input type="text" name="rname"> <br /><br />

            <input type="submit" value="Display" name="searchSubmit"></p>
        </form>



        <!--aggregation with group by-->
        <h2>Count the Tuples in Recipe</h2>
        <form method="GET" action="update.php"> <!--refresh page when submitted-->
            <input type="hidden" id="countTupleRequest" name="countTupleRequest">
            <input type="submit" name="countTuples"></p>
        </form>

        <hr />

        <?php
		//this tells the system that it's no longer just parsing html; it's now parsing PHP

        $success = True; //keep track of errors so it redirects the page only if there are no errors
        $db_conn = NULL; // edit the login credentials in connectToDB()
        $show_debug_alert_messages = False; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())

        function debugAlertMessage($message) {
            global $show_debug_alert_messages;

            if ($show_debug_alert_messages) {
                echo "<script type='text/javascript'>alert('" . $message . "');</script>";
            }
        }

        function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
            //echo "<br>running ".$cmdstr."<br>";
            global $db_conn, $success;

            $statement = OCIParse($db_conn, $cmdstr);
            //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
                echo htmlentities($e['message']);
                $success = False;
            }

            $r = OCIExecute($statement, OCI_DEFAULT);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
                echo htmlentities($e['message']);
                $success = False;
            }

			return $statement;
		}

        function executeBoundSQL($cmdstr, $list) {
            /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
		In this case you don't need to create the statement several times. Bound variables cause a statement to only be
		parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection.
		See the sample code below for how this function is used */

			global $db_conn, $success;
			$statement = OCIParse($db_conn, $cmdstr);

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn);
                echo htmlentities($e['message']);
                $success = False;
            }

            foreach ($list as $tuple) {
                foreach ($tuple as $bind => $val) {
                    //echo $val;
                    //echo "<br>".$bind."<br>";
                    OCIBindByName($statement, $bind, $val);
                    unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
				}

                $r = OCIExecute($statement, OCI_DEFAULT);
                if (!$r) {
                    echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                    $e = OCI_Error($statement); // For OCIExecute errors, pass the statementhandle
                    echo htmlentities($e['message']);
                    echo "<br>";
                    $success = False;
                }
            }
        }

        function printResult($result) { //prints results from a select statement
            echo "<br>Retrieved data from table demoTable:<br>"; 
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["ID"] . "</td><td>" . $row["NAME"] . "</td></tr>"; //or just use "echo $row[0]"
            }

            echo "</table>";
        }


        function connectToDB() {
            global $db_conn;

            // Your username is ora_(CWL_ID) and the password is a(student number). For example,
			// ora_platypus is the username and a12345678 is the password.
            $db_conn = OCILogon("ora_annaleee", "a66716515", "dbhost.students.cs.ubc.ca:1522/stu");

            if ($db_conn) {
                debugAlertMessage("Database is Connected");
                return true;
            } else {
                debugAlertMessage("Cannot connect to Database");
                $e = OCI_Error(); // For OCILogon errors pass no handle
                echo htmlentities($e['message']);
                return false;
            }
        }

        function disconnectFromDB() {
            global $db_conn;

            debugAlertMessage("Disconnect from Database");
            OCILogoff($db_conn);
        }

        function handleUpdateRequest() {
            global $db_conn;

            $old_name = $_POST['oldName'];
            $new_name = $_POST['newName'];

            // you need the wrap the old name and new name values with single quotations
            executePlainSQL("UPDATE Recipe SET RecipeName='" . $new_name . "' WHERE RecipeName='" . $old_name . "'");
            OCICommit($db_conn);
        }

        function handleResetRequest() {
            global $db_conn;
            // Drop old table
            executePlainSQL("DELETE FROM Recipe");
            echo "<br> empty recipe table <br>";

            // Create new table
            //echo "<br> creating new table <br>";
            //executePlainSQL("CREATE TABLE Recipe (id int PRIMARY KEY, name char(30))");
            //executePlainSQL("CREATE TABLE Recipe (RecipeID int PRIMARY KEY, UserName VARCHAR2(30), RecipeName VARCHAR2(15), Difficulty int, Instruction VARCHAR2(300),Time int))");
            OCICommit($db_conn);
        }

        function handleInsertRequest() {
            global $db_conn;

            //Getting the values from user and insert data into the table
            $tuple = array (
                ":bind1" => $_POST['insID'],
                ":bind2" => $_POST['insUserName'],
                ":bind3" => $_POST['insRecipeName'], 
                ":bind4" => $_POST['insDifficulty'],
                ":bind5" => $_POST['insInstruction'],
                ":bind6" => $_POST['insTime'],
            );

            $alltuples = array (
                $tuple
            );

            executeBoundSQL("insert into Recipe values (:bind1, :bind2, :bind3, :bind4, :bind5, :bind6)", $alltuples); 
            OCICommit($db_conn);
        }

        function handleSelectRequest() {
            global $db_conn;

            $difficulty_level = $_POST['difficulty'];

            $result = executePlainSQL("SELECT * FROM Recipe WHERE Difficulty = $difficulty_level");

            echo "<br>Retrieved data from table Recipe:<br>"; 
            echo "<table>";
            echo "<tr><th>RecipeName</th><th>Instruction</th><th>Time</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[2] . "</td><td>". $row[4] . "</td><td>" . $row[5] . "</td></tr>"; // correspond to RecipeName, Instruction, Time
            }

            echo "</table>";
        }

        function handleCountRequest() {
            global $db_conn;

            $result = executePlainSQL("SELECT Count(*) FROM Recipe");

            if (($row = oci_fetch_row($result)) != false) {
                echo "<br> The number of tuples in recipe: " . $row[0] . "<br>";
            }
        }

        function handleJoinRequest() {
            global $db_conn;

            $receipe_name = $_POST['rname'];

            
            $result = executePlainSQL("SELECT RecipeName, AllergyName
            FROM Recipe, Label WHERE Recipe.RecipeID = Label.RecipeID AND RecipeName = '$receipe_name'");

            echo "<br>Showing result for display allergy information:<br>"; 
            echo "<table>";
            echo "<tr><th>RecipeName</th><th>Allerge</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row['RecipeName'] . "</td><td>". $row['AllergyName'] . "</td><td>";
            }

            echo "</table>";
        }

    

        // HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handlePOSTRequest() {
            if (connectToDB()) {
                if (array_key_exists('resetTablesRequest', $_POST)) {
                    handleResetRequest();
                } else if (array_key_exists('updateQueryRequest', $_POST)) {
                    handleUpdateRequest();
                } else if (array_key_exists('insertQueryRequest', $_POST)) {
                    handleInsertRequest();
                } else if (array_key_exists('selectQueryRequest', $_POST)) {
                    handleSelectRequest();
                } else if (array_key_exists('joinQueryRequest', $_POST)) {
                    handleJoinRequest();
                }

                disconnectFromDB();
            }
        }


        // HANDLE ALL GET ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handleGETRequest() {
            if (connectToDB()) {
                if (array_key_exists('countTuples', $_GET)) {
                    handleCountRequest();
                }

                disconnectFromDB();
            }
        }

		if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['searchSubmit'])) {
            handlePOSTRequest();
        } else if (isset($_GET['countTupleRequest'])) {
            handleGETRequest();
        }
		?>
	</body>
</html>

