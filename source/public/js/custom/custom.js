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


    // modal atribute and frontend input 
    jQuery('a.modal-attribute').on('click', function(){
        var attribute_code=jQuery(this).attr('data-attribute-code');
        var frontend_label=jQuery(this).attr('data-frontend-label');
        var frontend_input=jQuery(this).attr('data-frontend-input');
        var id=jQuery(this).attr('id-attribute');
        jQuery('#modal-attribute').find('#attribute-code').val(attribute_code);
        jQuery('#modal-attribute').find('#frontend-label').val(frontend_label);
        jQuery('#modal-attribute').find('#attribute-id').val(id);
        jQuery('#modal-attribute').find('#frontend-input').val(frontend_input);
        jQuery('#modal-attribute').modal();
    });
    
    jQuery('#frontend-input').on('change', function(){
        var value=jQuery(this).val();
        if(value=='Select'){
            jQuery('.frontend-input').removeClass('hidden-xs hidden-sm hidden-md hidden-lg');
        }
        else{
            jQuery('.frontend-input').addClass('hidden-xs hidden-sm hidden-md hidden-lg');
        }
    });

    var frontend_input_html='<div class="row">'       
        +'<div class="col-xs-10 col-sm-10 col-md-5 col-lg-5 col-xs-offset-2 col-sm-offset-2 col-md-offset-1 col-lg-offset-1">'
        +   '<div class="form-group has-success">'
        +       '<input type="text" name="frontend_input_value[]" class="form-control" placeholder="Nhập giá trị">'
        +   '</div>'
        +   '</div>'
        +   '<div class="col-xs-10 col-sm-10 col-md-5 col-lg-5 col-xs-offset-2 col-sm-offset-2 col-md-offset-0 col-lg-offset-0">'
        +   '<div class="form-group has-success">'
        +     '<input type="text" name="frontend_input_label[]" class="form-control" placeholder="Nhập tên hiển thị">'
        +   '</div>'
        + '</div>'
        + '<div class="col-xs-10 col-sm-10 col-md-1 col-lg-1 col-xs-offset-2 col-sm-offset-2 col-md-offset-0 col-lg-offset-0">'            
        + '<div class="form-group has-success text-right">'
        +     '<a class="btn btn-default frontend-input-remove">-</a>'
        +   '</div>'
        + '</div>'
        +'</div>';
    
    jQuery('.frontend-input-add').on('click', function(){
        var value=jQuery('#frontend_input_value').val();
        var label=jQuery('#frontend_input_label').val();
        if(value=='' || label==''){
            return false;
        }
        jQuery('#frontend_input_value').val('');
        jQuery('#frontend_input_label').val('');
        jQuery('.frontend-input').append(frontend_input_html);
        jQuery('.frontend-input>div:last-child').find('input[name="frontend_input_value[]"]').val(value);
        jQuery('.frontend-input>div:last-child').find('input[name="frontend_input_label[]"]').val(label);
        jQuery('.frontend-input-remove').on('click', function(){
            jQuery(this).closest('div.row').remove();
        });
    });

    jQuery('.frontend-input-remove').on('click', function(){
        jQuery(this).closest('div.row').remove();
    });

    var count_option=jQuery('.frontend-input-add-option').attr('count-option');
    
    jQuery('.frontend-input-add-option').on('click', function(){
        count_option++;
        var frontend_option_html='<div class="row">' 
            +'<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">'
            +   '<h3><small>Option '+count_option+'</small></h3>'
            +'</div>'      
            +'<div class="col-xs-10 col-sm-10 col-md-5 col-lg-5 col-xs-offset-2 col-sm-offset-2 col-md-offset-1 col-lg-offset-1">'
            +   '<div class="form-group has-success">'
            +       '<input type="text" name="frontend_input_value[]" class="form-control" placeholder="Nhập giá trị">'
            +   '</div>'
            +   '</div>'
            +   '<div class="col-xs-10 col-sm-10 col-md-5 col-lg-5 col-xs-offset-2 col-sm-offset-2 col-md-offset-0 col-lg-offset-0">'
            +   '<div class="form-group has-success">'
            +     '<input type="text" name="frontend_input_label[]" class="form-control" placeholder="Nhập tên hiển thị">'
            +   '</div>'
            + '</div>'
            + '<div class="col-xs-10 col-sm-10 col-md-1 col-lg-1 col-xs-offset-2 col-sm-offset-2 col-md-offset-0 col-lg-offset-0">'            
            + '<div class="form-group has-success text-right">'
            +     '<a class="btn btn-default frontend-input-remove">-</a>'
            +   '</div>'
            + '</div>'
            +'</div>';
        jQuery('.frontend-input').append(frontend_option_html);
        jQuery('.frontend-input-remove').on('click', function(){
            jQuery(this).closest('div.row').remove();
        });
    });

    /**/
    jQuery('.checkbox-is-check').on('click', function(){
        if(jQuery(this).find('input[type="checkbox"]').prop('checked')){
            jQuery(this).find('input[type="checkbox"]').removeAttr('checked');
        }
        else{
            jQuery(this).find('input[type="checkbox"]').prop('checked', true);
            var parent_name=jQuery(this).find('input[type="checkbox"]').prop('name');
            var array_parent=parent_name.split("_");
            var parent=array_parent[0];
            checkParent(parent);
        }
    });
        
     
    
});
