
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

    // datetime-picker    
    $('.date-time').datepicker({
        format: "dd/mm/yyyy"
    });
    
    
});

