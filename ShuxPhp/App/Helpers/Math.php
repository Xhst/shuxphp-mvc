<?php
namespace ShuxPhp\App\Helpers
{
	defined('ShuxPhp') or exit;

	final class Math
	{

	    /**
	     * isDecimal
	     * @param  (all) val to check
	     * @return boolean
	     */
	    public static function isDecimal($val): bool
	    {
	    	return is_numeric( $val ) && floor( $val ) != $val;
	    }

		/**
		 * Factorial
		 * @param  int $num
		 * @return integer
		 */
	    public static function factorial(int $num): int
	    {
		    if($num < 2)
		    	return 1;

	    	for($f=2; $num-1 > 1; $f *= $num--);

	    	return $f;
		}

	}
}