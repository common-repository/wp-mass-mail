
<div class="wrap">
<?php if(function_exists('screen_icon')) screen_icon(); ?>
<h2>WP Mass Mail</h2>
<div class="updated fade">Thanks for using this plugin. Perhaps you want to know about the <a href="http://mr.hokya.com/wp-mass-mail" target="_blank">documentation</a> or make a <a href="http://mr.hokya.com/donate" target="_blank">donation</a></div>

<?php
if ($_POST["send"]<>"") {
	$subject = $_POST["subject"];
	$name = $_POST["name"];
	$from = $_POST["from"];
	$body = $_POST["body"];
	$cc = $_POST["cc"];
	$bcc = $_POST["bcc"];
	$reply = $_POST["reply"];
	//$to = explode(",",$_POST["to"]);
	$count = 0;
	
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/plain; charset=UTF-8\r\n";
	$headers .= 'From: "' . $name . '" <' . $from . ">\r\n";
	$headers .= 'Cc: "' . $cc .  "'>\r\n";
	$headers .= 'Bcc: "' . $bcc .  "'>\r\n";
	$headers .= 'Reply to: "' . $reply .  "'>\r\n";
	
	while (list($a,$b)=each($_POST)) {
		if (strpos($a,"address")>-1) {
			mail($b,$subject,$body,$headers);
			$count++;
		}
	}
	
	echo "<div class='updated fade'>Email was sent to the following $count address(es)</div>";
}

?>

<form id="form" method="post">

<style>
td {padding:5px;}
.address tr:hover {background-color:#AEFE78;}
.address {overflow:scroll; display:block; border:solid 1px #999;}
.kolom {border:solid 1px #6F0; padding:3px;}
</style>

<h3>Message Content</h3>
<div align="right"><small><a href="http://mr.hokya.com/wp-mass-mail" target="_blank">Get Support</a> or <a href="http://mr.hokya.com/donate" target="_blank">Give Support</a></small></div>
<em>Write your message below</em>
<div id="hide">If you see this message, please enable JavaScript</div>

<table>
  <tr>
    <td><input class="kolom" name="subject" id="subject" style="font-size:20px" size="45"/></td>
    <td>Yourname</td>
    <td><input class="kolom" name="name" value="<?php echo $user_identity; ?>" /></td>
  </tr>
  <tr>
  	<td rowspan="5"><textarea class="kolom" name="body" cols="64" rows="8" id="body"></textarea></td>
    <td>From</td>
    <td><input class="kolom" name="from" id="from" value="admin@<?php echo $_SERVER['HTTP_HOST'];?>" /></td>
  </tr>
  <tr>
    <td>Reply-to</td>
    <td><input class="kolom" name="reply" id="reply" value="admin@<?php echo $_SERVER['HTTP_HOST'];?>" /></td>
  </tr>
  <tr>
    <td>Cc</td>
    <td><input class="kolom" name="cc" id="cc" /></td>
  </tr>
  <tr>
    <td>Bcc</td>
    <td><input class="kolom" name="bcc" id="bcc" /></td>
  </tr>
</table>

<h3>Address Book</h3>
  <em>These are your current commentator mailing list. Pick those email address you are going to send to. You can send multiple mail at once but make sure you notice the <a href="http://mr.hokya.com/wp-mass-mail" target="_blank">rules</a></em>

	<p>Find Address : <input id="cari" style="padding:5px; border:solid 1px #3B5999"/></p>
  <table height="350" class="address" id="address">
  
  <?php
global $wpdb;
$count = 0;
$db = $wpdb->get_results("select * from $wpdb->comments where comment_type = '' group by comment_author_email order by comment_author_email asc");
foreach ($db as $db):?>
  <tr>
    <td><input type="checkbox" name="address<?php echo $count;?>" value="<?php echo $db->comment_author_email;?>" name=""/></td>
    <td><?php echo $db->comment_author;?></td>
    <td><?php echo $db->comment_author_email;?></td>
    <td><?php echo substr($db->comment_author_url,0,30);?></td>
	<td><?php echo $db->comment_author_IP;?></td>
  </tr>
  <?php $count++;?>
  <?php endforeach;?>

</table>
<small>There are total <?php echo mysql_affected_rows();?> record(s) in Address Book.</small>
<div align="right"><p>
<input class="button" type="button" value="Select All" onclick="selectall()"/>
<input class="button" type="button" value="Unselect All" onclick="unselectall()"/>
<input class="button-primary" type="submit" name="send" value="Send Email Messages" />
</p></div>
</form>


<script>
document.getElementById("hide").style.display = "none";
cari = document.getElementById("cari");
address = document.getElementById("address");
cari.onkeydown = function () {
	trs = address.getElementsByTagName("tr");
	for (i=0;i<trs.length;i++) {
		if (trs[i].innerHTML.indexOf(cari.value)>-1) trs[i].style.display = "table";
		else trs[i].style.display = "none";
	}
}

tr = document.getElementById("address").getElementsByTagName("tr");
for (i=0;i<tr.length;i++) {
	tr[i].onclick = mail_address_click;
}
function mail_address_click () {
	stat = this.getElementsByTagName("input")[0];
	if (stat.checked) {
		stat.checked = false;
	} else {
		stat.checked = true;
	}
}
function selectall() {
	input = document.getElementById("address").getElementsByTagName("input");
	for (i=0;i<input.length;i++) {
		input[i].checked = true;
	}
}
function unselectall() {
	input = document.getElementById("address").getElementsByTagName("input");
	for (i=0;i<input.length;i++) {
		input[i].checked = false;
	}
}
/*
form = document.getElementById("form");
form.onsubmit = function () {
	to = "";
	address = document.getElementById("address").getElementsByTagName("input");
	for (i=0;i<address.length;i++) {
		if (address[i].checked) to+=address[i].value+",";
	}
	input = document.createElement("input");
	input.name = "to";
	input.value = to;
	input.type = "hidden";
	form.appendChild(input);
}
*/
</script>



</div>