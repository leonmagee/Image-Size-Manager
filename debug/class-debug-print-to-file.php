<?php

/**
 * Class Debug_Print_To_File
 */
class Debug_Print_To_File {

	public $output_path;
	public $file_name;
	public $output_data;

	public function __construct( $output_data = 'demo data new', $file_name = 'leon-debug.txt' ) {

		//$debug_file = fopen( $file_name, "w" );
		$file_path = plugin_dir_path( __FILE__ ) . '/log/' . $file_name;
		$debug_file = fopen( $file_path, "w" );

		file_put_contents( $file_path, print_r( $output_data, true ) );
		//file_put_contents( "leon-debug.txt", print_r( $option_array, true ) );

		//$demo_text = "Filter is working Awesome - called from PLUGIN!!!!!... \n";

		//fwrite( $debug_file, $demo_text );

		fclose( $debug_file );

	}


}
