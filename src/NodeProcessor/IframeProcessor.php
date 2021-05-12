<?php

declare( strict_types=1 );


namespace FlorianBrinkmann\LazyLoadResponsiveImages\NodeProcessor;


use DOMDocument;
use DOMNode;

use const FlorianBrinkmann\LazyLoadResponsiveImages\NATIVE_LAZY_LOAD;

/**
 * Class IframeProcessor
 * @package FlorianBrinkmann\LazyLoadResponsiveImages\ContentProcessor
 */
class IframeProcessor implements Processor {
	use AddNoscriptElementTrait;
	use AddLazyloadClassTrait;

	/**
	 * @inheritDoc
	 */
	public static function process( DOMNode $node, DOMDocument $dom, array $config ): DOMDocument {
		// Add noscript element.
		$dom = self::add_noscript_element( $dom, $node, $config );

		// Check if the iframe has no src attribute.
		if ( ! $node->hasAttribute( 'src' ) ) {
			return $dom;
		}

		// Get src attribute.
		$src = $node->getAttribute( 'src' );

		// Set data-src value.
		$node->setAttribute( 'data-src', $src );

		if ( isset( $config[NATIVE_LAZY_LOAD] ) && true === $config[NATIVE_LAZY_LOAD] ) {
			$node->setAttribute( 'loading', 'lazy' );
		}

		$node = self::add_lazyload_class( $node );

		return $dom;
	}
}