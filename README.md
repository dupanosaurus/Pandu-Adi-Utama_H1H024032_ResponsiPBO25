## Nama         : Pandu Adi Utama
## NIM          : H1024032
## Shift Awal   : A
## Shift Akhir  : D

# Penjelasan
Ini adalah simulasi web sederhana berbasis PHP bernama PokéCare untuk melatih pokemon Raticate. Dalam simulasi ini, trainer melihat berbagai informasi dan statistik dari Raticate. Trainer juga dapat melatih Raticate untuk menaikkan statnya. Fokusan latihan Raticate pun beragam, ada Attack, Speed, dan Defense. Setiap latihan akan menambah EXP, HP dan statistik tertentu sesuai fokusan latihan. Jika EXP melewati batas tertentu, pokemon akan level up. Trainer juga bisa mengecek histori latihan Raticate agar stat yg didapat seimbang.


# Struktur File
Responsi/
│
├── assets/
│   ├── raticate.png
│   └── bg_grass.jpg
│
├── data/
│   ├── raticate.json        ← Menyimpan state Pokémon
│   └── riwayat.json         ← Menyimpan riwayat latihan
│
├── kode/
│   ├── Pokemon.php          ← Class induk (Abstraction + Inheritance)
│   ├── Raticate.php         ← Child class Pokémon
│   ├── Training.php         ← Perhitungan latihan & EXP
│   └── utils.php            ← Helper untuk menyimpan & load JSON
│
├── styling/
│   └── style.css            ← Style halaman
│
├── index.php                ← Halaman Beranda
├── latihan.php              ← Halaman Latihan Pokémon
├── riwayat.php              ← Halaman Riwayat Latihan
└── README.md                ← Dokumentasi proyek

# Cara Menjalankan Program
Karena saya menggunakan laragon maka saya akan menunjukkan cara menjalannkan program dengan laragon:
1. Buka laragon lalu nyalakan
2. Klik kanan pada laragon -> www -> pilih folder dimana kamu menyimpan kode tersebut -> klik folder tersebut.

