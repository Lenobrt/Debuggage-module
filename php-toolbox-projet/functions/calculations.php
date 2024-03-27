<?php

    function getPercent($percent = null, $of = null , $result =null){

        if($result === null){
            $result = $percent * $of / 100;

            return [
                'result' => $result,
            ];
        }
        if($percent === null){
            $percent = $of / $result * 100;

            return [
                'percent' => $percent,
            ];
        }
        if($of === null){
            $of = $result * 100 / $percent;

            return [
                'of' => $of,
            ];
        }
    }

    function ruleOfThird($a = 1, $b = 1, $c = 1): array
    {
        return [
            'd' => ($b * $c)  / $a,
        ];
    }

    function cesar($clear, $key, $reverse = false){
        $alphabet = 'abcdefghijklmnopqrstuvwxyz';
        $alphabet = str_split($alphabet);
        $clear = str_split($clear);
        $result = '';

        foreach ($clear as $letter){
            $index = array_search($letter, $alphabet);
            $index = $reverse ? $index - $key : $index + $key;
            if($index > 25){
                $index = $index - 26;
            }
            $result .= $alphabet[$index];
        }

        if($reverse){
            return [
                'clear' => $result,
            ];
        } else {
            return [
                'result' => $result,
            ];
        }
    }

    function convertCurrency($amount = null, $from_currency = null, $to_currency = null) {
        if ($amount === null || $from_currency === null || $to_currency === null) {
            return ['error' => 'Paramètres manquants'];
        }
    
        $url = 'https://open.er-api.com/v6/latest/'.$from_currency;
        $data = file_get_contents($url);
        $data = json_decode($data, true);
        if (!$data || !isset($data['rates'][$to_currency])) {
            return ['error' => 'Impossible de récupérer les taux de change'];
        }
        $rate = $data['rates'][$to_currency];
    
        $converted_amount = $amount * $rate;

        return [
            'amount' => $converted_amount,
            'currency' => $to_currency
        ];
    }
    