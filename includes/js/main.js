jQuery(function($){
	console.log("yaa");
	setTimeout(function(){
		jQuery(".notify_ninja_phone_field").intlTelInput({
			initialCountry: "auto",
			geoIpLookup: function(callback) {
				$.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
				  var countryCode = (resp && resp.country) ? resp.country : "";
				  callback(countryCode);
				});
			},
			utilsScript: ninja_notify_plugin_url  + '/includes/js/utils.js'
		
		});
	}, 1000);
	
	$(document).on("change", ".notify_ninja_phone_field", function(){
		var nfid = $(this).data('nfid');
		$("#" + nfid).val($(this).intlTelInput("getNumber"));
	});
	
});


// Create a new object for custom validation of a custom field.
var myCustomFieldController = Marionette.Object.extend( {
    initialize: function() {

        // On the Form Submission's field validaiton...
        var submitChannel = Backbone.Radio.channel( 'submit' );
        this.listenTo( submitChannel, 'validate:field', this.validateRequired );

        // on the Field's model value change...
        var fieldsChannel = Backbone.Radio.channel( 'fields' );
        this.listenTo( fieldsChannel, 'change:modelValue', this.validateRequired );
    },

    validateRequired: function( model ) {

        // Only validate a specific fields type.
        if( "notify_ninja_phone" != model.get( 'type' ) ) return;

        // Check if Model has a value
        if( model.get( 'value' ) && model.get( 'value' ).length == 12 ) {
            // Remove Error from Model
            Backbone.Radio.channel( 'fields' ).request( 'remove:error', model.get( 'id' ), 'custom-field-error' );
        } else {
            // Add Error to Model
            Backbone.Radio.channel( 'fields' ).request( 'add:error', model.get( 'id' ), 'custom-field-error', 'Please enter a valid phone number' );
        }
    }
});

// On Document Ready...
jQuery( document ).ready( function( $ ) {

    // Instantiate our custom field's controller, defined above.
    new myCustomFieldController();
});