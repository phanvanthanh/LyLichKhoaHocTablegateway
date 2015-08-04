
$(document).ready(function(){
    
    stickyDanhSachGiangVien();
    tableResponsive();

    // attach table filter plugin to inputs
    $('[data-action="filter"]').filterTable();    
    $('.danh-sach-giang-vien').on('click', '.panel-heading span.filter', function(e){
        var $this = $(this), 
            $panel = $this.parents('.panel');
        
        $panel.find('.panel-body').slideToggle();
        if($this.css('display') != 'none') {
            $panel.find('.panel-body input').focus();
        }
    });
    $('[data-toggle="tooltip"]').tooltip();

});

function stickyDanhSachGiangVien(){
    $(window).resize(function(){
        if ($(window).width()<=750) {            
            $(".danh-sach-giang-vien").unstick();
        }
        else{            
            $(".danh-sach-giang-vien").sticky({topSpacing:80});
        }
    });
    if ($(window).width()<=750) {
        $(".danh-sach-giang-vien").unstick();        
    }
    else{        
        $(".danh-sach-giang-vien").sticky({topSpacing:80});
    }
}

function tableResponsive(){
    $(window).resize(function(){
        if ($(window).width()<=767) {            
            jQuery('table.cf tbody tr td:first-child').addClass('active');            
        }
        else{
            jQuery('table.cf tbody tr td:first-child').removeClass('active');
        }
    });
    if ($(window).width()<=767) {
        jQuery('table.cf tbody tr td:first-child').addClass('active');
        
    }
    else{        
        jQuery('table.cf body tr td:first-child').removeClass('active');     
    }
}

(function(){
    'use strict';
    var $ = jQuery;
    $.fn.extend({
        filterTable: function(){
            return this.each(function(){
                $(this).on('keyup', function(e){
                    $('.filterTable_no_results').remove();
                    var $this = $(this), 
                        search = $this.val().toLowerCase(), 
                        target = $this.attr('data-filters'), 
                        $target = $(target), 
                        $rows = $target.find('tbody tr');
                        
                    if(search == '') {
                        $rows.show(); 
                    } else {
                        $rows.each(function(){
                            var $this = $(this);
                            $this.text().toLowerCase().indexOf(search) === -1 ? $this.hide() : $this.show();
                        })
                        if($target.find('tbody tr:visible').size() === 0) {
                            var col_count = $target.find('tr').first().find('td').size();
                            var no_results = $('<tr class="filterTable_no_results"><td colspan="'+col_count+'">No results found</td></tr>')
                            $target.find('tbody').append(no_results);
                        }
                    }
                });
            });
        }
    });
    $('[data-action="filter"]').filterTable();
})(jQuery);