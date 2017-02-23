<?php

use dosamigos\chartjs\ChartJs;
use app\models\DailyLog;

$this->title = 'Daily Stuffing';
$this->params['breadcrumbs'][] = 'Chart';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Daily Stuffing Report</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="chart">
                            <!-- Sales Chart Canvas -->

                            <?=
                            ChartJs::widget([
                                'id' => 'salesChart',
                                'type' => 'line',
                                'options' => [
                                    'height' => 200,
                                    'width' => 700
                                ],
                                'data' => [
                                    'labels' => ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
                                    'datasets' =>
                                    [
                                        [
                                            'label' => "This Week",
                                            'backgroundColor' => "rgba(0, 255, 153,0.2)",
                                            'borderColor' => "rgba(0, 255, 153,1)",
                                            'pointBackgroundColor' => "rgba(0, 255, 153,1)",
                                            'pointBorderColor' => "#fff",
                                            'pointHoverBackgroundColor' => "#fff",
                                            'pointHoverBorderColor' => "rgba(0, 255, 153,1)",
                                            'data' => DailyLog::aWeekContainerQty(),
                                        ],
                                        [
                                            'label' => "Last Week",
                                            'backgroundColor' => "rgba(200,200,200,0.2)",
                                            'borderColor' => "rgba(200,200,200,1)",
                                            'pointBackgroundColor' => "rgba(200,200,200,1)",
                                            'pointBorderColor' => "#fff",
                                            'pointHoverBackgroundColor' => "#fff",
                                            'pointHoverBorderColor' => "rgba(200,200,200,1)",
                                            'data' => DailyLog::aWeekContainerQty(-1),
                                        ],
                                    ]
                                ]
                            ]);
                            ?>
                        </div>
                        <!-- /.chart-responsive -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- ./box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
