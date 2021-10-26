-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Okt 2021 pada 08.31
-- Versi server: 10.4.18-MariaDB
-- Versi PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blanjaloka_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `chat_telepon`
--

CREATE TABLE `chat_telepon` (
  `id_chat` int(11) NOT NULL,
  `id_pedagang` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `id_driver` int(11) NOT NULL,
  `pesan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer`
--

CREATE TABLE `customer` (
  `id_customer` int(11) NOT NULL,
  `nama_customer` varchar(255) NOT NULL,
  `nomor_telepon` int(15) NOT NULL,
  `alamat_customer` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `email_customer` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar_belanja_harian`
--

CREATE TABLE `daftar_belanja_harian` (
  `id_daftar` int(11) NOT NULL,
  `kode_produk` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `driver`
--

CREATE TABLE `driver` (
  `id_driver` int(11) NOT NULL,
  `nama_driver` varchar(255) NOT NULL,
  `nomor_telepon` int(11) NOT NULL,
  `alamat_driver` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `nomor_ktp` int(11) NOT NULL,
  `kendaraan` varchar(255) NOT NULL,
  `foto_stnk` varchar(255) NOT NULL,
  `id_pendaftaraan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `gudang`
--

CREATE TABLE `gudang` (
  `id_gudang` int(11) NOT NULL,
  `id_toko` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `stok_saat_ini` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jam_operasional_pasar`
--

CREATE TABLE `jam_operasional_pasar` (
  `id_toko` int(11) NOT NULL,
  `hari_operasional` date NOT NULL,
  `jam_operasional` time NOT NULL DEFAULT current_timestamp(),
  `id_pengelola` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pedagang`
--

CREATE TABLE `pedagang` (
  `id_pedagang` int(11) NOT NULL,
  `nama_pedagang` varchar(255) NOT NULL,
  `nomor_telepon` int(11) NOT NULL,
  `alamat_pedagang` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `nomor_ktp` int(11) NOT NULL,
  `foto_rekening` varchar(255) NOT NULL,
  `id_pendaftaran` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemda`
--

CREATE TABLE `pemda` (
  `id_pemda` int(11) NOT NULL,
  `nama_pemda` varchar(255) NOT NULL,
  `alamat_pemda` varchar(255) NOT NULL,
  `nomor_telepon` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nomor_ktp` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `kode_produk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id_pendaftaran` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `nomor_telepon` int(11) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `nomor_ktp` int(11) NOT NULL,
  `foto_ktp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengelola_pasar`
--

CREATE TABLE `pengelola_pasar` (
  `id_pengelola` int(11) NOT NULL,
  `nama_pengelola` varchar(255) NOT NULL,
  `alamat_pengelola` varchar(255) NOT NULL,
  `nomor_telepon` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `id_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `nama_customer` varchar(255) NOT NULL,
  `nomor_telepon` int(11) NOT NULL,
  `alamat_customer` varchar(255) NOT NULL,
  `kode_produk` int(11) NOT NULL,
  `id_pedagang` int(11) NOT NULL,
  `kode_transaksi` int(11) NOT NULL,
  `pilihan_penawaran` varchar(255) NOT NULL,
  `id_driver` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `kode_produk` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `satuan` varchar(255) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `stok_saat_ini` int(11) NOT NULL,
  `status_produk` varchar(255) NOT NULL,
  `id_pedagang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekomendasi_bahan_masakan`
--

CREATE TABLE `rekomendasi_bahan_masakan` (
  `id_rekomendasi` int(11) NOT NULL,
  `kode_produk` int(11) NOT NULL,
  `resep_masakan` varchar(255) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `id_pedagang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `status_user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tawar_menawar`
--

CREATE TABLE `tawar_menawar` (
  `id_tawar` int(11) NOT NULL,
  `id_pedagang` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `harga_nego` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `toko`
--

CREATE TABLE `toko` (
  `id_toko` int(11) NOT NULL,
  `nama_toko` varchar(255) NOT NULL,
  `alamat_toko` varchar(255) NOT NULL,
  `id_pedagang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `kode_transaksi` int(11) NOT NULL,
  `jenis_pembayaran` varchar(255) NOT NULL,
  `pajak` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `id_pedagang` int(11) NOT NULL,
  `total_pembayaran` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `chat_telepon`
--
ALTER TABLE `chat_telepon`
  ADD PRIMARY KEY (`id_chat`),
  ADD KEY `id_pedagang` (`id_pedagang`),
  ADD KEY `id_customer` (`id_customer`),
  ADD KEY `id_driver` (`id_driver`);

--
-- Indeks untuk tabel `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_customer`),
  ADD KEY `id_role` (`id_role`);

--
-- Indeks untuk tabel `daftar_belanja_harian`
--
ALTER TABLE `daftar_belanja_harian`
  ADD PRIMARY KEY (`id_daftar`),
  ADD KEY `kode_produk` (`kode_produk`),
  ADD KEY `id_customer` (`id_customer`);

--
-- Indeks untuk tabel `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`id_driver`),
  ADD KEY `id_pendaftaraan` (`id_pendaftaraan`);

--
-- Indeks untuk tabel `gudang`
--
ALTER TABLE `gudang`
  ADD PRIMARY KEY (`id_gudang`),
  ADD KEY `id_toko` (`id_toko`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indeks untuk tabel `jam_operasional_pasar`
--
ALTER TABLE `jam_operasional_pasar`
  ADD KEY `id_toko` (`id_toko`),
  ADD KEY `id_pengelola` (`id_pengelola`);

--
-- Indeks untuk tabel `pedagang`
--
ALTER TABLE `pedagang`
  ADD PRIMARY KEY (`id_pedagang`),
  ADD KEY `id_pendaftaran` (`id_pendaftaran`);

--
-- Indeks untuk tabel `pemda`
--
ALTER TABLE `pemda`
  ADD PRIMARY KEY (`id_pemda`),
  ADD KEY `kode_produk` (`kode_produk`);

--
-- Indeks untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`);

--
-- Indeks untuk tabel `pengelola_pasar`
--
ALTER TABLE `pengelola_pasar`
  ADD PRIMARY KEY (`id_pengelola`,`id_role`),
  ADD KEY `id_role` (`id_role`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `id_driver` (`id_driver`),
  ADD KEY `kode_transaksi` (`kode_transaksi`),
  ADD KEY `id_pedagang` (`id_pedagang`),
  ADD KEY `kode_produk` (`kode_produk`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`kode_produk`),
  ADD KEY `id_pedagang` (`id_pedagang`);

--
-- Indeks untuk tabel `rekomendasi_bahan_masakan`
--
ALTER TABLE `rekomendasi_bahan_masakan`
  ADD PRIMARY KEY (`id_rekomendasi`),
  ADD KEY `kode_produk` (`kode_produk`),
  ADD KEY `id_customer` (`id_customer`),
  ADD KEY `id_pedagang` (`id_pedagang`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indeks untuk tabel `tawar_menawar`
--
ALTER TABLE `tawar_menawar`
  ADD PRIMARY KEY (`id_tawar`),
  ADD KEY `id_pedagang` (`id_pedagang`),
  ADD KEY `id_customer` (`id_customer`);

--
-- Indeks untuk tabel `toko`
--
ALTER TABLE `toko`
  ADD PRIMARY KEY (`id_toko`),
  ADD KEY `id_pedagang` (`id_pedagang`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`kode_transaksi`),
  ADD KEY `kode_transaksi` (`kode_transaksi`,`id_customer`),
  ADD KEY `id_pedagang` (`id_pedagang`),
  ADD KEY `id_customer` (`id_customer`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `chat_telepon`
--
ALTER TABLE `chat_telepon`
  MODIFY `id_chat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `customer`
--
ALTER TABLE `customer`
  MODIFY `id_customer` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `daftar_belanja_harian`
--
ALTER TABLE `daftar_belanja_harian`
  MODIFY `id_daftar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `driver`
--
ALTER TABLE `driver`
  MODIFY `id_driver` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `gudang`
--
ALTER TABLE `gudang`
  MODIFY `id_gudang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pedagang`
--
ALTER TABLE `pedagang`
  MODIFY `id_pedagang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pemda`
--
ALTER TABLE `pemda`
  MODIFY `id_pemda` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengelola_pasar`
--
ALTER TABLE `pengelola_pasar`
  MODIFY `id_pengelola` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `kode_produk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `rekomendasi_bahan_masakan`
--
ALTER TABLE `rekomendasi_bahan_masakan`
  MODIFY `id_rekomendasi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tawar_menawar`
--
ALTER TABLE `tawar_menawar`
  MODIFY `id_tawar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `toko`
--
ALTER TABLE `toko`
  MODIFY `id_toko` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `kode_transaksi` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `chat_telepon`
--
ALTER TABLE `chat_telepon`
  ADD CONSTRAINT `chat_telepon_ibfk_1` FOREIGN KEY (`id_pedagang`) REFERENCES `pedagang` (`id_pedagang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chat_telepon_ibfk_2` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id_customer`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chat_telepon_ibfk_3` FOREIGN KEY (`id_driver`) REFERENCES `driver` (`id_driver`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `customer_ibfk_2` FOREIGN KEY (`id_customer`) REFERENCES `rekomendasi_bahan_masakan` (`id_rekomendasi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `gudang`
--
ALTER TABLE `gudang`
  ADD CONSTRAINT `gudang_ibfk_1` FOREIGN KEY (`id_toko`) REFERENCES `toko` (`id_toko`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jam_operasional_pasar`
--
ALTER TABLE `jam_operasional_pasar`
  ADD CONSTRAINT `jam_operasional_pasar_ibfk_1` FOREIGN KEY (`id_toko`) REFERENCES `toko` (`id_toko`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jam_operasional_pasar_ibfk_2` FOREIGN KEY (`id_pengelola`) REFERENCES `pengelola_pasar` (`id_pengelola`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pedagang`
--
ALTER TABLE `pedagang`
  ADD CONSTRAINT `pedagang_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran` (`id_pendaftaran`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengelola_pasar`
--
ALTER TABLE `pengelola_pasar`
  ADD CONSTRAINT `pengelola_pasar_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`id_driver`) REFERENCES `driver` (`id_driver`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rekomendasi_bahan_masakan`
--
ALTER TABLE `rekomendasi_bahan_masakan`
  ADD CONSTRAINT `rekomendasi_bahan_masakan_ibfk_1` FOREIGN KEY (`kode_produk`) REFERENCES `produk` (`kode_produk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rekomendasi_bahan_masakan_ibfk_2` FOREIGN KEY (`id_pedagang`) REFERENCES `pedagang` (`id_pedagang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tawar_menawar`
--
ALTER TABLE `tawar_menawar`
  ADD CONSTRAINT `tawar_menawar_ibfk_1` FOREIGN KEY (`id_pedagang`) REFERENCES `pedagang` (`id_pedagang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `toko`
--
ALTER TABLE `toko`
  ADD CONSTRAINT `toko_ibfk_1` FOREIGN KEY (`id_pedagang`) REFERENCES `pedagang` (`id_pedagang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id_customer`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_pedagang`) REFERENCES `pedagang` (`id_pedagang`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
