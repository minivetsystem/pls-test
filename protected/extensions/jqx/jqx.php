<?php

/**
 * Created by PhpStorm.
 * Date: 23/2/16
 * Time: 6:52 PM
 */
class jqx extends CWidget
{
    /** @var string Path to assets directory published in init() */
    private $assetsDir;

    /** @var array Chosen script settings passed to $.fn.chosen() */

    public $htmlOptions = array();
    public $dimension = array();
    public $chartType = "summary";
    public $source = array();
    public $title = "";
    public $description = "";
    public $difficulties = array();
    public $colorSchema = "scheme08";
    public $settings = array();

    public function init()
    {
        $dir = dirname(__FILE__) . '/assets';
        $this->assetsDir = Yii::app()->assetManager->publish($dir);
        Yii::app()->clientScript->addPackage("jqxcore", array(
            "baseUrl" => $this->assetsDir,
            "js" => array(
                'jqxcore.js',
                'jqxchart.js',
                'jqxdata.js'
            ),
            "css" => array(
                'styles/jqx.base.css'
            ),
            "depends" => array("jquery")
        ));
        Yii::app()->clientScript->registerPackage("jqxcore");
    }

    private function computeOptions() {
        $_default_dimensions = array(
            "min-height" => "500px",
            "width" => "100%",
        );
        $_default_difficulties = array(
            "easy" => array(
                "color" => "#FF0000",
                "opacity" => "0.5",
                "text" => "Easy",
                "range" => array(
                    "min" => 0,
                    "max" => 25
                )
            ),
            "moderate" => array(
                "color" => "#8BA94A",
                "opacity" => "0.5",
                "text" => "Moderate",
                "range" => array(
                    "min" => 25.1,
                    "max" => 50
                )
            ),
            "hard" => array(
                "color" => "#715592",
                "opacity" => "0.5",
                "text" => "Hard",
                "range" => array(
                    "min" => 50.1,
                    "max" => 75
                )
            ),
            "insane" => array(
                "color" => "#FF0000",
                "opacity" => "0.5",
                "text" => "Insane",
                "range" => array(
                    "min" => 75.1,
                    "max" => 100
                )
            )
        );
        $_default_source = array(
            "datatype" => "json",
            "datafields" => array(array("name" => 'chapter'), array("name" => 'completion'), array("name" => 'incomplete')),
            "url" => ""
        );
        $_default_settings = array(
            "title" => $this->title,
            "description" => $this->description,
            "xAxis" => array(
                "dataField" => '',
                "gridLines" => array("visible" => true),
                "valuesOnTicks" => true,
                "title" => array("text" => ""),
                "labels" => array(
                    'angle'=>"-45",
                    'rotationPoint'=> 'topright',
                    'offset'=> array('x'=> 0, 'y'=> "-40")
                )
            ),
            "colorScheme" => $this->colorSchema,
            "seriesGroups" => array(
                array(
                    "orientation" => 'horizontal', //vertical
                    "type" => 'stackedcolumn100', //column
                    "columnsGapPercent" => 100,
                    "seriesGapPercent" => 5,
                    "valueAxis" => array(
                        "unitInterval" => 10,
                        "minValue" => 0,
                        "maxValue" => 100,
                        "flip" => true,
                        "visible" => true,
                        "title" => array("text" =>'')
                    ),
                    "series" => array()
                )
            )
        );

        $settings = array_merge($_default_settings, $this->settings);
        $this->settings = $settings;

        $dimension = array_merge($_default_dimensions, $this->dimension);
        $this->dimension = $dimension;

        $difficulties = array_merge($_default_difficulties, $this->difficulties);
        $this->difficulties = $difficulties;

        $source = array_merge($_default_source, $this->source);
        $this->source = $source;

        $style = "";
        foreach($this->dimension as $k=>$v) {
            $style .= $k.":".$v.";";
        }
        $this->htmlOptions['style'] = $style;
    }

    public function run()
    {
        $this->computeOptions();
        switch($this->chartType) {
            case "BAR":
                echo CHtml::openTag("div", $this->htmlOptions).CHtml::closeTag("div");
                $this->registerBarChartScripts();
                break;

            case "summary":
            default:
                echo CHtml::openTag("div", $this->htmlOptions).CHtml::closeTag("div");
                $this->registerSummaryScripts();
        }
    }


    /** Register client scripts for bar chart **/
    private function registerSummaryScripts()
    {
        $id = $this->htmlOptions['id'];
        $cs = Yii::app()->clientScript;
        $series = array(); $bands = array();
        foreach($this->difficulties as $each) {
            $series[] = array(
                "displayText" => $each['text'],
                "color" => $each['color'],
                "opacity" => $each['opacity'],
            );
            $bands[] = array(
                "minValue" => $each['range']['min'],
                "maxValue" => $each['range']['max'],
                "color" => $each['color'],
                "opacity" => $each['opacity'],
            );
        }

        $cs->registerScript("{$id}Script", "

			var dataAdapter = new $.jqx.dataAdapter(".CJSON::encode($this->source).", {
                autoBind: true,
                async: false
            });

			var settings = {
                title: '$this->title',
                description: '$this->description',
                showLegend: true,
                enableAnimations: true,
                padding: { left: 5, top: 5, right: 5, bottom: 5 },
                titlePadding: { left: 90, top: 0, right: 0, bottom: 10 },
                source: dataAdapter,
                xAxis: {
                    dataField: 'chapter',
                    gridLines: { visible: true },
                    valuesOnTicks: true,
                    title: { text: '".Yii::t('app', 'Chapters')."' },
                    labels: {
                        angle: -45,
                        rotationPoint: 'topright',
                        offset: { x: 0, y: -40 },
                    }
                },
                colorScheme: '".$this->colorSchema."',
                columnSeriesOverlap: false,
                seriesGroups: [
                    {
                        type: 'column',
                        valueAxis: {
                            visible: true,
                            unitInterval: 10,
                            minValue: 0,
                            maxValue: 100,
                            title: { text: '".Yii::t('app', 'Difficulty Level')."' }
                        },
                        series: [
                            { dataField: 'averageScore', displayText: '".Yii::t('app', 'Score')."' },
                        ]
                    },
                    {
                        orientation: 'vertical',
                        type: 'stepline',
                        columnsGapPercent: 100,
                        valueAxis: {
                            visible: false,
                            displayValueAxis: false,
                            description: 'Difficulty',
                            axisSize: 'auto',
                            minValue: 1,
                            unitInterval: 10,
                            maxValue: 100
                        },
                        series: ".CJSON::encode($series).",
                        bands: ".CJSON::encode($bands)."
                    }
                ]
            };

            $('#{$id}').jqxChart(settings);
        ");

    }

    /** Register client scripts for pie chart **/
    private function registerBarChartScripts()
    {
        $id = $this->htmlOptions['id'];
        $cs = Yii::app()->clientScript;
        $cs->registerScript("{$id}Script", "
			var dataAdapter = new $.jqx.dataAdapter(".CJSON::encode($this->source).", {
                autoBind: true,
                async: false
            });

            var overrideSettings = $.parseJSON('".CJSON::encode($this->settings)."');
			var settings = {
                enableAnimations: true,
                showLegend: true,
                enableAnimations: true,
                padding: { left: 5, top: 5, right: 5, bottom: 5 },
                titlePadding: { left: 90, top: 0, right: 0, bottom: 10 },
                source: dataAdapter,
                columnSeriesOverlap: false,
            };

            settings = $.extend(true, settings, overrideSettings);

            $('#{$id}').jqxChart(settings);
        ");

    }
}