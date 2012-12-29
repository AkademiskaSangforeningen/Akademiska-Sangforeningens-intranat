var AKADEMEN = (function(){
	"use strict";

    //Return public methods
	return {		

		/**
		*	Initialize dialog for forms
		*/
		initializeFormDialog: function(langSave, langCancel) {
			$('<div id="dialog_form"></div>')
				.dialog({
					autoOpen: false,
					height: ($(window).height() * 0.9),
					width: ($(window).width() * 0.9),
					modal: true,
					buttons: [
						{
							text: langSave,
							click: function () {
								$('#form_editobject').trigger('submit');
							}
						},
						{
							text: langCancel,
							"data-priority": "secondary",
							click: function () {
								$( this ).dialog( "close" );
							}
						}
					],
					open: function() {
						//On open, set priority CSS-classes for buttons (if given)
						$(this)
							.closest('.ui-dialog')
								.find('.ui-dialog-buttonpane button[data-priority]')
									.each(function() {
										$(this).addClass("ui-priority-" + $(this).attr("data-priority"));
									});

						}
				});
		},

		/**
		*	Initialize dialog for confirmation
		*/
		initializeConfirmDialog: function(langConfirm, langOK, langCancel) {
			$('<div id="dialog_confirm"></div>')
				.html("<p>" + langConfirm + "</p>")
				.dialog({
					autoOpen: false,
					modal: true,
					resizable: false,
					buttons: [
						{
							text: langOK,
							"data-priority": "secondary"
						},
						{
							text: langCancel,
							click: function () {
								$( this ).dialog( "close" );
							}
						}
					],
					open: function() {
						//On open, set priority CSS-classes for buttons (if given)
						$(this)
							.closest('.ui-dialog')
								.find('.ui-dialog-buttonpane button[data-priority]')
									.each(function() {
										$(this).addClass("ui-priority-" + $(this).attr("data-priority"));
									});

						}
				});
		},

		/**
		*	Initialize dialog for alert
		*/
		initializeAlertDialog: function(langOK) {
			$('<div id="dialog_alert"></div>')
				.dialog({
					autoOpen: false,
					modal: true,
					resizable: false,
					buttons: [
						{
							text: langOK,
							click: function () {
								$( this ).dialog( "close" );
							}
						}
					]
				});
		},

		/**
		*	Initialize dialog for confirmation
		*/
		initializeListDialog: function() {
			$('<div id="dialog_list"></div>')
				.dialog({
					autoOpen: false,
					height: ($(window).height() * 0.9),
					width: ($(window).width() * 0.9),
					modal: true
				});
		},

		/**
		*	Initialize buttons
		*	@param	queryFilter	Filter that can be used for filtering which buttons to initialize
		*/
		initializeButtons: function(queryFilter) {
			//If parameter is undefined, replace it with an empty link
			queryFilter = (queryFilter) || "";

			//Initialize not already initialized buttons
			$(queryFilter + " .button:not(.ui-button)")
				.each(function() {
					var icon = $(this).data("icon"),
						text = $(this).data("text");
					$(this)
						.button({ icons: { primary: icon }, text: text })
						.css("display", "inline-block");
				})
				//Special handling for those buttons that open a form dialog
				.filter('[data-formdialog="true"]')
					.on('click.openFormDialog', function (event) {
						var title = $(this).text();
						$.ajax({
							url: $(this).attr("href"),
							dataType: "html",
							cache: false,
							//on success, set the data to the dialog and open it
							success: function(data) {
								$('#dialog_form')
									.html(data)
									.dialog("option", "title", title)
									.dialog('open');
							},
							error: function(jqXHR, textStatus, errorThrown) {
								window.alert(errorThrown);
							}
						});
						return false;
					})
					.end()
				//Special handling for those buttons that open a confirmation dialog
				.filter('[data-confirmdialog="true"]')
					.on('click.openConfirmDialog', function (event) {
						var $this = $(this),
							title = $this.text();

						$('#dialog_confirm')
							.dialog("option", "title", title)
							.dialog('open')
							.closest('.ui-dialog')
								.find('button:first')
									.off('click')
									.on('click.confirmConfirmDialog', function (event) {
										$.ajax({
											url: $this.attr("href"),
											dataType: "html",
											cache: false,
											//on success, set the data to the dialog and open it
											success: function(data) {
												$('#dialog_confirm')
													.html(data);
											},
											error: function(jqXHR, textStatus, errorThrown) {
												window.alert(errorThrown);
											}
										});

										return false;
									});
						return false;
					})
					.end()
				//Special handling for those buttons that open a list dialog
				.filter('[data-listdialog="true"]')
					.on('click.openListDialog', function (event) {
						var title = $(this).text(),
							url = $(this).attr("href");

						$.ajax({
							url: url,
							dataType: "html",
							cache: false,
							//on success, set the data to the dialog and open it
							success: function(data) {
								$('#dialog_list')
									.data("url", url)
									.html(data)
									.dialog("option", "title", title)
									.dialog('open');
								AKADEMEN.initializeButtons();
							},
							error: function(jqXHR, textStatus, errorThrown) {
								window.alert(errorThrown);
							}
						});
						return false;
					});
		},

		/**
		*	Initialize tabs
		*/
		initializeTabs: function() {
			$('#header_navitabs')
				.tabs({
					load: function() {
						AKADEMEN.initializeButtons();
					}
				})
				.show();
		},

		/**
		*	Initialize form validation.
		*	Validation is automatically done when the form is submitted.
		*/
		initializeFormValidation: function(defaultPost) {
			$('#form_editobject')
				.validate({
					submitHandler: function(form) {
						if (defaultPost) {
							form.submit();
						} else {
							$.ajax({
								type: 'POST',
								url: $(form).attr("action"),
								data: $(form).serialize(),
								success: function(data) {
									$('#dialog_form').html(data);
								},
								error:  function(jqXHR, textStatus, errorThrown) {
									window.alert(errorThrown);
								},
								dataType: "html"
							});
						}

						return false;
					}
				});
		},

		/**
		*	Initialize date picker default values.
		*/
		initializeDatepicker: function() {
			$.datepicker.setDefaults({
						changeMonth: true,
						changeYear: true,
						showWeek: true,
						firstDay: 1,
						dateFormat: 'dd.mm.yy'
			});
		},

		/**
		*	Initialize overlay shown when ajax-calls are being made
		*/
		initializeAjaxLoading: function() {
			$('#ajaxloading')
				.ajaxStart(function() {
					$(this).show();
				})
				.ajaxStop(function() {
					$(this).hide();
				});
		}
    };
})();