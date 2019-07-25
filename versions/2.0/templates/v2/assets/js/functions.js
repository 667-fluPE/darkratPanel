
function generateWordMap(gdpData){
    var max = 0,
        min = Number.MAX_VALUE,
        cc,
        startColor = [25, 19, 28],
        endColor = [75, 20, 107],
        colors = { },
        hex;

    //find maximum and minimum values
    for (cc in gdpData)
    {
        if (parseFloat(gdpData[cc]) > max)
        {
            max = parseFloat(gdpData[cc]);
        }
        if (parseFloat(gdpData[cc]) < min)
        {
            min = parseFloat(gdpData[cc]);
        }
    }
    //set colors according to values of GDP
    for (cc in gdpData)
    {
        if (gdpData[cc] > 0)
        {
            colors[cc] = '#';
            for (var i = 0; i<3; i++)
            {
                hex = Math.round(startColor[i]
                    + (endColor[i]
                        - startColor[i])
                    * (gdpData[cc] / (max - min))).toString(16);

                if (hex.length == 1)
                {
                    hex = '0'+hex;
                }
                out = (hex.length == 1 ? '0' : '') + hex;
                //    colors[cc] += out.replace("-","");
                colors[cc] += out;
            }
        }
    }
    //initialize JQVMap
    var currentCalled = false;
    jQuery('#vmap').vectorMap(
    {
        colors: colors,
        hoverOpacity: 0.7,
        hoverColor: false,
        backgroundColor: "transparent",
        showTooltip: true,
        normalizeFunction: 'polynomial',
        onLabelShow: function (event, label, code) {
            if(gdpData[code] == null){
                gdpData[code] = 0;
            }
            label.append("<br>"+gdpData[code]+' Total');
        },
    });
}


function timeDifference(current, previous) {

    var now = new Date(current*1000);
    var previous = new Date(previous*1000),

        secondsPast = (now.getTime() - previous.getTime()) / 1000;
    if(secondsPast < 60){
        return parseInt(secondsPast) + ' Secounds Ago';
    }
    if(secondsPast < 3600){
        return parseInt(secondsPast/60) + ' Minutes Ago';
    }
    if(secondsPast <= 86400){
        return parseInt(secondsPast/3600) + ' Hours Ago';
    }
    if(secondsPast > 86400){
        day = previous.getDate();
        month = previous.toDateString().match(/ [a-zA-Z]*/)[0].replace(" ","");
        year = previous.getFullYear() == now.getFullYear() ? "" :  " "+previous.getFullYear();
        return day + " " + month + year;
    }
}



function generateOsPiChart(selector,lables,values){
    new Chart(document.getElementById(selector), {
        type: 'pie',
        data: {
            labels: lables,
            datasets: [{
                label: "Population (millions)",
                backgroundColor: ["#27293d", "#33354c","#474a63","#5d6079","#757996"],
                data: values
            }]
        }
    });
}
function generateArchitectureStatusLineChart(selector,lables,values){
    var horizontalBarChartData = {
        labels: lables,
        datasets: [{
            backgroundColor: "#27293d",
            data: values
        }]

    };
    var ctx = document.getElementById(selector).getContext("2d");
    ctx.width = 300;
    var myHorizontalBar = new Chart(ctx, {
        type: 'horizontalBar',
        data: horizontalBarChartData,
        options: {
            legend: {
                display: false
            },
            tooltips: {
                enabled: false
            },
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

}
function generateLineChart(selector,lables,values){
    console.log(values[0]);
    console.log(values[1]);
    var horizontalBarChartData = {
        labels: lables,
        datasets: [{
            label: "Admin",
            backgroundColor: "#723ac3",
            data: [values[0]]
        },{
            label: "User",
            backgroundColor: "#864DD9",
            data: [values[1]]
        }]

    };
    var ctx = document.getElementById(selector).getContext("2d");
    ctx.width = 300;
    var myHorizontalBar = new Chart(ctx, {
        type: 'horizontalBar',
        data: horizontalBarChartData,
        options: {
            legend: {
                display: true
            },
            tooltips: {
                enabled: false
            },
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }],
                yAxes: [{
                    display: !1,
                    gridLines: {
                        color: "#eee"
                    }
                }]
            }
        }
    });

}