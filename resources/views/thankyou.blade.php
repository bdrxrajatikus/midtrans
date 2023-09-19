<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href='https://fonts.googleapis.com/css?family=Lato:300,400|Montserrat:700' rel='stylesheet' type='text/css'>
    <style>
        @import url(//cdnjs.cloudflare.com/ajax/libs/normalize/3.0.1/normalize.min.css);
        @import url(//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css);
    </style>
    <link rel="stylesheet" href="https://2-22-4-dot-lead-pages.appspot.com/static/lp918/min/default_thank_you.css">
    <script src="https://2-22-4-dot-lead-pages.appspot.com/static/lp918/min/jquery-1.9.1.min.js"></script>
    <script src="https://2-22-4-dot-lead-pages.appspot.com/static/lp918/min/html5shiv.js"></script>
    <script>
        // Fungsi untuk mengalihkan ke homepage setelah countdown selesai
        function redirectHomepage() {
            window.location.href = "/"; // Ganti dengan URL homepage yang sesuai
        }

        // Fungsi untuk memulai countdown
        function startCountdown() {
            var countdown = 5; // Waktu dalam detik
            var countdownElement = document.getElementById("countdown");

            function updateCountdown() {
                countdownElement.innerHTML = countdown;
                countdown--;

                if (countdown < 0) {
                    redirectHomepage();
                } else {
                    setTimeout(updateCountdown, 1000);
                }
            }

            updateCountdown();
        }

        // Memulai countdown saat dokumen selesai dimuat
        document.addEventListener("DOMContentLoaded", startCountdown);
    </script>
</head>
<body>
    <header class="site-header" id="header">
        <h1 class="site-header__title" data-lead-id="site-header-title">THANK YOU!</h1>
    </header>

    <div class="main-content">
        <i class="fa fa-check main-content__checkmark" id="checkmark"></i>
        <p class="main-content__body" data-lead-id="main-content-body">Thank you so much for being one of the individuals who are trying to make a difference. We hope you stay healthy always, just like you! We really appreciate you taking a moment of your time today. Thanks for being yourself.</p>
    </div>

    <!-- Countdown akan muncul di bawah konten -->
    <div id="countdown" style="text-align: center; font-size: 24px; margin-top: 20px;"></div>

    <footer class="site-footer" id="footer">
        <p class="site-footer__fineprint" id="fineprint">Copyright @2023 | All Rights Reserved</p>
    </footer>
</body>
</html>
