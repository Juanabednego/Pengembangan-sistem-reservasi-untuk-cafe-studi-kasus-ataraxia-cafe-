<!DOCTYPE html>
<html lang="en">
<head>
@include('layouts.Navbar')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Kursi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
       .seat-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); /* Grid fleksibel */
    gap: 10px;
    justify-content: center;
    margin-top: 20px;
}

.seat-group {
    display: grid;
    grid-template-columns: repeat(2, 50px);
    grid-template-rows: repeat(2, 50px);
    gap: 5px;
    justify-content: center;
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
            background-color: grey;
            cursor: not-allowed;
        }
        .seat.selected {
            background-color: blue;
        }

/* Responsif untuk layar lebih kecil (tablet dan mobile) */
@media (max-width: 768px) {
    .seat-container {
        grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); /* Ukuran lebih kecil */
        gap: 8px;
    }
    .seat {
        width: 40px;
        height: 40px;
        line-height: 40px;
        font-size: 12px;
    }
    .stage {
        font-size: 18px;
        padding: 12px;
    }
}

@media (max-width: 480px) {
    .seat-container {
        grid-template-columns: repeat(auto-fit, minmax(90px, 1fr)); /* Lebih kecil untuk HP */
        gap: 5px;
    }
    .seat {
        width: 35px;
        height: 35px;
        line-height: 35px;
        font-size: 10px;
    }
    .stage {
        font-size: 16px;
        padding: 10px;
    }
}

/* Desain panggung lebih elegan */
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
<br>
<body>
<div class="container text-center">
    <div class="stage">STAGE</div>
    <div class="seat-container">
        <!-- Kursi akan dibuat oleh JavaScript -->
    </div>
    <div class="mt-4">
        <h4>Total Harga: <span id="totalPrice">Rp 0</span></h4>
        <h5>Tempat Duduk: <span id="selectedSeats">-</span></h5>
        <button class="btn btn-success mt-2">Konfirmasi Pemesanan</button>
        <button class="btn btn-danger mt-2" id="cancelSelection">Cancel</button> <!-- Tombol Cancel -->
    </div>
</div>
<br>

@include('layouts.footer')

<script>
    $(document).ready(function() {
        const rows = 5;
        const cols = 5;
        const seatPrice = 150000;
        const bookedSeats = ['', '', '']; // Kursi yang sudah dipesan
        let selectedSeats = [];

        const seatContainer = $(".seat-container");
        
        for (let i = 1; i <= rows * cols; i++) {
            let seatGroup = $('<div class="seat-group"></div>');
            for (let j = 0; j < 4; j++) {
                let seatId = i + String.fromCharCode(97 + j);
                let seatClass = bookedSeats.includes(seatId) ? 'seat booked' : 'seat';
                seatGroup.append(`<div class="${seatClass}" data-seat="${seatId}">${seatId}</div>`);
            }
            seatContainer.append(seatGroup);
        }

        // Klik untuk memilih atau membatalkan kursi
        $(document).on("click", ".seat:not(.booked)", function() {
            let seat = $(this).data("seat");

            if ($(this).hasClass("selected")) {
                $(this).removeClass("selected");
                selectedSeats = selectedSeats.filter(s => s !== seat);
            } else {
                $(this).addClass("selected");
                selectedSeats.push(seat);
            }

            updateSelection();
        });

        // Fungsi untuk mengupdate tampilan
        function updateSelection() {
            $("#selectedSeats").text(selectedSeats.length > 0 ? selectedSeats.join(', ') : '-');
            $("#totalPrice").text(`Rp ${selectedSeats.length * seatPrice}`);
        }

        // Tombol Cancel untuk menghapus semua kursi yang dipilih
        $("#cancelSelection").click(function() {
            $(".seat.selected").removeClass("selected"); // Hapus warna biru
            selectedSeats = [];
            updateSelection(); // Reset harga dan daftar kursi
        });
    });
</script>

</body>
</html>
