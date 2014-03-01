(function ($) {
	
	$(function() {
		
		var contactForm = $( '#contact-form' );
		var loader = contactForm.find('.ajax-loader');
		
		contactForm.submit(function()
		{
			if (contactForm.valid())
			{
				loader.css('display', 'block');
				var formValues = $(this).serialize();
				
				$.post($(this).attr('action'), formValues, function(data)
				{
					if ( data == 'success' )
					{
						contactForm.clearForm();
					}
					else
					{
						contactForm.clearForm();
						//$('.alert').addClass('error');
					}
					loader.hide();
					$('.alert').fadeIn().delay(2000).fadeOut();
				});
			}
			
			return false
		});
	
	});
	
	
	$.fn.clearForm = function() {
	  return this.each(function() {
	    var type = this.type, tag = this.tagName.toLowerCase();
	    if (tag == 'form')
	      return $(':input',this).clearForm();
	    if (type == 'text' || type == 'password' || tag == 'textarea')
	      this.value = '';
	    else if (type == 'checkbox' || type == 'radio')
	      this.checked = false;
	    else if (tag == 'select')
	      this.selectedIndex = -1;
	  });
	};

})(jQuery);