<?php /*Gets the current state for the next game by recording the player 's move in a
session variable.*/
function getCurrentState($playerThrow) {
    global $currentState;
    switch($playerThrow) {
        case 'rock ':
            $currentState = $_SESSION['rockState '];
            break;
        case 'paper ':
            $currentState = $_SESSION['paperState '];
            break;
        case 'scissors ':
            $currentState = $_SESSION['scissorState '];
            break;
        case 'N/A ':
            $currentState = $_SESSION['initialState '];
    }
    return $currentState; }

/*Creates an array of the player's past choices after their previous move and uses array_rand to make a weighted random selection.*/ function getCompGuess($currentState) { $newState=a rray(); foreach ($currentState as $element=>$value) { $newState = array_merge($newState, array_fill(0, $value, $element)); } $compGuess = $newState[array_rand($newState)]; return $compGuess;} //Takes the computer's guess and picks the appropriate countermove for compThrow function getCompThrow($compGuess) { switch ($compGuess) { case 'rock': $compThrow = 'paper'; break; case 'paper': $compThrow = 'scissors'; break; case 'scissors': $compThrow = 'rock'; break; default: $compThrow = 'ERR, please refresh!'; break; } return $compThrow; } //Compares both player's throws to determine the outcome of the game. function getOutcome($compThrow, $playerThrow) { global $winLossDraw; global $drawCount; global $winCount; global $lossCount; if ("$compThrow" == "$playerThrow") { $winLossDraw = '
<div class="alert alert-warning text-center lead" role="alert">It\'s a draw! Darn.</div>'; $drawCount++; } if ($compThrow == 'rock' && $playerThrow == 'paper') { $winLossDraw = '
<div class="alert alert-success text-center lead" role="alert">Congratulations. You win!</div>'; $winCount++; } if ($compThrow == 'paper' && $playerThrow == 'scissors') { $winLossDraw = '
<div class="alert alert-success text-center lead" role="alert">Congratulations. You win!</div>'; $winCount++; } if ($compThrow == 'scissors' && $playerThrow == 'rock') { $winLossDraw = '
<div class="alert alert-success text-center lead" role="alert">Congratulations. You win!</div>'; $winCount++; } if ($compThrow == 'scissors' && $playerThrow == 'paper') { $winLossDraw = '
<div class="alert alert-danger text-center lead" role="alert">Sorry. You lose!</div>'; $lossCount++; } if ($compThrow == 'paper' && $playerThrow == 'rock') { $winLossDraw = '
<div class="alert alert-danger text-center lead" role="alert">Sorry. You lose!</div>'; $lossCount++; } if ($compThrow == 'rock' && $playerThrow == 'scissors') { $winLossDraw = '
<div class="alert alert-danger text-center lead" role="alert">Sorry. You lose!</div>'; $lossCount++; }} //Adds the player's move to the appropriate state/array at the end of the round. function addMove($lastThrow, $playerThrow) { switch ($lastThrow) { case 'rock': $_SESSION['rockState'][$playerThrow]++; break; case 'paper': $_SESSION['paperState'][$playerThrow]++; break; case 'scissors': $_SESSION['scissorState'][$playerThrow]++; break; case 'N/A': $_SESSION['initialState'][$playerThrow]++; break; } } //Prints an icon reflecting the player's choices. function showPlayerMove($playerThrow) { switch($playerThrow) { case "rock": echo '<i class="fa fa-circle fa-align-center fa-5x"></i>'; break; case "paper": echo '<i class="fa fa-paper-plane-o fa-align-center fa-5x"></i>'; break; case "scissors": echo '<i class="fa fa-scissors fa-align-center fa-5x"></i>'; break; default: echo 'N/A'; break; } } function showCompMove($compThrow) { switch($compThrow) { case "rock": echo '<i class="fa fa-circle fa-align-center fa-5x"></i>'; break; case "paper": echo '<i class="fa fa-paper-plane-o fa-align-center fa-5x"></i>'; break; case "scissors": echo '<i class="fa fa-scissors fa-align-center fa-5x"></i>'; break; default: echo 'N/A'; break; } } //Determines the WLD ratio function winPercent($winCount, $drawCount, $lossCount) { $total = $winCount + $drawCount + $lossCount; $winPercent = $winCount / $total; $winPercent = $winPercent * 100; return $winPercent; } function drawPercent($winCount, $drawCount, $lossCount) { $total = $winCount + $drawCount + $lossCount; $drawPercent = $drawCount / $total; $drawPercent = $drawPercent * 100; return $drawPercent; } function lossPercent($winCount, $drawCount, $lossCount) { $total = $winCount + $drawCount + $lossCount; $lossPercent = $lossCount / $total; $lossPercent = $lossPercent * 100; return $lossPercent; } //Increases throwcount by one function throwLastThrow($playerThrow) { global $throwCount; $throwCount++; $_SESSION['lastThrow'] = $playerThrow; } /*Gets player input and prints results using POST and stores results for the AI using SESSION*/ if (isset($_POST['button'])==1) { session_start(); $compThrow = $_SESSION['nextThrow']; $rock = $_POST['rock']; $paper = $_POST['paper']; $scissors = $_POST['scissors']; $lastThrow = $_SESSION['lastThrow']; $playerThrow = $_POST['playerThrow']; $throwCount = $_POST['throwCount']; $winCount = $_POST['winCount']; $lossCount = $_POST['lossCount']; $drawCount = $_POST['drawCount']; getOutcome($compThrow, $playerThrow); addMove($lastThrow, $playerThrow); $currentState = getCurrentState($playerThrow, $_SESSION); $compGuess = getCompGuess($currentState); $_SESSION['nextThrow'] = getCompThrow($compGuess); $throwCount++; $_SESSION['lastThrow'] = $playerThrow; } /*Sets initial variables*/ else { session_start(); $throwCount = 0; $winCount = 0; $lossCount = 0; $drawCount = 0; $winLossDraw = '
<div class="alert alert-info text-center lead" role="alert">No games played yet!</div>"'; $playerThrow = "N/A"; $compThrow = "N/A"; $rock = "rock"; $paper = "paper"; $scissors = "scissors"; $lastThrow = "N/A"; $_SESSION['initialState'] = array('rock'=>1, 'paper'=>1, 'scissors'=>1); $_SESSION['rockState'] = array('rock'=>1, 'paper'=>1, 'scissors'=>1); $_SESSION['paperState'] = array('rock'=>1, 'paper'=>1, 'scissors'=>1); $_SESSION['scissorState'] = array('rock'=>1, 'paper'=>1, 'scissors'=>1); $_SESSION['lastThrow'] = 'N/A'; $currentState = $_SESSION['initialState']; $compGuess = getCompGuess($currentState); $_SESSION['nextThrow'] = getCompThrow($compGuess); } ?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<title>Rock Paper Scissors AI!</title>
	<link href="http://maxcdn.bootstrapcdn.com/bootswatch/3.2.0/cosmo/bootstrap.min.css" rel="stylesheet">
	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Walter+Turncoat|Shadows+Into+Light' rel='stylesheet' type='text/css'>

	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<style>
		#logo {
			font-family: 'Shadows Into Light', cursive;
			color: #ffffff;
			font-size: 2em;
		}
		#playerName {
			font-family: 'Shadows Into Light', cursive;
			font-size: 2em;
		}
		#compName {
			font-family: 'Shadows Into Light', cursive;
			font-size: 2em;
		}
		/* Commented out for time being. TODO: Choose font for this id.

        #currentGame {
             font-family: 'Walter Turncoat', cursive;
             font-size: 2.25em;
         }
         */
		#results {
			font-family: 'Walter Turncoat', cursive;
			font-size 1.75em;
		}
		#playerButtons {
			font-family: 'Shadows Into Light', cursive;
			font-size 3em;
		}
		#nextMove {
			color: black;
			background-color: black;
		}
	</style>
