<?php
/**
 * @file   SimpLineRot.php
 * @author simpart
 * @note   MIT License
 */
namespace mod\SimpLineRot\src;

require_once(__DIR__ . '/synxCheck.php');

class SimpLineRot implements \fnc\gen\InfGen
{
    private $cnf = null;
    private $prm = null;

    /**
     * set config, parameter
     *
     * @param $g : generator object
     */
    public function __construct($c, $p) {
        try {
            $this->cnf = $c;
            $this->prm = $p;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * start php source generate
     */
    public function generate() {
        try {
            /* syntax check */
            
            /* generate routing file */
            
            
            
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
/* end of file */
