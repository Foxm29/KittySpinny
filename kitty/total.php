<!DOCTYPE html>
<html>
<head>

<title>Creating Dynamic Data Graph using PHP and Chart.js</title>
<link rel="stylesheet" href="./CSS/main.css">

<script type="text/javascript" src="js/moment.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@0.7.4"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-zoom/0.6.6/chartjs-plugin-zoom.min.js"></script>



</head>


<body>

        <div id="mynav" class="nav">
            <ul>
                <li><a   href="./week.php">This week</a></li>
                <li><a href="./year.php">This year</a></li>
                <li><a class="active" href="./total.php">Total</a></li>
                <li><a href="#about">About</a></li>
              </ul> 
              </div>
    <div class="main" id ="main">
        

    
         <div id=distance> </div>
         <div id=time> </div>
         <div id=speed> </div>
      
         

         <div class="chartWrapper">
            <div class="chartAreaWrapper">
                 <canvas id="graphCanvas"></canvas>
            </div>
        </div>         


   
    <script>

        function umrechnungAusgeben(sekundenwert) {
				

				// Hier Ihren Code einfügen
				var startwert = sekundenwert;
				var sekunden = sekundenwert % 60;
				sekundenwert -= sekunden;
				var jahre = Math.floor(sekundenwert / (60*60*24*365));
				sekundenwert -= jahre*60*60*24*365;
				var tage = Math.floor(sekundenwert / (60*60*24));
				sekundenwert -= tage*60*60*24;
				var stunden = Math.floor(sekundenwert / (60*60));
				sekundenwert -= stunden*60*60;
				var minuten = Math.floor(sekundenwert / 60);
				var returnstring = "";
				returnstring = ""+ 
				      jahre + " years, " +
					  tage + " days, " +
					  stunden + " hours, " +
					  minuten + " minutes, " +
					  sekunden + " seconds."
					  ;
                return returnstring;
			}

        $(document).ready(function () {
            showGraph();
        });


        function showGraph()
        {
            {
                $.post("data_total.php",
                function (data)
                {
                    
                     var name = [];
					
                    var speed = [];
                    var distance = [];
                    var time = [];
                    var totaldistance = 0;
                    var avgspeed = 0;
                    var date1;
                    var date2;
                    var currentdate;
                    var t;
                    var totaltime = 0;
                    var now = moment();


                    for (var i in data) {

                        
                        
                       
                            
                            //time in seconds
                        t = data[i].time;
                        
                        totaltime = totaltime + t*1;
                        
						
                        var d = data[i].revolutions*1.22*3.141;
						
                        distance.push(d);
                        time.push(t);
                        name.push(data[i].year);
                        
                        
                        

                        
                        totaldistance = totaldistance + (d);
                    
                        
                        
                        

                    }
                    totaldistance = Math.floor(totaldistance*100)/100;
                    avgspeed = Math.floor(totaldistance/totaltime*100)/100;
                    document.getElementById('distance').innerHTML ="<p>Total distance: " + totaldistance.toLocaleString('en-GB') +" Meter </p>";
                    document.getElementById('time').innerHTML ="<p>Total time: " + umrechnungAusgeben(totaltime) + "</p>";
                    document.getElementById('speed').innerHTML ="<p>Average Speed: " + avgspeed + " m/s</p>";
                    

                    var chartdata = {
                        labels: name,
                        datasets: [
                        {
                                label: 'Time  [s]',
                                backgroundColor: '#FF0000',
                                borderColor: '#FF0000',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: time,
                                yAxisID: 'right-y-axis',
								
								
								
                            },
							{
                                label: 'Distance  [m]',
                                backgroundColor: '#FFD700',
                                borderColor: '#FFD700',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: distance,
                                yAxisID: 'left-y-axis',
								
								
                            },
                            
                            
                            
                        ]
                    };

                    var barGraph = $("#graphCanvas");
                    var rectangleSet = false;
                    var barGraph = new Chart(barGraph, {
                        type: 'bar',
                        data: chartdata,
                        
						options: {
                            responsive: true,
                            showTooltips: true,
                            title: {
                                display: true,
                                text: 'This Week'
                            },
                            
                            
                            
    
                            
							
							scales: {
								
							xAxes: [{
                                gridLines: {
                                    display:false
                                },
								offset: true,
								distribution: 'series',
								
                               
                                
                               
                                categoryPercentage: 0.5,
                                barPercentage: 1.0,

								ticks:{
                                    beginAtZero: true,
									source: 'labels',
                                    
									},
                                    time: {
                                        
                                        unit: 'day',
                                        tooltipFormat:'lll',
                                        unitStepSize: 1,
                                        displayFormats: {
                                            'millisecond':'lll',
                                            'second': 'lll',
                                            'minute': 'lll',
                                            'hour': 'lll',
                                            'day': 'lll',
                                            'week': 'lll',
                                            'month': 'lll',
                                            'quarter': 'lll',
                                            'year': 'lll',
                                          
                                        }
                                    },
                                
                                scaleLabel: {
                                    display: true,
                                     fontSize: 14,
                                     labelString: 'Date',
                                     
                                     }
							}],
							yAxes: [{
								id: 'left-y-axis',
                                gridLines: {
                                    display:false
                                },
								distribution: 'series',
								position: 'left',
                                offset: true,
								display: true, // Hopefully don't have to explain this one.
                                scaleLabel: {
                                    display: true,
                                     fontSize: 14,
                                     labelString: 'Distance',
                                     
                                     },
                                     ticks: {
                                        beginAtZero: true
                                    },
               
								
								
								},
                                {
                                    gridLines: {
                                    display:false
                                },
								id: 'right-y-axis',
								distribution: 'series',
								position: 'right',
                                offset: true,
								display: true, // Hopefully don't have to explain this one.
                                scaleLabel: {
                                    display: true,
                                     fontSize: 14,
                                     labelString: 'Time',
                                     
                                     },
                                     ticks: {
                                        beginAtZero: true
                                    },
               
								
								
								}
                                
                                
                                
                                
                                
                                
                                ]
							
							
                            },
                            }
                    });
                });
            }
        }
        </script>

</body>
</html>