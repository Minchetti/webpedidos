  $(function () {

    function convertMes(numero){
      if(numero == 12 || numero == 0)
      return 'Dezembro';

      if(numero == 11 || numero == -1)
      return 'Novembro';
      
      if(numero == 10 || numero == -2)
      return 'Outubro';
      
      if(numero == 9 || numero == -3)
      return 'Setembro';
    
      if(numero == 8 || numero == -4)
      return 'Agosto';
      
      if(numero == 7 || numero == -5)
      return 'Julho';
      
      if(numero == 6)
      return 'Junho';
      
      if(numero == 5)
      return 'Maio';
      
      if(numero == 4)
      return 'Abril';

      if(numero == 3)
      return 'Março';
      
      if(numero == 2)
      return 'Fevereiro';
      
      if(numero == 1)
      return 'Janeiro';
    }

    var data = new Date;
    var mesAtual = data.getMonth() + 1;
    var anoAtual = data.getYear() + 1900;
       
    var localizar = new Requisicao();
    var pedidos = [];

    if(mesAtual == 5){
      pedidos[0] = localizar.contarRequisicoes( 5, anoAtual );
      pedidos[1] = localizar.contarRequisicoes( 4, anoAtual );      
      pedidos[2] = localizar.contarRequisicoes( 3, anoAtual );
      pedidos[3] = localizar.contarRequisicoes( 2, anoAtual );
      pedidos[4] = localizar.contarRequisicoes( 1, anoAtual );      
      pedidos[5] = localizar.contarRequisicoes( 12, anoAtual-1 );  
    }
    else if(mesAtual == 4){
      pedidos[0] = localizar.contarRequisicoes( 4, anoAtual );
      pedidos[1] = localizar.contarRequisicoes( 3, anoAtual );      
      pedidos[2] = localizar.contarRequisicoes( 2, anoAtual );
      pedidos[3] = localizar.contarRequisicoes( 1, anoAtual );
      pedidos[4] = localizar.contarRequisicoes( 12, anoAtual-1 );      
      pedidos[5] = localizar.contarRequisicoes( 11, anoAtual-1 );
    }
    else if(mesAtual == 3){
      pedidos[0] = localizar.contarRequisicoes( 3, anoAtual );
      pedidos[1] = localizar.contarRequisicoes( 2, anoAtual );      
      pedidos[2] = localizar.contarRequisicoes( 1, anoAtual );
      pedidos[3] = localizar.contarRequisicoes( 12, anoAtual-1 );
      pedidos[4] = localizar.contarRequisicoes( 11, anoAtual-1 );      
      pedidos[5] = localizar.contarRequisicoes( 10, anoAtual-1 );
    }
    else if(mesAtual == 2){
      pedidos[0] = localizar.contarRequisicoes( 2, anoAtual );
      pedidos[1] = localizar.contarRequisicoes( 1, anoAtual );      
      pedidos[2] = localizar.contarRequisicoes( 12, anoAtual-1 );
      pedidos[3] = localizar.contarRequisicoes( 11, anoAtual-1 );
      pedidos[4] = localizar.contarRequisicoes( 10, anoAtual-1 );      
      pedidos[5] = localizar.contarRequisicoes( 9, anoAtual-1 );
    }
    else if(mesAtual == 1){
      pedidos[0] = localizar.contarRequisicoes( 1, anoAtual );
      pedidos[1] = localizar.contarRequisicoes( 12, anoAtual-1 );      
      pedidos[2] = localizar.contarRequisicoes( 11, anoAtual-1 );
      pedidos[3] = localizar.contarRequisicoes( 10, anoAtual-1 );
      pedidos[4] = localizar.contarRequisicoes( 9, anoAtual-1 );      
      pedidos[5] = localizar.contarRequisicoes( 8, anoAtual-1 );
    }
    else{
      pedidos[0] = localizar.contarRequisicoes( mesAtual, anoAtual );
      pedidos[1] = localizar.contarRequisicoes( mesAtual-1, anoAtual );      
      pedidos[2] = localizar.contarRequisicoes( mesAtual-2, anoAtual );
      pedidos[3] = localizar.contarRequisicoes( mesAtual-3, anoAtual );
      pedidos[4] = localizar.contarRequisicoes( mesAtual-4, anoAtual );      
      pedidos[5] = localizar.contarRequisicoes( mesAtual-5, anoAtual );
    }

    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);


      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          [        'Mês',                    'Requisições Feitas',   'Requisições Recebidas' ],
          [ convertMes(mesAtual - 5),          pedidos[5].feito,       pedidos[5].recebido   ],
          [ convertMes(mesAtual - 4),          pedidos[4].feito,       pedidos[4].recebido   ],
          [ convertMes(mesAtual - 3),          pedidos[3].feito,       pedidos[3].recebido   ],
          [ convertMes(mesAtual - 2),          pedidos[2].feito,       pedidos[2].recebido   ],
          [ convertMes(mesAtual - 1),          pedidos[1].feito,       pedidos[1].recebido   ],
          [ convertMes(mesAtual),              pedidos[0].feito,       pedidos[0].recebido   ]
        ]);

        var options = {
          // title: 'Company Performance',
        //   curveType: 'function',
          legend: { position: 'bottom' },
          vAxis: {
            title: 'Requisições'
          }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
     
  })
  