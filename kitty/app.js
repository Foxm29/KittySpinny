$(document).ready(function(){
  $.ajax({
    url: "http://localhost/kitty/index.php",
    method: "GET",
    success: function(data) {
      console.log(data);
      var player = [];
      var revolutions = [];

      for(var i in data) {
        player.push("Player " + data[i].id);
        revolutions.push(data[i].revolutions);
      }

      var chartdata = {
        labels: player,
        datasets : [
          {
            label: 'Player revolutions',
            backgroundColor: 'rgba(200, 200, 200, 0.75)',
            borderColor: 'rgba(200, 200, 200, 0.75)',
            hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
            hoverBorderColor: 'rgba(200, 200, 200, 1)',
            data: revolutions
          }
        ]
      };

      var ctx = $("#mycanvas");

      var barGraph = new Chart(ctx, {
        type: 'bar',
        data: chartdata
      });
    },
    error: function(data) {
      console.log(data);
    }
  });
});