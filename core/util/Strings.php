<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace core\util;
/**
 * Description of Strings
 *
 * @author jlgre_000
 */
class Strings {
    
    /**
     * Retorna um array contendo todas as UF do Brasil 
     * @return array
     */
    public static function getUf(){
        return array("AC"=>"Acre", "AL"=>"Alagoas", "AM"=>"Amazonas", "AP"=>"Amapá","BA"=>"Bahia","CE"=>"Ceará","DF"=>"Distrito Federal","ES"=>"Espírito Santo","GO"=>"Goiás","MA"=>"Maranhão","MT"=>"Mato Grosso","MS"=>"Mato Grosso do Sul","MG"=>"Minas Gerais","PA"=>"Pará","PB"=>"Paraíba","PR"=>"Paraná","PE"=>"Pernambuco","PI"=>"Piauí","RJ"=>"Rio de Janeiro","RN"=>"Rio Grande do Norte","RO"=>"Rondônia","RS"=>"Rio Grande do Sul","RR"=>"Roraima","SC"=>"Santa Catarina","SE"=>"Sergipe","SP"=>"São Paulo","TO"=>"Tocantins");               
    }
    
    /**
     * Retorna o formato monetário de uma valor
     * @param numeric $value Um valor numérico
     * @return string O $value formatado
     */
    public static function formatMoney($value){
        return 'R$' . number_format($value,2,",",".");
    }
    
    public static function formatDate($date){
        return (new \DateTime($date))->format('d/m/Y');
    }

    

    /**
     * Converte strings vazias para valores nulos
     * @param string $var 
     * @return NULL|$var
     */
    public static function emptyToNull($var){
        if (trim($var) === '')
            return NULL;
        else
            return $var;
    }
    
}
