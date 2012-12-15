<div>
	<b>Email: <span class="muted"><?= $email ?></span></b>
</div>
<br>
<div id="change-name">
	<b>User Name</b>
	<?= form("user/change-name") ?>
		<input type="text" class="input-block-level" placeholder="Name" name="name" value="<?= $name ?>">
		<button class="btn" type="submit">Update Name</button>
	</form>
</div>
<br>
<div id="change-password">
	<b>Password</b>
	<?= form("user/change-password") ?>
		<input type="password" class="input-block-level" placeholder="Password" name="password" id="password">
		<input type="password" class="input-block-level" placeholder="Confirm" name="confirm">
		<button class="btn" type="submit">Update Password</button>
	</form>
</div>