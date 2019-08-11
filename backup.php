
<?php
require('../routeros_api.class.php');

$config['host']='111.111.111.111';
$config['user']='LOGIN';
$config['password']='*****';
$config['nama_file']='nama_file.rsc';
$config['folder_local']='/var/www/html/';

$API = new RouterosAPI();
$API->debug = true;
if ($API->connect($config['host'], $config['user'], $config['password'])) {
   $API->write('/export',false);
   $API->write('=file=nama_file.rsc', true);
   $READ = $API->read(false);
   $ARRAY = $API->parseResponse($READ);
   print_r($ARRAY);
   $API->disconnect();
   
   
	//FTP
	// define some variables
	//nama file di server lokal,sebutkan juga nama folder dimana file tersebut akan disimpan
	$local_file =$config['folder_local'].$config['nama_file'];
	//nama file di server tujuan
	$server_file = $config['nama_file'];
	//nama host/ip server FTP
	$ftp_server=$config['host'];
	//username Server FTP
	$ftp_user_name=$config['user'];
	//password server FTP
	$ftp_user_pass=$config['password'];

	$conn_id = ftp_connect($ftp_server);

	// login with username and password
	$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

	// try to download $server_file and save to $local_file
	if (ftp_get($conn_id, $local_file, $server_file, FTP_BINARY)) {
			$pesan	='sukses';		    
			$text_msg="Successfully written to $local_file\n";
			$responStatus []=$r['host'].',OK';
	}
	else {
			$pesan	='gagal';		    
			$text_msg="There was a problem\n";
			$responStatus []=$r['host'].',GAGAL';
	}
	// close the connection
	ftp_close($conn_id);
	echo $text_msg;
   
}
?>
