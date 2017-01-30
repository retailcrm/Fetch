<?php

namespace Fetch;

final class UTF8
{
    public static function fix($text)
    {
        if(!is_string($text)) {
            return $text;
        }

        $buf = '';
        for ($i = 0, $max = strlen($text); $i < $max; $i++) {
            $c1 = $text{$i};
            if ($c1 >= "\xc0") { //Should be converted to UTF8, if it's not UTF8 already
                $c2 = $i + 1 >= $max ? "\x00" : $text[$i + 1];
                $c3 = $i + 2 >= $max ? "\x00" : $text[$i + 2];
                $c4 = $i + 3 >= $max ? "\x00" : $text[$i + 3];

                if ($c1 >= "\xc0" & $c1 <= "\xdf") { //looks like 2 bytes UTF8
                    if ($c2 >= "\x80" && $c2 <= "\xbf") { //yeah, almost sure it's UTF8 already
                        $buf .= $c1 . $c2;
                        $i++;
                    } else { //not valid UTF8.  Convert it.
                        $buf .= '?';
                    }
                } elseif ($c1 >= "\xe0" & $c1 <= "\xef") { //looks like 3 bytes UTF8
                    if ($c2 >= "\x80" && $c2 <= "\xbf" && $c3 >= "\x80" && $c3 <= "\xbf") { //yeah, almost sure it's UTF8 already
                        $buf .= $c1 . $c2 . $c3;
                        $i   += 2;
                    } else { //not valid UTF8.  Convert it.
                        $buf .= '?';
                    }
                } elseif ($c1 >= "\xf0" & $c1 <= "\xf7") { //looks like 4 bytes UTF8
                    if ($c2 >= "\x80" && $c2 <= "\xbf" && $c3 >= "\x80" && $c3 <= "\xbf" && $c4 >= "\x80" && $c4 <= "\xbf") { //yeah, almost sure it's UTF8 already
                        $buf .= $c1 . $c2 . $c3 . $c4;
                        $i   += 3;
                    } else { //not valid UTF8.  Convert it.
                        $buf .= '?';
                    }
                } else { //doesn't look like UTF8, but should be converted
                    $buf .= '?';
                }
            } elseif (($c1 & "\xc0") === "\x80") { // needs conversion
                $buf .= '?';
            } else { // it doesn't need conversion
                $buf .= $c1;
            }
        }

        return $buf;
    }
}
