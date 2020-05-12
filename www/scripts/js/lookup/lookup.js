$(document).ready(function() {
    $('#lookup_first').on('keydown', function(event) {
        var code = event.keyCode || event.which;
        if(code == 13) { //Enter keycode
            event.preventDefault();
            addToList($(this).val());
        }
    });

    $('#btn_add_list').on('click', function() {
        addToList($('#lookup_first').val());
    });

    $('#btn_do_lookup').on('click', function() {
        calloutMsj('primary', '', 'Sending...', true);
        // Disable to avoid several calls
        $('#btn_do_lookup').prop('disabled', true);

        var params = formQueryToJSON($('#form_lookup').serialize());

        $.post(
            '/controllers/sendAJAX.php', 
            params,
            function(data) {
                // Return the result of the lookup
                calloutMsj(data.type, 'Success!', data.msj);
                // remove all domains
                $('.data-dns').remove();
            },
            'json'
        )
        .always(function(data, status, error) {
            if(typeof data.error !== 'undefined') {
                calloutMsj(data.error.type, 'Error', data.error.msj);
            }
            addTopDomains();
            
            $('#btn_do_lookup').prop('disabled', false);
        });
    });

    addTopDomains();
});

function addToList(dns) {
    'use strict';

    if($.trim(dns) !== '') {
        $('#lookup_first').val('');

        $('#div_dns_to_lookup').append(
            '<div class="grid-x grid-padding-x data-dns">' + 
                '<div class="cell small-8">' +
                    '<input type="text" readonly="readonly" name="dns_lookup" value="' + dns + '" />' + 
                '</div>' + 
                '<div class="cell small-4">' +
                    '<button class="button alert" onClick="removeDNS(this);">&times;</button>' + 
                '</div>' +
            '</div>'
        );

        $('#btn_do_lookup').removeClass('hidden');
    }
    else {
        // animate the error
        $('#lookup_first').css("border", "2px solid darkred").trigger('focus');

        setTimeout(function() {
            $('#lookup_first').css("border", "1px solid #cacaca");
        }, 2000);
    }
}

function removeDNS(button) {
    'use strict';

    $(button).parents('.data-dns').remove();

    if($('#div_dns_to_lookup').find('div').length === 0) {
        $('#btn_do_lookup').addClass('hidden');
    }
}

function addTopDomains() {
    $('#div_last_10_domains').load(
        '/views/top_domains.php',
        {},
        function(data, status, error) {
            if(status !== 'success') {
                calloutMsj(alert, 'Error', error);
            }
        }
    );
}