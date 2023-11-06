<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>BLURRED</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Simple line icons-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css" rel="stylesheet" />
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <style>
        /* Ganti ukuran dan posisi dari left tab */
        .col-md-3 {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background-color: rgba(255, 255, 255, 0.5); /* Atur ke transparan */
        }

        .nav.flex-column {
            flex-direction: row;
            justify-content: space-around;
            align-items: center;
            height: 100px; /* Atur tinggi sesuai kebutuhan */
        }

        .nav-link {
            padding: 10px 20px;
            margin: 5px;
        }

        /* Sesuaikan warna dan gaya menu Anda */
        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.7);
        }

        /* Atur agar konten di kanan tampil di bawah menu */
        .col-md-9 {
            margin-left: 0%; /* Atur margin kiri sesuai dengan lebar left tab */
        }
    </style>
</head>

<body id="page-top">
    <!-- Tab section -->
    <div class="container-fluid">
        <div class="row">
            <!-- Left Tabs -->
            <div class="col-md-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-payment-tab" data-bs-toggle="pill" href="#v-pills-payment" role="tab" aria-controls="v-pills-payment" aria-selected="true">Payment</a>
                    <a class="nav-link" id="v-pills-frame-tab" data-bs-toggle="pill" href="#v-pills-frame" role="tab" aria-controls="v-pills-how-to-use" aria-selected="false">Frame</a>
                    <a class="nav-link" id="v-pills-how-to-use-tab" data-bs-toggle="pill" href="#v-pills-how-to-use" role="tab" aria-controls="v-pills-how-to-use" aria-selected="false">How To Use</a>
                    <a class="nav-link" id="v-pills-contact-us-tab" data-bs-toggle="pill" href="#v-pills-contact-us" role="tab" aria-controls="v-pills-contact-us" aria-selected="false">Contact Us</a>
                    <div class="mt-5"></div>
                    <a class="nav-link" id="v-pills-test-camera-tab" data-bs-toggle="pill" href="#v-pills-test-camera" role="tab" aria-controls="v-pills-test-camera" aria-selected="false">Test Camera</a>
                </div>
            </div>

            <!-- Right Tab -->
            <div class="col-md-12">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-payment" role="tabpanel" aria-labelledby="v-pills-payment-tab">
                        <header class="masthead d-flex align-items-center" id="paymentPage">
                            <div class="container px-4 px-lg-5 text-center" style="margin-top:180px;">
                                <h4 class="mb-1 text-danger text-decoration-line-through" id="masterPrice"></h4>
                                <h2 class="mb-1" id="fixedPrice"></h2>
                                <h5 class="mb-5 text-success" id="promoCodeUsed"></h5>
                                <a class="btn btn-primary btn-xl" id="startAndPay" style="font-size:35px;">START & PAY</a>
                                <p class="modal-voucher mt-3" href="#" style="font-weight: bold;font-size:20px;cursor:pointer;color:blue">Apply Promo Code</p>
                            </div>
                        </header>
                    </div>
                    <div class="tab-pane fade" id="v-pills-frame" role="tabpanel" aria-labelledby="v-pills-frame-tab">
                        <header class="masthead d-flex align-items-center" id="frame">
                            <div class="container px-4 px-lg-5 text-center">
                            </div>
                        </header>
                    </div>
                    <div class="tab-pane fade" id="v-pills-how-to-use" role="tabpanel" aria-labelledby="v-pills-how-to-use-tab">
                        <header class="masthead d-flex align-items-center" id="howToUse">
                            <div class="container px-4 px-lg-5 text-center">
                            </div>
                        </header>
                    </div>
                    <div class="tab-pane fade" id="v-pills-contact-us" role="tabpanel" aria-labelledby="v-pills-contact-us-tab">
                        <header class="masthead d-flex align-items-center" id="contact">
                            <div class="container px-4 px-lg-5 text-center">
                            </div>
                        </header>
                    </div>
                    <div class="tab-pane fade" id="v-pills-test-camera" role="tabpanel" aria-labelledby="v-pills-test-camera">
                        <header class="masthead d-flex align-items-center" id="test-camera">
                            <video id="videoElement" autoplay style="width: 100%"></video>
                        </header>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script>
            const api_url ="{{ env('API_URL') }}";
            const appId ="{{ env('APP_ID') }}";
            function formatRupiah(angka, prefix){
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split   		= number_string.split(','),
                sisa     		= split[0].length % 3,
                rupiah     		= split[0].substr(0, sisa),
                ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
    
                // tambahkan titik jika yang di input sudah menjadi angka ribuan
                if(ribuan){
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }
    
                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
            }
            // Fungsi untuk menampilkan modal SweetAlert2 saat tombol diklik
            let masterPrice = 1000000;
            
            $("#fixedPrice").text(formatRupiah(masterPrice.toString(), 'Rp'));
            let default_promo_code = ""
            let default_promo_id = null
            let fixedPrice = parseInt(masterPrice);
            document.querySelector('.modal-voucher').addEventListener('click', function () {
                Swal.fire({
                    title: 'Apply Promo Code',
                    html: `<input id="promoCode" class="swal2-input" placeholder="Masukkan Kode Promo" value="${default_promo_code}">`,
                    showCancelButton: true,
                    confirmButtonText: 'Apply',
                    preConfirm: () => {
                        const promoCode = document.getElementById('promoCode').value;
                        return fetch(`${api_url}/api/vouchers/check/${promoCode}?app_id=${appId}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    const { id, amount, qty, usage, is_percentage, promo_name, promo_code } = data.data
                                    if (parseInt(usage) >= parseInt(qty)) {
                                        Swal.fire('Gagal', 'Kode Promo Ini Sudah Tidak Valid', 'error');
                                    } else { 
                                        if(parseInt(is_percentage) == 1) {
                                            let discountPrice = (parseInt(masterPrice) * parseInt(amount)) / 100;
                                            fixedPrice = parseInt(masterPrice) - parseInt(discountPrice);
                                        } else { 
                                            fixedPrice = parseInt(masterPrice) - parseInt(amount);
                                        }
                                        $("#masterPrice").text(formatRupiah(masterPrice.toString(), 'Rp'));
                                        $("#fixedPrice").text(formatRupiah(fixedPrice.toString(), 'Rp'));
                                        $("#promoCodeUsed").text(`(${promo_code})`)
                                        default_promo_code = promo_code;
                                        default_promo_id = id;

                                        Swal.fire('Sukses', `Harga sekarang: ${formatRupiah(fixedPrice.toString())}`, 'success');
                                    }
                                } else {
                                    Swal.fire('Gagal', 'Kode promo tidak valid', 'error');
                                }
                            })
                            .catch(error => {
                                Swal.fire('Error', 'Terjadi kesalahan saat menghubungi server', 'error');
                            });
                    }
                });
            });
            $("#startAndPay").click(function(){
                let url = `/payment?price=${fixedPrice}&masterPrice=${masterPrice}&promoId=${default_promo_id}&app_id=${appId}`
                if(fixedPrice <= 0){
                    url = `/payment_voucher?price=${fixedPrice}&masterPrice=${masterPrice}&promoId=${default_promo_id}&app_id=${appId}`
                }
                window.location.href = url;
            });
            
            function fetchSettings() {
                fetch(`${api_url}/api/settings/${appId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Terjadi kesalahan saat memuat data.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        masterPrice = parseFloat(data?.master_price) ?? 25000
                        fixedPrice = masterPrice;
                        $("#fixedPrice").text(formatRupiah(masterPrice.toString(), 'Rp'));
                        var paymentPage = document.querySelector('#paymentPage');
                        
                        let paymentImage, frameImage, howToUseImage, contactImage;

                        for (let i = 0; i < data.templates.length; i++) {
                            if (data.templates[i].TYPE === "payment") {
                                paymentImage = `${api_url}/images/` + data.templates[i].image;
                            } else if (data.templates[i].TYPE === "frame") {
                                frameImage = `${api_url}/images/` + data.templates[i].image;
                            } else if (data.templates[i].TYPE === "how_to_use") {
                                howToUseImage = `${api_url}/images/` + data.templates[i].image;
                            } else if (data.templates[i].TYPE === "contact") {
                                contactImage =`${api_url}/images/` +  data.templates[i].image;
                            }
                        }
                        let imageUrl = `${api_url}/images/` + data?.homepage_image;
                        paymentPage.style.backgroundImage = 'linear-gradient(90deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.1) 100%), url("' + paymentImage + '")';
                        var howTouse = document.querySelector('#howToUse');
                        howTouse.style.backgroundImage = 'linear-gradient(90deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.1) 100%), url("' + howToUseImage + '")';
                        var frame = document.querySelector('#frame');
                        frame.style.backgroundImage = 'linear-gradient(90deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.1) 100%), url("' + frameImage + '")';
                        var contact = document.querySelector('#contact');
                        contact.style.backgroundImage = 'linear-gradient(90deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.1) 100%), url("' + contactImage + '")';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
            $(document).ready(function() {
                fetchSettings()
            });
        </script>
        <script>
            // Menangkap elemen video
            var video = document.querySelector("#videoElement");
    
            // Mencoba mendapatkan akses kamera pengguna
            if (navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({ video: true })
                    .then(function (stream) {
                        video.srcObject = stream;
                    })
                    .catch(function (err0r) {
                        console.log("Something went wrong!");
                    });
            }
        </script>
        
    </body>
</html>
