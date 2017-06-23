<?php include 'header.php'; ?>
<?php
    $n = $db->query("select * from admin where id = 1",database::GET_ROW);
?>
<script language="javascript" src="<?=BASE_PATH?>js/validation.js"></script>
<script language="javascript" >

	var compulsory = new Array('username','password');
	var dispError = new Array('Username','Password');

	function chf(tthis)
	{
		if(document.dfrm.password.value != document.dfrm.cpass.value)
		{
			alert("password not confirmed");
			document.dfrm.password.focus();
			return false;
		}

		return chkfrm(compulsory,dispError,tthis);
	}
</script>
        <h2></h2>
        <h2>&nbsp;&nbsp; Admin Settings</h2>
    <div class="form">

         <form name="dfrm" method="post" action="settings_db.php" onsubmit="return chf(this);" class="niceform">
                <fieldset>
                    <dl>
                        <dt style="width: 200px"><label for="Admin">Admin:</label></dt>
                        <dd><input type="text" name="username" id="" value="<?=$n['username']?>" size="54" /></dd>
                    </dl>
                    <dl>
                        <dt style="width: 200px"><label for="password">Password:</label></dt>
                        <dd><input type="password" name="password" value="<?=$n['password']?>" id="" size="54" /></dd>
                    </dl>
                    <dl>
                        <dt style="width: 200px"><label for="confirmpassword">Confirm Password:</label></dt>
                        <dd><input type="password" name="cpass" value="<?=$n['password']?>" id="" size="54" /></dd>
                    </dl>
                    <dl>
                        <dt style="width: 200px"><label for="email">Email Address:</label></dt>
                        <dd><input type="text" name="email" id="" value="<?=$n['email']?>" size="54" /></dd>
                    </dl>
                    <dl>
                        <dt style="width: 200px"><label for="sitename">Site Name:</label></dt>
                        <dd><input type="text" name="sitename" id="" value="<?=$n['sitename']?>" size="54" /></dd>
                    </dl>
                    <dl>
                        <dt style="width: 200px"><label for="Site Title">Site Title:</label></dt>
                        <dd><input type="text" name="title" id="" value="<?=$n['title']?>" size="54" /></dd>
                    </dl>
                    <dl>
                        <dt style="width: 200px"><label for="File Post Fix">File Post Fix:</label></dt>
                        <dd><input type="text" name="filepostfix" id="" value="<?=$n['filepostfix']?>" size="54" /></dd>
                    </dl>
                    <dl>
                        <dt style="width: 200px"><label for="Create Thumbnail Size">Create Thumbnail Size:</label></dt>
                        <dd><input type="text" name="thumbw" id="" value="<?=$n['thumbw']?>" size="5" maxlength="3" /></dd>
                    </dl>
                    <dl>
                        <dt style="width: 200px"><label for="Create Thumbnail Size">Display Thumbnail (H/W):</label></dt>
                        <dd><input type="text" name="dthumbh" size="5" maxlength="3" value="<?=$n['dthumbh']?>" /> &nbsp; &nbsp; <input type="text" name="dthumbw" size="5" maxlength="3" value="<?=$n['dthumbw']?>" /></dd>
                    </dl>
                    <dl class="submit">
                        <dt style="width: 200px"></dt>
                        <dd>
                            <input type="submit" name="submit" id="submit" value="Submit" />
                        </dd>
                    </dl>


                </fieldset>

         </form>
         </div>
<?php include $adminfolder.'footer.php'; ?>