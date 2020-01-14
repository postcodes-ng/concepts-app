
(function ($) {
    "use strict";

    const contactForm = document.querySelector('.npc-contact-form');

    contactForm.addEventListener('submit',function(event){
        event.preventDefault();
        processEvent();
    });


    $('.npc-contact-form .npc-input').each(function(){
        $(this).focus(function(){
            hideValidate(this);
        });
    });

    function validateForm(inputs) {
        let validInputs = true;

        for(var i=0; i<inputs.length; i++) {
            if(validate(inputs[i]) == false){
                showValidate(inputs[i]);
                validInputs=false;
            }
        }

        return validInputs;
    }

    function validate (input) {
        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        }
        else {
            if($(input).val().trim() == ''){
                return false;
            }
        }
    }

    function showValidate(input) {
        let thisAlert = $(input).parent();

        $(thisAlert).addClass('npc-input-validate-alert');
    }

    function hideValidate(input) {
        let thisAlert = $(input).parent();

        $(thisAlert).removeClass('npc-input-validate-alert');
    }

    function processEvent() {
        const inputs = $('.npc-input-validate .npc-input');
        if (validateForm(inputs)) {
            hideDiv('cf-result');
            sendMessage('cf-loading', displaySendMessageResult);
        } else {
            return false;
        }
    }

    function sendMessage(spinnerId, responseHandler) {

        let data = {
            'firstName': jQuery('#first-name').val(),
            'lastName': jQuery('#last-name').val(),
            'email': jQuery('#email').val(),
            'phone': jQuery('#phone').val(),
            'message': jQuery('#message').val()
        }

        //start spinner
        startSpinner(spinnerId);

        // Send to the server
        makeRequest('/api/contact/send', 'POST', JSON.stringify(data), responseHandler, spinnerId);
    }

    function displaySendMessageResult(status, result) {
        var resultDiv = jQuery('#cf-result');
        var errorDiv = jQuery('#cf-error');
        var successDiv = jQuery('#cf-success');
        if (status === 'success') {
            successDiv.children('span').text(result.message);
            errorDiv.addClass( 'npc-hidden' );
            successDiv.removeClass( 'npc-hidden' );
        } else {
            const message = (result && result.length > 0) ? result : 'Error sending message';
            errorDiv.children('span').text(message);
            errorDiv.removeClass( 'npc-hidden' );
            successDiv.addClass( 'npc-hidden' );
        }
        resultDiv.removeClass( 'npc-hidden' );
    }


})(jQuery);