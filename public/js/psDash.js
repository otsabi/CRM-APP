$(document).ready(function(){
    google.charts.load('current', {'packages':['corechart']});

    google.charts.setOnLoadCallback(drawVisitesBySpecialiteChart);

    google.charts.setOnLoadCallback(drawVisitesByCityChart);


    $('#spec-filter').on('change',function () {
            var timeRange = $(this).val();
            drawVisitesBySpecialiteChart(timeRange);
    });

    $('#ville-filter').on('change',function () {
        var timeRange = $(this).val();
        drawVisitesByCityChart(timeRange);
    });

    function drawVisitesBySpecialiteChart(filter) {

        var jsonData = $.ajax({
            url: "dash/visites/specialites",
            data:{timeRange: filter},
            dataType: "json",
            async: false
        }).responseJSON;

        var data = new google.visualization.DataTable();
        data.addColumn('string','Specialité');
        data.addColumn('number','Nbr visites');

        jsonData.forEach(function(element){
            data.addRow([element.code,element.nombreVisites]);
        });

        var options = {
            height: 220,
            legend:{
                position:'left',
            },
            chartArea:{width:'80%',height:'100%'}
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }

    function drawVisitesByCityChart(filter){

        var jsonData = $.ajax({
            url:'dash/visites/ville',
            dataType: "json",
            data:{timeRange: filter},
            async: false
        }).responseJSON;

        var data = new google.visualization.DataTable();
        data.addColumn('string','Ville');
        data.addColumn('number','Nbr visites');
        data.addColumn({type:'number',role: 'annotation' });
        jsonData.forEach(function(element){
            data.addRow([element.libelle,element.nombreVisites,element.nombreVisites]);
        });

        var options = {
            height: 220,
            vAxis:{
                title: 'Nombre visites'
            },
            hAxis:{
                title: 'Villes'
            },
            legend:{
                position:'left',
            },
            chartArea:{width:'80%',height:'80%'}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('barchart'));

        chart.draw(data, options);
    }

});
