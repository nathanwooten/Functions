<?php

namespace nathanwooten\Functions;

use Exception;

class Functions
{

	public static $delimiters = [ '{{', '}}' ];
	public static $handle = 1;

	public function match( $input, $specific = null )
	{

		$expression = is_null( $specific ) ? '(.*?)' : $specific . '(.*?)';
		$regex = '/' . $this->delimit( $expression ) . '/';

		preg_match_all( $regex, $input, $match );

		$match = $match[0];
		return $match;

	}

	public function escape( $escape )
	{

		return '\\' . implode( '\\', str_split( $escape ) );

	}

	public function delimit( $name, $regex = true, $delimiters = [ '{{', '}}' ] )
	{

		$delimiters = $this->delimiters( $delimiters, $regex );

		$delimited = $delimiters[0] . trim( $name, $delimiters[0] . $delimiters[1] ) . $delimiters[1];

		return $delimited;

	}

	public function strip( $delimited, $regex = false )
	{

		$name = str_replace( $this->delimiters( $this->delimiters, $regex ), '', $delimited );
		return $name;

	}

	public function delimiters( array $delimiters = [], $regex = true )
	{

		$delimiters = empty( $delimiters ) ? static::$delimiters : $delimiters;

		$delimiters = array_values( $delimiters );

		if ( $regex ) {
			$delimiters[0] = $this->escape( $delimiters[0] );
			$delimiters[1] = $this->escape( $delimiters[1] );
		}

		return $delimiters;

	}

	public function getDirectoryByFile( $dir, $toFileName )
	{

		$target = false;

		while ( ! file_exists( $target ) )
		{

			$dir = isset( $dir ) ? $dir : $from;
			$newdir = dirname( $dir );

			if ( ! isset( $dir ) ) {
				$dir = $newdir;

			} else {
				//reached root
				if ( $newdir === $dir ) {
					return false;
				}

				$dir = $newdir;
			}

			$target = $dir . DS . $toFileName;

			if ( file_exists( $target ) && is_readable( $target ) ) {
				$dir = rtrim( $dir, DS ) . DS;

				return $dir;
			} else {

				$function = __FUNCTION__;

				return $this->{$function}( $dir, $toFileName );
			}
		}

		return $target;

	}

	public static function handle( Exception $e, $code )
	{

		switch( (bool) $code ) {
			case true:
				throw $e;
			case false;
				return $e;
		}

	}

}
