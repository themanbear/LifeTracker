<?php

session_start();

$page = "edit";

include('inc_connect.php');

$query = $db->prepare("SELECT * FROM records WHERE id = :id");
$query->bindParam(':id',$_GET['id']);
$query->execute();
$row = $query->fetch();

if(isset($_POST['update'])) {

  try {

    $recordDate = $_POST['date'];
    $sleep = $_POST['sleep'];
    $exercise = $_POST['exercise'];
    $food = $_POST['food'];
    $service = $_POST['service'];
    $challenge = $_POST['challenge'];
    $fun = $_POST['fun'];
    $satisfaction = $_POST['satisfaction'];
    $notes = $_POST['notes'];


    $sql = "UPDATE records SET recordDate = :recordDate,
                               sleep = :sleep,
                               exercise = :exercise,
                               food = :food,
                               service = :service,
                               challenge = :challenge,
                               fun = :fun,
                               satisfaction = :satisfaction,
                               notes = :notes  
                               WHERE id = :id";    

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':recordDate',$recordDate);
    $stmt->bindParam(':sleep',$sleep);
    $stmt->bindParam(':exercise',$exercise);
    $stmt->bindParam(':food',$food);    
    $stmt->bindParam(':service',$service);
    $stmt->bindParam(':challenge',$challenge);
    $stmt->bindParam(':fun',$fun);
    $stmt->bindParam(':satisfaction',$satisfaction);
    $stmt->bindParam(':notes',$notes);
    $stmt->bindParam(':id',$_GET['id']);



    if ($stmt->execute())
    {
      $success = TRUE;
      echo "<div class='alert alert-success' role='alert' style='line-height:34px;overflow:auto;'>";
      echo "<h4 style='margin:0;'>Your record was updated successfully.</h4>";
      echo "</div>";
    } 
    else 
    {
      echo "<div class='alert alert-danger' role='alert' style='line-height:34px;overflow:auto;'>";
      echo "<h4 style='margin:0;'>There was an error editing your record.</h4>";
      echo "</div>";        
    }
  }//End try

  catch(PDOException $e) {
    echo "<div class='alert alert-danger' role='alert'>";
    echo "<h4 style='margin:0;'>Something went wrong.</h4>";
    echo "Error: ".$e->getMessage();
    echo "</div>";      
  }
}
?>

<!doctype html>
<html>
<head>

  <?php include("inc_links.php"); ?>

  <!-- Date Picker -->
  <script src="../js/datedropper.js"></script>
  <link rel="stylesheet" type="text/css" href="../js/datedropper.css">

  <style type="text/css">

    form div, select, textarea, button {
      margin-bottom: 20px;
    }

    .field-label {
      margin-left: 10px;
    }

  </style>
</head>
<body>
        
  <?php include("inc_nav.php"); ?>

  <div class="container"><!-- Main container -->

    <!-- Start "tracker" form -->
    <form id="tracker" method="POST">

      <!-- Date picker -->
      <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">Date</span>
        <input type="text" id="date" class="form-control" name="date" value="<?php echo (isset($_POST['update']) ? $_POST['date'] : $row['recordDate']) ?>" />
        <script>$( "#date" ).dateDropper();</script>
      </div>

      <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">Hours of Sleep (last night)</span>
        <input type="number" class="form-control" name="sleep" step="any" value="<?php echo (isset($_POST['update']) ? $_POST['sleep'] : $row['sleep']) ?>" required>
      </div>

      <h4 class="field-label">Did you exercise?</h4>
      <select class="form-control" name="exercise" required>
        <option value="" disabled selected>Did you exercise?</option>
        <option <?php echo (($_POST['exercise'] == "Yes") || $row['exercise'] == "Yes") ? "selected='selected'" : ""; ?> value="Yes">Yes</option>
        <option <?php echo (($_POST['exercise'] == "No") || $row['exercise'] == "No") ? "selected='selected'" : ""; ?> value="No">No</option>
<!--         <option value="Yes">Yes</option>
        <option value="No">No</option> -->
      </select>

      <h4 class="field-label">Did you follow a good diet?</h4>
      <select class="form-control" name="food" required>
        <option value="" disabled selected>Did you follow a good diet?</option>
        <option <?php echo (($_POST['food'] == "Yes") || $row['food'] == "Yes") ? "selected='selected'" : ""; ?> value="Yes">Yes</option>
        <option <?php echo (($_POST['food'] == "No") || $row['food'] == "No") ? "selected='selected'" : ""; ?> value="No">No</option>
      </select>

      <h4 class="field-label">Did you do something to help someone else today?</h4>
      <select class="form-control" name="service" required>
        <option value="" disabled selected>Did you do something to help someone else today?</option>
        <option <?php echo (($_POST['service'] == "Yes") || $row['service'] == "Yes") ? "selected='selected'" : ""; ?> value="Yes">Yes</option>
        <option <?php echo (($_POST['service'] == "No") || $row['service'] == "No") ? "selected='selected'" : ""; ?> value="No">No</option>
      </select>

      <h4 class="field-label">Did you challenge yourself today?</h4>
      <select class="form-control" name="challenge" required>
        <option value="" disabled selected>Did you challenge yourself today?</option>
        <option <?php echo (($_POST['challenge'] == "Yes") || $row['challenge'] == "Yes") ? "selected='selected'" : ""; ?> value="Yes">Yes</option>
        <option <?php echo (($_POST['challenge'] == "No") || $row['challenge'] == "No") ? "selected='selected'" : ""; ?> value="No">No</option>
      </select>

      <h4 class="field-label">Did you have fun?</h4>
      <select class="form-control" name="fun" required>
        <option value="" disabled selected>Did you have fun?</option>
        <option <?php echo (($_POST['fun'] == "Yes") || $row['fun'] == "Yes") ? "selected='selected'" : ""; ?> value="Yes">Yes</option>
        <option <?php echo (($_POST['fun'] == "No") || $row['fun'] == "No") ? "selected='selected'" : ""; ?> value="No">No</option>
      </select>      

      <h4 class="field-label">How would you rate your day?</h4>
      <select class="form-control" name="satisfaction" required>
        <option value="" disabled selected>How would you rate your day?</option>
        <option <?php echo (($_POST['satisfaction'] == "Excellent") || $row['satisfaction'] == "Excellent") ? "selected='selected'" : ""; ?> value="Excellent">Excellent</option>
        <option <?php echo (($_POST['satisfaction'] == "Great") || $row['satisfaction'] == "Great") ? "selected='selected'" : ""; ?> value="Great">Great</option>
        <option <?php echo (($_POST['satisfaction'] == "Good") || $row['satisfaction'] == "Good") ? "selected='selected'" : ""; ?> value="Good">Good</option>
        <option <?php echo (($_POST['satisfaction'] == "Fair") || $row['satisfaction'] == "Fair") ? "selected='selected'" : ""; ?> value="Fair">Fair</option>
        <option <?php echo (($_POST['satisfaction'] == "Poor") || $row['satisfaction'] == "Poor") ? "selected='selected'" : ""; ?> value="Poor">Poor</option>
      </select>

      <textarea name="notes" class="form-control" rows="5" col="100" placeholder="Enter any additional notes here (Optional)"><?php echo (isset($_POST['update']) ? $_POST['notes'] : $row['notes']) ?></textarea>

      <button type="submit" name="update" value="Update" class="btn btn-success">Update Record</button>
      &nbsp;
      <a class="btn btn-danger" href="inc_delete.php?id=<?php echo $row['ID'] ?>">Delete Record</a>

    </form><!-- close form -->
  </div><!-- close container -->

</body>

</html>