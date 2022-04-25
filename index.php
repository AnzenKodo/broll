<?php
// Enables strict typing for more error free coding.
declare(strict_types=1);

// Disable error repoting in HTML file.
error_reporting(0);
ini_set('display_errors', '0');

// Read the JSON file
$json = file_get_contents('data.json');

// Decode the JSON file
$data = json_decode($json, true);
$info = $data["info"];
$style = $data["style"];
$feeds = $data["feeds"];

require_once 'rss.php';
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?= $info["name"] ?></title>
		<meta charset="UTF-8">
		<meta name="description" content="<?= $info["description"] ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="stylesheet" href="styles.css">
		<style>
			<?php $font = str_replace(" ", "+", $style['font']) ?>
			@import url("https://fonts.googleapis.com/css2?family=<?= $font ?>&display=swap");

			:root {
				--font: "<?= $style["font"] ?>";
				--link-color: <?= $style["theme_color"] ?>;
				--fg: <?= $style["forground_color"] ?>;
				--bg: <?= $style["background_color"] ?>;
			}
		</style>
	</head>
	<body>
		<header>
			<h1><?= $info["name"] ?></h1>
			<p><?= $info["description"] ?></p>
		</header>

<?php
		$rss = RSS::feed(["https://markmanson.net/feed", "https://understandlegacycode.com/rss.xml"]);
		echo "<li><a href=''>".print_r($rss)."</a></li>";

		foreach ($feeds as $subject => $values) {
			$subject_id = str_replace(" ", "+", strtolower($subject));
			$subject_titlecase = ucwords($subject);
			echo "<h2><a href='#$subject_id'>$subject_titlecase</a></h2>";

			foreach ($values as $value) {
			/* 	$rss = new RSS("https://wakingup.libsyn.com/rss"); */
			/* 	$rss = $rss_data->parsing(); */
				echo "
				<details>
					<summary><a href=''></a>$value</summary>
					<p class='list-meta'><a href=".$value.">URL</a> | <a href=".$value.">Feed</a></p>
				</details>
				";
			}
		}
?>
		<footer>
			<p><?= $info["footer"] ?></p>
		</footer>
		</body>

</html>
