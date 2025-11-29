## Nama         : Pandu Adi Utama
## NIM          : H1024032
## Shift Awal   : A
## Shift Akhir  : D

# Penjelasan
Ini adalah simulasi web sederhana berbasis PHP bernama PokéCare untuk melatih pokemon Raticate. Dalam simulasi ini, trainer melihat berbagai informasi dan statistik dari Raticate. Trainer juga dapat melatih Raticate untuk menaikkan statnya. Fokusan latihan Raticate pun beragam, ada Attack, Speed, dan Defense. Setiap latihan akan menambah EXP, HP dan statistik tertentu sesuai fokusan latihan. Jika EXP melewati batas tertentu, pokemon akan level up. Trainer juga bisa mengecek histori latihan Raticate agar stat yg didapat seimbang.


# Struktur File
folder Responsi yg berisi
1. folder assest           ← menyimpan aset yg digunakan
2. folder data yg berisi
   1. raticate.json        ← Menyimpan state Pokémon
   2. riwayat.json         ← Menyimpan riwayat latihan
3. folder kode yg berisi
   1. Pokemon.php          ← Class induk (Abstraction + Inheritance)
   2. Raticate.php         ← Child class Pokémon
   3. Training.php         ← Perhitungan latihan & EXP
   4. utils.php            ← Helper untuk menyimpan & load JSON
4. folder styling yg berisi
   1. style.css            ← Style halaman
5. index.php               ← Halaman Beranda
6. latihan.php             ← Halaman Latihan Pokémon
7. riwayat.php             ← Halaman Riwayat Latihan
8. README.md               ← Dokumentasi proyek

# Cara Menjalankan Program
Karena saya menggunakan laragon maka saya akan menunjukkan cara menjalannkan program dengan laragon:
1. Buka laragon lalu nyalakan
2. Klik kanan pada laragon -> www -> pilih folder dimana kamu menyimpan kode tersebut -> klik folder tersebut hingga akhirnya berpindah ke laman web.

![2025-11-29+15-56-44](https://github.com/user-attachments/assets/36c62904-ea35-4379-bbc5-6e2d66276247)
