"use strict";!function(){const e=document.getElementById("slider-pricing"),t=document.getElementById("swiper-clients-logos"),i=document.getElementById("swiper-reviews");screen.width>="1200"&&document.addEventListener("mousemove",(function(e){this.querySelectorAll(".animation-img").forEach((t=>{let i=t.getAttribute("data-speed"),n=(window.innerWidth-e.pageX*i)/100,r=(window.innerWidth-e.pageY*i)/100;t.style.transform=`translate(${n}px, ${r}px)`}))})),e&&noUiSlider.create(e,{start:[458],step:1,connect:[!0,!1],behaviour:"tap-drag",direction:isRtl?"rtl":"ltr",tooltips:[{to:function(e){return parseFloat(e).toLocaleString("en-EN",{minimumFractionDigits:0})+"+"}}],range:{min:0,max:916}}),i&&new Swiper(i,{slidesPerView:1,spaceBetween:5,centeredSlides:!0,grabCursor:!0,autoplay:{delay:3e3,disableOnInteraction:!1},loop:!0,loopAdditionalSlides:1,pagination:{el:".swiper-pagination",clickable:!0},breakpoints:{992:{slidesPerView:4,spaceBetween:20},768:{slidesPerView:2,spaceBetween:20}}}),t&&new Swiper(t,{slidesPerView:2,autoplay:{delay:3e3,disableOnInteraction:!1},breakpoints:{992:{slidesPerView:5},768:{slidesPerView:3}}})}();