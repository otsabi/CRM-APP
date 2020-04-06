$(document).ready(function(){
    google.charts.load('current', {'packages':['corechart']});

    google.charts.setOnLoadCallback(drawVisitesByDelegueChart);
    google.charts.setOnLoadCallback(drawVisitesBySpecChart);
    google.charts.setOnLoadCallback(drawVisitesByVilleChart);

    $('#secteur-filter,#spec-filter').on('change',function(){
        drawVisitesBySpecChart();
    });

    $('#delegue-filter').on('change',function(){
        drawVisitesByDelegueChart();
    });

    $('#villes-filter').on('change',function(){
        drawVisitesByVilleChart();
    });

    function drawVisitesByDelegueChart() {
        var secteur = $('#delegue-filter option:selected').val();
        var jsonData = $.ajax({
            url: "/admin/dash/visites/delegues",
            dataType: "json",
            data:{q:secteur},
            async: false
        }).responseJSON;

        var data = new google.visualization.DataTable();
        data.addColumn('string','Délégue');
        data.addColumn('number','Nbr visites');

        jsonData.forEach(function(element){
            data.addRow([element.nom+' '+element.prenom,element.visite_medicales_count]);
        });

        var options = {
            height: 300,
            vAxis:{
                title: 'Nombre visites'
            },
            chartArea:{
                width:'85%'
            },
            pieHole: 0.4
        };

        var chart = new google.visualization.PieChart(document.getElementById('columnChart'));

        chart.draw(data, options);
    }


    function drawVisitesBySpecChart() {
        var secteur = $('#secteur-filter option:selected').val();
        var spec = $('#spec-filter option:selected').val();

        var jsonData = $.ajax({
            url: "/admin/dash/visites/specialities",
            dataType: "json",
            data:'sect='+secteur+'&spec='+spec,
            async: false
        }).responseJSON;

        var data = new google.visualization.DataTable();
        data.addColumn('string','Délégue');
        data.addColumn('number','Nbr visites');
        data.addColumn({type:'string',role: 'style' });

        jsonData.forEach(function(element){
            data.addRow([element.nom+' '+element.prenom,element.visite_medicales_count,'color:#6E9887']);
        });

        var options = {
            height: 300,
            legend: 'none',
            vAxis:{
                title:'Nombre visites'
            },
            isStacked:true
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('stackedChart'));
        chart.draw(data, options);
    }

    function drawVisitesByVilleChart() {
        var secteur = $('#villes-filter option:selected').val();

        var jsonData = $.ajax({
            url: "/admin/dash/visites/villes",
            dataType: "json",
            data:{q:secteur},
            async: false
        }).responseJSON;

        var data = new google.visualization.DataTable();
        data.addColumn('string','Délégue');
        data.addColumn('number','Nbr visites');
        data.addColumn({type:'string',role: 'style' });

        jsonData.forEach(function(element){
            data.addRow([element.nom+' '+element.prenom,element.visite_medicales_count,'color:#458EB1']);
        });

        var options = {
            height: 300,
            legend: 'none',
            vAxis:{
                title:'Nombre visites'
            },
            isStacked:true
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('villesColumnChart'));
        chart.draw(data, options);
    }

});
