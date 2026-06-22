<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>UniTour Virtual Tour</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css"/>

<style>
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:'Segoe UI',Tahoma,Arial,sans-serif;
}

body{
  background:#071722;
  overflow:hidden;
  color:white;
}

/* ================= INTRO ================= */

.intro{
  position:fixed;
  inset:0;
  z-index:9999;
  background:
    linear-gradient(rgba(7,23,34,.72),rgba(7,23,34,.84)),
    url("images/building.jpg") center/cover no-repeat;
  display:flex;
  align-items:center;
  justify-content:center;
  padding:18px;
}

.intro-card{
  width:min(90vw,520px);
  background:rgba(7,23,34,.68);
  border:1px solid rgba(255,255,255,.12);
  backdrop-filter:blur(14px);
  border-radius:28px;
  display:flex;
  flex-direction:column;
  align-items:center;
  justify-content:center;
  padding:24px;
  box-shadow:0 10px 35px rgba(0,0,0,.35);
}

.intro-logo{
  width:165px;
  margin-bottom:14px;
}

.video-box{
  text-align:center;
  width:100%;
}

.video-box p{
  font-size:14px;
  line-height:1.8;
  color:#d9eef2;
  margin-bottom:16px;
}

.video-frame{
  width:310px;
  height:430px;
  margin:auto;
  border-radius:24px;
  overflow:hidden;
  border:2px solid rgba(255,255,255,.12);
  background:#000;
}

.video-frame video{
  width:100%;
  height:100%;
  object-fit:cover;
  background:#000;
}

