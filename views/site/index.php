<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

app\assets\SliderAsset::register($this);

$this->title = Yii::$app->name;
?>

<div class="site-index">

    <div class="jumbotron">

        <div class="callbacks_container">
            <?=
            Html::ul(
                [
                Html::img('@web/jasco/slide/slide001a.jpg'),
                Html::img('@web/jasco/slide/slide002a.jpg'),
                Html::img('@web/jasco/slide/slide003a.jpg'),
                Html::img('@web/jasco/slide/slide004a.jpg'),
                Html::img('@web/jasco/slide/slide005a.jpg'),
                ]
                ,
                [
                'class' => "rslides",
                'id' => "slider",
                'encode' => false,
                ]
            );
            ?>
        </div>

    </div>

    <div class="content">

        <div class="row">

            <div class="col-md-9">
                <h1>
                    PT. Jasco Logistics
                </h1>


                <div style="text-align: justify; font-size: 14px;">
                    <strong>JASCO LOGISTICS</strong>
                    has been offering first-class transport and logistics solutions for more than 10 years.
                    We building a strong global network and ensuring close customer relationships and market focus.
                    <br/>
                    <br/>
                    Jasco has full Indonesia Freight Forwarding licensed,
                    and we are managed by the solid management team which consists of capable personnel,
                    who have extensive, and experience in the freight forwarding industry,
                    so we can offer quick and flexible transport solutions tailored to meet your needs for all types of goods.
                    <br/>
                    <br/>
                    JASCO LOGISTICS has office at major cities in Indonesia,
                    such as : SEMARANG (covering Yogya, Solo, Jepara), JAKARTA and SURABAYA.
                    <br/>
                    <br/>
                    Our full range of transportation and logistics services include air and ocean freight,
                    domestic distribution, warehousing, trucking,
                    as well as quality insurance to protect your goods.
                    &nbsp;
                </div>

                <div style="text-align: center;">
                    <?= Html::img('@web/jasco/images/we-deliver-all-your-shipments-around-the-world.jpg'); ?>
                </div>

                <div style="text-align: center;">
                    <?= Html::img('@web/jasco/images/wo.png'); ?>
                </div>

                <div style="text-align: center;">
                    <?= Html::img('@web/jasco/images/save-delivery.jpg'); ?>
                </div>

            </div>

            <div class="col-md-3">
                <div class="box box-primary box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            SEMARANG - HEAD OFFICE
                        </h3>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        Perkantoran Mutiara Marina No. 5<br/>
                        Jl. Marina – Semarang 50144<br/>
                        T. +62 24 761 4495 (HUNTING)<br/>
                        F. +62 24 761 2095 / 97<br/>
                        Email : info@jasco-logistics.com
                    </div>
                    <!-- /.box-body -->
                </div>
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            JAKARTA
                        </h3>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" style="display: block;">
                        Jl. Kebon Bawang No 16 A<br/>
                        (D/h : Jalan Fort Barat)<br/>
                        Tanjung Priok, Jakarta Utara 14320<br/>
                        T. +62 21 4374 345<br/>
                        F. +62 21 4390 9840<br/>
                        Mobile : 0815 9212 090, 0877 7001 1043<br/>
                        Email   : maman.jkt@jasco-logistics.com
                    </div>
                    <!-- /.box-body -->
                </div>
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            SOLO
                        </h3>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" style="display: block;">
                        Griya Batas Kota No. 10<br/>
                        Makamhaji, Solo, 57137 <br/>
                        T/F. +62 271 711 918<br/>
                        Email : enia.slo@jasco-logistics.com
                    </div>
                    <!-- /.box-body -->
                </div>
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            YOGYAKARTA
                        </h3>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" style="display: block;">
                        Jl Ring Road Utara No 39<br/>
                        Maguwoharjo, Depok, Sleman 55282<br/>
                        T/F. +62 274 4333 642<br/>
                        Email : miko.slo@jasco-logistics.com

                    </div>
                    <!-- /.box-body -->
                </div>
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            JEPARA
                        </h3>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" style="display: block;">
                        JL. Raya Soekarno - Hatta KM 5.5 Tahunan<br/>
                        Jepara, Jawa Tengah <br/>
                        T/F. +62 291 597 761<br/>
                        Email : feric.jpr@jasco-logistics.com
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>

        </div>

    </div>
</div>

<?php
$js = <<<JS

	$(function () {

      $("#slider").responsiveSlides({
        auto: true,
        pager: false,
        nav: true,
        speed: 100,
        namespace: "callbacks",
        before: function () {
          $('.events').append("<li>before event fired.</li>");
        },
        after: function () {
          $('.events').append("<li>after event fired.</li>");
        }
      });

	});

JS;

$this->registerJs($js, \yii\web\View::POS_READY);

