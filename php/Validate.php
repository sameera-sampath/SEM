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
//Foreign
function StayedFor($from,$to)
{
    $val1=date_create_from_format('Y-m-j', $from);
    $val2=date_create_from_format('Y-m-j', $to);
    if($val1==false or $val2==false)
    {
        return 0;
    }
    else
    {
        $duration=date_diff($val1, $val2,true);
        $years=$duration->y;
        switch($years)
        {
            case 0:
                return 5;
            case 1:
                return 10;
            case 2:
                return 15;
            default:
                return 25;
        }
    }
}
function reason($type)
{
    $marks=0;
    switch($type)
    {
        case "Diplomatic Travels":
            $marks=40;
            break;
        case "For Government Service":
            $marks=30;
            break;
        case "For Scholarship":
            $marks=20;
            break;
        case "Private Reason":
            $marks=10;
            break;
    }
    return $marks;
}
function nearforeign($residence,$no)
{
    if($residence>0)
    {
        $marks= reduce(35,$no,5);
        if($marks>0)
        {
            return $marks;
        }
    }
    return 0;
}
/* Educational */
function leave($y1,$y2,$y3,$y4,$y5)
{
    $num1=check_greater($y1,20,2);
    $num2=check_greater($y2,20,2);
    $num3=check_greater($y3,20,2);
    $num4=check_greater($y4,20,2);
    $num5=check_greater($y5,20,2);
    return $num1+$num2+$num3+$num4+$num5;
}
function same_School_service($num)
{
    if($num<0)
    {
        return 0;
    }
    elseif($num<3){
        return 5;
    }
    else
    {
        return 10;
    }
}
function remote($num1,$num2)
{
    $e1=floatval($num1);
    $e2=floatval($num2);
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
    return calculate_marks_two($e1,$e2,5,3);
}

function distance($num)
{
    if($num<0)
    {
        return 0;
    }
    elseif($num<25)
    {
        return 5;
    }
    elseif($num<50)
    {
        return 15;
    }
    elseif($num<100)
    {
        return 25;
    }
    else
    {
        return 35;
    }
}
function service($num)
{
    if($num<20)
    {
        return 20;
    }
    else{
        return $num;
    }
}
/*
* Educational End
 *
 */

/* Old Student */
function grades($num)
{
    if($num<13)
    {
        return 26;
    }
    else{
        return 2*$num;
    }
}
/*
* Old Student End
 *
 */

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
function check_greater($val,$const,$true)
{
    if($val<$const)
    {
        return 0;
    }
    else
    {
        return $true;
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