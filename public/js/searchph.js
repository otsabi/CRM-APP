$(document).ready(function(){

    $('#pharma').select2({
        language: {
            // You can find all of the options in the language files provided in the
            // build. They all must be functions that return the string that should be
            // displayed.
            inputTooShort: function () {
                return "Veuillez entrer 4 caractères ou plus pour lancer la recherche";
            },
            noResults:function(){
                return "Aucun résultat trouvé";
            },
            searching:function(){
                return "Recherche en cours…";
            }
        },
        placeholder: 'Rechercher une pharmacie',
        closeOnSelect:true,
        minimumInputLength:4,
        ajax: {
            url: '/searchpharma',
            dataType: 'json',
            delay: 600,
            processResults: function (data) {
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: data
                };
            }
        },
        allowClear:true,
        templateResult:formatMed,
        templateSelection:formatSelection
    });

    function formatMed(pharma) {
        if(!pharma.id){
            return pharma.text;
        }

        var container = $(
            "<p class='h6'>"+ pharma.pharma_name + "</p>" +
            "<small class='text-uppercase text-muted'>"+
            pharma.zone + "&nbsp;" +
            pharma.ville  + "</small>");

        return container;
    }

    function formatSelection(pharma){
        if(pharma.id === ""){
            return 'Rechercher une pharmacie';
        }
        return pharma.pharma_name + " - " + pharma.zone;
    }
});

