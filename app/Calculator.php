<?php

namespace App;

class Calculator
{
    private $priority = [
        '^', '/', '*', '-', '+'
    ];

    public $debug = false;


    public function calculate($expression)
    {
        $expression = str_replace(',', '.', $expression);
        $expression = str_replace(' ', '', $expression);
        $expression = trim($expression,implode($this->priority));
        if (!preg_match("/^[0-9\+\*\-\/\(\)\.\s]+$/",$expression)){
            return "incorrect input data";
        }
        while (strpos($expression, '(') || strpos($expression, ')')) {
            if ($this->debug)
                Helper::echoPrint($expression);
            $expression = preg_replace_callback('/\(([^\(\)]+)\)/', 'self::callbackArray', $expression);
        }
        return $this->callbackString($expression);

    }

    private function callbackArray($input)
    {
        $expression = str_replace(['(', ')'], '', $input[0]);
        return $this->callbackString($expression);
    }

    private function callbackString($expression)
    {
        if ($this->debug)
            Helper::echoPrint($expression);
        $decimal = "-?\d+(?:[\.,]\d+)*";
        $actionsRegex = "[\+\-\*\/\^]";
        if (is_numeric($expression)) {
            return $expression;
        } elseif (preg_match("/^($decimal)($actionsRegex)($decimal)$/", $expression, $match)) {
            return $this->compute($match[2], $match[1], $match[3]);
        } else {
            foreach ($this->priority as $action) {
                $actionRegex = "/($decimal)(\\$action)($decimal)/";
                while (preg_match($actionRegex, $expression, $match)) {
                    $expression = preg_replace_callback($actionRegex, 'self::callbackArray', $expression);
                }
            }
            return $expression;
        }
    }

    private function compute($operator, $a, $b)
    {
        switch ($operator) {
            case '+':
                $p = $a + $b;
                break;
            case '-':
                $p = $a - $b;
                break;
            case '*':
                $p = $a * $b;
                break;
            case '/':
                $p = $a / $b;
                break;
            case '^':
                $p = pow($a, $b);
                break;
            default:
                Helper::echoPrint(new \Exception('action is not defined', 228));
                die();
        }
        return $p;
    }

}