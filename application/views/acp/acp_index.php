        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Dashboard <small>Statistics Overview</small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-twitch">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-twitch fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo number_format($community['name']); ?></div>
                                        <div>Total Channel</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-eye fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo number_format($community['views']); ?></div>
                                        <div>Total Views</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-heart fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo number_format($community['followers']); ?></div>
                                        <div>Total Followers</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-server fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $load; ?></div>
                                        <div>Server Load</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i>Statistics</h3>
                            </div>
                            <div class="panel-body">
                                <!-- Top Streamed Games -->
                                <div class="col-lg-4 col-md-6">
                                <table id="topgames" class="table table-striped table-bordered">
                                        <caption class="text-center">Top Streamed Games</caption>
                                        <thead>
                                          <tr>
                                            <th>Game</th>
                                            <th>Count</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                              <?php foreach ($gametop as $top_item): ?>
                                                 <tr>
                                                   <td><a><?php echo ucfirst($top_item['game']); ?></a></td>
                                                   <td><a><?php echo number_format($top_item['count']); ?></a></td>
                                                 </tr>
                                             <?php endforeach; ?>   

                                              </tbody>
                                      </table>
                                </div>
                                 <!-- Top Streamed Games -->
                                 <!-- Top Videos 
                                <div class="col-lg-4 col-md-6">
                                <table id="topgames" class="table table-striped table-bordered">
                                        <caption class="text-center">Top Streamed Games</caption>
                                        <thead>
                                          <tr>
                                            <th>Channel</th>
                                            <th>Number of videos</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                              <?php foreach ($videostop as $top_item): ?>
                                                 <tr>
                                                   <td><a><?php echo ucfirst($top_item['name']); ?></a></td>
                                                   <td><a><?php echo number_format($top_item['videos']); ?></a></td>
                                                 </tr>
                                             <?php endforeach; ?>   

                                              </tbody>
                                      </table>
                                </div>
                              <!-- Top Videos -->
                              <!-- Top Partners -->
                                <div class="col-lg-4 col-md-6">
                                <table id="topgames" class="table table-striped table-bordered">
                                        <caption class="text-center">Top Twitch Partners</caption>
                                        <thead>
                                          <tr>
                                            <th>Channel</th>
                                            <th>Subscribers</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                              <?php foreach ($partnertop as $top_item): ?>
                                                 <tr>
                                                   <td><a><?php echo ucfirst($top_item['name']); ?></a></td>
                                                   <td><a><?php echo number_format($top_item['followers']); ?></a></td>
                                                 </tr>
                                             <?php endforeach; ?>   

                                         </tbody>
                                      </table>
                                </div>
                              <!-- Top Partners -->
                              <!-- Daily Activity -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="panel panel-default col-lg-12" style="padding:0">
                                        <div class="panel-heading">Online Channels by Day</div>
                                    <div id="daily_fetch" style="height: 500px;"></div>
                                    <script>
                                         new Morris.Line({
                                          // ID of the element in which to draw the chart.
                                          element: 'daily_fetch',
                                          // Chart data records -- each entry in this array corresponds to a point on
                                          // the chart.
                                          data: [
                                          <?php foreach ($daily_updates as $top_item): ?>
                                            { date: '<?php echo $top_item['year'];?>-<?php echo $top_item['month'];?>-<?php echo $top_item['day'];?>',value : <?php echo number_format($top_item['count']); ?>},
                                          <?php endforeach; ?>  
                                          ],
                                          // The name of the data record attribute that contains x-values.
                                          xkey: 'date',
                                          xlabels: ['day'],
                                          // A list of names of data record attributes that contain y-values.
                                          ykeys: ['value'],
                                          // Labels for the ykeys -- will be displayed when you hover over the
                                          // chart.
                                          labels: ['Online Channels']
                                        });
                                    </script>    
                                </div>
                              </div>
                              <!-- Daily Activity -->
                              
                              
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>