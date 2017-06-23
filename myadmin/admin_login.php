<?php include 'header.php'; ?>
<h2></h2>
<h2></h2>
<h2></h2>

<h2>&nbsp;&nbsp; Login Panel</h2>
    <div align="left">
		<form action="login_check.php" method="post" class="niceform">
			<fieldset style="width:73%">
				<dl>
					<dt><label for="email">Username:</label></dt>
					<dd><input type="text" name="uname" size="54" /></dd>
				</dl>
				<dl>
					<dt><label for="password">Password:</label></dt>
					<dd><input type="password" name="pwd" id="" size="54" /></dd>
				</dl>
				<dl class="submit">
					<dt></dt>
					<dd><input type="submit" name="submit" id="submit" value="Enter" /></dd>
				</dl>
	
			</fieldset>
		</form>
	</div>

<?php

 include $adminfolder.'footer.php'; ?>