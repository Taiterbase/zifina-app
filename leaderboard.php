<?php
/* Power By Yexs */
session_start();
include 'db.php';
ini_set("display_errors", 0);
error_reporting(E_ALL ^ E_NOTICE);
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html>
<head>
    <?php include "header.php"; ?>
	
    <title><?php echo $website_title; ?></title>
</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><img src="/static/images/logos/logo.png"></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">

                <li class='active'><a href='/home'><span class='glyphicon glyphicon-home'></span> HOME</a></li>
                <li><a href='/changelog'><span class='glyphicon glyphicon-wrench'></span> CHANGELOG</a></li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-signal"></span> INFORMATION <i class="fa fa-chevron-down"></i>
                    </a>
						<div class="dropdown-menu dropdown-menu-dark" role="menu">
                            <a class="dropdown-item" href="/connect">Connection Guide</a>
                            <a class="dropdown-item" href="/account">FAQ</a>
                            <a class="dropdown-item" href="/account">Changes</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/account">Report a bug</a>
                            
                        </div>
                </li>
                <li><a href='/leaderboard'><span class='glyphicon glyphicon-blackboard'></span> LEADERBOARD</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
               
                <?php
                // Check if the user is logged in, if not then redirect him to login page
                if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){

                    ?>
                    <li><a href="/account/login"><span class="glyphicon glyphicon-user"></span> Sign In</a></li>

                    <?php
                }
                else
                {
                ?>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle " data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <?php echo htmlspecialchars($_SESSION["username"]); ?> <i class="fa fa-chevron-down"></i>
                    </a>
                        <div class="dropdown-menu dropdown-menu-dark dropdown-menu-right" role="menu">
                            <a class="dropdown-item" href="/account/store"><i class="fa fa-shopping-bag"></i>Store</a>
                            <a class="dropdown-item" href="/account/services"><i class="fa fa-wrench"></i>Services</a>
                            <a class="dropdown-item" href="/account/donate"><i class="fa fa-heart"></i>Donate</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/account/manage"><i class="fa fa-cogs"></i>My account</a>
                            <a class="dropdown-item logout-btn" href="/account/logout"><i class="fa fa-sign-out"></i>Log out</a>
                        </div>
                </li>
            </ul>
            <?php } ?>
        </div>
    </div>
</nav>

 <div class="container">
    <div class="row">
      <div class="col-sm-12 col-xs-12">
        <div class="panel panel-default">
          <div class="panel-heading"><?php echo $realm_name; ?> - Top 10: 2v2</div>
          <div class="panel-body">
            
<center>
<table width='100%'>
<tr>
<td width='45%'>Team Name</td>
<td width='45%'>Team Leader</td>
<td width='5%'>Rating</td>
</tr>
</table>
</center>

<?php

$db = new mysqli($dbHost, $dbUser, $dbPassword, $dbName, $port, $dbChar);
$j=1;
        $teamType = array(
                '2' => '2x2',
                '3' => '3x3',
                '5' => '5x5'
				);
				


if(!isset($_GET['guid'])){

$sql = "SELECT * FROM " . $dbChar . ".arena_team ORDER by `name`";
$result = $db->query($sql);

echo "<center><table border=1 width=70%>
<tr>
<td>Team Name</td>
<td align=center>Command Type</td>
<td align=center><center>Team Leader</center></td>
<td>Faction</td>
<td align=center>Rating</td>

</tr>";


while ($row = $result->fetch_assoc()) {
array($row);
$query_num = "SELECT COUNT(*) FROM " . $dbChar . ".arena_team_member` WHERE `arenateamid`='$row[arenateamid]'";
$gleader = "SELECT name,race * FROM " . $dbChar . " WHERE `guid`='$row[captainguid]'";
$myrow = $db->query($gleader);
$top = "SELECT * FROM " . $dbChar . ".arena_team_stats` WHERE `arenateamid`='$row[arenateamid]'";
$toprow = $db->query($top);


echo "
<tr>
<td >
<p style='padding-left: 5px'><a href='?guid=".$row['arenateamid']."' >".$row['name']."</a></p>
</td>
<td  align=center><center>".$teamType[$row['type']]."</center></td>

<td><a href=".$wowd."/index.php?player=".$row['captainguid'].">".$myrow['name']."</a></td>
<td align=center><center><img src=images/".$faction.".gif title=".$faction."></center></td>
<td align=right><p style='padding-right: 8px'>".$toprow['rating']."</p></td></tr>";

}
echo "</table></center><br><br>";
}


?>



          </div>
        </div>
      </div>
    </div>
  </div>
  

  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-xs-12">
        <div class="panel panel-default">
          <div class="panel-heading"><?php echo $realm_name; ?> - Top 10: 3v3 </div>
          <div class="panel-body">
            
<center>
<table width='100%'>
<tr>
<td width='45%'>Team Name</td>
<td width='45%'>Team Leader</td>
<td width='5%'>Rating</td>
</tr>

</table>
</center>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-xs-12">
        <div class="panel panel-default">
          <div class="panel-heading"><?php echo $realm_name; ?> - Top 10: 5v5 </div>
          <div class="panel-body">
            
<center>
<table width='100%'>
<tr>
<td width='45%'>Team Name</td>
<td width='45%'>Team Leader</td>
<td width='5%'>Rating</td>
</tr>

</table>
</center>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php include "footer.php" ?>
</body>
</html>