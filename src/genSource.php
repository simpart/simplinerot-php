<?php
/**
 * @file   genSource.php
 * @author simpart
 * @note   MIT License
 */
namespace mod\SimpLineRot\src;

/*** function ***/

function genFunc($out) {
    try {
        $ret = copy(
                   __DIR__ . '/../file/rotFunc.php',
                   $out . 'rotFunc.php'
               );
        if ( false === $ret ) {
            throw new \err\ComErr(
                'failed create rotFunc.php file',
                'please check ' . $out
            );
        }
    } catch (\Exception $e) {
        throw $e;
    }
}



function genRoute($out,$cnf) {
    try {
        $rot_src = file_get_contents (
                       __DIR__ . '/../file/route.php'
                   );
        if ( false === $rot_src ) {
            throw new \err\gen\GenErr( 
                'could not read route.php file',
                'please check ' . __DIR__ . '/../file/route.php'
            );
        }
        
        $rot_tbl = array();
        foreach ($cnf as $key => $val) {
            if (0 === strcmp($key, '__NMATCHED__')) {
                continue;
            }
            $rot_tbl[$key] = $val;
        }
        if (0 === count($rot_tbl)) {
            throw new \err\gen\GenErr(
                'could not find routing table in config file',
                'please check config file'
            );
        }
        
        $rot_tbl_ary =  getArrayCode($rot_tbl);
        
        $rot_rep = str_replace( '@gen1', $rot_tbl_ary, $rot_src );
        $rot_rep = str_replace(
                       '@gen2',
                       $cnf['__NMATCHED__'],
                       $rot_rep
                   );
        $ret = file_put_contents( $out . 'route.php', $rot_rep );
        if ( false === $ret ) {
            throw new \err\gen\GenErr(
                'failed create route.php file',
                'please check ' . $out
            );
        }
    } catch (\Exception $e) {
        throw $e;
    }
}


function getArrayCode( $ary, $cnt=0 ) {
    try {
        $isarr = false;
        if ( false === is_array( $ary ) ) {
            throw new Exception( 'invalid parameter' );
        }
        $ret_str = 'array(';
        if ( 0 === $cnt ) {
            $ret_str .= PHP_EOL;
        }
        if ( array_values( $ary ) === $ary ) {
            foreach ( $ary as $val ) {
                if ( null === $val ) {
                    $ret_str .= 'null';
                } else if ( true === is_array( $val ) ) {
                    $isarr    = true; 
                    $ret_str .= ' '.getArrayCode( $val, $cnt+1 );
                } else { 
                    if ( true === is_string( $val ) ) {
                        $ret_str .= '\''. $val .'\'';
                    } else {
                        $ret_str .= $val;
                    }
                }
                $ret_str .= ',';
                if ( (0 === $cnt) && (true === $isarr) ) {
                    $ret_str .= PHP_EOL;
                    $isarr    = false;
                }
            }
        } else {
            foreach ( $ary as $key => $val ) {
                if ( 0 === $cnt ) {
                    $ret_str .= '    ';
                }
                $ret_str .= '\''. $key .'\' =>';
                if ( null === $val ) {
                    $ret_str .= ' null';
                } else if ( true === is_array( $val ) ) {
                    $isarr    = true;
                    $ret_str .= ' '.getArrayCode( $val, $cnt+1 );
                } else { 
                    if ( true === is_string( $val ) ) {
                        $ret_str .= '\''. $val .'\'';
                    } else {
                        $ret_str .= $val;
                    }
                }
                $ret_str .= ',';
                if ( (0 === $cnt) && (true === $isarr) ) {
                    $ret_str .= PHP_EOL;
                    $isarr    = false;
                }
            }
        }
        
        if ( 0 === $cnt ) {
            $ret_str .= PHP_EOL.');';
        } else {
            $ret_str .= ')';
        }
        return $ret_str; 
    } catch ( \Exception $e ) {
        throw $e;
    }
}

/* end of file */
