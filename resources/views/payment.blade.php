<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            background-color:rgb(53, 0, 68); /* Latar belakang hitam */
            color:rgb(0, 0, 0); /* Teks putih */
        }
        .container {
            max-width: 500px;
            margin-top: 50px;
            background:rgb(255, 255, 255); /* Latar belakang putih */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgb(83, 1, 99);
        }
        .btn-back {
            background-color: #6c757d;
            border: none;
        }
        .btn-primary {
            background-color: #6f42c1; /* Warna ungu untuk tombol */
            border: none;
        }
        .form-label {
            font-weight: bold;
        }
        .modal-content {
            background-color: #333333; /* Latar belakang modal hitam */
            color: #ffffff; /* Teks putih di modal */
        }
        .form-select, .form-control {
            background-color:rgb(248, 250, 248);
            color: #000;
        }
        .payment-details {
            margin-top: 20px;
            padding: 10px;
            background-color:rgb(255, 255, 255); /* Warna ungu */
            color: #000;
            border-radius: 8px;
            display: none; /* Menyembunyikan detail rekening awal */
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <h2 class="mb-4" style="color: #6f42c1;">Pembayaran</h2>

        <p><strong>Kursi yang Dipilih:</strong> {{ implode(', ', json_decode($booking->seats)) }}</p>
        <p><strong>Total Harga:</strong> Rp {{ number_format($booking->total_price) }}</p>

        <form id="paymentForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="booking_id" value="{{ $booking->id }}">

            <div class="mb-3">
                <label class="form-label">Metode Pembayaran:</label>
                <select name="payment_method" class="form-select" required>
                    <option value="bca">Bank BCA</option>
                    <option value="mandiri">Bank Mandiri</option>
                    <option value="ovo">OVO</option>
                    <option value="dana">DANA</option>
                </select>
            </div>

            <!-- Bagian untuk menampilkan nomor rekening berdasarkan metode pembayaran -->
            <div id="paymentDetails" style="display: none;">
    <span id="accountNumber"></span>
    <button id="copyButton" class="btn btn-outline-secondary" style="margin-left: 10px;">
        <i class="fas fa-copy"></i> Salin
    </button>
</div>


            <div class="mb-3">
                <label class="form-label">Upload Bukti Transfer:</label>
                <input type="file" name="proof_of_payment" accept="image/*" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Konfirmasi Pembayaran</button>
        </form>

        <!-- Tombol kembali ke halaman sebelumnya -->
        <button onclick="history.back()" class="btn btn-back w-100 mt-3">Kembali</button>
    </div>

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Pembayaran Diproses</h5>
                </div>
                <div class="modal-body text-center">
                    <p>Pembayaran Anda sedang diproses. Silakan tunggu konfirmasi dari Admin.</p>
                </div>
                <div class="modal-footer">
                    <a href="/" class="btn btn-success w-100">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Fungsi untuk menampilkan nomor rekening sesuai dengan metode pembayaran yang dipilih
      // Fungsi untuk menampilkan nomor rekening sesuai dengan metode pembayaran yang dipilih
$("select[name='payment_method']").change(function() {
    var paymentMethod = $(this).val();
    var accountNumber = '';

    if (paymentMethod === 'bca') {
        accountNumber = 'Nomor Rekening : 123-456-7890';
    } else if (paymentMethod === 'mandiri') {
        accountNumber = 'Nomor Rekening : 987-654-3210';
    } else if (paymentMethod === 'ovo') {
        accountNumber = 'Nomor Rekening : 0812-3456-7890';
    } else if (paymentMethod === 'dana') {
        accountNumber = 'Nomor Rekening : 0812-9876-5432';
    }

    // Menampilkan nomor rekening dan tombol salin
    $("#accountNumber").text(accountNumber);
    $("#paymentDetails").show(); // Menampilkan nomor rekening

    // Menangani aksi klik tombol salin
    $("#copyButton").click(function() {
        var copyText = document.getElementById("accountNumber").textContent; // Mengambil teks nomor rekening
        navigator.clipboard.writeText(copyText) // Menyalin ke clipboard
            .then(function() {
                alert("Nomor rekening disalin: " + copyText); // Menampilkan alert setelah disalin
            })
            .catch(function(error) {
                alert("Gagal menyalin: " + error); // Menangani error
            });
    });



            $("#accountNumber").text(accountNumber);
            $("#paymentDetails").show(); // Menampilkan nomor rekening
        });

        // Submit form
        $("#paymentForm").submit(function(event) {
            event.preventDefault();
            let formData = new FormData(this);
            
            $.ajax({
                url: "{{ route('payment.process') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function() {
                    $("#confirmationModal").modal("show"); // Tampilkan modal konfirmasi
                },
                error: function() {
                    alert("Terjadi kesalahan, silakan coba lagi.");
                }
            });
        });
    </script>
</body>
</html>
