<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function aram_defaults() {
	return array(
		'color_primary' => '#173B2D',
		'color_accent'  => '#D99145',
		'hero_title'    => 'خودت را بهتر بشناس، زندگی بهتری بساز!',
		'hero_text'     => 'با دوره‌های توسعه فردی و روانشناسی کاربردی، قدم‌به‌قدم به آرامش ذهن، اعتماد به نفس و رشد فردی برسید.',
		'hero_cta1'     => 'مشاهده دوره‌ها',
		'hero_cta2'     => 'آشنایی با من',
		'cta_title'     => 'مسیر رشد فردی خود را همین امروز شروع کنید!',
		'cta_text'      => 'با شرکت در دوره‌های تخصصی، قدمی بزرگ به سمت آرامش و موفقیت بردارید.',
		'about_short'   => 'متن نمونه: معرفی کوتاه خود را از مسیر «نمایش › شخصی‌سازی › آرام زیستن › درباره من» جایگزین کنید.',
		'about_philosophy' => 'متن نمونه: فلسفه کاری خود را اینجا بنویسید.',
		'about_education'  => "نمونه: عنوان مدرک و دانشگاه را جایگزین کنید\nنمونه: گواهینامه‌های حرفه‌ای را جایگزین کنید",
		'about_experience' => 'نمونه: سابقه کاری خود را جایگزین کنید',
		'about_expertise'  => "خودشناسی\nمدیریت استرس\nروابط سالم\nهوش هیجانی",
		'about_teaching'   => 'متن نمونه: شیوه تدریس خود را اینجا بنویسید.',
		'about_achievements' => 'نمونه: دستاوردهای واقعی خود را جایگزین کنید',
		'contact_email' => '', 'contact_phone' => '', 'contact_address' => '', 'contact_hours' => '', 'contact_map' => '',
		'social_instagram' => '', 'social_telegram' => '', 'social_whatsapp' => '', 'social_linkedin' => '',
		'footer_text'   => 'مسیر رشد فردی',
	);
}

function aram_opt( $key ) {
	$d = aram_defaults();
	return get_theme_mod( $key, isset( $d[ $key ] ) ? $d[ $key ] : '' );
}

function aram_customize( $wp_customize ) {
	$d = aram_defaults();
	$wp_customize->add_panel( 'aram', array( 'title' => __( 'آرام زیستن', 'aram-zist' ), 'priority' => 30 ) );
	$sections = array(
		'colors'  => array( 'رنگ‌ها', array( 'color_primary' => array( 'رنگ اصلی (سبز)', 'color' ), 'color_accent' => array( 'رنگ تأکید (نارنجی)', 'color' ) ) ),
		'hero'    => array( 'صفحه اصلی', array( 'hero_title' => array( 'عنوان', 'text' ), 'hero_text' => array( 'توضیح', 'textarea' ), 'hero_cta1' => array( 'متن دکمه اول', 'text' ), 'hero_cta2' => array( 'متن دکمه دوم', 'text' ), 'cta_title' => array( 'عنوان دعوت نهایی', 'text' ), 'cta_text' => array( 'متن دعوت نهایی', 'textarea' ) ) ),
		'about'   => array( 'درباره من', array( 'about_short' => array( 'معرفی کوتاه', 'textarea' ), 'about_philosophy' => array( 'فلسفه کاری', 'textarea' ), 'about_education' => array( 'تحصیلات و گواهینامه‌ها (هر خط یک مورد)', 'textarea' ), 'about_experience' => array( 'سوابق کاری (هر خط یک مورد)', 'textarea' ), 'about_expertise' => array( 'حوزه‌های تخصص (هر خط یک مورد)', 'textarea' ), 'about_teaching' => array( 'شیوه تدریس', 'textarea' ), 'about_achievements' => array( 'دستاوردها (هر خط یک مورد)', 'textarea' ) ) ),
		'contact' => array( 'تماس و شبکه‌های اجتماعی', array( 'contact_email' => array( 'ایمیل دریافت پیام‌ها', 'email' ), 'contact_phone' => array( 'تلفن', 'text' ), 'contact_address' => array( 'آدرس (اختیاری)', 'textarea' ), 'contact_hours' => array( 'ساعات کاری (هر خط یک مورد)', 'textarea' ), 'contact_map' => array( 'لینک embed نقشه (اختیاری)', 'url' ), 'social_instagram' => array( 'اینستاگرام', 'url' ), 'social_telegram' => array( 'تلگرام', 'url' ), 'social_whatsapp' => array( 'واتساپ', 'url' ), 'social_linkedin' => array( 'لینکدین', 'url' ), 'footer_text' => array( 'شعار فوتر', 'text' ) ) ),
	);
	foreach ( $sections as $sid => $sec ) {
		$wp_customize->add_section( 'aram_' . $sid, array( 'title' => $sec[0], 'panel' => 'aram' ) );
		foreach ( $sec[1] as $key => $f ) {
			$type = $f[1];
			$san  = 'color' === $type ? 'sanitize_hex_color' : ( 'email' === $type ? 'sanitize_email' : ( 'url' === $type ? 'esc_url_raw' : ( 'textarea' === $type ? 'sanitize_textarea_field' : 'sanitize_text_field' ) ) );
			$wp_customize->add_setting( $key, array( 'default' => $d[ $key ], 'sanitize_callback' => $san ) );
			if ( 'color' === $type ) {
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $key, array( 'label' => $f[0], 'section' => 'aram_' . $sid ) ) );
			} else {
				$wp_customize->add_control( $key, array( 'label' => $f[0], 'section' => 'aram_' . $sid, 'type' => $type ) );
			}
		}
	}
}
add_action( 'customize_register', 'aram_customize' );
