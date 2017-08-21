<?php
namespace App\helper;

class HtmlToText {
	public static function convert( $html_content ) {
		$app_content = strip_tags( $html_content, '<img><p><br><table><ul><li><tr><td>' );

		$app_content = preg_replace( [
			"/<p.*?>/s",
			"/<li.*?>/s",
			"/<tr.*?>/s",
			"/<ul.*?>/s",
			"/<br.*?>/s",
			"/<table.*?>/s",
			"/<td.*?>/s",
			"/<\/td>/s",
			"/<\/[a-zA-Z]+?>/s",
			"/&nbsp;/"
		], [
			"",
			"*  ",
			"\n\t",
			"\n",
			"\n",
			"\n\n",
			"\n",
			"",
			"\n",
			" "
		], $app_content );


		preg_match_all( '/<img.*?src="(.*?)".*?>/i', $app_content, $urls );
		$urls = $urls[1];

		$app_content = preg_replace( '/<img.*?src=".*?".*?>/i', "{{img}}", $app_content );

		return json_encode( [ 'post_content' => $app_content, 'image_urls' => $urls ], JSON_UNESCAPED_UNICODE );
	}
}