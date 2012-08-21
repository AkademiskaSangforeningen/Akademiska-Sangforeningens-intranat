var AKADEMEN = (function(){
  
    //Return public methods
	return {
	
		/**
		*	Initialize dialog for forms
		*/		
		initializeFormDialog: function(langSave, langCancel) {
			$('<div id="dialog_editobject"></div>')
				.dialog({
					autoOpen: false,
					height: 580,
					width: 700,
					modal: true,
					buttons: [
						{
							text: langSave,
							click: function () {
								$('#form_editobject').trigger('submit');
							},
						},
						{
							text: langCancel,
							"data-priority": "secondary",
							click: function () {
								$( this ).dialog( "close" );
							},
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
				//Special handling for those buttons that open a dialog
				.filter('[data-formdialog="true"]')
					.on('click.openDialog', function (event) {			
						var title = $(this).text();
						$.ajax({
							url: $(this).attr("href"),				  
							dataType: "html",
							cache: false,
							//on success, set the data to the dialog and open it
							success: function(data) {
								$('#dialog_editobject')
									.html(data)
									.dialog("option", "title", title)								
									.dialog('open');							
							},
							error: function(jqXHR, textStatus, errorThrown) {
								alert(errorThrown);
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
		initializeFormValidation: function() {		
			$('#form_editobject')
				.validate({
					submitHandler: function(form) {
						$.ajax({
							type: 'POST',
							url: $(form).attr("action"),
							data: $(form).serialize(),
							success: function(data) {													
								$('#dialog_editobject').html(data);
							},
							error:  function(jqXHR, textStatus, errorThrown) {
								alert(errorThrown);
							},
							dataType: "html"
						});
						
						return false;
					}
				});
		},
		
		/**
		*	Initialize date picker form input fields..
		*/
		initializeDatePicker: function() {						
			$("input[data-datepicker]").each(function() {
				$(this)
					.datepicker({
						changeMonth: true,
						changeYear: true,
						showWeek: true,
						firstDay: 1,
						dateFormat: $(this).attr("data-datepicker")
					});
			});
		}
    };
})();