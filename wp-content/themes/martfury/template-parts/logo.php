<?php
/**
 * The template part for displaying the main logo on header
 *
 * @package Martfury
 */

$logo = '';
$logo = martfury_get_option( 'logo' );


if ( ! $logo ) {
	$logo = get_template_directory_uri() . '/images/logo/logo.png';
}

if ( is_page_template( 'template-coming-soon-page.php' ) ) {
	$logo = martfury_get_option( 'coming_soon_logo' );

	if ( ! $logo ) {
		$logo = get_template_directory_uri() . '/images/logo/coming-soon-logo.png';
	}

	echo '<div class="container">';
}

?>
<div class="logo">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" >
		<img alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" src="<?php echo esc_url( $logo ); ?>" />
	</a>
</div>
<?php
printf(
	'<%1$s class="site-title"><a href="%2$s" rel="home">%3$s</a></%1$s>',
	is_home() || is_front_page() ? 'h1' : 'p',
	esc_url( home_url( '/' ) ),
	get_bloginfo( 'name' )
);
?>
	<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>

<?php

if ( is_page_template( 'template-coming-soon-page.php' ) ) {
	echo '</div>';
}

