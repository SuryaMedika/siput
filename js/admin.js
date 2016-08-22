$(function () {

    $('.box >h3').append('<button type="button" class="toggle"><span class="fa fa-caret-up"></span></button>');

    $(document).on('click', 'button.toggle', function (e) {
        var id = $(this).closest('.box').attr('id');
        $(this).parent().next().toggle();
        if ($('.fa', this).hasClass('fa-caret-up')) {
            $('.fa', this).removeClass('fa-caret-up').addClass('fa-caret-down');
            if (id != 'undefined') {
                localStorage.setItem('box_' + id, true);
            }
        } else {
            $('.fa', this).removeClass('fa-caret-down').addClass('fa-caret-up');
            if (id != 'undefined') {
                delete localStorage['box_' + id];
            }
        }
        e.preventDefault();
    });

    function checkToggle() {
        $.each(localStorage, function (key, val) {
            if (!key.indexOf('box_')) {
                $('#' + (key.replace('box_', '')) + ' .toggle').trigger('click');
            }
        });
    }

    checkToggle();

    $('.sidebar >ul >li:not(.line)').hover(function () {
        if (!$('.sub-menu:visible', this).length) {
            $('.dropdown-menu', this).show();
            $(this).addClass('hover');
        }
    }, function () {
        $('.dropdown-menu', this).hide();
        $(this).removeClass('hover');
    });

    $('[dropdown] >li').hover(function () {
        $('ul', this).show();
        $(this).addClass('active');
    }, function () {
        $('ul', this).hide();
        $(this).removeClass('active');
    });

    $('[dropdown-profile] >li').hover(function () {
        $('ul', this).show();
        $(this).addClass('active');
    }, function () {
        $('ul', this).hide();
        $(this).removeClass('active');
    });


    $('.sidebar >ul >li').each(function () {
        if ($('.sub-menu', this).length) {
            var html = $('.sub-menu', this).html();
            $(this).append('<ul dropdown class="dropdown-menu">' + html + '</ul>');
        }
    });

    $('.collapse-menu').on('click', function (e) {
        $('.sidebar').toggleClass('fix');
        e.preventDefault();
    });

    function sidebarCheck() {
        if (localStorage.getItem('sidebar')) {
            $('.sidebar .collapse-menu').trigger('click');
        }
    }

    sidebarCheck();

    $('#birthdate').datetimepicker({

        lang:'id',
        timepicker:false,
        format:'d M Y',
        formatDate:'Y/m/d',

    });

    $(".diagnosa").select2({
        tags: true,
        placeholder: "Pilih Diagnosa",
        ajax: {
            url: "inc/icd10.php",
            type: "post",
            dataType: "json",
            delay: 250,
            data: function(params){
                return { q: params.term };
            },
            processResults: function(data){
                return { results: data };
            },
            cache: true
        },
        templateResult: formatData,
        minimumInputLength: 3
    });

    function formatData (data) {
        //if (!data.id) { return data.text; }
        var $data = $(
            '<b>'+ data.id +'</b> - <i>'+ data.text +'</i>'
        );
        return $data;
    };

    $( '#add-row' ).on('click', function() {
        var row = $( '.empty-row.screen-reader-text' ).clone(true);
        row.removeClass( 'empty-row screen-reader-text' );
        row.insertAfter( '#obat-fieldset-one tbody>tr:last' );
        return false;
    });

    $( '.remove-row' ).on('click', function() {
        $(this).parents('tr').remove();
        return false;
    });

});

