<div class="row">
	<div class="col-lg-4 col-md-8">
	    <div class="panel info-box panel-white">
	        <div class="panel-body">
	            <div class="info-box-stats">
	                <p class="counter"><?= $allpasien->jumlah_pasien; ?></p>
	                <span class="info-box-title">Data pasien yang terdaftar</span>
	            </div>
	            <div class="info-box-icon">
	                <i class="icon-users"></i>
	            </div>
	        </div>
	    </div>
	</div>
	<div class="col-lg-4 col-md-8">
	    <div class="panel info-box panel-white">
	        <div class="panel-body">
	            <div class="info-box-stats">
	                <p>Rp.&nbsp;<span class="counter"><?= number_format($pendapatan_perhari->total_perhari); ?></span></p>
	                <span class="info-box-title">Total Pendapatan Perhari</span>
	            </div>
	            <div class="info-box-icon">
	                <i class="icon-wallet"></i>
	            </div>
	        </div>
	    </div>
	</div>
	<div class="col-lg-4 col-md-8">
	    <div class="panel info-box panel-white">
	        <div class="panel-body">
	            <div class="info-box-stats">
	                <p>Rp.&nbsp;<span class="counter"><?= number_format($pendapatan_all->total); ?></span></p>
	                <span class="info-box-title">Total Seluruh Pendapatan</span>
	            </div>
	            <div class="info-box-icon">
	                <i class="icon-credit-card"></i>
	            </div>
	        </div>
	    </div>
	</div>
</div>

<div class="row">
    <div class="col-lg-9 col-md-12">
        <div class="panel panel-white">
            <div class="row">
                <div class="col-sm-7">
                    <div class="visitors-chart">
                        <div class="panel-heading">
                            <h3 class="panel-title">Grafik Status Kunjungan Pasien</h3>
                        </div>
                        <div class="panel-body">
                            <div>
                                <div id="pasien_lama_chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="stats-info">
                        <div class="panel-heading">
                            <h4 class="panel-title">Data User Login</h4>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled">
                                <table class="table table-condensed table-striped table-hover" id="table_login">
				                    <thead>
				                        <tr class="success">
				                            <th>No</th>
				                            <th>Nama</th>
				                        </tr>
				                    </thead>

				                    <tbody>

				                    </tbody>
				                </table>
				                <!-- <div class="pages_summary pull-left" id="s_summary"></div><br><br> -->
								<!-- <div id="s_pagination" class="pull-right"></div> -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-white" style="height: 100%;">
            <div class="panel-heading">
                <h4 class="panel-title">Server Load</h4>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Expand/Collapse" class="panel-collapse"><i class="icon-arrow-down"></i></a>
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Reload" class="panel-reload"><i class="icon-reload"></i></a>
                </div>
            </div>
            <div class="panel-body">

                <div class="server-load">
                	<?php 
                		list($mem_total, $mem_used) = shapeSpace_memory_usage();
                	?>
                	<div class="server-stat">
                        <span>Used Memory</span>
                        <p><?= $mem_used; ?></p>
                    </div>
				</div>	
            	<div id="flotchart2"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var flot2 = function () {

        // We use an inline data source in the example, usually data would
        // be fetched from a server

        var data = [],
            totalPoints = 100;
        
        function getRandomData() {

            if (data.length > 0)
                data = data.slice(1);

            // Do a random walk

            while (data.length < totalPoints) {

                var prev = data.length > 0 ? data[data.length - 1] : 50,
                    y = prev + Math.random() * 10 - 5;

                if (y < 0) {
                    y = 0;
                } else if (y > 100) {
                    y = 100;
                }

                data.push(y);
            }

            // Zip the generated y values with the x values

            var res = [];
            for (var i = 0; i < data.length; ++i) {
                res.push([i, data[i]])
            }

            return res;
        }

        var plot2 = $.plot("#flotchart2", [ getRandomData() ], {
            series: {
                shadowSize: 0   // Drawing is faster without shadows
            },
            yaxis: {
                min: 0,
                max: 100
            },
            xaxis: {
                show: false
            },
            colors: ["#22BAA0"],
            legend: {
                show: false
            },
            grid: {
                color: "#AFAFAF",
                hoverable: true,
                borderWidth: 0,
                backgroundColor: '#FFF'
            },
            tooltip: true,
            tooltipOpts: {
                content: "Y: %y",
                defaultTheme: false
            }
        });

        function update() {
            plot2.setData([getRandomData()]);

            plot2.draw();
            setTimeout(update, 30);
        }

        update();
        
        };

        flot2();

        $('.counter').counterUp({
            delay: 10,
            time: 1000
        });

        reload_graph();

        get_list_data_session(1, '');

    });

    function paging(p) {
        get_list_data_session(p);
    }

    function get_list_data_session(p) {
        $.ajax({
            type : 'GET',
            url : '<?= base_url('api/sistem/list_data_session/page/'); ?>'+p,
            cache : false,
            dataType : 'json',
            success: function(data) {
                if ((p > 1) & (data.data.length === 0)) {
                    get_list_data_session(p - 1);
                    return false;
                };

                $('#s_pagination').html(pagination(data.jumlah, data.limit, data.page, 2));
                $('#s_summary').html(page_summary(data.jumlah, data.data.length, data.limit, data.page));

                $('#table_login tbody').empty();

                var str = '';
                $.each(data.data, function(i, v) {
                    
                    str = '<tr>'+
                            '<td align="center">'+((i+1) + ((data.page - 1) * data.limit))+'</td>'+
                            '<td>'+v.nama+' <i>has been logged in for '+ timeago.format(v.tanggal_login);  +'</i></td>'+
                          '</tr>';
                    $('#table_login tbody').append(str);
                });
                hide_ajax_loading();
            },
            error: function(e){
                access_failed(e.status);
                hide_ajax_loading();
            }
        });
    }

    function reload_graph() {
        get_data_series('home/dashboard_data_pasien_lama_baru','pasienlamabaru')
    }

    function get_data_series(url, chart) {
        show_ajax_loading();
        $.ajax({
            url: '<?= base_url("'+url+'"); ?>',
            dataType: 'json',
            success: function(data) {
                if(chart === 'pasienlamabaru'){
                    draw_spline_chart('#pasien_lama_chart',data);
                }
                hide_ajax_loading();
            }
        });
    }

    function draw_spline_chart(div, data) {
        $(div).highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            exporting: {
                enabled: false
            },
            xAxis: {
                categories: data.tanggal
            },
            yAxis:{
                title: {
                    text: 'Jumlah'
                }
            },
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '{point.y} pasien'
            },
            series: data.data
        });

    }
</script>

