
(function($) {
	
	$.modals = {

		value: 0,               
		// Public methods
		
		alert: function(title, data, callback) {
			if( title == null ) title = 'Alert';
			$.modals._show(title, data, 'alert', function(result) {
				if( callback ) callback(result);
			});
		},

		// Private methods
		
		_show: function(title, data, type, callback) {

			$("BODY").append(
			
			 '<div class="modal fade" id="modal"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title"></h4></div><div class="modal-body"></div><div class="modal-footer"></div></div><!-- /.modal-content --></div><!-- /.modal-dialog --></div><!-- /.modal -->');

			switch( type ) {
				case 'alert':

					$(".modal-title").html(title);				
					$(".modal-body").html('<p>'+data+'</p>');
					 
					$(".modal-footer").html('<button type="button" id="close_modal" class="btn btn-default" data-dismiss="modal">Close</button>');
	 
				break;
	
			}
			
			$("#modal").modal();

		},
		
		_hide: function() {
			$("#modal").modal({backdrop:false}); 
		}
		
	}
	
	// Shortuct functions
	jAlert = function(title, data, callback) {
		$.modals.alert(title, data, callback);
	}
	
	
	
})(jQuery);





