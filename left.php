<!-- left -->
<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
  <?php
  // Check if the user is logged in, if not then redirect him to login page
  if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {

  ?>
    <div class="panel panel-default">
      <div class="panel-heading"><span class="glyphicon glyphicon-lock"></span> Registration</div>
      <div class="panel-body">
        <div class="signin-form">
          <div id="alert"></div>
          <form action="account/register" class="form-signin" method="POST" id="register-form">

            <div class="form-group">
              <label for="user">Username:</label>
              <input type="text" id="user" class="form-control" name="user" required>
              <span id="check-e"></span>
            </div>

            <div class="form-group">
              <label for="pass">Password:</label>
              <input type="password" id="pass" class="form-control" name="pass" required>
            </div>

            <div class="form-group">
              <label for="confirmpass">Confirm Password:</label>
              <input type="password" id="confirmpass" class="form-control" name="confirmpass" required>
            </div>

            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" id="email" class="form-control" name="email" required>
            </div>

            <center>
              <div class="g-recaptcha" data-sitekey="6Le2aKsZAAAAAEW-m4vwTi7RWV3fhaA6FSfeYkhU"></div>
            </center>

            <?php $register = sha1(time()); ?>
            <div class="form-group">
              <input type="hidden" name="register" value="<?php echo $register; ?>">
              <button type="submit" class="gradient-btn full-width gradient-color-palette7" id="btn-submit">
                Join Zifina!
              </button>
            </div>
          </form>
        </div>
      </div>

    </div>
  <?php
  }
  ?>
  <div class="panel panel-default">
    <div class="panel-heading"><span class="glyphicon glyphicon-flash"></span> Server stats</div>
    <div class="panel-body">
      <?php
      /* Power By Yexs */
      $db = new mysqli($dbHost, $dbUser, $dbPassword, $dbName, $port, $dbChar);
      $sql = "SELECT * FROM `uptime` WHERE `realmid`= 1 ORDER BY `startstring` DESC LIMIT 1";
      $result = $db->query($sql);
      while ($row = $result->fetch_assoc()) {

        $uptime = $row['uptime'];
        $sec = $uptime % 60;
        $uptime = intval($uptime / 60);
        $min = $uptime % 60;
        $uptime = intval($uptime / 60);
        $hour = $uptime % 24;
        $uptime = intval($uptime / 24);
        $day = $uptime;

        if ($day != 0)
          $day = $day . " d,";
        else
          $day = "";
        if ($hour != 0)
          $hour = $hour . " h,";
        else
          $hour = "";
        if ($min != 0)
          $min = $min . " m";
        else
          $min = "";

        if ($sec != 0)
          $sec = $sec . " s,";
        else
          $sec = "";

        echo "<a href='#'><span class='glyphicon glyphicon-time'></span> Server uptime: $day $hour $min</a></br>";
      }
      ?>
      <span class="glyphicon glyphicon-flash"></span> Realmlist: <code><?php echo $realmlist; ?></code>
    </div>
  </div>