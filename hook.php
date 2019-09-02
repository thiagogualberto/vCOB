<?php
$user = trim(`whoami>&1`);
$host = trim(`hostname>&1`);
$tree = '~/public_html';
$path = '~/vcob-sistema.git';

$output = '';

function bash_line($cmd) {
	global $user, $host, $tree, $output;

	if (isset($_GET['mode']) && $_GET['mode'] == 'text') {
		$output.= "$user@$host:$tree$ $cmd\n";
	} else {
		$output.= "<span class=\"user_host\">$user@$host</span>:<span class=\"dir\">$tree</span>$ $cmd\n";
	}
}

function cmd($cmd = '') {
	global $output;
	bash_line($cmd);
	$output.= `$cmd>&1`;
}

function git_exec($cmd) {
	global $tree, $path, $output;
	bash_line($cmd);
	$output.= `GIT_WORK_TREE=$tree GIT_DIR=$path $cmd>&1`;
}

git_exec('git pull');
git_exec('git checkout -f');
git_exec('git status');
cmd('./composer.phar install');
cmd();

if (isset($_GET['mode']) && $_GET['mode'] == 'text') {
	header('Content-type: text/plain');
	exit($output);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<style>
		body { background-color: #222; color: #fff; font-size: 10pt }
		.user_host { color: limegreen }
		.host { color: green }
		.dir { color: cornflowerblue }
	</style>
	<title>GIT Deploy</title>
</head>
<body>
	<pre><?php echo $output ?></pre>
</body>
</html>