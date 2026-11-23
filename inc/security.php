<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

/** Contact form: nonce, honeypot, rate limit, sanitisation, wp_mail. */
function aram_handle_contact() {
	$back = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	$back = remove_query_arg( 'aram_msg', $back );
	$go   = function ( $code ) use ( $back ) {
		wp_safe_redirect( add_query_arg( 'aram_msg', $code, $back ) . '#contact-form' );
		exit;
	};

	if ( ! isset( $_POST['aram_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['aram_contact_nonce'] ) ), 'aram_contact' ) ) { $go( 'invalid' ); }
	if ( ! empty( $_POST['aram_website'] ) ) { $go( 'ok' ); } // honeypot

	$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'x';
	$key = 'aram_rl_' . md5( $ip );
	if ( get_transient( $key ) ) { $go( 'slow' ); }

	$name    = sanitize_text_field( wp_unslash( isset( $_POST['aram_name'] ) ? $_POST['aram_name'] : '' ) );
	$email   = sanitize_email( wp_unslash( isset( $_POST['aram_email'] ) ? $_POST['aram_email'] : '' ) );
	$phone   = sanitize_text_field( wp_unslash( isset( $_POST['aram_phone'] ) ? $_POST['aram_phone'] : '' ) );
	$subject = sanitize_text_field( wp_unslash( isset( $_POST['aram_subject'] ) ? $_POST['aram_subject'] : '' ) );
	$message = sanitize_textarea_field( wp_unslash( isset( $_POST['aram_message'] ) ? $_POST['aram_message'] : '' ) );

	$bad_phone = $phone && ! preg_match( '/^[\d\s+\-()۰-۹]{7,20}$/u', $phone );
	if ( '' === $name || ! is_email( $email ) || '' === $subject || mb_strlen( $message ) < 10 || $bad_phone ) { $go( 'invalid' ); }

	$to      = aram_opt( 'contact_email' ) ? aram_opt( 'contact_email' ) : get_option( 'admin_email' );
	$headers = array( 'Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $name . ' <' . $email . '>' );
	$body    = "نام: $name\nایمیل: $email\nتلفن: $phone\n\n$message";
	$sent    = wp_mail( $to, '[' . get_bloginfo( 'name' ) . '] ' . $subject, $body, $headers );

	if ( $sent ) { set_transient( $key, 1, 30 ); }
	$go( $sent ? 'ok' : 'fail' );
}
add_action( 'admin_post_nopriv_aram_contact', 'aram_handle_contact' );
add_action( 'admin_post_aram_contact', 'aram_handle_contact' );
