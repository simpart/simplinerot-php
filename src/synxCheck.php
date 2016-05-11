<?php
/**
 * @file   synxCheck.php
 * @author simpart
 * @note   MIT License
 */
namespace mod\SimpLineRot\src;

function chkRequredKey($cnf) {
    try {
        $chk = false;
        foreach ($cnf as $key => $val) {
            if (0 === strcmp('__NMATCHED__', $key)) {
                $chk = true;
                break;
            }
        }
        if (false === $chk) {
            throw new \err\gen\GenErr(
                'could not find \'__NMATCHED__\' key',
                'require \'__NMATCHED__\' key in config file'
            );
        }
    } catch (\Exception $e) {
         throw $e;
    }
}



function chkRotDest($cnf) {
    try {
        $chk  = true;
        $base = '';
        if (true === array_key_exists('__BASEDIR__', $cnf)) {
            $base = $cnf['__BASEDIR__']; 
        }
        foreach ($cnf as $key => $val) {
            if (0 === strcmp($key, '__BASEDIR__')) {
                continue;
            }
            if (true !== file_exists($base . $val)) {
                $chk = false;
                break;
            }
            $ftype = filetype($base . $val);
            if (0 !== strcmp($ftype, 'file')) {
                $chk = false;
                break;
            }
        }
        if (false === $chk) {
            throw new \err\gen\GenErr(
                'could not find ' . $val . ' file',
                'please specify an existing file' . PHP_EOL .
                'and you need specify absolute path'
            );
        }
    } catch (\Exception $e) {
        throw $e;
    }
}

/* end of file */
