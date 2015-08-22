<?php
namespace Application\FunctionClass;

class FunctionClass
{

    public function selectValueStringSelect($array_arrayData_columnKey_columnValue)
    {     
        $array = array();
        foreach ($array_arrayData_columnKey_columnValue['array_data'] as $data) {         
            $str = $data[$array_arrayData_columnKey_columnValue['column_value']];
            $dates = strtotime($str);
            $date = date('Y-m-d', $dates);
            if (! isset($array_arrayData_columnKey_columnValue['array_attribute_column']) or !isset($data[$array_arrayData_columnKey_columnValue['array_attribute_column']])) {
                if (! $dates or strlen($str) <= 1) {
                    $array[$data[$array_arrayData_columnKey_columnValue['column_key']]] = $data[$array_arrayData_columnKey_columnValue['column_value']];                   
                } else {               
                    $array[$data[$array_arrayData_columnKey_columnValue['column_key']]] = $date;
                }
            } else {
                $attribute = $array_arrayData_columnKey_columnValue['array_attribute_column'];                
                if (! $dates or strlen($str) <= 1) {
                    $array[] = [
                        'attributes' => [
                            'data-key' => $data[$attribute]
                        ],
                        'value' => $data[$array_arrayData_columnKey_columnValue['column_key']],
                        'label' => $data[$array_arrayData_columnKey_columnValue['column_value']]
                    ];
                } else {
                    $array[] = [
                        'attributes' => [
                            'data-key' => $data[$attribute]
                        ],
                        'value' => $data[$array_arrayData_columnKey_columnValue['column_key']],
                        'label' => $date
                    ];
                }
            }
        }

        return $array;
    }

    public function selectElementArray($array_arrayElement_array)
    {
        $arr = $array_arrayElement_array['array'];
        $arr = $arr[key($array_arrayElement_array['array_element'])];
        if (is_array($array_arrayElement_array['array_element'][key($array_arrayElement_array['array_element'])])) {
            $arr = $this->selectElementArray(array(
                'array_element' => $array_arrayElement_array['array_element'][key($array_arrayElement_array['array_element'])],
                'array' => $arr
            ));
        } else {
            $arr = $arr[$array_arrayElement_array['array_element'][key($array_arrayElement_array['array_element'])]];
        }
        return $arr;
    }
    public function makeFriendlyURL($text){
        //global $ibforums;
        //Charachters must be in ASCII and certain ones aint allowed
        $text = html_entity_decode ($text);
        $text = preg_replace("/(ä|à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ|Ä|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/",'a', $text);
        $text = str_replace("/(ç|Ç)/","c",$text);
        $text = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ|È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'e', $text);
        $text = preg_replace("/(ì|í|î|ị|ỉ|ĩ|Ì|Í|Ị|Ỉ|Ĩ)/", 'i', $text);
        $text = preg_replace("/(ö|ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ|Ö|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/",'o', $text);
        $text = preg_replace("/(ü|ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ|Ü|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'u', $text);
        $text = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ|Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'y', $text);
        $text = preg_replace("/(đ|Đ)/", 'd', $text);
        //Special string
        
        $text = preg_replace("/(|!|\"|#|$|%|')/", '', $text);
        $text = preg_replace("/(̀|́|̉|$|>)/", '', $text);
        $text = preg_replace ("''si", "", $text);
        $text = str_replace(" / ","-",$text);
        $text = str_replace("/","-",$text);
        $text = str_replace("(","",$text);
        $text = str_replace(")","",$text);
        $text = str_replace(" - ","-",$text);
        $text = str_replace("_","-",$text);
        $text = str_replace(" ","-",$text);
        $text = str_replace(".","",$text);
        $text = str_replace( "ß", "ss", $text);
        $text = str_replace( "&", "", $text);
        $text = str_replace( "%", "", $text);
        $text = preg_replace("[^A-Za-z0-9-]", "", $text);
        $text = str_replace("----","-",$text);
        $text = str_replace("---","-",$text);
        $text = str_replace("--","-",$text);
        return $text;
    }
    
    public function convertIpToDecimal($ip){
        $d = 0.0;
        $b = explode(".", $ip,4);
        for ($i = 0; $i < 4; $i++) {
            $d *= 256.0;
            $d += $b[$i];
        };
        return $d;
    }
    
    public function convertDecimalToIp($decimal_ip){
        $b=array(0,0,0,0);
        $c = 16777216.0;
        $decimal_ip += 0.0;
        for ($i = 0; $i < 4; $i++) {
            $k = (int) ($decimal_ip / $c);
            $decimal_ip -= $c * $k;
            $b[$i]= $k;
            $c /=256.0;
        };
        $d=join('.', $b);
        return($d);
    }
}