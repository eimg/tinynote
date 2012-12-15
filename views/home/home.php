<span class="label label-info fixed-msg">Loading...</span>

<div class="row-fluid">
	<div class="span4" id="note-sidebar">
		<button class="btn" id="add-note">
			<span class="icon-plus"></span> Add New Note
		</button>
		<br><br>
		<ul class="nav nav-tabs nav-stacked" id="note-list">
		</ul>
	</div>

	<div class="span8" id="note-reader">
		<div>
			<input id="note-title" type="text" value="" class="input-block-level">
			<textarea class="note" id="note-body"></textarea>
		</div>

		<div class="pull-right">
			<button class="btn hide" id="close-button">
				<span class="icon-chevron-left"></span> Close
			</button>
			<a role="button" class="btn" data-toggle="modal" href="#email-modal" id="send-email">
				<span class="icon-envelope"></span> Send To
			</a>
			<button class="btn btn-primary " id="update-note">
				<span class="icon-book icon-white"></span> Save Note
			</button>
		</div>

		<button class="btn btn-danger" title="Delete Note" id="del-note">
			<span class="icon-trash icon-white"></span>
		</button>
	</div>
</div>

<!-- Modal Dialog Box -->
<div class="modal hide fade" id="email-modal" role="dialog">
	<?= form("note/send") ?>
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Enter Email Address</h3>
		</div>
		<div class="modal-body">
			<input id="email-address" name="email-address" type="text" 
					class="input-block-level" placeholder="enter email address">
		</div>
		<div class="modal-footer">
			<a class="btn" data-dismiss="modal" aria-hidden="true">Close</a>
			<button type="submit" class="btn btn-primary">
				<span class="icon-envelope icon-white"></span> Send Now
			</a>
		</div>
	</form>
</div>