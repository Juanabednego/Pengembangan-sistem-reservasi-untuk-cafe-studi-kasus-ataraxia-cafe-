<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.Navbar')
    <br>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Kursi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .seat-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        .seat-group {
            display: grid;
            grid-template-columns: repeat(2, 50px);
            grid-template-rows: repeat(2, 50px);
            gap: 5px;
            justify-content: center;
            background-color: #222;
            padding: 10px;
            border-radius: 10px;
        }
        .seat {
            width: 50px;
            height: 50px;
            line-height: 50px;
            text-align: center;
            font-size: 14px;
            background-color: black;
            color: white;
            border-radius: 10px;
            cursor: pointer;
        }
        .seat.booked {
    background-color: grey !important; /* Warna abu-abu untuk kursi yang sudah dipesan */
    cursor: not-allowed; /* Menonaktifkan kursor klik */
}
.seat.selected {
    background-color: blue !important; /* Warna biru untuk kursi yang dipilih */
}
.seat:hover:not(.booked) {
    background-color: blue !important; /* Mengubah warna saat kursor berada di atas kursi yang belum dibooking */
}
        .stage {
            background: linear-gradient(to bottom, #999, #666);
            text-align: center;
            padding: 15px;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 30px;
            width: 80%;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
            border-radius: 20px 20px 50px 50px;
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.3);
            color: white;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
<div class="container text-center">
    <div class="stage">STAGE</div>
   <div class="seat-container">
    @php
        $formattedSeats = $formattedSeats ?? [];
    @endphp
    @for($i = 1; $i <= 25; $i++)
        @php
            $seatId1 = $i . 'a';
            $seatId2 = $i . 'b';
            $seatId3 = $i . 'c';
            $seatId4 = $i . 'd';
        @endphp
        <div class="seat-group">
            <div class="seat {{ in_array($seatId1, $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $seatId1 }}">{{ $seatId1 }}</div>
            <div class="seat {{ in_array($seatId2, $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $seatId2 }}">{{ $seatId2 }}</div>
            <div class="seat {{ in_array($seatId3, $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $seatId3 }}">{{ $seatId3 }}</div>
            <div class="seat {{ in_array($seatId4, $formattedSeats) ? 'booked' : '' }}" data-seat="{{ $seatId4 }}">{{ $seatId4 }}</div>
        </div>
    @endfor
</div>

    <div class="mt-4">
        <h4>Total Harga: <span id="totalPrice">Rp 0</span></h4>
        <h5>Tempat Duduk: <span id="selectedSeats">-</span></h5>
        <button id="confirmBooking" class="btn btn-success mt-2" disabled>Konfirmasi Pemesanan</button>
        <button class="btn btn-danger mt-2" id="cancelSelection">Cancel</button>
    </div>
</div>
@include('layouts.footer')

<script>
$(document).ready(function() {
    const seatPrice = 150000;
    let selectedSeats = [];
    const confirmButton = $("#confirmBooking");

    // Fungsi untuk memuat kursi yang sudah dibooking
    function loadSeats() {
        $.ajax({
            url: "{{ route('pilih-kursi') }}", // URL untuk memanggil data kursi
            type: "GET",
            dataType: "json",
            success: function(response) {
                console.log("Kursi yang sudah dipesan:", response.formattedSeats);

                // Reset semua kursi dulu
                $(".seat").removeClass("booked selected")
                    .css("background-color", "black")
                    .css("cursor", "pointer")
                    .off("click");

                // Tandai kursi yang sudah dibooking sebagai booked
                response.formattedSeats.forEach(function(seat) {
                    $(".seat[data-seat='" + seat + "']")
                        .addClass("booked") // Menambahkan kelas 'booked'
                        .css("background-color", "grey") // Ubah warna kursi yang sudah dibooking menjadi abu-abu
                        .css("cursor", "not-allowed") // Nonaktifkan klik pada kursi yang sudah dibooking
                        .off("click"); // Nonaktifkan event klik pada kursi yang sudah dibooking
                });

                // Tambahkan event klik hanya pada kursi yang belum dibooking
                  // Tambahkan event klik hanya pada kursi yang belum dibooking
                  $(".seat:not(.booked)").click(function() {
                    let seat = $(this).data("seat");

                    if ($(this).hasClass("selected")) {
                        $(this).removeClass("selected"); // Hapus kelas selected jika kursi dibatalkan
                        selectedSeats = selectedSeats.filter(s => s !== seat); // Hapus kursi dari pilihan
                    } else {
                        $(this).addClass("selected"); // Tambahkan kelas selected jika kursi dipilih
                        selectedSeats.push(seat); // Tambahkan kursi ke dalam array selectedSeats
                    }


                    // Update teks yang ditampilkan
                    $("#selectedSeats").text(selectedSeats.length > 0 ? selectedSeats.join(', ') : '-');
                    $("#totalPrice").text(`Rp ${selectedSeats.length * seatPrice}`); // Update harga total

                    // Disable tombol konfirmasi jika tidak ada kursi yang dipilih
                    confirmButton.prop("disabled", selectedSeats.length === 0);
                });
            },
            error: function(xhr) {
                console.error("Gagal mengambil kursi terbaru:", xhr.responseText);
            }
        });
    }

    // Panggil fungsi loadSeats untuk pertama kali saat halaman dimuat
    loadSeats();

    // Update kursi setiap 5 detik agar yang dikonfirmasi otomatis berubah
    setInterval(loadSeats, 5000); // Update setiap 5 detik

    // Konfirmasi pemesanan kursi
    $("#confirmBooking").click(function() {
        let selectedSeatsString = selectedSeats.join(', ');

        $.post("{{ route('booking.store') }}", {
            _token: "{{ csrf_token() }}",
            seats: selectedSeatsString,
            total_price: selectedSeats.length * seatPrice
        }).done(function(response) {
            if (response.booking_id) {
                loadSeats(); // Memperbarui kursi yang sudah dipesan
                window.location.href = `/payment?booking_id=${response.booking_id}`;
            } else {
                alert("Terjadi kesalahan, silakan coba lagi.");
            }
        }).fail(function(xhr) {
            console.error("Error dari backend:", xhr.responseText);
            alert("Gagal menyimpan pemesanan, coba lagi!");
        });
    });

    // Batalkan pemilihan kursi
    $("#cancelSelection").click(function() {
        $(".seat.selected").removeClass("selected");
        selectedSeats = [];
        $("#selectedSeats").text('-');
        $("#totalPrice").text('Rp 0');
        confirmButton.prop("disabled", true);
    });
});
</script>



</body>
</html>
