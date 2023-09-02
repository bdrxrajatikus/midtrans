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
                <h4 class="mb-1 text-danger text-decoration-line-through">IDR48.000</h4>
                <h2 class="mb-5">IDR28.000</h2>
                <a class="btn btn-primary btn-xl" href="/payment" style="font-size:35px;">START & PAY</a>
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
            // Fungsi untuk menampilkan modal SweetAlert2 saat tombol diklik
            document.querySelector('.modal-voucher').addEventListener('click', function () {
                Swal.fire({
                    title: 'Apply Promo Code',
                    html: '<input id="promoCode" class="swal2-input" placeholder="Masukkan Kode Promo">',
                    showCancelButton: true,
                    confirmButtonText: 'Apply',
                    preConfirm: () => {
                        const promoCode = document.getElementById('promoCode').value;
                        return fetch(`http://cek-harga.com/api/price?promo=${promoCode}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire('Sukses', `Harga sekarang: ${data.price}`, 'success');
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
        </script>
        
    </body>
</html>
