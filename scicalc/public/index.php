<?php

session_start();

?>

<html>

<head>
  <link rel="stylesheet" href="./templates/practice.css">
</head>


<body>

  <h1>Scientific Calculator</h1>


  <div class="inpBody">
    <form method="post">
      <input type="text" id="numbers" name="numbers" autofocus><br>
      <input type="submit" id="submitval" value="submit" hidden/>
    </form>

    <?php include_once __DIR__ . '/handler.php'; ?>
  </div>

  <div class="ctrlPanel">
    <form method="post">
      <input type="text" id="clearAll" name="clearAll" value="clearAll" hidden>
      <button type="submit" id="submit" value="submit">Clear All</button>
    </form>

  </div>

</body>


</html>