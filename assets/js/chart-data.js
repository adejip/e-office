

window.onload = function(){

    $.getJSON(BASE_URL + "/ajax/hitung_surat_per_tanggal/",function(data){
        surat = [];
        disposisi = [];
        data.surat.forEach(function(item,key){
            surat.push([new Date(item[0]).getTime(),item[1]]);
        });
        data.disposisi.forEach(function(item,key){
            disposisi.push([new Date(item[0]).getTime(),item[1]]);
        });

        console.log(disposisi);
        Highcharts.stockChart("hChartContainer",{
            rangeSelector: {
                selected: 2
            },
            title: {
                text: "Grafik jumlah surat dan disposisi"
            },
            series : [
                {
                    name: "Surat",
                    data: surat,
                    showInNavigator: true
                },
                {
                    name: "Disposisi",
                    data: disposisi,
                    showInNavigator: true
                }
            ]
        });


    });
	
};