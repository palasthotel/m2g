<?php


namespace Palasthotel\WordPress\MigrateToGutenberg\Transformations;


use Palasthotel\WordPress\MigrateToGutenberg\Interfaces\ShortcodeTransformation;

class CaptionTransformation implements ShortcodeTransformation {

	function tag(): string {
		return "caption";
	}

	function transform($attrs, $content = ""): string {

		if(empty($content)) return "";

		$id = intval(str_replace("attachment_", "", $attrs["id"]));
		$attrs["id"] = $id;
		$attrs["sizeSlug"] = "large";
		$json = [
			"id" => intval(str_replace("attachment_", "", $attrs["id"])),
			"sizeSlug" => "large",
		];
		$attrJson = json_encode($json);

		$closeTagPos = strpos($content, "/>");
		$caption = trim(substr($content, $closeTagPos+2));

		//$attachment = wp_get_attachment_metadata($id);
		$imageUrl = wp_get_attachment_url($id);


		return "<!-- wp:image $attrJson -->\n".
		       "<figure class=\"wp-block-image size-large\"><img src=\"$imageUrl\" class=\"wp-image-$id\" />\n".
		       "<figcaption>$caption</figcaption>".
		       "</figure>\n".
		       "<!-- /wp:image -->\n\n";
	}
}