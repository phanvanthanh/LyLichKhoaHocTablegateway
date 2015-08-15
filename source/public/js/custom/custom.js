$(document).ready(function(){
    // alert
    $("#alert").hide();

    stickyDanhSachGiangVien();
    tableResponsive();
    yesOrNo(); 

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

    // modal
    jQuery('select.modal-mon-hoc').on('change', function(){
        var value=jQuery(this).val();
        if(value.trim()=='#modal-mon-hoc'){
            $('#modal-mon-hoc').modal(); 
        }               
    });

    jQuery('select.modal-ngoai-ngu').on('change', function(){
        var value=jQuery(this).val();
        if(value.trim()=='#modal-ngoai-ngu'){
            $('#modal-ngoai-ngu').modal(); 
        }               
    }); 

    jQuery('.modal-cap-nhat-quyen').on('click', function(){

        var permission_id=jQuery(this).attr('permission-id');
        var permission_data=jQuery(this).attr('permission-data');
        jQuery('#modal-cap-nhat-quyen').find('#permission-id').val(permission_id);
        jQuery('#modal-cap-nhat-quyen').find('#permission-name').val(permission_data);
        jQuery('#modal-cap-nhat-quyen').modal();
    });
     
    
});