</head>

<body>

	<nav class="navbar navbar-default" role="navigation">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="#" id="logo">rock, paper, scissors</a>
			</div>
		</div>
		<!-- /.container-fluid -->
	</nav>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4 col-xs-2 col-sm-2"></div>
			<div class="col-md-2 col-xs-4 col-sm-4">
				<h3 class="text-left" id="playerName"><span class="label label-primary"><span class="glyphicon glyphicon-user"></span></span><span class="label label-default">Player
            </h3>
				<h3 class="text-center"><?php showPlayerMove($playerThrow); ?></h3>
				<h4 class="text-center"><em>You threw <?php echo $playerThrow; ?></em></h4>
			</div>
			<div class="col-md-2 col-xs-4 col-sm-2">
				<h3 class="text-right" id="compName"><span class="label label-default">Comp</span><span class="label label-primary"><span class="fa fa-desktop"></span></span>
            </h3>
				<h3 class="text-center"><?php showCompMove($compThrow); ?></h3>
				<h4 class="text-center"><em>Computer threw <?php echo $compThrow; ?></em></h4>
			</div>
			<div class="col-md-4 col-xs-2 col-sm-4">
			</div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4 col-sm-2"></div>
			<div class="col-md-4 col-sm-6">
				<h2 class="text-center" id="currentGame">Current Game:</h2>
				<span id="results"><?php echo $winLossDraw; ?></span>
			</div>
			<div class="col-md-4 col-sm-2"></div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-sm-2"></div>
		<div class="col-md-4 col-sm-6">
			<div class="progress">
				<div class="progress-bar progress-bar-success progress-bar-striped active" style="width: <?php echo winPercent($winCount, $lossCount, $drawCount); ?>%">
					<span class="sr-only"><?php echo winPercent($winCount, $lossCount, $drawCount); ?>%</span>
				</div>
				<div class="progress-bar progress-bar-warning progress-bar-striped active" style="width: <?php echo lossPercent($winCount, $lossCount, $drawCount); ?>%">
					<span class="sr-only"><?php echo lossPercent($winCount, $lossCount, $drawCount); ?>%</span>
				</div>
				<div class="progress-bar progress-bar-danger progress-bar-striped active" style="width: <?php echo drawPercent($winCount, $lossCount, $drawCount); ?>%">
					<span class="sr-only"><?php echo drawPercent($winCount, $lossCount, $drawCount); ?>%</span>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-sm-2"></div>
	</div>

	<div class="row">
		<div class="col-md-4 col-sm-2"></div>
		<div class="col-md-4 col-sm-6">
			<form action="index.php" method="post">
				<input name="button" type="hidden" value="1" />

				<input name="throwCount" type="hidden" value="<?php echo $throwCount; ?>" />

				<input name="winCount" type="hidden" value="<?php echo $winCount; ?>" />

				<input name="lossCount" type="hidden" value="<?php echo $lossCount; ?>" />

				<input name="drawCount" type="hidden" value="<?php echo $drawCount; ?>" />
				<div class="btn-group btn-group-justified" id="playerButtons">
					<div class="btn-group" data-toggle="buttons">
						<button type="submit" name="playerThrow" value="rock" class="btn btn-default">ROCK</button>
					</div>
					<div class="btn-group">
						<button type="submit" name="playerThrow" value="paper" class="btn btn-primary">PAPER</button>
					</div>
					<div class="btn-group">
						<button type="submit" name="playerThrow" value="scissors" class="btn btn-default">SCISSORS</button>
					</div>
				</div>
			</form>
		</div>
		<div class="col-md-4 col=sm-2"></div>
	</div>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4 col-sm-2"></div>
			<div class="col-md-4 col-sm-6">

				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>Win:</th>
							<th>Lose:</th>
							<th>Draw:</th>
						</tr>
					</thead>
					<tr>
						<td class="text-center">
							<?php echo $winCount; ?>
						</td>
						<td class="text-center">
							<?php echo $lossCount; ?>
						</td>
						<td class="text-center">
							<?php echo $drawCount; ?>
						</td>
					</tr>
				</table>
			</div>
			<div class="col-md-4 col-sm-2"></div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4 col-sm-2"></div>
			<div class="col-md-4 col-sm-6">
				<table class="table">
					<thead>
						<tr>
							<th class="text-center">Total Throws:</th>
						</tr>
					</thead>
					<tr>
						<td class="text-center">
							<?php echo $throwCount; ?>
						</td>
					</tr>
				</table>
			</div>
			<div class="col-md-4 col-sm-2"></div>
		</div>
	</div>

	<div id="footer">
		<div class="container text-center">
			© Billy Chappell, 2014
		</div>
	</div>
</body>
<script>
	(function (i, s, o, g, r, a, m) {
		i['GoogleAnalyticsObject'] = r;
		i[r] = i[r] || function () {
			(i[r].q = i[r].q || []).push(arguments)
		}, i[r].l = 1 * new Date();
		a = s.createElement(o),
		m = s.getElementsByTagName(o)[0];
		a.async = 1;
		a.src = g;
		m.parentNode.insertBefore(a, m)
	})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

	ga('create', 'UA-58029601-1', 'auto');
	ga('send', 'pageview');
</script>

</html>
