<?php

$salt = "7RHPXiqNPmGf76ebb6oq"; //please randomize this string yourself
$datadir = "/var/www/html/__captcha_validation/ip/";

header("Content-type: text/html; charset=utf-8");
header("Expires: Mon, 29 Jun 1981 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$REF = (isset($_GET["ref"]) && $_GET["ref"]) ? $_GET["ref"] : false;
$URI = (isset($_GET["uri"]) && $_GET["uri"]) ? $_GET["uri"] : false;
$QS = (isset($_GET["qs"]) && $_GET["qs"]) ? $_GET["qs"] : false;
$REDIRECTED_IP = (isset($_GET["c"]) && $_GET["c"]) ? $_GET["c"] : false;
$CLIENT_IP = (isset($_SERVER["REMOTE_ADDR"]) && $_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] : false;
$LANG = (isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) && $_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? strtolower(substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2)): "en";
$location = "";
$captcha_correct = false;

$h1title = "Please validate the captcha field before submitting your request";
if($LANG == 'nl') {
	$h1title = "Gelieve het captcha veld te valideren alvorens verder te gaan";
}

if(isset($_POST['__captcha_validation_answer_hash']) && $_POST['__captcha_validation_answer_hash'] != "" && preg_match('/^([a-z0-9]){32}$/', $_POST['__captcha_validation_answer_hash']) && preg_match('/^([0-9]){1,2}$/', $_POST['__captcha_validation_answer'])) {

	if(md5($salt.$_POST['__captcha_validation_answer']) == $_POST['__captcha_validation_answer_hash']) {

		$captcha_correct = true;
		$location = urldecode($REF . $URI . "?" . $QS);

		//save client ip
		if ($CLIENT_IP) {
			$IPF=$datadir.$CLIENT_IP.".dat";
			if (is_dir($datadir)) {
				if ($handle = fopen($IPF, 'w')) {
					fclose($handle);
				}
			}
		}
	}

}

if(!$captcha_correct) {
	//initiate captcha
	$n1 = rand(0,14);
	$n2 = rand(1,14);
	$answer = $n1 + $n2;

	$captcha[0] = 'zero';
	$captcha[1] = 'one';
	$captcha[2] = 'two';
	$captcha[3] = 'three';
	$captcha[4] = 'four';
	$captcha[5] = 'five';
	$captcha[6] = 'six';
	$captcha[7] = 'seven';
	$captcha[8] = 'eight';
	$captcha[9] = 'nine';
	$captcha[10] = 'ten';
	$captcha[11] = 'eleven';
	$captcha[12] = 'twelve';
	$captcha[13] = 'thirteen';
	$captcha[14] = 'fourteen';
	$captcha[15] = 'fifteen';
	$captcha[16] = 'sixteen';
	$captcha[17] = 'seventeen';
	$captcha[18] = 'eighteen';
	$captcha[19] = 'nineteen';
	$captcha[20] = 'twenty';
	$question = 'What is the sum of ' . $captcha[$n1] . ' and ' . $captcha[$n2] . '?';

	if($LANG == 'nl') {
		$captcha[0] = 'nul';
		$captcha[1] = 'een';
		$captcha[2] = 'twee';
		$captcha[3] = 'drie';
		$captcha[4] = 'vier';
		$captcha[5] = 'vijf';
		$captcha[6] = 'zes';
		$captcha[7] = 'zeven';
		$captcha[8] = 'acht';
		$captcha[9] = 'negen';
		$captcha[10] = 'tien';
		$captcha[11] = 'elf';
		$captcha[12] = 'twaalf';
		$captcha[13] = 'dertien';
		$captcha[14] = 'veertien';
		$captcha[15] = 'vijftien';
		$captcha[16] = 'zestien';
		$captcha[17] = 'zeventien';
		$captcha[18] = 'achtien';
		$captcha[19] = 'negentien';
		$captcha[20] = 'twintig';
		$question = 'Wat is de som van ' . $captcha[$n1] . ' en ' . $captcha[$n2] . '?';
	}

}

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Captcha validation</title>
<style>
body {
	font-size: 16px;
	font-family: Arial, Helvetica, sans-serif;
	color: black;
	background-repeat: repeat-x;
}
.whitebackground {
	padding: 30px;
	background: #FFFFFF;
	border: 1px solid rgba(0,0,0,0.1);
	width: 400px;
	margin: 0 auto;
	position: relative;
	max-width: 900px;
	border-radius: 10px;
	text-align: center;
	height: 140px;
}
h1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 26px;
	text-align: center;
	font-weight: bold;
	margin-bottom: 20px;
}
.button {
	padding: 10px;

	background-color: #08d;
	border-radius: 12px;
	border: 0;
	box-sizing: border-box;
	color: #FFF;
	font-size: 18px;
	height: 50px;
	text-align: center;
	width: 240px;
}
.dropdown {
	background-color: #DDD;
	border-radius: 12px;
	border: 0;
	box-sizing: border-box;
	color: #000;
	font-size: 14px;
	height: 30px;
	outline: 0;
	padding: 4px 20px 0;
	width: 100px;
}
</style>
</head>

<body>
<h1><?php echo $h1title ?></h1>
<div class="whitebackground">
<form id="__captcha_validation_form" action="<?php echo $location ?>" method="post">
<?php
foreach ($_POST as $a => $b) {
	if(!is_array($_POST[$a])) {
		if (!preg_match('/^__captcha_validation_/', $a)) {
			echo '<input type="hidden" name="' . $a . '" value="' . $b . '">' . chr(10);
		}
	} else {
		foreach($_POST[$a] as $aa => $ab) {
			echo '<input type="hidden" name="'. $a . '[' . $aa . ']" value="' . $ab . '">' . chr(10);
		}
	}
}
?>

<?php if(!$captcha_correct) { ?>
<input type="hidden" name="__captcha_validation_answer_hash" value="<?php echo md5($salt.$answer) ?>">
<?php echo $question ?><br /><br />
  <select class="dropdown" name="__captcha_validation_answer" id="captcha">
	<option>0</option>
	<option>1</option>
	<option>2</option>
	<option>3</option>
	<option>4</option>
	<option>5</option>
	<option>6</option>
	<option>7</option>
	<option>8</option>
	<option>9</option>
	<option>10</option>
	<option>11</option>
	<option>12</option>
	<option>13</option>
	<option>14</option>
	<option>15</option>
	<option>16</option>
	<option>17</option>
	<option>18</option>
	<option>19</option>
	<option>20</option>
	<option>21</option>
	<option>22</option>
	<option>23</option>
	<option>24</option>
	<option>25</option>
	<option>26</option>
	<option>27</option>
	<option>28</option>
  </select><br /><br />
<input class="button" type="submit" name="__captcha_validation_answer_submit" value="Validate" />
<?php } else { ?>
Validation succeeded.<br />
<?php if($location != "") { ?>
Please press this button to continue.<br />
<script type="text/javascript">
    document.getElementById('__captcha_validation_form').submit();
</script>
<input class="button" type="submit" name="__captcha_validation_answer_submit" value="Continue" />
<?php } ?>
<?php } ?>

</form>
</div>
<?php if($REDIRECTED_IP != $CLIENT_IP) { ?>
<div style="text-align: center; padding-top: 50px;">Warning: your IP changed, this might not work.</div>
<?php } ?>
</body>
</html>
