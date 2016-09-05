<?php

/**
 * Created by PhpStorm.
 * Date: 15/2/16
 * Time: 1:20 PM
 */
//YiiBase::import('ext.Chosen.Chosen');

/**
 * Widget to use Chosen in Yii application.
 */
class ChosenComponent extends Chosen {

    // for ajax
    public $source = false;
    public $minLength = 0;
    public $isFrontend = false;

    /** Publish assets and set default values for properties */
    public function init() {
        $this->placeholderSingle = Yii::t('app','Select an Option');
        $this->placeholderMultiple = Yii::t('app','Select Some Options');
        parent::init();
    }

    /** Render widget html and register client scripts */
    public function run() {
        list($name, $id) = $this->resolveNameID();
        if (isset($this->htmlOptions['id'])) {
            $id = $this->htmlOptions['id'];
        } else {
            $this->htmlOptions['id'] = $id;
        }
        parent::run();
        $this->registerScripts($id);
    }

    /** Register client scripts */
    private function registerScripts($id) {
        if ($this->source !== false) {
            Yii::app()->clientScript->registerCoreScript('jquery.ui');

            $resolveAjax = '';
            if ($this->isFrontend !== false) {
                $dataType = 'html';
                $resolveAjax = 'data = resolveAjaxData( data );';
            } else {
                $dataType = 'json';
            }

            $cs = Yii::app()->getClientScript();
            $cs->registerCoreScript('jquery');

            $jsStr = "
                $.fn.selectedData = function(onlyId){
                    var prevData = [];

                    if( onlyId ){
                        $('#{$id}').find(':selected').each(function(i, selected){
                            prevData[i] = $(selected).val();
                        });
                        return prevData;
                    }

                    $('#{$id}').find(':selected').each(function(i, selected){
                        prevData[i] = { id : $(selected).val() , name : $(selected).text() };
                    });
                    return prevData;
                }

                var searchString = '';
                var prevSearch = '';
                $('#{$id}_chosen input').autocomplete({
                    minLength : {$this->minLength},
                    source: function( request, response ) {
                        if (typeof searchString !== 'undefined') {
                            prevSearch = searchString;
                        }
                        searchString = $('#{$id}_chosen input').val();
                        if (searchString !== prevSearch) {
                            $.ajax({
                                url: '{$this->source}',
                                data : { 'searchStr' : searchString , 'selectedIds' : $.fn.selectedData(true) },
                                dataType: '$dataType',
                                success: function( data ) {
                                    var prevData = $.fn.selectedData(false);
                                    $('#{$id}').html('');
                                    if( prevData.length ){
                                        $( prevData ).each(function(i, selected){
                                            $('#{$id}').append('<option value=\"' + prevData[i].id + '\" selected=\"selected\">' + prevData[i].name + '</option>')
                                        });
                                    }
                                    $resolveAjax
                                    response( $.map( data, function( item ) {
                                        $('#{$id}').append('<option value=\"' + item.id + '\">' + item.name + '</option>')
                                        $('#{$id}').trigger('chosen:updated');
                                    }))
                                    $('#{$id}_chosen input').val(searchString);
                                }
                            });
                        }
                    }
                });

                $('#{$id}').on('chosen:no_results', function() {
                    if ($('#{$id}_chosen input').val().length < {$this->minLength}) {
                        $('#{$id}_chosen ul.chosen-results').html('');
                    }
                });
            ";
            $cs->registerScript("{$id}_additional_chosen_script", "$jsStr");
        }
    }

}
