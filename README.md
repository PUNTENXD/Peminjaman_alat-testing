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





📌 USER
INSERT → Menambahkan user
UPDATE → Mengubah user
DELETE → Menghapus user

📌 KATEGORI
INSERT
UPDATE
DELETE

📌 ALAT
INSERT
UPDATE
DELETE

📌 PEMINJAMAN
INSERT → User mengajukan peminjaman
UPDATE status:
pending → pinjam → ACC petugas
pinjam → kembali → pengembalian









user_______________________________________________

DELIMITER $$

CREATE TRIGGER trg_user_insert
AFTER INSERT ON users
FOR EACH ROW
BEGIN
    INSERT INTO log (id_user, aktivitas, target_tabel, id_target)
    VALUES (
        NEW.id_user,
        'Menambahkan user',
        'users',
        NEW.id_user
    );
END$$

DELIMITER ;




DELIMITER $$

CREATE TRIGGER trg_user_update
AFTER UPDATE ON users
FOR EACH ROW
BEGIN
    INSERT INTO log (id_user, aktivitas, target_tabel, id_target)
    VALUES (
        NEW.id_user,
        'Mengubah data user',
        'users',
        NEW.id_user
    );
END$$

DELIMITER ;




DELIMITER $$

CREATE TRIGGER trg_user_delete
AFTER DELETE ON users
FOR EACH ROW
BEGIN
    INSERT INTO log (id_user, aktivitas, target_tabel, id_target)
    VALUES (
        OLD.id_user,
        'Menghapus user',
        'users',
        OLD.id_user
    );
END$$

DELIMITER ;




Kategori___________________


DELIMITER $$

CREATE TRIGGER trg_kategori_insert
AFTER INSERT ON kategori
FOR EACH ROW
BEGIN
    INSERT INTO log (id_user, aktivitas, target_tabel, id_target)
    VALUES (
        NULL,
        'Menambahkan kategori',
        'kategori',
        NEW.id_kategori
    );
END$$

DELIMITER ;




CREATE TRIGGER trg_kategori_update
AFTER UPDATE ON kategori
FOR EACH ROW
BEGIN
    INSERT INTO log (id_user, aktivitas, target_tabel, id_target)
    VALUES (
        NULL,
        'Mengubah kategori',
        'kategori',
        NEW.id_kategori
    );
END;






CREATE TRIGGER trg_kategori_delete
AFTER DELETE ON kategori
FOR EACH ROW
BEGIN
    INSERT INTO log (id_user, aktivitas, target_tabel, id_target)
    VALUES (
        NULL,
        'Menghapus kategori',
        'kategori',
        OLD.id_kategori
    );
END;











alat_______________________________________________

DELIMITER $$

CREATE TRIGGER trg_alat_update
AFTER UPDATE ON alat
FOR EACH ROW
BEGIN
    INSERT INTO log (id_user, aktivitas, target_tabel, id_target)
    VALUES (
        NULL,
        'Mengubah alat',
        'alat',
        NEW.id_alat
    );
END$$

DELIMITER ;




CREATE TRIGGER trg_alat_delete
AFTER DELETE ON alat
FOR EACH ROW
BEGIN
    INSERT INTO log (id_user, aktivitas, target_tabel, id_target)
    VALUES (
        NULL,
        'Menghapus alat',
        'alat',
        OLD.id_alat
    );
END;






Peminjaman_______________________________




DELIMITER $$

CREATE TRIGGER trg_peminjaman_insert
AFTER INSERT ON peminjaman
FOR EACH ROW
BEGIN
    INSERT INTO log (id_user, aktivitas, target_tabel, id_target)
    VALUES (
        NEW.id_user,
        'Mengajukan peminjaman',
        'peminjaman',
        NEW.id_peminjaman
    );
END$$

DELIMITER ;





DELIMITER $$

CREATE TRIGGER trg_peminjaman_update
AFTER UPDATE ON peminjaman
FOR EACH ROW
BEGIN

    IF OLD.status = 'pending' AND NEW.status = 'pinjam' THEN
        INSERT INTO log (id_user, aktivitas, target_tabel, id_target)
        VALUES (
            NEW.id_user,
            'Peminjaman disetujui petugas',
            'peminjaman',
            NEW.id_peminjaman
        );
    END IF;

    IF OLD.status = 'pinjam' AND NEW.status = 'kembali' THEN
        INSERT INTO log (id_user, aktivitas, target_tabel, id_target)
        VALUES (
            NEW.id_user,
            'Pengembalian dikonfirmasi',
            'peminjaman',
            NEW.id_peminjaman
        );
    END IF;

END$$

DELIMITER ;

















































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





Belum____________________________________________________

halaman peminjaman:
durasi < 1 = 0, atau  kalau bisa buat per jam

hilangkan keterangan Kembali di table data peminjaman.
keterangan harus punya fungsi yang jelas.
denda akan secara otomatis terakumulasi di table denda setiap lewat 1 hari + 5000, dan kalau denda tidak memenuhi syarat akan penambahan akan tetap 0.

tambahkan rules:
		maximal durasi peminjaman 7 hari
		



saat mengubah value stok ada beberapa rules:
	tidak bisa melebihi stok yang ada -> ada peringatan
	tidak bisa mengubah value stok menjadi <1
	








halaman edit peminjaman:
saat di tambah jumlah pinjamannnya stoknya malah tidak berkurang dan tidak ada Batasan peminjaman jadinya bisa meminjam melebihi stok yang tersedia (sudah)