.start-btn{
  margin-top:16px;
  border:none;
  border-radius:30px;
  background:linear-gradient(135deg,#19c6d8,#1186a0);
  color:white;
  padding:12px 34px;
  cursor:pointer;
  font-size:15px;
  font-weight:bold;
  transition:.3s;
}

.start-btn:hover{
  transform:scale(1.04);
}

/* ================= TOUR ================= */

.tour{
  display:none;
}

.swiper{
  width:100vw;
  height:100vh;
}

.swiper-slide{
  position:relative;
}

.scene{
  width:100%;
  height:100%;
  object-fit:cover;
}

.top-logo{
  position:fixed;
  top:12px;
  left:50%;
  transform:translateX(-50%);
  z-index:1000;
  background:rgba(7,23,34,.60);
  border:1px solid rgba(66,216,213,.18);
  backdrop-filter:blur(10px);
  border-radius:20px;
  padding:8px 18px;
}

.top-logo img{
  width:145px;
  display:block;
}


.language-switch{
  position:fixed;
  top:14px;
  left:18px;
  z-index:1000;
  display:flex;
  gap:6px;
  background:rgba(7,23,34,.56);
  padding:5px;
  border-radius:20px;
  backdrop-filter:blur(8px);
}

.language-switch button{
  border:none;
  background:rgba(255,255,255,.08);
  color:white;
  padding:6px 13px;
  border-radius:16px;
  cursor:pointer;
  font-size:12px;
  transition:.3s;
}

.language-switch button.active{
  background:#19c6d8;
  color:#071722;
  font-weight:bold;
}


.category-menu{
  position:fixed;
  top:74px;
  left:50%;
  transform:translateX(-50%);
  z-index:999;
  display:flex;
  gap:5px;
  max-width:65vw;
  overflow-x:auto;
  background:rgba(7,23,34,.50);
  border:1px solid rgba(66,216,213,.12);
  backdrop-filter:blur(8px);
  padding:5px;
  border-radius:18px;
}

.category-menu::-webkit-scrollbar{
  display:none;
}

.category-menu button{
  border:none;
  background:rgba(255,255,255,.08);
  color:white;
  padding:6px 12px;
  border-radius:14px;
  cursor:pointer;
  white-space:nowrap;
  font-size:11px;
  transition:.3s;
}

.category-menu button:hover{
  background:#19c6d8;
  color:#071722;
}



.place-title{
  position:fixed;
  top:118px;
  right:18px;
  z-index:999;
  background:rgba(7,23,34,.60);
  border:1px solid rgba(66,216,213,.14);
  backdrop-filter:blur(8px);
  padding:9px 16px;
  border-radius:16px;
  font-size:15px;
  font-weight:bold;
}



.controls{
  position:fixed;
  bottom:18px;
  right:18px;
  z-index:999;
  display:flex;gap:6px;
  background:rgba(7,23,34,.58);
  border:1px solid rgba(66,216,213,.14);
  backdrop-filter:blur(8px);
  padding:7px;
  border-radius:24px;
}

.controls button{
  width:36px;
  height:36px;
  border:none;
  border-radius:50%;
  background:rgba(255,255,255,.10);
  color:white;
  font-size:17px;
  cursor:pointer;
  transition:.3s;
}

.controls button:hover{
  background:#19c6d8;
  color:#071722;
}

.home-btn{
  background:#19c6d8 !important;
  color:#071722 !important;
  font-weight:bold;
}



.counter{
  position:fixed;
  left:18px;
  bottom:18px;
  z-index:999;
  background:rgba(7,23,34,.58);
  border:1px solid rgba(66,216,213,.12);
  padding:7px 13px;
  border-radius:16px;
  font-size:12px;
}


@media(max-width:900px){
  .intro-card{
    width:92vw;
    padding:20px;
  }

  .intro-logo{
    width:140px;
  }

  .video-frame{
    width:250px;
    height:390px;
  }

  .top-logo img{
    width:120px;
  }

  .category-menu{
    max-width:78vw;
    top:70px;
  }

  .category-menu button{
    font-size:10px;
    padding:6px 9px;
  }

  .place-title{
    top:110px;
    font-size:13px;
  }
}
</style>
</head>

<body>

<div class="intro" id="intro">
  <div class="intro-card">

    <img class="intro-logo" src="images/unitour_v2.png" alt="UniTour">

    <div class="video-box">
      <p data-ar="اكتشفي مرافق الكلية التطبيقية بطريقة تفاعلية ومنظمة" data-en="Explore the Applied College facilities interactively">
        اكتشفي مرافق الكلية التطبيقية بطريقة تفاعلية ومنظمة
      </p>

      <div class="video-frame">
        <video autoplay muted controls playsinline id="introVideo">
          <source src="videos/intro.MP4" type="video/mp4">
        </video>
      </div>

      <button class="start-btn" onclick="startTour()" data-ar="ابدأ الجولة" data-en="Start Tour">
        ابدأ الجولة
      </button>
    </div>

  </div>
</div>


<section class="tour" id="tour">

  <div class="swiper mySwiper">
    <div class="swiper-wrapper">

      <div class="swiper-slide" data-ar="المدخل الرئيسي" data-en="Main Entrance">
        <img class="scene" src="images/building.jpg" alt="Main Entrance">
      </div>

      <div class="swiper-slide" data-ar="الممر الخارجي" data-en="Outdoor Pathway">
        <img class="scene" src="images/pathway1.jpg" alt="Outdoor Pathway">
      </div>

      <div class="swiper-slide" data-ar="البهو الرئيسي" data-en="Main Lobby">
        <img class="scene" src="images/lobby1.jpg" alt="Main Lobby">
      </div>

      <div class="swiper-slide" data-ar="البهو الرئيسي" data-en="Main Lobby">
        <img class="scene" src="images/lobby2.jpg" alt="Main Lobby">
      </div>

      <div class="swiper-slide" data-ar="البهو الرئيسي" data-en="Main Lobby">
        <img class="scene" src="images/lobby3.jpg" alt="Main Lobby">
      </div>

      <div class="swiper-slide" data-ar="البهو الرئيسي" data-en="Main Lobby">
        <img class="scene" src="images/lobby4.jpg" alt="Main Lobby">
      </div>

      <div class="swiper-slide" data-ar="البهو الرئيسي" data-en="Main Lobby">
        <img class="scene" src="images/lobby5.jpg" alt="Main Lobby">
      </div>

      <div class="swiper-slide" data-ar="المكتبة" data-en="Library">
        <img class="scene" src="images/library1.jpg" alt="Library">
      </div>

      <div class="swiper-slide" data-ar="المكتبة" data-en="Library">
        <img class="scene" src="images/library2.jpg" alt="Library">
      </div>

      <div class="swiper-slide" data-ar="المكتبة" data-en="Library">
        <img class="scene" src="images/library3.jpg" alt="Library">
      </div>

      <div class="swiper-slide" data-ar="معمل الحاسب" data-en="Computer Lab">
        <img class="scene" src="images/cs1.jpg" alt="Computer Lab">
      </div>

      <div class="swiper-slide" data-ar="معمل الحاسب" data-en="Computer Lab">
        <img class="scene" src="images/cs2.jpg" alt="Computer Lab">
      </div><div class="swiper-slide" data-ar="المعامل" data-en="Labs">
        <img class="scene" src="images/lab1.jpg" alt="Labs">
      </div>

      <div class="swiper-slide" data-ar="المعامل" data-en="Labs">
        <img class="scene" src="images/lab2.jpg" alt="Labs">
      </div>

      <div class="swiper-slide" data-ar="المعامل" data-en="Labs">
        <img class="scene" src="images/lab3.jpg" alt="Labs">
      </div>

      <div class="swiper-slide" data-ar="المعامل" data-en="Labs">
        <img class="scene" src="images/lab4.jpg" alt="Labs">
      </div>

      <div class="swiper-slide" data-ar="القاعات الدراسية" data-en="Classrooms">
        <img class="scene" src="images/class.jpg" alt="Classrooms">
      </div>

      <div class="swiper-slide" data-ar="القاعات الدراسية" data-en="Classrooms">
        <img class="scene" src="images/class1.jpg" alt="Classrooms">
      </div>

      <div class="swiper-slide" data-ar="القاعات الدراسية" data-en="Classrooms">
        <img class="scene" src="images/class2.jpg" alt="Classrooms">
      </div>

      <div class="swiper-slide" data-ar="القاعات الدراسية" data-en="Classrooms">
        <img class="scene" src="images/class3.jpg" alt="Classrooms">
      </div>

      <div class="swiper-slide" data-ar="الكافتيريا" data-en="Cafeteria">
        <img class="scene" src="images/cafe1.jpg" alt="Cafeteria">
      </div>

      <div class="swiper-slide" data-ar="الكافتيريا" data-en="Cafeteria">
        <img class="scene" src="images/cafe2.jpg" alt="Cafeteria">
      </div>

      <div class="swiper-slide" data-ar="الكافتيريا" data-en="Cafeteria">
        <img class="scene" src="images/cafe3.jpg" alt="Cafeteria">
      </div>

      <div class="swiper-slide" data-ar="الكافتيريا" data-en="Cafeteria">
        <img class="scene" src="images/cafe4.jpg" alt="Cafeteria">
      </div>

    </div>
  </div>

  <div class="top-logo">
    <img src="images/unitour_v2.png" alt="UniTour">
  </div>

  <div class="language-switch">
    <button id="enBtn" onclick="setLang('en')">English</button>
    <button id="arBtn" class="active" onclick="setLang('ar')">عربي</button>
  </div>

  <div class="category-menu">
    <button onclick="goTo(0)" data-ar="المدخل" data-en="Entrance">المدخل</button>
    <button onclick="goTo(1)" data-ar="الممر" data-en="Pathway">الممر</button>
    <button onclick="goTo(2)" data-ar="البهو" data-en="Lobby">البهو</button>
    <button onclick="goTo(7)" data-ar="المكتبة" data-en="Library">المكتبة</button>
    <button onclick="goTo(10)" data-ar="الحاسب" data-en="Computer">الحاسب</button>
    <button onclick="goTo(12)" data-ar="المعامل" data-en="Labs">المعامل</button>
    <button onclick="goTo(16)" data-ar="القاعات" data-en="Classes">القاعات</button>
    <button onclick="goTo(20)" data-ar="الكافتيريا" data-en="Cafeteria">الكافتيريا</button>
  </div>

  <div class="place-title" id="placeTitle">المدخل الرئيسي</div>

  <div class="controls">
    <button onclick="swiper.slidePrev()">‹</button>
    <button onclick="toggleFullscreen()">⛶</button>
    <button class="home-btn" onclick="goHome()">⌂</button>
    <button onclick="swiper.slideNext()">›</button>
  </div>

  <div class="counter" id="counter">1 / 24</div>

</section>

<script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>

<script>
let currentLang = "ar";

const swiper = new Swiper(".mySwiper", {
  effect: "slide",
  speed: 350,
  grabCursor: true,
  keyboard: true,
  autoplay: false,
  loop: false,
  mousewheel: false,
  allowTouchMove: true,
  resistanceRatio: 0.4,
  touchRatio: 1
});

function startTour(){
  document.getElementById("intro").style.display = "none";
  document.getElementById("tour").style.display = "block";
  swiper.update();
  updateText();
}

function goHome(){
  document.getElementById("tour").style.display = "none";
  document.getElementById("intro").style.display = "flex";

  const video = document.getElementById("introVideo");
  video.pause();
  video.currentTime = 0;
}

function goTo(index){
  swiper.slideTo(index);
  updateText();
}

swiper.on("slideChange", updateText);function updateText(){
  const slides = document.querySelectorAll(".swiper-slide");
  const slide = slides[swiper.activeIndex];

  if(slide){
    document.getElementById("placeTitle").innerText =
      slide.getAttribute(currentLang === "ar" ? "data-ar" : "data-en");
  }

  document.getElementById("counter").innerText =
    (swiper.activeIndex + 1) + " / " + slides.length;
}

function setLang(lang){
  currentLang = lang;

  document.getElementById("arBtn").classList.toggle("active", lang === "ar");
  document.getElementById("enBtn").classList.toggle("active", lang === "en");

  document.querySelectorAll("[data-ar]").forEach(el => {
    if(!el.classList.contains("swiper-slide")){
      el.innerText = el.getAttribute(lang === "ar" ? "data-ar" : "data-en");
    }
  });

  updateText();
}

function toggleFullscreen(){
  if(!document.fullscreenElement){
    document.documentElement.requestFullscreen();
  }else{
    document.exitFullscreen();
  }
}

window.onload = function(){
  const params = new URLSearchParams(window.location.search);
  if(params.get("start") === "1"){
    startTour();
  }
}
</script>

</body>
</html>