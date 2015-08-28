/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2014 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
function setLocation(url){
    window.location.href = url;
}

function confirmSetLocation(message, url){
    if( confirm(message) ) {
        setLocation(url);
    }
    return false;
}

function deleteConfirm(message, url) {
    confirmSetLocation(message, url);
}

/*
    function customer created
*/
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
        if ($(window).width()<=750) {            
            jQuery('table.cf tbody tr td:first-child').addClass('active');            
        }
        else{
            jQuery('table.cf tbody tr td:first-child').removeClass('active');
        }
    });
    if ($(window).width()<=750) {
        jQuery('table.cf tbody tr td:first-child').addClass('active');
        
    }
    else{        
        jQuery('table.cf body tr td:first-child').removeClass('active');     
    }
}
 
function yesOrNo(){
    jQuery('.yes-no').on('click', function(){
        var data=jQuery(this).attr('data-yes-no');
        var type=jQuery(this).attr('type-yes-no');
        if(type.trim()=='y'){
            jQuery(data).removeClass('hidden-xs hidden-sm hidden-md hidden-lg');
        }
        else{
            jQuery(data).addClass('hidden-xs hidden-sm hidden-md hidden-lg');
        }
    });
}

function checkParent(parent){    
    var parent=parent;
    jQuery('.checkbox-is-check').each(function(){
        var value=jQuery(this).find('input[type="checkbox"]').val();
        if(parseInt(value)==parseInt(parent)){   
            if(!jQuery(this).find('input[type="checkbox"]').prop('checked')){
                jQuery(this).find('input[type="checkbox"]').prop('checked', true);
                var parent_name=jQuery(this).find('input[type="checkbox"]').prop('name');
                var array_parent=parent_name.split("_");
                var parent_new=array_parent[0];
                checkParent(parent_new);
            }
        }
    });
}

function unCheckChild(parent){    
    var parent=parent;
    jQuery('.checkbox-is-check').each(function(){
        var name=jQuery(this).find('input[type="checkbox"]').prop('name');
        var array_name=name.split("_");
        var value=array_name[0];
        if(parseInt(value)==parseInt(parent)){   
            if(jQuery(this).find('input[type="checkbox"]').prop('checked')){
                jQuery(this).find('input[type="checkbox"]').prop('checked', false);
                var parent_new=jQuery(this).find('input[type="checkbox"]').val();
                /*var array_parent=parent_name.split("_");
                var parent_new=array_parent[0];*/
                unCheckChild(parent_new);
            }
        }
    });
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
