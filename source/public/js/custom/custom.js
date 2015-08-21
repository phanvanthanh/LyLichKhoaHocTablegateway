$(document).ready(function(){
    // alert
    $("#alert").hide();

    stickyDanhSachGiangVien();
    //tableResponsive();
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
    $('.date-time-yyyy').datepicker({
        format: "yyyy"
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

    jQuery('.modal-cap-nhat-cong-tac-nghien-cuu').on('click', function(){
        var data=jQuery(this).attr('data-activity');
        var id=jQuery(this).attr('id-activity');
        jQuery('#modal-cap-nhat-cong-tac-nghien-cuu').find('#name').val(data);
        jQuery('#modal-cap-nhat-cong-tac-nghien-cuu').find('#id').val(id);
        jQuery('#modal-cap-nhat-cong-tac-nghien-cuu').modal();
    });

    jQuery('a.modal-mon-hoc').on('click', function(){
        var data=jQuery(this).attr('data-mon-hoc');
        var id=jQuery(this).attr('id-mon-hoc');
        jQuery('#modal-mon-hoc').find('#name').val(data);
        jQuery('#modal-mon-hoc').find('#id').val(id);
        jQuery('#modal-mon-hoc').modal();
    });

    jQuery('a.modal-chung-chi-khac').on('click', function(){
        var data=jQuery(this).attr('data-chung-chi-khac');
        var id=jQuery(this).attr('id-chung-chi-khac');
        jQuery('#modal-chung-chi-khac').find('#name').val(data);
        jQuery('#modal-chung-chi-khac').find('#id').val(id);
        jQuery('#modal-chung-chi-khac').modal();
    });

    jQuery('a.modal-attribute').on('click', function(){
        var attribute_code=jQuery(this).attr('data-attribute-code');
        var frontend_label=jQuery(this).attr('data-frontend-label');
        var id=jQuery(this).attr('id-attribute');
        jQuery('#modal-attribute').find('#attribute-code').val(attribute_code);
        jQuery('#modal-attribute').find('#frontend-label').val(frontend_label);
        jQuery('#modal-attribute').find('#attribute-id').val(id);
        jQuery('#modal-attribute').modal();
    });


    jQuery('.checkbox-is-check').on('click', function(){
        if(jQuery(this).find('input[type="checkbox"]').prop('checked')){
            jQuery(this).find('input[type="checkbox"]').removeAttr('checked');
        }
        else{
            jQuery(this).find('input[type="checkbox"]').prop('checked', true);
        }
    });
     
    
});
