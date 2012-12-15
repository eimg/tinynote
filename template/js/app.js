$(function() {
	// Tweak UI for small screen devices
	var smallScreen = $(document).width() < 700 ? true : false;

	if(smallScreen) { 
		$("#note-reader").attr("class", "span12").hide();
		$("#note-sidebar").attr("class", "span12");

		$("#close-button").click(function() {
			$("#note-sidebar").show();
			$("#note-reader").hide();
		}).show();

		$("#send-email").hide();
	}

	// Set WYSIWIG editor for note body
	$('#note-body').wysihtml5({ 
		"font-styles": false,
		"color": true
	});

	// Note Management [get all notes]
	$(".fixed-msg").text("loading notes...").show();
	$.get(PATH + "/note/all", function(data) {
		$.each(data, function(i, note) {
			var noteSelector = $("<a>", {
				"href": "#"
			}).text(note.title)
			.attr("data-title", note.title)
			.attr("data-id", note.id)
			.attr("data-body", note.body)
			.attr("data-super", note.super_note)
			.click(function() {

				$("#note-list a").removeClass("active");
				if(!smallScreen) $(this).addClass("active");

				$("#update-note, #del-note, #email-address").attr("data-id", $(this).data("id"));
				$("#note-title").val( $(this).data("title") ).focus();

				var noteBody = $(this).data("body") || "";

				$("#note-body").val( noteBody );
				$(".wysihtml5-sandbox").contents().find(".note").html( noteBody );

				if($(this).data("super")) {
					$("#del-note").hide();
				} else {
					$("#del-note").show();
				}

				$("#note-sidebar").hide();
				$("#note-reader").show();

			})
			.appendTo("#note-list")
			.wrap("<li>");

			$(".fixed-msg").hide();
		});

		if(!smallScreen)
			$("#note-list li:first a").trigger("click");

	}, "json");
	
	// Note Management [add note]
	$("#add-note").click(function() {
		$(".fixed-msg").text("creating note...").show();

		$.post(PATH + "/note/new", function(data) {
			var noteSelector = $("<a>", {
				"href": "#"
			}).text("Empty note")
			.attr("data-title", "Empty note")
			.attr("data-id", data.id)
			.attr("data-body", "")
			.click(function() {

				$("#note-list a").removeClass("active");
				if(!smallScreen) $(this).addClass("active");

				$("#update-note, #del-note, #email-address").attr("data-id", $(this).data("id"));
				$("#note-title").val( $(this).data("title") ).focus();

				var noteBody = $(this).data("body") || "";

				$("#note-body").val( noteBody );
				$(".wysihtml5-sandbox").contents().find(".note").html( noteBody );

				$("#note-sidebar").hide();
				$("#note-reader").show();

			})
			.appendTo("#note-list")
			.wrap("<li>")
			.trigger("click");

			$(".fixed-msg").hide();
		}, "json");
	});

	// Note Management [save/update note]
	$("#update-note").click(function() {
		$(".fixed-msg").text("saving note...").show();

		var id = $(this).attr("data-id");
		var title = $("#note-title").val();
		var body = $("#note-body").val();

		$.post(PATH + "/note/update", {"id": id, "title": title, "body": body}, function(data) {
			$(".fixed-msg").text("done").fadeOut("slow");
			$(".wysihtml5-sandbox").contents().find(".note").glow();
			$(".wysihtml5-sandbox").glow();

			var noteItem = $("#note-list a[data-id=" + id + "]");
			noteItem.text(data.title).data("title", data.title).data("body", data.body);

			$("#note-title").val(data.title);

		}, "json");
	});

	// Note Management [delete note]
	$("#del-note").click(function() {

		var sure = confirm("Are you sure you want to delete this note?");
		if(!sure) return false;

		$(".fixed-msg").text("deleting note...").show();

		var id = $(this).attr("data-id");

		$.post(PATH + "/note/delete", {"id": id}, function(data) {
			$(".fixed-msg").text("done").fadeOut("slow");

			var noteItem = $("#note-list a[data-id=" + id + "]");
			noteItem.parent().remove();
			
			if(smallScreen) {
				$("#note-sidebar").show();
				$("#note-reader").hide();
			} else {
				$("#note-list li:first a").trigger("click");
			}

		}, "json");
	});

	// Form Validations
	$("#signin form").validate({
		rules: {
			email: "required",
			password: "required"
		},
		messages: {
			email: "Email required",
			password: "Password required"
		}
	});

	$("#create-account form").validate({
		rules: {
			name: {
				required: true,
				alphanum: /^[0-9a-zA-Z_\-\s]*$/,
				minlength: 3
			},
			email: {
				required: true,
				email: true
			},
			password: {
				required: true,
				minlength: 6
			}
		},
		messages: {
			name: {
				required: "Name required",
				alphanum: "Special characters are not allow",
				minlength: "Name should be at lease 3 characters"
			},
			email: {
				required: "Email required",
				email: "Email should be valid email format"
			},
			password: {
				required: "Password required",
				minlength: "Passwrod should be at lease 6 characters"
			}
		}
	});

	$("#change-name form").validate({
		rules: {
			name: {
				required: true,
				alphanum: /^[0-9a-zA-Z_\-\s]*$/,
				minlength: 3
			}
		},
		messages: {
			name: {
				required: "Name required",
				alphanum: "Special characters are not allow",
				minlength: "Name should be at lease 3 characters"
			}
		}
	});

	$("#change-password form").validate({
		rules: {
			password: {
				required: true,
				minlength: 6
			},
			confirm: {
				required: true,
				equalTo: '#password'
			}
		},
		messages: {
			password: {
				required: "Password required",
				minlength: "Name should be at lease 6 characters"
			},
			confirm: {
				required: "Password confirm required",
				equalTo: "Password and confirm don't match"
			}
		}
	});

	var emailValidator = $("#email-modal form").validate({
		rules: {
			"email-address": {
				required: true,
				email: true
			}
		},
		messages: {
			"email-address": {
				required: "Email address required",
				email: "Email should be valid email address"
			}
		},
		submitHandler: function() {
			$("<span>", {
				id: "email-status",
				style: "float:left",
				"class": "label label-info"
			}).html("Sending email... ")
			.prependTo("#email-modal .modal-footer");
			$("#email-address").attr("disable", "disabled");

			$.post(PATH + "/note/send", function() {
				
				$("#email-status").html("Done ");
				$("#email-address").removeAttr("disabled").val("").focus();
			});

			return false;
		}
	});

	// Extension for jQuery Validate
	$.validator.addMethod("alphanum", function(value, element, pattern) {
		return this.optional(element) || pattern.test(value);
	}, "Field contains invalid characters.");

	// Email modal dialog box
	$('#email-modal').on('hidden', function () {
		$("#email-address").val("");
		$("#email-status").remove();
		emailValidator.resetForm();
	});

	$("#email-modal [data-dismiss=modal]").click(function() {
		$("#email-modal").modal("hide");
	});
});
