<? if($action == "create-failed"): ?>
<div class="alert">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>Can't create account!</strong> Please try again with another email.
</div>
<? endif; ?>

<div class="tabbable">
	
	<ul class="nav nav-tabs">
		<li class="active"><a href="#signin" data-toggle="tab">Sign In</a></li>
		<li><a href="#create-account" data-toggle="tab">Create Account</a></li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane active" id="signin">
			<? if($action == "signin-failed"): ?>
			<div class="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Sign in failed!</strong> email address or password invalid.
		    </div>
			<? endif; ?>

			<?= form("user/try-signin") ?>
				<h4>Please sign in</h4>
				
				<input type="text" class="input-block-level" placeholder="Email address" name="email">
				<input type="password" class="input-block-level" placeholder="Password" name="password">

				<button class="btn btn-primary" type="submit">Sign in</button>
			</form>
		</div>

		<div class="tab-pane" id="create-account">
			<?= form("user/create") ?>
				<h4>New User</h4>
				
				<input type="text" class="input-block-level" placeholder="Name" name="name">
				<input type="text" class="input-block-level" placeholder="Email address" name="email">
				<input type="password" class="input-block-level" placeholder="Password" name="password">

				<button class="btn btn-primary" type="submit">Create Account</button>
			</form>
		</div>
	</div>

</div>
