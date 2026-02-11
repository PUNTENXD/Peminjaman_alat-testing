test
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
tgl_pinjam          DATE
tgl_rencana_kembali DATE
tgl_kembali         DATE
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
