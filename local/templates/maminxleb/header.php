<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();
?>
<!DOCTYPE html>
<html class="light desktop" lang="ru" data-capo="">

<head>
	<? $APPLICATION->ShowHead(); ?>
	<title><? $APPLICATION->ShowTitle(); ?></title>
	<link rel="preconnect" href="https://fonts.googleapis.com/" />
	<link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/style.css">
	<link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/svg-icons.css">
	<link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/mask-image.css">

	<script type="text/javascript" src="http://code.jquery.com/jquery-3.0.0.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

	<!-- Magnific Popup core CSS file -->
	<link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/css/magnific-popup.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
	<script src="https://api-maps.yandex.ru/2.1/?apikey=84eaac21-a0f1-46e4-8faa-258382d17245&lang=ru_RU"
		type="text/javascript"></script>

</head>

<? $APPLICATION->ShowPanel(); ?>

<body style="background-color: var(--theme-background)">
	<div id="__nuxt" >
		<div >
			<div class="flex min-h-screen min-w-[900px] flex-col max-lg:[--sticky-top-offset:calc(var(--desktop-header-height)+var(--desktop-horizontal-menu-height))]"
				>
				<header class="sticky top-0 z-20">
					<div class="relative z-10 flex h-[--desktop-header-height] items-center border-b bg-white px-4 py-4 2xl:px-12 dark:border-gray-800 dark:bg-black"
						>
						<div class="desktop-container flex w-full items-center gap-3 xl:gap-8" >
							<div class="flex shrink-0 items-center gap-2" >
								<a aria-current="page" href="<?= SITE_DIR ?>"
									class="router-link-active router-link-exact-active min-w-14 max-w-36 shrink-0 lg:max-w-none">
									<img img src="<?= SITE_TEMPLATE_PATH ?>/assets/1644306968czentr.png"
										alt="Мамин хлеб | Брест" class="rounded-sm max-h-14" />
								</a>
							</div>
							<div class="grow" >
								<ul class="menu__list">
									<li><a href="">Акции</a></li>
									<li><a href="">Доставка и Оплата</a></li>
									<li><a href="">Контакты</a></li>
									<li><a href="">Статьи</a></li>
								</ul>
							</div>
							<div class="flex max-w-96 items-center gap-2" >
								<span class="iconify i-ri:time-line icon text-primary hidden xl:block"
									aria-hidden="true" style=""></span>
								<div class="space-y-1 truncate whitespace-nowrap" >
									<p class="text-xs leading-none text-gray-500 dark:text-gray-400">
										Время работы
									</p>
									<p class="text-sm !leading-none lg:text-base">
										9:30 — 20:30
									</p>
								</div>
							</div>
							<button data-state="closed" data-grace-area-trigger="" class="flex items-center gap-2">
								<a class="flex max-w-80 items-center gap-2 text-left" href="tel:+375297874411"
									target="_blank"><span
										class="iconify i-ri:phone-fill icon text-primary hidden xl:block"
										aria-hidden="true" style=""></span>
									<div class="space-y-1" >
										<p class="text-xs leading-none text-gray-500 dark:text-gray-400">
											Телефон
										</p>
										<p class="text-sm !leading-none lg:text-base">+375 (29) 787-44-11</p>
									</div>
								</a>
								<?
								if ($USER->IsAuthorized()) {
									?>
									<a href="/profile/"
										class="inline-flex border-gray-500 bg-white text-gray-900 hover:bg-gray-100 focus-visible:ring-gray-500/30 dark:border-gray-600 dark:bg-black dark:text-gray-300 dark:hover:bg-gray-900 disabled:cursor-not-allowed items-center justify-center px-4 py-3 text-center leading-none transition focus-visible:outline-none focus-visible:ring-4 disabled:opacity-50 h-11">
										<div class="w-full" >
											<div id="userButton" class="flex items-center gap-1.5" >
												<span style="font-size: 2.5rem;"
													class="iconify i-ri:account-circle-fill icon text-gray-600 dark:text-gray-500"
													aria-hidden="true"></span>
											</div>
										</div>
										<span class="iconify i-ri:loader-4-line icon absolute animate-spin"
											aria-hidden="true" style="display: none"></span>
									</a>
									<?
								} else {
									?>
									<a href="#authModal"
										class="inline-flex border-gray-500 bg-white text-gray-900 hover:bg-gray-100 focus-visible:ring-gray-500/30 dark:border-gray-600 dark:bg-black dark:text-gray-300 dark:hover:bg-gray-900 disabled:cursor-not-allowed items-center justify-center rounded-md border px-4 py-3 text-center leading-none transition focus-visible:outline-none focus-visible:ring-4 disabled:opacity-50 h-11  popup-modal authModalButton"
										type="button">
										<div class="w-full" >
											<div id="userButton" class="flex items-center gap-1.5" >
												<span
													class="iconify i-ri:account-circle-fill icon text-gray-600 dark:text-gray-500"
													aria-hidden="true"></span>
												<!-- <span class="hidden xl:inline">Войти</span> -->
											</div>
										</div>
										<span class="iconify i-ri:loader-4-line icon absolute animate-spin"
											aria-hidden="true" style="display: none"></span>
									</a>
									<?
								}
								?>

							</button>
						</div>
					</div>
				</header>

				<? $APPLICATION->IncludeComponent(
					"shelton:auth.registration",
					"",
					array()
				);
				?>