lalu ada juga tanggal pinjam  dan rencana Kembali yang kurang rules
seharusnya Ketika tanggal dibawah hari ini gak bisa diclick (sudah)







halaman Kembali:
data tanggal Kembali tidak tercatat, tambah detail jam pada saat click pinjam, dan saat click kembali (sudah)
CATATAN: tabel peminjaman tgl_kembali diubah jadi DATETIME

tambahkan denda, keterlambatan, durasi (sudah)




belum________________________________________________

tambahkan denda di table.
tambahkan keterangan terlambat di tabel dan isinya menghitug berapa hari terlambat kalau tidak memenuhi persyaratan isnya akan tetap "0 hari" ini jug harus diterapkan di halaman pantau dashboard petugas








halaman log aktivitas:
menggunakan trigger untuk manambahkan log, semisal saat click atau ada perubahan data 









Petugas dashboard

halaman Pantau peminjaman:
belum ada keterangan tanggal pinjam, tanggal rencana Kembali, keterangan jam, denda, dan keterlambatan, yah isinya mirip dengan halaman peminjaman yang ada di dashboard admin (sudah)


semua halaman:
ubah nama sidebar data pengembalian menjadi laporan 


halaman dashboard:
pada tabel tgl Pinjam keterangan jamnya masih belum benar (lumayan tapi masih perlu penyesuaian)





Peminjam dashboard

halaman dashboard bagian daftar alat:
saat tekan pinjam hasilnya 
    403
Akses ditolak (sudah)


perbarui dashboard agar lebih mudah dimengerti


opsionl fitur:
tambahkan fitur batalkan peminjaman hanya saat status pending



gini saja pada halaman dashboard kita berikan daftar alat dan tombol pinjam yang akan memunculkan pop up untu mengisi data peminjaman, kalau bentunya begini kan UI nya jadi lebih bersih

tambahkan halaman daftar peminjaman, didalanya ada data keterangan peminjaman dari sudut pandang peminjam seperti no, nama buku, tanggal pinjam, janggal rencana Kembali (atau ini kita jadikan durasi pinjam, nanti mentukany missal "7 hari"), status


tambahkan juga halaman history pengembalian yang berisi data peminjaman yang sudah selesai dari sudut pandang peminjam ya


Kalau mau next level lagi, kita bisa:

Tambah filter kategori

Tambah search

Tambah pagination

Tambah notifikasi toast







pengalaman user


user UI perbaiki semuanya

bagian peminjaman buku UI nya diperjelas dengan banyak fungsi dan filter

status:
	Pending orange
	pinjam biru
	Kembali hijau



password minimal 8 digit
status tengah
denda/number kanan 
 



petugas bisa registrasi peminjam
detail peminjam ada nama,alamat,email,,no telephone kalau mau lebih bagus kasih validasi KTP/data diri

kita akan buat profil dashboard (sudah disiapkan tempatnya)
buat agar aplikasinya bisa menyimpan gambar, gak tau fungsinya untuk apa nanti kita tentukan

denda per hari 1% dari jumlah benda yang dipinjam, jadinya denda dihitung dari Harga benda
melebihi kuota tidak bisa
detail, jumlah stok di akun peminjam(sudah tinggal di kembangkan lagi)
untuk yang masuh meminjamb alat satu satu, jadi peminjam bisa meminjam alat beberapa sekaligus

karena persayratannya makin gak masuk akal untuk UKK, jadinya saya mau menambah 1 fitur lagi, yaitu chat AI, AI ini bisa menjelaskan fitur apa saja yang ada di aplikasi, lalu kita buat personality untuk membatasi beberapa pembahasan,dan ada fitur reset chat













5. Transaction (Commit & Rollback)
Ini adalah fitur untuk menjaga keamanan data jika terjadi error di tengah jalan.

    Konsep: Anggap kamu sedang proses pinjam alat. Step 1: Input data pinjam. Step 2: Kurangi stok alat. Jika Step 2 gagal (laptop mati/error), maka Step 1 harus dibatalkan.
    Commit: Menyimpan perubahan secara permanen (jika semua step berhasil).
    Rollback: Membatalkan semua perubahan (jika ada salah satu step yang gagal).











public function store(Request $request)
{
    // 1. Validasi Input
    $request->validate([
        'alat_id' => 'required|exists:alats,id',
        'jumlah' => 'required|integer|min:1',
    ]);

    $alat = Alat::findOrFail($request->alat_id);

    // 2. Cek Stok (Keamanan tambahan)
    if ($alat->stok < $request->jumlah) {
        return back()->with('error', 'Stok tidak mencukupi!');
    }

    // 3. Gunakan Database Transaction
    DB::beginTransaction();
    try {
        // Step A: Catat Peminjaman
        Peminjaman::create([
            'user_id' => auth()->id(),
            'alat_id' => $request->alat_id,
            'jumlah'  => $request->jumlah,
            'status'  => 'dipinjam',
            'tgl_pinjam' => now(),
        ]);

        // Step B: Kurangi Stok Alat
        $alat->decrement('stok', $request->jumlah);

        // Jika semua OK, Simpan!
        DB::commit();
        return redirect()->route('peminjaman.index')->with('success', 'Berhasil meminjam!');

    } catch (\Exception $e) {
        // Jika ada error (misal: database mati mendadak), Batalkan semua!
        DB::rollBack();
        return back()->with('error', 'Terjadi kesalahan, coba lagi.');
    }
}






















ls resources/views


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






