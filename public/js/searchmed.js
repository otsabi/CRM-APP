$(document).ready(function(){

    $('#med').select2({
        language: {
            // You can find all of the options in the language files provided in the
            // build. They all must be functions that return the string that should be
            // displayed.
            inputTooShort: function () {
                return "Veuillez entrer 4 caractères ou plus pour lancer la recherche";
            },
            noResults:function(){
                return"Aucun résultat trouvé";
            },
            searching:function(){
                return"Recherche en cours…";
            }
        },
        placeholder: 'Rechercher un médecin',
        closeOnSelect:true,
        minimumInputLength:4,
        ajax: {
            url: '/searchmedecins',
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

    function formatMed(docteur) {
        if(!docteur.id){
            return docteur.text;
        }

        var container = $(
            "<p class='h6'>"+docteur.mednom +"&nbsp;"+ docteur.medprenom + "</p>" +
            "<small class='text-uppercase text-muted'>"+
            docteur.medspec + "&nbsp;" +
            docteur.etat + "&nbsp;" +
            docteur.ville +  "&nbsp;" +
            docteur.zone + "</small>");

        return container;
    }

    function formatSelection(docteur){
        if(docteur.id === ""){
            return 'Rechercher un médecin';
        }
        return docteur.mednom + " " + docteur.medprenom + " " + docteur.medspec;
    }

    
});

