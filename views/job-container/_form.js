$(function ()
{
    /*
     * set shipper label uppercase
     */
    $('#jobcontainerform-shipper_id').on('select2:open', function (event)
    {
        $('.select2-search__field').addClass('uppercase');
    });

    /*
     * behavior after shipper selection closed
     */
    $('#jobcontainerform-shipper_id').on('select2:close', function (event)
    {
        shipper = $(this).val();

        if (shipper && isNaN(shipper)) {
            /*
             * if inserting new shipper, show shipper detail block
             * start by focusing shipper address
             */
            $('#input-shipperdetail').show({
                effect: 'blind',
                complete: function ()
                {
                    $('#jobcontainerform-shipperaddress').focus();
                }
            });
        } else {
            /*
             * else hide shipper detail block
             * not focusing any input
             */
            $('#input-shipperdetail').hide({
                effect: 'blind'
            });
        }
    });

    /*
     * when pressing 'enter' inside shipper-phone, jump to shipper-email input
     */
    $('#jobcontainerform-shipperphone').keypress(function (event)
    {
        if (event.which == 13) {
            $('#jobcontainerform-shipperemail').focus();
            event.preventDefault();
        }
    });

    /*
     * when pressing 'enter' inside shipper-email, jump to shipper-npwp input
     */
    $('#jobcontainerform-shipperemail').keypress(function (event)
    {
        if (event.which == 13) {
            $('#jobcontainerform-shippernpwp').focus();
            event.preventDefault();
        }
    });

    /*
     * when pressing 'enter' inside containernumber, jump to size input
     */
    $('#jobcontainerform-containernumber').keypress(function (event)
    {
        if (event.which == 13) {
            $('#jobcontainerform-size').focus();
            event.preventDefault();
        }
    });

    /*
     * when pressing 'enter' inside size, jump to type input
     */
    $('#jobcontainerform-size').keypress(function (event)
    {
        if (event.which == 13) {
            $('#jobcontainerform-type_id').focus();
            event.preventDefault();
        }
    });

    /*
     * when pressing 'enter' inside type, jump to sealnumber input
     */
    $('#jobcontainerform-type_id').keypress(function (event)
    {
        if (event.which == 13) {
            $('#jobcontainerform-sealnumber').focus();
            event.preventDefault();
        }
    });

    /*
     * when pressing 'enter' inside sealnumber, jump to stuffingdate input
     */
    $('#jobcontainerform-sealnumber').keypress(function (event)
    {
        if (event.which == 13) {
            $('#jobcontainerform-stuffingdate').focus();
            event.preventDefault();
        }
    });

    $('#jobcontainerform-stuffingdate').keypress(function (event)
    {
        if (event.which == 13) {
            $(this).blur();
            containerdepo_id = $('#jobcontainerform-containerdepo_id').val();

            if (containerdepo_id) {
                $('#jobcontainerform-containerdepo_id').trigger('select2:close');
            } else {
                $('#jobcontainerform-containerdepo_id').select2('open');
            }

            event.preventDefault();
        }
    });

    /*
     * behavior when selecting supervisor
     */
    $('#jobcontainerform-supervisor_id').on('select2:close', function (event)
    {
        spv = $(this).val();

        if (spv && isNaN(spv)) {
            /*
             * if new supervisor, show supervisor block
             * start by focusing spv phone
             */
            $('#input-spvdetail').show({
                effect: 'blind',
                complete: function ()
                {
                    $('#jobcontainerform-supervisorphone').focus();
                }
            });
        } else {
            /*
             * else, close spv block
             */
            $('#input-spvdetail').hide({
                effect: 'blind'
            });
        }
    });

    /*
     * when pressing enter inside spv phone, jump & open trucking selection
     */
    $('#jobcontainerform-supervisorphone').keypress(function (event)
    {
        if (event.which == 13) {
            truckvendor_id = $('#jobcontainerform-truckvendor_id').val();

            if (truckvendor_id) {
                $('#jobcontainerform-truckvendor_id').trigger('select2:close');
            } else {
                $('#jobcontainerform-truckvendor_id').select2('open');
            }

            event.preventDefault();
        }
    });

    /*
     * when pressing 'enter' inside drivername, jump to cellphone input
     */
    $('#jobcontainerform-drivername').keypress(function (event)
    {
        if (event.which == 13) {
            $('#jobcontainerform-cellphone').focus();
            event.preventDefault();
        }
    });

    /*
     * when pressing 'enter' inside cellphone, jump to policenumber input
     */
    $('#jobcontainerform-cellphone').keypress(function (event)
    {
        if (event.which == 13) {
            $('#jobcontainerform-policenumber').focus();
            event.preventDefault();
        }
    });

    /*
     * when pressing 'enter' inside policenumber, jump to notes input
     */
    $('#jobcontainerform-policenumber').keypress(function (event)
    {
        if (event.which == 13) {
            $('#jobcontainerform-notes').focus();
            event.preventDefault();
        }
    });

    // first trigger

    $('#input-spvdetail').hide();
    $('#input-shipperdetail').hide();
    $('#jobcontainerform-deliveryorder').focus();

});
