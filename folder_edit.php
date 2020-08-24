<?php
require_once ("./header.php");
logged_in_only ();

$foldername = set_post_foldername ();
$public = set_post_bool_var ("public", false);
$inherit = set_post_bool_var ("inherit", false);

if ($folderid == "" || $folderid == "0"){
	message ("No Folder selected");
	}
else if ($foldername == "") {
	$query = "SELECT name, public FROM folder WHERE id=? AND user=? AND deleted!='1'";
	$args = [$folderid, $username];

	if ($result = $mysql->query ($query, $args)) {
		if ($result->rowCount() == 1) {
			$row = $result->fetch(PDO::FETCH_ASSOC);
			}
		else {
			message ("No Folder to edit.");
			}
		}
	else {
		message ($mysql->error);
		}
	?>

	<h2 class="title">Edit Folder</h2>
	<form action="<?php echo $_SERVER['SCRIPT_NAME'] . "?folderid=" . $folderid; ?>" id="fedit" method="POST">
	<p><input type=text name="foldername" size="50" value="<?php echo $row["name"]; ?>"> <?php echo $row["public"] ? $folder_opened_public : $folder_opened; ?></p>
	<p><input type="checkbox" name="public" <?php if ($row["public"]) {echo "checked";} ?>> Public</p>
	<p><input type="checkbox" name="inherit"> Inherit Public Status to all Subfolders and Bookmarks</p>
	<input type="submit" value=" OK ">
	<input type="button" value=" Cancel " onClick="self.close()">
	</form>
	<script>
	this.focus();
	document.getElementById('fedit').foldername.focus();
	</script>

	<?php
	}
else {
	$query = "UPDATE folder SET name=?, public=? WHERE id=? AND user=?";
	$args = [$foldername, $public, $folderid, $username];
	if ($mysql->query ($query, $args)) {
		if ($inherit) {
			require_once (ABSOLUTE_PATH . "folders.php");
			$tree = new folder;
			$tree->get_children ($folderid);
			if (count ($tree->get_children) > 0) {
				$sub_folders = implode (",", $tree->get_children);

				# set subfolders to public
				$query = "UPDATE folder SET public=? WHERE id IN (?) AND user=?";
				$args = [$public, $sub_folders, $username];
				if (! $mysql->query ($query, $args)) {
					message ($mysql->error);
					}

				$sub_folders .= "," . $folderid;
				# set bookmarks to public as well
				$query = "UPDATE bookmark SET public=? WHERE childof IN (?) AND user=?";
				$args = [$public, $sub_folders, $username];
				if ($mysql->query ($query,$args)) {
					echo '<script language="JavaScript">reloadclose();</script>';
					}
				else {
					message ($mysql->error);
					}
				}
			else {
				$query = "UPDATE bookmark SET public=? WHERE childof=? AND user=? ";
				$args = [$public, $folderid, $username];
				if ($mysql->query ($query, $args)) {
					echo '<script language="JavaScript">reloadclose();</script>';
					}
				else {
					message ($mysql->error);
					}
				}
			}
		echo '<script language="JavaScript">reloadclose();</script>';
	}
	else {
		message ($mysql->error);
	}
}

require_once (ABSOLUTE_PATH . "footer.php");
?>
