$(document).ready(function(){
    $('#registration_form_siren').focusout(function(){
        var siren = $('#registration_form_siren').val().replace(/ /g, '');
        $('#registration_form_raisonSociale').val('');
        $('#registration_form_activite').val('');
        $('#registration_form_adresse').val('');
        $('#registration_form_adresseComplement').val('');
        $('#registration_form_codePostal').val('');
        $('#registration_form_ville').val('');
        $.ajax({
            method: 'GET',
            url: "../insee/siren",
            data:{'siren' : siren},
            success: function(data){
                $('#registration_form_raisonSociale').val(data['raisonSociale']);
                $('#registration_form_activite').val(data['activite']);
                if (data['type'] === 'siret') {
                    $('#registration_form_adresse').val(data['adresse']);
                    $('#registration_form_adresseComplement').val(data['complementAdresse']);
                    $('#registration_form_codePostal').val(data['codePostal']);
                    $('#registration_form_ville').val(data['ville']);
                }
            }
        })
    });

    $('#registration_form_internet').change(function() {
        if($('#registration_form_internet').prop('checked')) {
            $('#registration_form_adresse').hide();
            $('#registration_form_adresse').val(null);
            $('label[for="' + $('#registration_form_adresse').attr('id') + '"]').hide();
            $('#registration_form_adresseComplement').hide();
            $('#registration_form_adresseComplement').val(null);
            $('label[for="' + $('#registration_form_adresseComplement').attr('id') + '"]').hide();
            $('#registration_form_codePostal').hide();
            $('#registration_form_codePostal').val(null);
            $('label[for="' + $('#registration_form_codePostal').attr('id') + '"]').hide();
            $('#registration_form_ville').hide();
            $('#registration_form_ville').val(null);
            $('label[for="' + $('#registration_form_ville').attr('id') + '"]').hide();
        } else {
            $('#registration_form_adresse').show();
            $('label[for="' + $('#registration_form_adresse').attr('id') + '"]').show();
            $('#registration_form_adresseComplement').show();
            $('label[for="' + $('#registration_form_adresseComplement').attr('id') + '"]').show();
            $('#registration_form_codePostal').show();
            $('label[for="' + $('#registration_form_codePostal').attr('id') + '"]').show();
            $('#registration_form_ville').show();
            $('label[for="' + $('#registration_form_ville').attr('id') + '"]').show();
        }
    })
})