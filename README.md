test
testestestestestestest
stuktur table database

users
id_user            BIGINT PK
username           VARCHAR(50)
password           VARCHAR(255)
role               ENUM(admin, petugas, peminjam)
create_at          Timestamp
update_at         Timestamp

🔹 kategori
id_kategori         BIGINT PK
nama_kategori       VARCHAR(100)
create_at          Timestamp
update_at         Timestamp

🔹 alat
id_alat             BIGINT PK
id_kategori         BIGINT FK
nama_alat           VARCHAR(100)
stok                INT
kondisi             VARCHAR(50)
create_at          Timestamp
update_at         Timestamp

relasi
restrict
cascade


🔹 peminjaman
id_peminjaman       BIGINT PK
id_user             BIGINT FK
id_alat             BIGINT FK
jumlah              INT
tgl_pinjam          DATEtime
tgl_rencana_kembali DATE
tgl_kembali         Datetime
status              ENUM(pending, pinjam, kembali)
create_at          Timestamp
update_at         Timestamp

relasi user
restrict
cascade

relasi alat
restrict
cascade


🔹 log
id_log              BIGINT PK
id_user             BIGINT FK
aktivitas           VARCHAR(150)
target_tabel        VARCHAR(50)
id_target           BIGINT
create              Timestamp

relasi
set null
cascade


git clone https://github.com

https://github.com/PUNTENXD/Peminjaman_alat-testing.git


























php artisan config:clear
php artisan cache:clear
php artisan config:cache
php artisan route:clear
php artisan cache:clear


Admin dashboard

halaman kategori:
kategori belum bisa dihapus, karena disuruh membuat CRUD jadi minimal kategorinya bisa dihapus (sudah)


halaman tambah alat:
buat rules stok tidak bisa trigger kalau <=1 , contoh admin memasukkan -2 akan otomatis menjadi 1  (sudah)

halaman peminjaman:
durasi < 1 = 0, atau  kalau bisa buat per jam
 

halaman edit peminjaman:
saat di tambah jumlah pinjamannnya stoknya malah tidak berkurang dan tidak ada Batasan peminjaman jadinya bisa meminjam melebihi stok yang tersedia

lalu ada juga tanggal pinjam  dan rencana Kembali yang kurang rules
seharusnya Ketika tanggal dibawah hari ini gak bisa diclick (sudah)



halaman Kembali:
data tanggal Kembali tidak tercatat, tambah detail jam pada saat click pinjam, dan saat click kembali (sudah)
CATATAN: tabel peminjaman tgl_kembali diubah jadi DATETIME



tambahkan denda, keterlambatan, durasi (sudah)



halaman log aktivitas:
menggunakan trigger untuk manambahkan log, semisal saat click atau ada perubahan data 









Petugas dashboard

halaman Pantau peminjaman:
belum ada keterangan tanggal pinjam, tanggal rencana Kembali, keterangan jam, denda, dan keterlambatan, yah isinya mirip dengan halaman peminjaman yang ada di dashboard admin


semua halaman:
ubah nama sidebar data pengembalian menjadi laporan


halaman dashboard:
pada tabel tgl Pinjam keterangan jamnya masih belum benar





Peminjam dashboard

halaman dashboard bagian daftar alat:
saat tekan pinjam hasilnya 
    403
Akses ditolak 


pebarui dashboard agar lebih mudah dimengerti


opsionl fitur:
tambahkan fitur batalkan peminjaman hanya saat status pending









cd nama-folder-project
git remote -v
git status
git add .

ver rapi:
	git add app/
	git add resources/
	git add routes/

git commit -m "Refactor peminjaman & kembali, perbaikan alur status"

git push origin main

Kalau branch kamu master:

git push origin master

Kalau pertama kali push dan error upstream:

git push -u origin main


Bonus (Supaya Lebih Aman Lagi)
Sebelum push besar, kamu bisa buat branch:
git checkout -b refactor-peminjaman

Lalu push:
git push -u origin refactor-peminjaman
Ini aman kalau mau eksperimen besar.


git pull origin main --no-rebase --allow-unrelated-histories

Ctrl + X
Y
Enter

git push origin main



