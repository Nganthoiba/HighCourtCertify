<!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
          </div>

          <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Request</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $viewData->total_request ?></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Total request completed -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Request Completed</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $viewData->completed_request ?></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Requests</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $viewData->pending_request ?></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Total number of applicants -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Applicants</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $viewData->totalApplicants ?></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>            
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Basic Card Example -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Bar Chart</h6>
                    <p>Showing number of requests for certify copy and how many of them has been completed month wise.</p>
                    <label>Select Year: </label>
                    <select onchange="getBarchartInfo(this.value);" id="barchar_year">
                        <?php 
                        $base_year = 2019;
                        $curr_date = (int)date('Y');
                        for($y = $curr_date; $y>=$base_year; $y--){
                            echo "<option>".$y."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="card-body" >
                    <canvas id="barchart"></canvas>
                </div>
              </div>

            </div>

          </div>

        </div>
        <!-- /.container-fluid -->
        <script src="../../root/MDB/charts/chart.js" type="text/javascript"></script>
        <script src="../../root/MDB/charts/chart_functions.js" type="text/javascript"></script>
        
        <script type="text/javascript">
            function getBarchartInfo(year){
                $.ajax({
                    url:"Application/barchartInfo/"+year,
                    success:function(resp){
                        var data = resp.data;
                        var total_request = [];
                        var completed_request = [];
                        var labels = [];
                        for(var i=0; i<data.length; i++){
                            labels[i] = data[i].month;
                            total_request[i] = data[i].total_request;
                            completed_request[i] = data[i].completed_request;
                        }
                        var barchartInfo = {
                            labels: labels,
                            datasets:[
                                {
                                    label: 'No of Applications',
                                    backgroundColor: "#26B99A",
                                    data: total_request
                                },
                                {
                                    label: 'No of Completed Applications',
                                    backgroundColor: "#03586A",
                                    data: completed_request
                                }
                            ]
                        };
                        drawBarChart("barchart",barchartInfo);
                    }
                });
            }
            
            $(document).ready(function(){
                getBarchartInfo(document.getElementById("barchar_year").value);
            });
            
        </script>