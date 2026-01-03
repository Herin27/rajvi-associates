<?php
include('db.php');
// Fetch the latest slider
$result = mysqli_query($conn, "SELECT * FROM sliders ORDER BY id DESC LIMIT 1");
$row = mysqli_fetch_assoc($result);

// Default values if database is empty
$title = $row['title'] ?? "Exclusive Designs";
$subtitle = $row['subtitle'] ?? "Handpicked for You";
$image = $row['image_path'] ?? "./assets/image/hero.jpg";
?>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

<style>
.swiper {
    width: 100%;
    height: 90vh;
}



/* Gradient Overlay for better text readability */
.overlay {
    background: linear-gradient(to right, rgba(0, 0, 0, 0.50) 20%, rgba(0, 0, 0, 0.1) 100%);
}

/* Custom Pagination Style */
.swiper-pagination-bullet {
    background: #ffffff !important;
    opacity: 0.5;
    transition: all 0.3s ease;
}

.swiper-pagination-bullet-active {
    background: #ca8a04 !important;
    width: 35px !important;
    border-radius: 5px !important;
    opacity: 1;
}
</style>

<div class="swiper mySwiper">
    <div class="swiper-wrapper">
        <?php
        include('db.php');
        $result = mysqli_query($conn, "SELECT * FROM sliders ORDER BY id DESC");
        
        while($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="swiper-slide bg-black">
            <div class="absolute inset-0 z-0">
                <img src="<?php echo $row['image_path']; ?>" class="w-full h-full object-cover opacity-50">
                <div class="absolute inset-0 overlay"></div>
            </div>

            <div class="relative z-10 flex flex-col justify-center h-full px-12 md:px-32">
                <div class="slider-content overflow-hidden">
                    <div
                        class="flex items-center gap-2 bg-yellow-600/20 border border-yellow-600/50 w-fit px-4 py-1 rounded-full mb-6 animate__animated animate__fadeInDown">
                        <span class="text-yellow-500 text-xs font-bold uppercase tracking-[3px]">Luxury
                            Collection</span>
                    </div>
                </div>

                <h1 class="text-6xl md:text-72px font-serif font-bold text-white mb-4 animate__animated animate__fadeInLeft"
                    style="animation-delay: 0.3s;">
                    <?php echo $row['title']; ?>
                </h1>

                <h2 class="text-2xl md:text-20px font-serif text-yellow-500 mb-8 italic animate__animated animate__fadeInLeft"
                    style="animation-delay: 0.6s;">
                    <?php echo $row['subtitle']; ?>
                </h2>

                <div class="flex gap-5 animate__animated animate__fadeInUp" style="animation-delay: 0.9s;">
                    <a href="#"
                        class="group relative overflow-hidden bg-yellow-500 text-white px-10 py-4 rounded-full font-bold transition-all hover:pr-12">
                        <span class="relative z-10">Explore Now</span>
                        <i
                            class="fa fa-arrow-right absolute right-4 opacity-0 group-hover:opacity-100 transition-all"></i>
                    </a>
                    <a href="https://wa.me/yournumber"
                        class="backdrop-blur-md border border-white/30 hover:bg-white hover:text-black text-white px-10 py-4 rounded-full font-bold transition-all">
                        Get Inquiry
                    </a>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>

    <!-- <div class="swiper-button-next text-white/50 hover:text-yellow-500 transition px-10 hidden md:flex"></div>
    <div class="swiper-button-prev text-white/50 hover:text-yellow-500 transition px-10 hidden md:flex"></div> -->

    <div class="swiper-pagination"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://kit.fontawesome.com/your-code.js"></script>

<script>
var swiper = new Swiper(".mySwiper", {
    loop: true,
    effect: "fade", // Smooth Fade transition
    speed: 1000, // Transition speed (1 second)
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    // on: {
    //     slideChangeTransitionStart: function() {
    //         // Re-trigger animations on slide change
    //         document.querySelectorAll('.animate__animated').forEach((el) => {
    //             el.style.visibility = 'hidden';
    //         });
    //     },
    //     slideChangeTransitionEnd: function() {
    //         document.querySelectorAll('.animate__animated').forEach((el) => {
    //             el.style.visibility = 'visible';
    //         });
    //     }
    // }
});
</script>