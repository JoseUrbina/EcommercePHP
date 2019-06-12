<?php

    // Create instances for each model
    
    try
    {
        $pedido = new Pedidos();
        $producto = new Productos();
        $categoria = new Categorias();
        $reporte = new Reportes();
        $usuario = new Usuarios();

        /*This variable stores the title for each bar*/
        $element_text = ['Todos los pedidos',
                         'Todos los reportes',
                         'Todos los productos',
                         'Todas las categorias',
                         'Todos los usuarios'];

        /* 
            Getting amount for each model with a respective function
            for using them into the code and google charts
        */
        $num_pedidos = $pedido->get_numero_pedidos();
        $num_reportes = $reporte->get_numero_reportes();
        $num_productos = $producto->get_numero_productos();
        $num_categorias = $categoria->get_numero_categorias();
        $num_usuarios = $usuario->get_numero_usuarios();

        /*This variable stores all total values to show*/
        $element_count = [$num_pedidos,
                          $num_reportes,
                          $num_productos,
                          $num_categorias,
                          $num_usuarios];
    }
    catch(Exception $e)
    {
        die("Error: {$e->getMessage()}");
    }  

?>
<!-- /.row -->
<div class="row">

    <div class="col-lg-4 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-shopping-cart fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">
                        <?php
                            echo $num_pedidos;
                            //echo $pedido->get_numero_pedidos();
                        ?>
                        </div>
                        <div>Pedidos!</div>
                    </div>
                </div>
            </div>
            <a href="index.php?pedidos">
                <div class="panel-footer">
                    <span class="pull-left">Ver Detalles</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-support fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">
                        <?php
                            echo $num_productos;
                            //echo $producto->get_numero_productos();
                        ?>
                        </div>
                        <div>Productos!</div>
                    </div>
                </div>
            </div>
            <a href="index.php?productos">
                <div class="panel-footer">
                    <span class="pull-left">Ver Detalles</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-tasks fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">
                        <?php
                            echo $num_categorias;
                        //echo $categoria->get_numero_categorias();
                        ?>
                        </div>
                        <div>Categorias!</div>
                    </div>
                </div>
            </div>
            <a href="index.php?categorias">
                <div class="panel-footer">
                    <span class="pull-left">Ver Detalles</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- GRAFICO GOOGLE CHART-->

<div class="row">
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);

      /*
            [
                [titleX, titleY],
                [titleColumn, value],....
            ]
      */
      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ['Data', 'Registros'],
          <?php

            /*This variable stores the title for each bar*/
            /*$element_text = ['Todos los pedidos',
                             'Todos los reportes',
                             'Todos los productos',
                             'Todas las categorias',
                             'Todos los usuarios'];*/

            /*This variable stores all total values to show*/
            /*$element_count = [$pedido->get_numero_pedidos(),
                              $reporte->get_numero_reportes(),
                              $producto->get_numero_productos(),
                              $categoria->get_numero_categorias(),
                              $usuario->get_numero_usuarios()];*/

            /*Getting titles and values, create array and to show
              them*/
            for($i=0;$i<5;$i++)
            {
                echo "['$element_text[$i]'" . "," 
                     . "$element_count[$i]],";
            }

            /*
                All this code here is the original verison code from video61 (Google charts), but i move out to the beginnig for more security with try...catch,
                and we can use different variable in all the code page
            */
          ?>
        ]);

        /*Variables here, they wre not necesaries*/
        var options = {
          chart: {
            title: '',
            subtitle: '',
          }
        };

        /*div container which will use to show datas*/
        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
        // Convert the Classic options to Material options.
        chart.draw(data, google.charts.Bar.convertOptions(options));
      };
    </script>
  
  <div id="columnchart_material" style="width: auto; height: 500px;"></div>
</div>


<!-- /.row -->

<!-- SECOND ROW WITH TABLES-->

<!-- <div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Transactions Panel</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Order Date</th>
                                <th>Order Time</th>
                                <th>Amount (USD)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>3326</td>
                                <td>10/21/2013</td>
                                <td>3:29 PM</td>
                                <td>$321.33</td>
                            </tr>
                            <tr>
                                <td>3325</td>
                                <td>10/21/2013</td>
                                <td>3:20 PM</td>
                                <td>$234.34</td>
                            </tr>
                            <tr>
                                <td>3324</td>
                                <td>10/21/2013</td>
                                <td>3:03 PM</td>
                                <td>$724.17</td>
                            </tr>
                            <tr>
                                <td>3323</td>
                                <td>10/21/2013</td>
                                <td>3:00 PM</td>
                                <td>$23.71</td>
                            </tr>
                            <tr>
                                <td>3322</td>
                                <td>10/21/2013</td>
                                <td>2:49 PM</td>
                                <td>$8345.23</td>
                            </tr>
                            <tr>
                                <td>3321</td>
                                <td>10/21/2013</td>
                                <td>2:23 PM</td>
                                <td>$245.12</td>
                            </tr>
                            <tr>
                                <td>3320</td>
                                <td>10/21/2013</td>
                                <td>2:15 PM</td>
                                <td>$5663.54</td>
                            </tr>
                            <tr>
                                <td>3319</td>
                                <td>10/21/2013</td>
                                <td>2:13 PM</td>
                                <td>$943.45</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-right">
                    <a href="#">View All Transactions <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>

     <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Transactions Panel</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Order Date</th>
                                <th>Order Time</th>
                                <th>Amount (USD)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>3326</td>
                                <td>10/21/2013</td>
                                <td>3:29 PM</td>
                                <td>$321.33</td>
                            </tr>
                            <tr>
                                <td>3325</td>
                                <td>10/21/2013</td>
                                <td>3:20 PM</td>
                                <td>$234.34</td>
                            </tr>
                            <tr>
                                <td>3324</td>
                                <td>10/21/2013</td>
                                <td>3:03 PM</td>
                                <td>$724.17</td>
                            </tr>
                            <tr>
                                <td>3323</td>
                                <td>10/21/2013</td>
                                <td>3:00 PM</td>
                                <td>$23.71</td>
                            </tr>
                            <tr>
                                <td>3322</td>
                                <td>10/21/2013</td>
                                <td>2:49 PM</td>
                                <td>$8345.23</td>
                            </tr>
                            <tr>
                                <td>3321</td>
                                <td>10/21/2013</td>
                                <td>2:23 PM</td>
                                <td>$245.12</td>
                            </tr>
                            <tr>
                                <td>3320</td>
                                <td>10/21/2013</td>
                                <td>2:15 PM</td>
                                <td>$5663.54</td>
                            </tr>
                            <tr>
                                <td>3319</td>
                                <td>10/21/2013</td>
                                <td>2:13 PM</td>
                                <td>$943.45</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-right">
                    <a href="#">View All Transactions <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div> -->
<!-- /.row -->