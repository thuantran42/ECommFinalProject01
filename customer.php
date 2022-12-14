<?php require_once('header.php');?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Enter your info</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>



</head>

<style>
    body {
        background-image: url("https://img.freepik.com/free-vector/confetti-background_1048-7865.jpg?w=740&t=st=1669434268~exp=1669434868~hmac=769baab9295a48e4a300e4e0c9efd7cca933906626f8630687dec24764522ee2");
        /*background-color: #cccccc;*/
        background-size: cover;
        background-repeat: no-repeat;
        /*margin:auto;*/
        /*background-position: center center;*/
        /*background-attachment: fixed;*/
    }
</style>



<body>



    <?php
    $servername = "localhost";
    $username = "traeoucr_homework3User";
    $password = "mysqltt1024332";
    $dbname = "traeoucr_ecommfinalproject";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    switch ($_POST['saveType']) {
    case 'Add':
    $sqlAdd = "insert into Customer (customerName, customerPhone, customerAddress) values (?, ?, ?)";
    $stmtAdd = $conn->prepare($sqlAdd);
    $stmtAdd->bind_param("sss", $_POST['iName'], $_POST['iPhone'], $_POST['iAddress']);
    $stmtAdd->execute();
    echo '<div class="alert alert-success" role="alert">New Customer info added!</div>';

    break;

    case 'Edit':
    $sqlEdit = "update Customer set customerName=?,customerPhone=?,customerAddress=? where customer_id=?";
    $stmtEdit = $conn->prepare($sqlEdit);
    $stmtEdit->bind_param("sssi", $_POST['iName'], $_POST['iPhone'], $_POST['iAddress'], $_POST['iid']);
    $stmtEdit->execute();
    echo '<div class="alert alert-success" role="alert">Customer Info edited!</div>';

    break;

    case 'Delete':
    $sqlDelete = "delete from Customer where customer_id=?";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bind_param("i", $_POST['iid']);
    $stmtDelete->execute();
    echo '<div class="alert alert-success" role="alert">Customer info deleted.</div>';

    break;

    }
    }
    ?>

    <br /> <!-- Space break -->


    <div class="card">
        <div class="card-header">
            <h1> <span onmouseover="style.color='blue'" onmouseout="style.color='pink'" style="color: pink">Customer(s) info</span></h1> <!-- Customer Info Title-->
            <h5> <span onmouseover="style.color='blue'" onmouseout="style.color='pink'" style="color: pink">You got friends that want to shop too? Add them here!</span></h5>
        </div>
    </div>



    <!--<div class="card-header">

    </div>
    <div class="card-body">

    </div>-->




    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th><span onmouseover="style.color='blue'" onmouseout="style.color='pink'" style="color: pink">ID</span></th> <!-- ID Attribute -->
                        <th><span onmouseover="style.color='blue'" onmouseout="style.color='pink'" style="color: pink">Name</span></th>  <!-- Name Attribute -->
                        <th><span onmouseover="style.color='blue'" onmouseout="style.color='pink'" style="color: pink">Phone Number</span></th>  <!-- Phone Number Attribute -->
                        <th><span onmouseover="style.color='blue'" onmouseout="style.color='pink'" style="color: pink">Address</span></th>  <!-- Address Attribute -->
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $sql = "SELECT customer_id, customerName, customerPhone, customerAddress from Customer";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                    ?>

                    <tr>
                        <td><?=$row["customer_id"]?></td>
                        <td><?=$row["customerName"]?></td>
                        <td><?=$row["customerPhone"]?></td>
                        <td><?=$row["customerAddress"]?></td>
                        <td>
                            <button type="button" class="btn" style="background-color:hotpink;" data-bs-toggle="modal" data-bs-target="#editWeapons<?=$row['customer_id']?>">
                                <!-- Edit Section-->
                                Edit
                            </button>
                            <div class="modal fade" id="editWeapons<?=$row['customer_id']?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editWeapons<?=$row['customer_id']?>Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="editWeapons<?=$row['customer_id']?>Label">Edit Customer Information</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="">
                                                <div class="mb-3">
                                                    <label for="editWeapons<?=$row['customer_id']?>Name" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="editWeapons<?=$row['customer_id']?>Name" aria-describedby="editWeapons<?=$row['customer_id']?>Help" name="iName" value="<?=$row['customerName']?>"> <!-- customerName -->
                                                    Phone Number
                                                    <input type="text" class="form-control" id="editWeapons<?=$row['customer_id']?>Name" aria-describedby="editWeapons<?=$row['customer_id']?>Help" name="iPhone" value="<?=$row['customerPhone']?>"> <!-- customerPhone -->
                                                    Address (Where we delivery the sweets to you!)
                                                    <input type="text" class="form-control" id="editWeapons<?=$row['customer_id']?>Name" aria-describedby="editWeapons<?=$row['customer_id']?>Help" name="iAddress" value="<?=$row['customerAddress']?>"> <!-- customerAddress-->
                                                    <div id="editWeapons<?=$row['customer_id']?>Help" class="form-text">Edit info.</div>
                                                </div>
                                                <input type="hidden" name="iid" value="<?=$row['customer_id']?>">
                                                <input type="hidden" name="saveType" value="Edit">
                                                <input type="submit" class="btn btn-primary" value="Submit">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <form method="post" action="">
                                <!-- Delete section -->
                                <input type="hidden" name="iid" value="<?=$row['customer_id']?>" />
                                <input type="hidden" name="saveType" value="Delete">
                                <input type="submit" class="btn" style="background-color:hotpink;" onclick="return confirm('Are you sure?')" value="Delete">
                            </form>
                        </td>
                    </tr>

                    <?php
                    }
                    } else {
                    echo "0 results";
                    }
                    $conn->close();
                    ?>

                </tbody>
            </table>
        </div>
    </div>



    <br /> <!-- Space Break-->
    <!-- Add New Button trigger modal -->
    <button type="button" class="btn btn-primary" style="background-color:hotpink;" data-bs-toggle="modal" data-bs-target="#addWeapons">
        <!-- Add New Section -->
        Add New
    </button>

    <br /> <!-- Space break-->

    <!-- Modal -->
    <div class="modal fade" id="addWeapons" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addWeaponsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addWeaponsLabel">Add Customer Information</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <form method="post" action="">
                        <div class="mb-3">
                            <label for="WeaponsName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="WeaponsName" aria-describedby="nameHelp" name="iName"> <!-- input name-->
                            Phone Number
                            <input type="text" class="form-control" id="CustomerPhone" aria-describedby="nameHelp" name="iPhone"> <!-- input phone number-->
                            Address (Where we will deliver the sweets to you!)
                            <input type="text" class="form-control" id="CustomerAddress" aria-describedby="nameHelp" name="iAddress">  <!-- input address-->
                            <div id="nameHelp" class="form-text">Enter the Customer's info.</div>
                        </div>
                        <input type="hidden" name="saveType" value="Add">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <br /> <!-- Space Break-->

    <div class="card">
        <div class="card-header">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTp9MN2zz3-tN_MxO9BLyt2-kx8mz7gHXya3Q&usqp=CAU" class="card-img-top" alt="picture of screaming" style="height:100px; width:100px;">

            <span onmouseover="style.color='blue'" onmouseout="style.color='pink'" style="color: pink"> Did you know?</span>
        </div>
        <div class="card-body">
            The Ice Scream company is committed to make icy and organized purchases for our customers! <br />
            This way, we can tag the name next to their order and see which item is theirs! <br />
        </div>
    </div>


    <br /> <!-- Space Break -->



    <a class="btn btn-primary" style="background-color:hotpink;" href="index.php" role="button">Home</a> <!-- Bottom Home Button-->
    <a class="btn btn-primary" style="background-color:hotpink;" href="icecream.php" role="button">Go to Ice Cream</a>

    <div class="fw-bold ">
        <!-- footer divs -->
        <hr />
        <div>
            <!-- first row divs in footer-->
            <div style="width: 400px; float: left;">
                Privacy Policy
            </div>

            <div style="width:400px; float:left;">
                Terms & Conditions
            </div>

            <div style="width: 400px; float: left;">
                Do Not Sell or Share My Personal Information
            </div>

        </div>



        <div>
            <div style="width: 400px; float: left;">
                Cookie Settings
            </div>

            <div style="width: 400px; float: left;">
                @2018 - 2022 The Ice Scream Comapny Inc.
            </div>

        </div>



    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>
</html>
