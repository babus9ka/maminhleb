<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();
?>
<footer class="mt-auto">
	<div class="border-t bg-white py-8 dark:border-gray-800 dark:bg-black" bis_skin_checked="1">
		<div class="desktop-container space-y-6 px-4" bis_skin_checked="1">
			<div class="flex items-center justify-center gap-8" bis_skin_checked="1">
				<a aria-current="page" href="<?= SITE_DIR ?>"
					class="router-link-active router-link-exact-active shrink-0"><img img
						src="<?= SITE_TEMPLATE_PATH ?>/assets/1644306968czentr.png" alt="Мамин хлеб | Брест"
						class="max-h-14 rounded-sm" /></a>

				<div class="flex flex-wrap gap-2.5" bis_skin_checked="1">
					<a href="https://vk.com/maminhleb" rel="noopener noreferrer" target="_blank"
						class="transition hover:scale-105">
						<img style="width: 40px;" src="<?= SITE_TEMPLATE_PATH ?>/assets/instagram.png"
							alt="instagram" />
					</a>
				</div>
				<div class="flex flex-col gap-1" bis_skin_checked="1">
					<a href="" rel="noopener noreferrer" target="_blank"
						class="text-sm text-gray-500 underline underline-offset-2 transition hover:text-primary dark:text-gray-500">Политика
						конфиденциальности</a>
				</div>
			</div>
			<div class="text-center" bis_skin_checked="1">
				<div class="text-xs text-gray-400 dark:text-gray-400" bis_skin_checked="1">

					<p>Мамин хлеб © 2025</p>
				</div>
			</div>
		</div>
	</div>
</footer>
<!---->
</div>
</div>
</div>
<div id="teleports" bis_skin_checked="1"></div>




<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<!-- jQuery 1.7.2+ or Zepto.js 1.0+ -->
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
<!-- Magnific Popup core JS file -->
<script src="<?= SITE_TEMPLATE_PATH ?>/js/jquery.magnific-popup.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/js/main.js"></script>
<!-- Инициализация Swiper с необходимыми параметрами -->
<script>
	var swiper = new Swiper(".mySwiper", {
		slidesPerView: 4,  // Показывать 4 слайда одновременно
		spaceBetween: 10,  // Расстояние между слайдами (по желанию, можно настроить)
		navigation: {
			nextEl: ".swiper-button-next",
			prevEl: ".swiper-button-prev",
		},
	});
</script>

<script>
	var swiper = new Swiper(".swiper-container", {
		slidesPerView: 2,
		centeredSlides: true,
		spaceBetween: 30,
		grabCursor: true,
		initialSlide: 1, // Номер начального слайда (нумерация начинается с 0)
		pagination: {
			el: ".swiper-pagination",
			clickable: true,
		},
	});
</script>

<script>
	document.querySelectorAll('.section_catalog_from_scroll').forEach(anchor => {
		anchor.addEventListener('click', function (e) {
			e.preventDefault(); // Предотвращаем стандартное поведение ссылки
			const targetId = this.getAttribute('href').replace('#', '');
			const targetElement = document.getElementById(targetId);

			if (targetElement) {
				targetElement.scrollIntoView({
					behavior: 'smooth', // Плавный скролл
					block: 'start', // Скроллить к верхней границе элемента
				});

				// Если нужно скорректировать позицию:
				const offset = -100; // Сдвиг на 50px вверх
				const y = targetElement.getBoundingClientRect().top + window.scrollY + offset;
				window.scrollTo({ top: y, behavior: 'smooth' });
			}
		});
	});

</script>


</body>

</html>