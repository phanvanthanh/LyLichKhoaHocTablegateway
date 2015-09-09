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
        format: "yyyy-mm-dd"
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
            var parent=jQuery(this).find('input[type="checkbox"]').val();
            unCheckChild(parent);
        }
        else{
            jQuery(this).find('input[type="checkbox"]').prop('checked', true);
            var parent_name=jQuery(this).find('input[type="checkbox"]').prop('name');
            var array_parent=parent_name.split("_");
            var parent=array_parent[0];
            checkParent(parent);
        }
    });

    /*
        edit ctgd        
    */

    jQuery('.ctgd-btn-edit').on('click', function(){
        var id=jQuery(this).closest('tr').find('td[data-title="STT"] span').text();
        var ten_mon=jQuery(this).closest('tr').find('td[data-title="Tên môn"] span').text();
        var so_tiet=jQuery(this).closest('tr').find('td[data-title="Số tiết"]').text();
        var bac_hoc=jQuery(this).closest('tr').find('td[data-title="Bậc học"]').text();
        var he_dao_tao=jQuery(this).closest('tr').find('td[data-title="Hệ đào tạo"]').text();
        var ghi_chu=jQuery(this).closest('tr').find('td[data-title="Ghi chú"]').text();
        
        jQuery('#modal-cong-tac-giang-day-edit').find('input[name="id_cong_tac"]').val(id);
        jQuery('#modal-cong-tac-giang-day-edit').find('select[name="ten_mon"]').val(ten_mon);
        jQuery('#modal-cong-tac-giang-day-edit').find('select[name="so_tiet"]').val(so_tiet);
        jQuery('#modal-cong-tac-giang-day-edit').find('input[name="ghi_chu"]').val(ghi_chu);
        
        bac_hoc=bac_hoc.split(',');
        jQuery.each(bac_hoc, function(i, v){
            v=v.trim();
            jQuery('#modal-cong-tac-giang-day-edit').find('label[title="'+v+'"]').addClass('active').find('input[type="checkbox"]').val(1).prop('checked', true);
        });

        he_dao_tao=he_dao_tao.split(',');
        jQuery.each(he_dao_tao, function(i, v){
            v=v.trim();
            jQuery('#modal-cong-tac-giang-day-edit').find('label[title="'+v+'"]').addClass('active').find('input[type="checkbox"]').val(1).prop('checked', true);
        });
    });

    /*
        edit future-ctgd        
    */

    jQuery('.future-ctgd-btn-edit').on('click', function(){
        var id=jQuery(this).closest('tr').find('td[data-title="STT"] span').text();
        var ten_mon=jQuery(this).closest('tr').find('td[data-title="Tên môn"] span').text();
        var so_tiet=jQuery(this).closest('tr').find('td[data-title="Số tiết"]').text();
        var bac_hoc=jQuery(this).closest('tr').find('td[data-title="Bậc học"]').text();
        var he_dao_tao=jQuery(this).closest('tr').find('td[data-title="Hệ đào tạo"]').text();
        var ghi_chu=jQuery(this).closest('tr').find('td[data-title="Ghi chú"]').text();
        
        jQuery('#modal-future-cong-tac-giang-day-edit').find('input[name="id_cong_tac"]').val(id);
        jQuery('#modal-future-cong-tac-giang-day-edit').find('select[name="ten_mon"]').val(ten_mon);
        jQuery('#modal-future-cong-tac-giang-day-edit').find('select[name="so_tiet"]').val(so_tiet);
        jQuery('#modal-future-cong-tac-giang-day-edit').find('input[name="ghi_chu"]').val(ghi_chu);
        
        bac_hoc=bac_hoc.split(',');
        jQuery.each(bac_hoc, function(i, v){
            v=v.trim();
            jQuery('#modal-future-cong-tac-giang-day-edit').find('label[title="'+v+'"]').addClass('active').find('input[type="checkbox"]').val(1).prop('checked', true);
        });

        he_dao_tao=he_dao_tao.split(',');
        jQuery.each(he_dao_tao, function(i, v){
            v=v.trim();
            jQuery('#modal-future-cong-tac-giang-day-edit').find('label[title="'+v+'"]').addClass('active').find('input[type="checkbox"]').val(1).prop('checked', true);
        });

        console.log(id, ten_mon, so_tiet, bac_hoc, he_dao_tao, ghi_chu);
    });
        
    jQuery('.nghien-cuu-btn-edit').on('click', function(){
        var id_hoat_dong=jQuery(this).closest('tr').find('td[data-title="STT"] span').text();
        var ten_hoat_dong=jQuery(this).closest('tr').find('td[data-title="Tham gia hoạt động"]').text();
        var trang_thai=jQuery(this).closest('tr').find('td[data-title="Trạng thái"]').text();
        var bat_dau='';
        var ket_thuc='';
        var ghi_chu='';
        if(trang_thai=='Có'){
            bat_dau=jQuery(this).closest('tr').find('td[data-title="Thời gian bắt đầu"]').text();
            ket_thuc=jQuery(this).closest('tr').find('td[data-title="Thời gian kết thúc"]').text();
            ghi_chu=jQuery(this).closest('tr').find('td[data-title="Ghi chú"]').text();
            jQuery('#modal-nghien-cuu-edit').find('input[name="trang_thai"].checkbox').prop('checked', true).val(1);
        }
        console.log(id_hoat_dong, ten_hoat_dong, trang_thai, bat_dau, ket_thuc, ghi_chu);
        jQuery('#modal-nghien-cuu-edit').find('input[name="id_hoat_dong"]').val(id_hoat_dong);
        jQuery('#modal-nghien-cuu-edit').find('input[name="ten_hoat_dong"]').val(ten_hoat_dong);
        jQuery('#modal-nghien-cuu-edit').find('input[name="time_from"]').val(bat_dau);
        jQuery('#modal-nghien-cuu-edit').find('input[name="time_to"]').val(ket_thuc);
        jQuery('#modal-nghien-cuu-edit').find('input[name="ghi_chu"]').val(ghi_chu);
    });

    jQuery('.future-hdnckh-btn-edit').on('click', function(){
        var value_id=jQuery(this).closest('tr').find('td[data-title="STT"] span').text();
        var science_activity_name=jQuery(this).closest('tr').find('td[data-title="Nội dung"]').text();
        var time_from=jQuery(this).closest('tr').find('td[data-title="Thời gian bắt đầu"]').text();
        var note=jQuery(this).closest('tr').find('td[data-title="Ghi chú"]').text();
        jQuery('#modal-future-hoat-dong-nghien-cuu-khoa-hoc-edit').find('input[name="value_id"]').val(value_id);
        jQuery('#modal-future-hoat-dong-nghien-cuu-khoa-hoc-edit').find('input[name="science_activity_name"]').val(science_activity_name);
        jQuery('#modal-future-hoat-dong-nghien-cuu-khoa-hoc-edit').find('input[name="time_from"]').val(time_from);
        jQuery('#modal-future-hoat-dong-nghien-cuu-khoa-hoc-edit').find('input[name="note"]').val(note);

    });

    jQuery('.orther-work-btn-edit').on('click', function(){
        var value_id=jQuery(this).closest('tr').find('td[data-title="STT"] span').text();
        var content=jQuery(this).closest('tr').find('td[data-title="Nội dung"]').text();
        var time_from=jQuery(this).closest('tr').find('td[data-title="Thời gian"] span.time_from').text();
        var time_to=jQuery(this).closest('tr').find('td[data-title="Thời gian"] span.time_to').text();
        var note=jQuery(this).closest('tr').find('td[data-title="Ghi chú"]').text();

        jQuery('#modal-orther-work-edit').find('input[name="value_id"]').val(value_id);
        jQuery('#modal-orther-work-edit').find('input[name="content"]').val(content);
        jQuery('#modal-orther-work-edit').find('input[name="time_from"]').val(time_from);
        jQuery('#modal-orther-work-edit').find('input[name="time_to"]').val(time_to);
        jQuery('#modal-orther-work-edit').find('input[name="note"]').val(note);

    });

    jQuery('.future-orther-work-btn-edit').on('click', function(){
        var value_id=jQuery(this).closest('tr').find('td[data-title="STT"] span').text();
        var content=jQuery(this).closest('tr').find('td[data-title="Nội dung"]').text();
        var time_from=jQuery(this).closest('tr').find('td[data-title="Thời gian"] span.time_from').text();
        var time_to=jQuery(this).closest('tr').find('td[data-title="Thời gian"] span.time_to').text();
        var note=jQuery(this).closest('tr').find('td[data-title="Ghi chú"]').text();

        jQuery('#modal-future-orther-work-edit').find('input[name="value_id"]').val(value_id);
        jQuery('#modal-future-orther-work-edit').find('input[name="content"]').val(content);
        jQuery('#modal-future-orther-work-edit').find('input[name="time_from"]').val(time_from);
        jQuery('#modal-future-orther-work-edit').find('input[name="time_to"]').val(time_to);
        jQuery('#modal-future-orther-work-edit').find('input[name="note"]').val(note);

    });
     
    
});
