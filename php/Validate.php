<?php

function calculate_marks_two($electoral1,$electoral2,$rate1,$rate2)
{
    $r1=floatval($rate1);
    $r2=floatval($rate2);
    $e1=floatval($electoral1);
    $e2=floatval($electoral2);
    $total=$e1*$r1+$e2*$r2;
    return $total;
}
function reduce($original,$val,$rate)
{
    $original=floatval($original);
    $val=floatval($val);
    $rate=floatval($rate);
    return $original-($val*$rate);
}
/* Residential */
function near($residence,$no)
{
    if($residence>0)
    {
        $marks= reduce(50,$no,5);
        if($marks>0)
        {
            return $marks;
        }
    }
    return 0;
}
function extra_doc($no)
{
    $no=intval($no);
    if($no>5)
    {
        return 5;
    }
    else
    {
        return $no;
    }
}

function ownership($type,$years)
{
    $marks=0;
    $rate=0.0;
    $years=intval($years);
    switch($years)
    {
        case 0:
        case 1:
        case 2:
            $rate=0.5;
            break;
        case 3:
        case 4:
            $rate=0.75;
            break;
        default:
            $rate=1;
    }
    switch($type)
    {
        case "Title deed for Applicant":
            $marks=10;
            break;
        case "Title deed for Applicant's Parent":
            $marks=6;
            break;
        case "Registered lease deed":
            $marks=4;
            break;
        case "Official resident":
            $marks=4;
            break;
        case "Unregistered lease deed":
            $marks=2;
            break;
        case "Othere":
            $marks=0;
            break;
    }
    return $marks*$rate;
}

function electorial_marks($electoral1,$electoral2)
{
    $e1=floatval($electoral1);
    $e2=floatval($electoral2);
    if($e1>5)
    {
        $e1=5;
    }
    if($e2>5)
    {
        $e2=5;
    }
    if(($e1+$e2)>5)
    {
        $e2=5-$e1;
    }
    return calculate_marks_two($e1,$e2,7,5);
}
/*
* Residential End
 *
* Input Validation
*/
function getVal($var)
{
    if(isset($var) and strlen($var) > 0)
    {
        if(is_numeric($var))
        {
            if(is_int($var))
            {
                $int=intval($var);
                return $int;
            }
            else{
                return floatval($var);
            }
        }
        else
        {
            return strval($var);
        }
    }
    else
    {
        return null;
    }
}

function removeNull($str)
{
    if(is_null($str))
    {
        return "";
    }
    return $str;
}
?>