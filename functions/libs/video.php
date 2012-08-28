<?php


class WP_Video_Include {

	private $_video_url  = '';
	private $_video_type = '';
	private $_video_id   = '';

	function __construct( $url ) {
		$this->_video_url = $url;
		$this->_video_type = 'youtube';
	}


	function extract_vimeo_video_id( $video_url = '' ) {
		sscanf(parse_url($video_url, PHP_URL_PATH), '/%d', $video_id);
		return $video_id;
	}

	function extract_youtube_video_id( $video_obj ) {
		$matches;

		if( preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $video_obj, $matches) )
		{
			return $matches[0];
		}

		parse_str( parse_url( $video_obj, PHP_URL_QUERY ) );

		if(!$v || strpos($v, 'http://www.youtube.com/user/TheJerusalemCenter#p/u/') )
		{
			$v = str_replace('http://www.youtube.com/user/TheJerusalemCenter#p/u/', '', $video_obj);
			$v = str_replace('0/', '', $v);
			$v = str_replace('1/', '', $v);
			$v = str_replace('2/', '', $v);
			$v = str_replace('3/', '', $v);
			$v = str_replace('4/', '', $v);
			$v = str_replace('5/', '', $v);
			$v = str_replace('6/', '', $v);
			$v = str_replace('6/', '', $v);
			$v = str_replace('7/', '', $v);
			$v = str_replace('8/', '', $v);
			$v = str_replace('9/', '', $v);
		}

		return $v;
	}


	function get_video( $url, $width, $height, $output = true ) {

		$height = ($height) ? $height : 226 ;
		$video_id = extract_video_id( $url );

		$player .= '<div class="player youtube">';
		$player .= '	<object width="' . $width . '" height="' . $height . '" >';
		$player .= '		<param name="movie" value="http://www.youtube-nocookie.com/v/' . $video_id . '?fs=1&amp;hl=en_US&amp;rel=0&amp;hd=1" />';
		$player .= '		<param name="allowFullScreen" value="true" />';
		$player .= '		<param name="wmode" value="opaque" />';
		$player .= '		<param value="always" name="allowscriptaccess"></param>';
		$player .= '		<embed src="http://www.youtube-nocookie.com/v/' . $video_id . '?fs=1&amp;hl=en_US&amp;rel=0&amp;hd=1" type="application/x-shockwave-flash" width="' . $width . '" height="' . $height . '" allowfullscreen="true" wmode="opaque"></embed>';
		$player .= '	</object>';
		$player .= '</div>';


		if( $output ) {
			echo $player;
		}

		return $player;
	}



	private function get_youtube_thumbnail() {

	}

	private function get_vimeo_thumbnail() {

	}


	private function get_youtube_video() {

	}

	private function get_vimeo_video() {

	}

}