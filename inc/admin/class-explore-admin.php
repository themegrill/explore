<?php
/**
 * Explore Admin Class.
 *
 * @author  ThemeGrill
 * @package Explore
 * @since   1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Explore_Admin' ) ) :

	/**
	 * Explore_Admin Class.
	 */
	class Explore_Admin {

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		}

		/**
		 * Add admin menu.
		 */
		public function admin_menu() {
			$theme = wp_get_theme( get_template() );

			$page = add_theme_page(
				esc_html__( 'About', 'explore' ) . ' ' . $theme->display( 'Name' ),
				esc_html__( 'About', 'explore' ) . ' ' . $theme->display( 'Name' ),
				'activate_plugins',
				'explore-welcome',
				array(
					$this,
					'welcome_screen',
				)
			);
			add_action( 'admin_print_styles-' . $page, array( $this, 'enqueue_styles' ) );
		}

		/**
		 * Enqueue styles.
		 */
		public function enqueue_styles() {

			wp_enqueue_style( 'explore-welcome', get_template_directory_uri() . '/css/admin/welcome.css', array(), EXPLORE_THEME_VERSION );
		}


		/**
		 * Intro text/links shown to all about pages.
		 *
		 * @access private
		 */
		private function intro() {

			$theme = wp_get_theme( get_template() );

			// Drop minor version if 0
			$major_version = substr( EXPLORE_THEME_VERSION, 0, 3 );
			?>
			<div class="explore-theme-info">
				<h1>
					<?php esc_html_e( 'About', 'explore' ); ?>
					<?php echo $theme->display( 'Name' ); ?>
					<?php printf( esc_html__( '%s', 'explore' ), $major_version ); ?>
				</h1>

				<div class="welcome-description-wrap">
					<div class="about-text"><?php echo $theme->display( 'Description' ); ?></div>

					<div class="explore-screenshot">
						<img src="<?php echo esc_url( get_template_directory_uri() ) . '/screenshot.jpg'; ?>" />
					</div>
				</div>
			</div>

			<p class="explore-actions">
				<a href="<?php echo esc_url( 'https://themegrill.com/themes/explore/?utm_source=explore-about&utm_medium=theme-info-link&utm_campaign=theme-info' ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Theme Info', 'explore' ); ?></a>

				<a href="<?php echo esc_url( apply_filters( 'explore_pro_theme_url', 'https://demo.themegrill.com/explore/' ) ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'View Demo', 'explore' ); ?></a>

				<a href="<?php echo esc_url( apply_filters( 'explore_pro_theme_url', 'https://wordpress.org/support/theme/explore/reviews/?filter=5' ) ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'Rate this theme', 'explore' ); ?></a>
			</p>

			<h2 class="nav-tab-wrapper">
				<a class="nav-tab
				<?php
				if ( empty( $_GET['tab'] ) && $_GET['page'] == 'explore-welcome' ) {
					echo 'nav-tab-active';
				}
				?>
				" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'explore-welcome' ), 'themes.php' ) ) ); ?>">
					<?php echo $theme->display( 'Name' ); ?>
				</a>
				<a class="nav-tab
				<?php
				if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'supported_plugins' ) {
					echo 'nav-tab-active';
				}
				?>
				" href="
				<?php
				echo esc_url(
					admin_url(
						add_query_arg(
							array(
								'page' => 'explore-welcome',
								'tab'  => 'supported_plugins',
							),
							'themes.php'
						)
					)
				);
				?>
				">
					<?php esc_html_e( 'Supported Plugins', 'explore' ); ?>
				</a>
				<a class="nav-tab
				<?php
				if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'changelog' ) {
					echo 'nav-tab-active';
				}
				?>
				" href="
				<?php
				echo esc_url(
					admin_url(
						add_query_arg(
							array(
								'page' => 'explore-welcome',
								'tab'  => 'changelog',
							),
							'themes.php'
						)
					)
				);
				?>
				">
					<?php esc_html_e( 'Changelog', 'explore' ); ?>
				</a>
			</h2>
			<?php
		}

		/**
		 * Welcome screen page.
		 */
		public function welcome_screen() {
			$current_tab = empty( $_GET['tab'] ) ? 'about' : sanitize_title( $_GET['tab'] );

			// Look for a {$current_tab}_screen method.
			if ( is_callable( array( $this, $current_tab . '_screen' ) ) ) {
				return $this->{$current_tab . '_screen'}();
			}

			// Fallback to about screen.
			return $this->about_screen();
		}

		/**
		 * Output the about screen.
		 */
		public function about_screen() {
			$theme = wp_get_theme( get_template() );
			?>
			<div class="wrap about-wrap">

				<?php $this->intro(); ?>

				<div class="changelog point-releases">
					<div class="under-the-hood two-col">
						<div class="col">
							<h3><?php esc_html_e( 'Theme Customizer', 'explore' ); ?></h3>
							<p><?php esc_html_e( 'All Theme Options are available via Customize screen.', 'explore' ); ?></p>
							<p>
								<a href="<?php echo admin_url( 'customize.php' ); ?>" class="button button-secondary"><?php esc_html_e( 'Customize', 'explore' ); ?></a>
							</p>
						</div>

						<div class="col">
							<h3><?php esc_html_e( 'Documentation', 'explore' ); ?></h3>
							<p><?php esc_html_e( 'Please view our documentation page to setup the theme.', 'explore' ); ?></p>
							<p>
								<a href="<?php echo esc_url( 'https://docs.themegrill.com/explore/?utm_source=explore-about&utm_medium=documentation-link&utm_campaign=documentation' ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Documentation', 'explore' ); ?></a>
							</p>
						</div>

						<div class="col">
							<h3><?php esc_html_e( 'Got theme support question?', 'explore' ); ?></h3>
							<p><?php esc_html_e( 'Please put it in our dedicated support forum.', 'explore' ); ?></p>
							<p>
								<a href="<?php echo esc_url( 'https://themegrill.com/support-forum/?utm_source=explore-about&utm_medium=support-forum-link&utm_campaign=support-forum' ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Support', 'explore' ); ?></a>
							</p>
						</div>

						<div class="col">
							<h3>
								<?php
								esc_html_e( 'Translate', 'explore' );
								echo ' ' . $theme->display( 'Name' );
								?>
							</h3>
							<p><?php esc_html_e( 'Click below to translate this theme into your own language.', 'explore' ); ?></p>
							<p>
								<a href="<?php echo esc_url( 'http://translate.wordpress.org/projects/wp-themes/explore' ); ?>" class="button button-secondary">
									<?php
									esc_html_e( 'Translate', 'explore' );
									echo ' ' . $theme->display( 'Name' );
									?>
								</a>
							</p>
						</div>
					</div>
				</div>

				<div class="return-to-dashboard explore">
					<?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
						<a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>">
							<?php is_multisite() ? esc_html_e( 'Return to Updates', 'explore' ) : esc_html_e( 'Return to Dashboard &rarr; Updates', 'explore' ); ?>
						</a> |
					<?php endif; ?>
					<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php is_blog_admin() ? esc_html_e( 'Go to Dashboard &rarr; Home', 'explore' ) : esc_html_e( 'Go to Dashboard', 'explore' ); ?></a>
				</div>
			</div>
			<?php
		}

		/**
		 * Output the changelog screen.
		 */
		public function changelog_screen() {
			global $wp_filesystem;

			?>
			<div class="wrap about-wrap">

				<?php $this->intro(); ?>

				<p class="about-description"><?php esc_html_e( 'View changelog below.', 'explore' ); ?></p>

				<?php
				$changelog_file = apply_filters( 'explore_changelog_file', get_template_directory() . '/readme.txt' );

				// Check if the changelog file exists and is readable.
				if ( $changelog_file && is_readable( $changelog_file ) ) {
					WP_Filesystem();
					$changelog      = $wp_filesystem->get_contents( $changelog_file );
					$changelog_list = $this->parse_changelog( $changelog );

					echo wp_kses_post( $changelog_list );
				}
				?>
			</div>
			<?php
		}

		/**
		 * Parse changelog from readme file.
		 *
		 * @param  string $content
		 *
		 * @return string
		 */
		private function parse_changelog( $content ) {
			$matches   = null;
			$regexp    = '~==\s*Changelog\s*==(.*)($)~Uis';
			$changelog = '';

			if ( preg_match( $regexp, $content, $matches ) ) {
				$changes = explode( '\r\n', trim( $matches[1] ) );

				$changelog .= '<pre class="changelog">';

				foreach ( $changes as $index => $line ) {
					$changelog .= wp_kses_post( preg_replace( '~(=\s*Version\s*(\d+(?:\.\d+)+)\s*=|$)~Uis', '<span class="title">${1}</span>', $line ) );
				}

				$changelog .= '</pre>';
			}

			return wp_kses_post( $changelog );
		}


		/**
		 * Output the supported plugins screen.
		 */
		public function supported_plugins_screen() {
			?>
			<div class="wrap about-wrap">

				<?php $this->intro(); ?>

				<p class="about-description"><?php esc_html_e( 'This theme recommends following plugins:', 'explore' ); ?></p>
				<ol>
					<li>
						<a href="<?php echo esc_url( 'https://wordpress.org/plugins/social-icons/' ); ?>" target="_blank"><?php esc_html_e( 'Social Icons', 'explore' ); ?></a>
						<?php esc_html_e( ' by ThemeGrill', 'explore' ); ?>
					</li>
					<li>
						<a href="<?php echo esc_url( 'https://wordpress.org/plugins/easy-social-sharing/' ); ?>" target="_blank"><?php esc_html_e( 'Easy Social Sharing', 'explore' ); ?></a>
						<?php esc_html_e( ' by ThemeGrill', 'explore' ); ?>
					</li>
					<li>
						<a href="<?php echo esc_url( 'https://wordpress.org/plugins/contact-form-7/' ); ?>" target="_blank"><?php esc_html_e( 'Contact Form 7', 'explore' ); ?></a>
					</li>
					<li>
						<a href="<?php echo esc_url( 'https://wordpress.org/plugins/wp-pagenavi/' ); ?>" target="_blank"><?php esc_html_e( 'WP-PageNavi', 'explore' ); ?></a>
					</li>
					<li>
						<a href="<?php echo esc_url( 'https://wordpress.org/plugins/breadcrumb-navxt/' ); ?>" target="_blank"><?php esc_html_e( 'Breadcrumb NavXT', 'explore' ); ?></a>
					</li>
				</ol>

			</div>
			<?php
		}

	}

endif;

return new Explore_Admin();
