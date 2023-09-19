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
    </head>

    <body id="page-top">
        <header class="masthead d-flex align-items-center">
            <div class="container px-4 px-lg-5 text-center">
                <h1 class="mb-1">WELCOME TO BLURRED</h1>
                <h3 class="mb-5"><em>Let's Start Take A Photo!</em></h3>
                <h4 class="mb-1 text-danger text-decoration-line-through" id="masterPrice"></h4>
                <h2 class="mb-1" id="fixedPrice"></h2>
                <h5 class="mb-5 text-success" id="promoCodeUsed"></h5>
                <a class="btn btn-primary btn-xl" id="startAndPay" style="font-size:35px;">START & PAY</a>
                <p class="modal-voucher text-danger mt-3" href="#" style="font-weight: bold;font-size:20px;cursor:pointer;">Apply Promo Code</p>
            </div>
        </header>
        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>
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
            let fixedPrice = masterPrice;
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
                                    if (usage >= qty) {
                                        Swal.fire('Gagal', 'Kode Promo Ini Sudah Tidak Valid', 'error');
                                    } else { 
                                        if(is_percentage) {
                                            let discountPrice = (masterPrice * amount) / 100;
                                            fixedPrice = masterPrice - discountPrice;
                                        } else { 
                                            fixedPrice = masterPrice - amount;
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
                window.location.href = `/payment?price=${fixedPrice}&masterPrice=${masterPrice}&promoId=${default_promo_id}&app_id=${appId}`
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
                        var masthead = document.querySelector('.masthead');
                        let imageUrl = `${api_url}/images/` + data?.homepage_image;
                        masthead.style.backgroundImage = 'linear-gradient(90deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.1) 100%), url("' + imageUrl + '")';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
            $(document).ready(function() {
                fetchSettings()
            });
        </script>
        
    </body>
</html>
