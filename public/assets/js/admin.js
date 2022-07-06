jQuery(function($) {
    $('[data-rel=tooltip]').tooltip({container:'body'});
    $('[data-rel=popover]').popover({container:'body'});

    if($(".sortable").length) {
        $(".sortable").sortable({
            change: function( event, ui ) {
                $(this).closest('.form-sort').find('.form-actions').show();
            }
        });
        $( ".sortable" ).disableSelection();
    }

    $(".action-delete").on('click', function() {
        var $this = $(this);
        var message = "Вы уверены что хотите удалить объект?";
        if($this.data('message')) {
            message = $this.data('message');
        }
        bootbox.confirm(message, function(result) {
            if(result) {
                $this.closest('form').submit();
                return true;
            }
        });
    });

    $(".action-restore").on(ace.click_event, function() {
        var $this = $(this);
        var message = "Вы уверены что хотите востановить объект?";
        if($this.data('message')) {
            message = $this.data('message');
        }
        bootbox.confirm(message, function(result) {
            if(result) {
                $this.closest('form').submit();
                return true;
            }
        });
    });

    $(".action-delete-link").on(ace.click_event, function(e) {
        e.preventDefault();
        var $this = $(this);
        bootbox.confirm("Вы уверены что хотите удалить объект?", function(result) {
            if(result) {
                location.href = $this.attr('href');
                return true;
            }
        });
    });

    $(".action-confirm").on(ace.click_event, function(e) {
        e.preventDefault();
        var $this = $(this);
        bootbox.confirm($this.data('text'), function(result) {
            if(result) {
                location.href = $this.attr('href');
                return true;
            }
        });
    });

    if($('.chosen-select').length) {
        $('.chosen-select').chosen({allow_single_deselect: true});
    }

    if($('.chosen-autocomplite').length) {
        $('.chosen-autocomplite').each(function(){
            var $id = $(this).attr('id');
            $id = $id.replace(/\-/gi, "_");
            var selector = '#'+$id+'_chosen .chosen-search input';
            var $url = $(this).data('url');
            var MySelect = $(this);

            $(selector).autocomplete({
                source: function( request, response ) {
                    $search_param = $(selector).val();
                    var data = {
                        search_param: $search_param
                    };
                    if($search_param.length > 2) { //отправлять поисковой запрос к базе, если введено более 2 символов
                        $.post($url, data, function onAjaxSuccess(data) {
                            if((data.length!='0')) {
                                $('ul.chosen-results').find('li').each(function () {
                                    $(this).remove();//отчищаем выпадающий список перед новым поиском
                                });
                                MySelect.find('option').each(function () {
                                    $(this).remove(); //отчищаем поля перед новым поисков
                                });
                            }
                            jQuery.each(data, function(){
                                MySelect.append('<option value="' + this.id + '">' + this.name + ' </option>');
                            });
                            MySelect.trigger("chosen:updated");
                            $(selector).val($search_param);
                            anSelected = MySelect.val();
                        });
                    }
                }
            });

        });
    }

    if($('textarea.limited').length) {
        $('textarea.limited').inputlimiter({
            remText: '%n символ(ов) осталось...',
            limitText: 'максимально: %n.'
        });
    }

    $(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: Ctrl+V, Command+V
            (e.keyCode === 86 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    $('.spinbox-input').ace_spinner({min:1,max:90,step:1, btn_up_class:'btn-info' , btn_down_class:'btn-info'});

    $('.file-input-img').ace_file_input({
        no_file:'Не выбрано ...',
        btn_choose:'Выберите',
        btn_change:'Изменить',
        droppable:false,
        onchange:null,
        thumbnail:false, //| true | large
        whitelist:'gif|png|jpg|jpeg'
    });

    $('.filters-header a[data-action="collapse"]').click(function (e) {
        e.preventDefault();
        $('.filters').slideToggle();
        $(this).find('i').toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
    });

    if ($('input[name="filter_show"]').length && $('input[name="filter_show"]').val() == 0) {
        $('.filters').hide();
        $('.filters-header a[data-action="collapse"] i').toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
    }

    var popOverSettings = {
        placement: 'right',
        container: 'body',
        trigger: 'hover',
        html: true,
        selector: '[data-toggle="popover-hover"]',
        content: function () { return '<img src="' + $(this).data('img') + '" height="330" " />'; }
    }

    $('body').popover(popOverSettings);

    $('.input-file').ace_file_input({
        no_file:'Файл не выбран ...',
        btn_choose:'Выберите',
        btn_change:'Изменить',
        droppable:false,
        onchange:null,
        thumbnail:false,
        //blacklist:'exe|php'
        //onchange:''
        //
    });

    if($('.date-picker').length) {
        $('.date-picker').datepicker({
            autoclose: true,
            todayHighlight: true
        })
            //show datepicker when clicking on the icon
            .next().on(ace.click_event, function(){
            $(this).prev().focus();
        });
    }
});
