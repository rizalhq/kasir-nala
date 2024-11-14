-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Nov 2024 pada 16.39
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasirnala`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `id_detail` int(11) NOT NULL,
  `kode_penjualan` varchar(15) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `sub_total` decimal(10,2) NOT NULL,
  `deskripsi` varchar(50) NOT NULL,
  `bahan_terpakai` varchar(50) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `panjang` varchar(50) NOT NULL,
  `lebar` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `status_pembayaran` enum('sudah','belum') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_penjualan`
--

INSERT INTO `detail_penjualan` (`id_detail`, `kode_penjualan`, `id_produk`, `sub_total`, `deskripsi`, `bahan_terpakai`, `id_pelanggan`, `panjang`, `lebar`, `qty`, `status_pembayaran`) VALUES
(133, '1', 19, '35000.00', '1', '1', 7, '0', '0', 1, 'sudah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `telp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `alamat`, `telp`) VALUES
(7, 'nala media', 'karanganyar', '0888888'),
(8, 'Antok Sugiyanto', 'Mojogedang', '0811111');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `status_pembayaran` enum('Belum Lunas','Lunas') NOT NULL,
  `jumlah_kurang` varchar(50) NOT NULL,
  `uang_muka` varchar(50) NOT NULL,
  `uang_dibayar` varchar(50) NOT NULL,
  `kembalian` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_penjualan`, `status_pembayaran`, `jumlah_kurang`, `uang_muka`, `uang_dibayar`, `kembalian`) VALUES
(39, 49, 'Lunas', '0', '0', '40000', '5000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id_pengeluaran` int(11) NOT NULL,
  `keterangan_pengeluaran` varchar(50) NOT NULL,
  `harga_pengeluaran` varchar(50) NOT NULL,
  `tanggal_pengeluaran` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengeluaran`
--

INSERT INTO `pengeluaran` (`id_pengeluaran`, `keterangan_pengeluaran`, `harga_pengeluaran`, `tanggal_pengeluaran`) VALUES
(2, 'beli makan', '50000', '2024-11-09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `kode_penjualan` varchar(20) NOT NULL,
  `total_harga` int(12) NOT NULL,
  `id_pelanggan` varchar(15) NOT NULL,
  `tanggal_penjualan` date NOT NULL,
  `status_pembayaran` enum('sudah') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `kode_penjualan`, `total_harga`, `id_pelanggan`, `tanggal_penjualan`, `status_pembayaran`) VALUES
(49, '1', 35000, '7', '2024-11-14', 'sudah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `jumlah_barang` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `jumlah_barang`) VALUES
(14, 'FL280GR', '103.88'),
(15, 'FL440GR', '215'),
(16, 'INFLEX', ''),
(17, 'STICKER NON LABEL', ''),
(18, 'ALBATROS', ''),
(19, 'XBANNER', '5'),
(20, 'ROLL UP BANNER', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `staff`
--

CREATE TABLE `staff` (
  `id_staff` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `level` enum('admin','kasir') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `staff`
--

INSERT INTO `staff` (`id_staff`, `username`, `password`, `level`) VALUES
(7, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(18, 'kasir', 'c7911af3adbd12a035b289556d96470a', 'kasir');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok`
--

CREATE TABLE `stok` (
  `id_stok` int(11) NOT NULL,
  `id_produk` varchar(50) NOT NULL,
  `jumlah_stok` varchar(50) NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `harga_beli` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `stok`
--

INSERT INTO `stok` (`id_stok`, `id_produk`, `jumlah_stok`, `tanggal_pembelian`, `harga_beli`) VALUES
(20, '14', '224', '2024-11-07', '80000'),
(21, '19', '10', '2024-11-07', '100000'),
(22, '15', '224', '2024-11-08', '25000');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`);

--
-- Indeks untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id_pengeluaran`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indeks untuk tabel `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id_staff`);

--
-- Indeks untuk tabel `stok`
--
ALTER TABLE `stok`
  ADD PRIMARY KEY (`id_stok`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id_pengeluaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `staff`
--
ALTER TABLE `staff`
  MODIFY `id_staff` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `stok`
--
ALTER TABLE `stok`
  MODIFY `id_stok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
