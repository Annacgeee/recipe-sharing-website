<html>
    <head>
        <title>CPSC 304 Group 36 Project</title>
    </head>

    <body>

        <h1>Yummy Yummy</h1>
        <hr />
  
        <!--insert-->
        <h2>Create New Recipe</h2> 
        <form method="POST" action="project.php"> <!--refresh page when submitted-->
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

        <!--upadte-->
        <h2>Update Recipe</h2>
        <p>please input the recipe's name you would like to update</p>
        <form method="POST" action="project.php">
            <input type="hidden" id="updateQueryRequest2" name="updateQueryRequest2">
            Recipe Name: <input type="text" name="recipename"> <br /><br />

        <p>please choose the info about the recipe you would like to update</p>
        <!-- <form method="POST" action="project.php"> -->
         <select name="RecipeAttributes">
         <option value="RecipeName">Recipe name</option>
         <option value="Instruction">Instruction</option>
         <option value="Time">Time</option>
         <option value="Difficulty">Difficulty</option>
        </select> 

        <p> Put your update in below box</p>
        <!--<input type="hidden" id="updateQueryRequest" name="updateQueryRequest">-->
            New Value: <input type="text" name="newValue"> <br /><br />

        <input type="submit" value="Update" name="update">
        </form>

        <hr />

        <!-- delete -->
        <h2>Delete Recipe</h2>
        <form method="POST" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
            
            RecipeName: <input type="text" name="recipename"> <br /><br />

            <input type="submit" value="Delete" name="deleteSubmit"></p>
        </form>

        <hr />

        <!-- selection -->
        <h2> Filter Recipe According To Difficulty Level</h2>
        <p> The difficulty level ranges from 1 to 5, entering numbers out of range is illegal input. </p>
        <form method="POST" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="selectQueryRequest" name="selectQueryRequest">

            Difficulty level: <input type="text" name="difficulty"> <br /><br />

            <input type="submit" value="Search" name="selectSubmit"></p>
        </form>

        <hr />

        <!-- projection -->
        <h2> Display Recipe Information</h2>
        <p> Choose from the following attributes: </p>
        <form method="POST" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="chooseQueryRequest" name="chooseQueryRequest">

            RecipeID: <input type="checkbox" name="insID"> 
            UserName: <input type="checkbox" name="insUserName"> 
            RecipeName: <input type="checkbox" name="insRecipeName"> 
            Difficulty: <input type="checkbox" name="insDifficulty"> 
            Instruction: <input type="checkbox" name="insInstruction"> 
            Time: <input type="checkbox" name="insTime"> <br /><br />

            <input type="submit" value="Search" name="chooseSubmit"></p>
        </form>

        <hr />

        <!-- join -->
        <h2> Display Recipe's Allergy Information</h2>   
        <p> Enter the recipe name below find out its allergy information </p>
        <form method="POST" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="joinQueryRequest" name="joinQueryRequest">

             Recipe Name: <input type="text" name="rname"> <br /><br />

            <input type="submit" value="Display" name="searchSubmit"></p>
        </form>

        <hr />

        <!--aggregation with group by-->
        <h2> Count Recipe by Category </h2>
        <form method="GET" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="countTupleRequest" name="countTupleRequest">
            
            <input type="submit" value="Submit" name="countTuples"></p>
        </form>

        <hr />

         <!-- aggregation w/ having -->
         <h2> Aggregation With Having</h2>
        <p> Find out the number of users in each city </p>
        <form method="POST" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="aggregationWithHavingRequest" name="aggregationWithHavingRequest">

            only include cities have more than : <input type="text" name="number">  person<br /><br />

            <input type="submit" value="Search" name="aggregationWithHavingSubmit"></p>
        </form>

        <hr />

         <!-- nested aggregation w/ group by -->
         <h2> Nested Aggregation With Group By</h2>
        <form method="POST" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="nestAggregationWithGroup" name="nestAggregationWithGroup">

            For each difficulty level, find the number of recipes of each difficulty that is lower than the overall average cooking time <br /><br />

            <input type="submit" value="Submit" name="nestAggregationWithGroupSubmit"></p>
        </form>

        <hr />

        <!--Division-->
         <h2> Find Ingredients That Include In All Recipes </h2>
        <form method="POST" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="divisionQueryRequest" name="divisionQueryRequest">
            
            <input type="submit" value="Find" name="Division"></p>
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
            $db_conn = OCILogon("ora_xuanya", "a17923146", "dbhost.students.cs.ubc.ca:1522/stu");

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

        function handleUpdateRequest2() {
            global $db_conn;

            if(isset($_POST['RecipeAttributes'])) {
                $attributeToUpdate = $_POST['RecipeAttributes'];
            }

            $choose_recipe = $_POST['recipename'];
            $new_value = $_POST['newValue'];

            executePlainSQL("UPDATE Recipe SET $attributeToUpdate='" . $new_value . "' WHERE RecipeName='" . $choose_recipe. "'"); 
            
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
                echo "<tr><td>" . $row[2] . "</td><td>". $row[4] . "</td><td>" . $row[5] . "</td></tr>"; 
            }

            echo "</table>";

            OCICommit($db_conn);

        }

        function handleChooseRequest() {
            global $db_conn;

            $checkList = array (
                $_POST['insID'],
                $_POST['insUserName'],
                $_POST['insRecipeName'], 
                $_POST['insDifficulty'],
                $_POST['insInstruction'],
                $_POST['insTime'],
            );

            $check = array (
                'RecipeID', 
                'UserName',
                'RecipeName', 
                'Difficulty',
                'Instruction',
                'Time',
            );

            $attributeName = "";
            for ($x = 0; $x < 6; $x++) {
                if ($checkList[$x] == "on") {
                    $attributeName .= $check[$x] ." ,";
                }
            }
            $attributeName = rtrim($attributeName, ","); // remove last comma

            $sql = "SELECT $attributeName FROM Recipe";
            $result = executePlainSQL($sql);
            $title = "";
            for ($x = 0; $x < 6; $x++) {
                if ($checkList[$x] == "on") {
                    $title .= "<th>" . $check[$x] . "</th>";
                }
            }
        
            echo "<table>";
            echo "<tr>" . $title . "</tr>";
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>". $row[1] . "</td><td>" . $row[2] . "</td><td>". $row[3] . "</td><td>" . $row[4]. "</td><td>". $row[5] . "</td></tr>"; // correspond to RecipeName, Instruction, Time
            }
            echo "</table>";

            OCICommit($db_conn);

        }

        function handleDeleteRequest() {
            global $db_conn;

            $recipe_name = $_POST['recipename'];

            $result = executePlainSQL("DELETE FROM Recipe WHERE RecipeName = '$recipe_name'");

            if ($result === FALSE) {
                printf("query could not be executed");
                exit(1);
            } 
            
            OCICommit($db_conn);

        }

        function handleCountRequest() {
            global $db_conn;

            $count = executePlainSQL("SELECT Count(RecipeID), CategoryName FROM Belong GROUP BY CategoryName ORDER BY Count(RecipeID) DESC");

            echo "<br>Count Recipe by Category: <br>"; 
            echo "<table>";
            echo "<tr><th>Count</th><th>Category</th></tr>";

            while ($row = OCI_Fetch_Array($count, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>". $row[1] . "</td></tr>"; 
            }

            echo "</table>";

            OCICommit($db_conn);

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
                echo "<tr><td>" . $row[0] . "</td><td>". $row[1] . "</td><td>";
            }
            echo "</table>";
        }

        function handleAggregationWithHavingRequest(){
            global $db_conn;
            $num = $_POST['number'];

            $result = executePlainSQL("SELECT COUNT(ID), City 
                                     FROM Users
                                     GROUP BY City
                                     HAVING COUNT(ID) >= $num");

            echo "<br>Showing result:<br>"; 
            echo "<table>";
            echo "<tr><th>number of users</th><th>City</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>". $row[1] . "</td><td>";
            }
            echo "</table>";
        }

        function nestAggregationWithGroupRequet(){
            global $db_conn;
            $num = $_POST['level'];

            $result = executePlainSQL("SELECT COUNT(*), r.Difficulty
                           FROM Recipe r 
                           WHERE r.Time <= (SELECT AVG(r1.Time)
                                             FROM Recipe r1)
                           GROUP BY Difficulty ");

            echo "<br>Showing result:<br>"; 
            echo "<table>";
            echo "<tr><th>Count</th><th>Difficulty Level</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>". $row[1] . "</td><td>";
            }                            
        }

        function handleDivisionRequest() {
            global $db_conn;

            $count = executePlainSQL("SELECT DISTINCT IngredientName  
            FROM Includes inc
            WHERE NOT EXISTS 
            ((SELECT r.RecipeID FROM Recipe r)
            MINUS 
            (SELECT inc2.RecipeID FROM Includes inc2 WHERE inc2.IngredientName = inc.IngredientName))");

            echo "<br>Find Ingredients include in all recipes: <br>"; 
            echo "<table>";
            echo "<tr><th>IngredientName</th><th>";

            while ($row = OCI_Fetch_Array($count, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td></tr>"; 
            }

            echo "</table>";

            OCICommit($db_conn);

        }

        // HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handlePOSTRequest() {
            if (connectToDB()) {
                if (array_key_exists('insertQueryRequest', $_POST)) {
                    handleInsertRequest();
                } else if (array_key_exists('selectQueryRequest', $_POST)) {
                    handleSelectRequest();
                } else if (array_key_exists('deleteQueryRequest', $_POST)) {
                    handleDeleteRequest();
                } else if (array_key_exists('chooseQueryRequest', $_POST)) {
                    handleChooseRequest();
                } else if (array_key_exists('joinQueryRequest', $_POST)) {
                    handleJoinRequest();
                } else if (array_key_exists('updateQueryRequest2', $_POST)) {
                    handleUpdateRequest2();
                } else if (array_key_exists('aggregationWithHavingRequest', $_POST)) {
                    handleAggregationWithHavingRequest();
                } else if (array_key_exists('nestAggregationWithGroup', $_POST)) {
                    nestAggregationWithGroupRequet();
                } else if (array_key_exists('divisionQueryRequest', $_POST)) {
                    handleDivisionRequest();
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

		if (isset($_POST['insertSubmit']) || isset($_POST['update']) || isset($_POST['selectSubmit']) 
        || isset($_POST['deleteSubmit']) || isset($_POST['chooseSubmit']) || isset($_POST['searchSubmit']) 
        || isset($_POST['aggregationWithHavingSubmit'])||isset($_POST['nestAggregationWithGroupSubmit']) 
        || isset($_POST['Division'])){
            
            handlePOSTRequest();
        
        } else if (isset($_GET['countTupleRequest'])) {
            
            handleGETRequest(); 
        }
		?>
	</body>
</html>