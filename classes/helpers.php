<?php

if (!function_exists('dump')) {

    function dump($v = 'RANDOM_STR')
    {
        echo "<pre style='background:#263238;color:white;padding:10px;margin:20px 0px'>";
        if ($v === null) {
            echo 'null';
        } elseif ($v === 'RANDOM_STR') {
            echo randstr();
        } elseif ($v === true) {
            echo 'true';
        } elseif ($v === false) {
            echo 'false';
        } else {
            if (is_array($v)) {
                $v = (json_encode($v, JSON_PRETTY_PRINT));
                $v = strip_tags($v);
                print_r($v);
            } else {
                print_r($v);
            }
        }
        echo "</pre>";
    }
}

if (!function_exists('dd')) {
    function dd($v = 'RANDOM_STR')
    {
        echo "<pre style='background:#000000;color:white;padding:10px;margin:20px 0px'>";
        if ($v === null) {
            echo 'null';
        } elseif ($v === 'RANDOM_STR') {
            echo randstr();
        } elseif ($v === true) {
            echo 'true';
        } elseif ($v === false) {
            echo 'false';
        } else {
            if (is_array($v)) {
                $v = (json_encode($v, JSON_PRETTY_PRINT));
                $v = strip_tags($v);
                print_r($v);
            } elseif (is_object($v)) {
                // Convert boolean properties to strings in the object
                $v = convertBooleansToStrings(get_object_vars($v));

                // JSON encode the object
                $v = json_encode($v, JSON_PRETTY_PRINT);
                $v = strip_tags($v);
                print_r($v);
            } else {
                print_r($v);
            }
        }
        echo "</pre>";
        echo "<hr>";
        echo "EXIT";
        echo "<hr>";
        exit;
    }
}


function debug()
{
    if (!isDev()) return;
    $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
    $output = '';
    foreach ($backtrace as $index => $trace) {
        $file = isset($trace['file']) ? $trace['file'] : '';
        $line = isset($trace['line']) ? $trace['line'] : '';
        $class = isset($trace['class']) ? $trace['class'] : '';
        $function = isset($trace['function']) ? $trace['function'] : '';
        $output .= "#{$index} {$file}({$line}): ";
        if ($class) {
            $output .= "{$class}->{$function}()\n";
        } else {
            $output .= "{$function}()\n";
        }
    }
    echo $output . '<hr>';
}

//toggle this when do development
function isDev()
{
    if (
        ($_SERVER['REMOTE_ADDR'] ?? null) == '60.50.53.101'

    ) {
        return true;
    } else {
        return false;
    }
}

function randstr($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
