/**
* 2007-2022 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2022 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/
function flSlider(idSlider) { 
    let nextBtn = document.querySelector("#"+idSlider+" .navs .next"),
        prevBtn = document.querySelector("#"+idSlider+" .navs .prev"),
        slide = document.querySelectorAll("#"+idSlider+" .slides .block"),
        i = 0;

    prevBtn.onclick = (event) => {
        event.preventDefault();
        slide[i].classList.remove("active");
        i--;

        if (i < 0) {
            i = slide.length - 1;
        }
        slide[i].classList.add("active");
    };

    nextBtn.onclick = (event) => {
        event.preventDefault();
        slide[i].classList.remove("active");
        i++;

        if (i >= slide.length) {
            i = 0;
        }

        slide[i].classList.add("active");
    };

    slider_callback();
    let sliderInterval = window.setInterval(slider_callback, 3000);

    function slider_callback() {
        nextBtn.click();
    }
}

const flSliders = document.querySelectorAll(".fl-slider");
if (flSliders.length > 0) {
    flSliders.forEach(sl => {
        flSlider(sl.id);
    });
}