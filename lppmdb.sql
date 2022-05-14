-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Des 2018 pada 16.08
-- Versi server: 10.1.30-MariaDB
-- Versi PHP: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lppmdb`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `agenda`
--

CREATE TABLE `agenda` (
  `ID_AGENDA` int(11) NOT NULL,
  `ID_ACARA` int(11) NOT NULL,
  `ID_USER` int(11) NOT NULL,
  `TITLE` varchar(100) NOT NULL,
  `DESCRIPTION` varchar(100) NOT NULL,
  `LOCATION` varchar(50) NOT NULL,
  `JENIS_AGENDA` int(11) NOT NULL,
  `ATTACH_FILE` varchar(50) NOT NULL,
  `TIME_START` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TIME_END` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `STATUS` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `agenda`
--

INSERT INTO `agenda` (`ID_AGENDA`, `ID_ACARA`, `ID_USER`, `TITLE`, `DESCRIPTION`, `LOCATION`, `JENIS_AGENDA`, `ATTACH_FILE`, `TIME_START`, `TIME_END`, `STATUS`) VALUES
(2, 0, 3, 'Janjian Pimpinan', 'Janjian Penting', 'Ruang C', 2, '', '2018-11-30 08:00:00', '2018-11-30 09:00:00', 'Ditolak'),
(4, 0, 3, 'Rapat Progress Pengerjaan', 'Progress LPPM Dashboard', 'Ruang C', 2, '', '2018-11-30 05:00:00', '2018-11-30 08:00:00', 'Request'),
(5, 1, 3, 'Test Acara', 'Semhas PKL', 'Ruang C', 1, '', '2018-11-30 02:00:00', '2018-11-30 03:00:00', 'Confirmed'),
(7, 7, 3, 'Event Talk Skripsi', 'Tes Acara', 'Ruang C', 1, '', '2018-11-30 05:00:00', '2018-11-30 08:00:00', 'Confirmed'),
(8, 0, 3, 'Ngajar Pemdas', 'Ngajar Pemdas Ndek FILKOM.', 'Filkom', 4, '', '2018-12-05 02:00:00', '2018-12-05 05:00:00', 'Confirmed'),
(9, 9, 2, 'Rapat Rutin pimpinan', 'Rapat', 'Ruang B', 1, '', '2018-12-06 02:00:00', '2018-12-06 05:00:00', 'Request'),
(10, 9, 3, 'Rapat Rutin pimpinan', 'Rapat', 'Ruang B', 1, '', '2018-12-06 02:00:00', '2018-12-06 05:00:00', 'Confirmed'),
(25, 17, 2, 'Tes Rapat', 'Tes Acara', 'Ruang C', 1, '', '2018-12-08 03:00:00', '2018-12-08 05:00:00', 'Request'),
(26, 17, 3, 'Tes Rapat', 'Tes Acara', 'Ruang C', 1, '', '2018-12-08 03:00:00', '2018-12-08 05:00:00', 'Request'),
(27, 18, 2, 'Tes Validasi', 'Testing Doang', 'Ruang B', 1, '', '2018-12-11 06:00:00', '2018-12-11 08:00:00', 'Request'),
(28, 18, 3, 'Tes Validasi', 'Testing Doang', 'Ruang B', 1, '', '2018-12-11 06:00:00', '2018-12-11 08:00:00', 'Confirmed'),
(29, 18, 4, 'Tes Validasi', 'Testing Doang', 'Ruang B', 1, '', '2018-12-11 06:00:00', '2018-12-11 08:00:00', 'Request'),
(30, 18, 5, 'Tes Validasi', 'Testing Doang', 'Ruang B', 1, '', '2018-12-11 06:00:00', '2018-12-11 08:00:00', 'Request'),
(31, 18, 6, 'Tes Validasi', 'Testing Doang', 'Ruang B', 1, '', '2018-12-11 06:00:00', '2018-12-11 08:00:00', 'Request'),
(32, 0, 3, 'Testing', 'hehehe', 'Ruang C', 2, '', '2018-12-22 05:05:00', '2018-12-22 07:00:00', 'Confirmed');

-- --------------------------------------------------------

--
-- Struktur dari tabel `event`
--

CREATE TABLE `event` (
  `ID_EVENT` int(11) NOT NULL,
  `ID_ROOM` int(11) NOT NULL,
  `EVENTNAME` varchar(100) NOT NULL,
  `EVENTINITIATOR` varchar(100) NOT NULL,
  `INITIATORNOTELP` varchar(20) NOT NULL,
  `INITIATOREMAIL` varchar(100) NOT NULL,
  `EVENTLOCATION` varchar(100) NOT NULL,
  `EVENTDESCRIPTION` varchar(255) NOT NULL,
  `ATTENDANCE` int(11) NOT NULL,
  `REFERENCELETTERPATH` varchar(255) NOT NULL,
  `TIME_START` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `TIME_END` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `event`
--

INSERT INTO `event` (`ID_EVENT`, `ID_ROOM`, `EVENTNAME`, `EVENTINITIATOR`, `INITIATORNOTELP`, `INITIATOREMAIL`, `EVENTLOCATION`, `EVENTDESCRIPTION`, `ATTENDANCE`, `REFERENCELETTERPATH`, `TIME_START`, `TIME_END`) VALUES
(17, 3, 'Tes Rapat', 'Mohammad Alfan', '081334744293', 'mohalfan22@gmail.com', '', 'Tes Acara', 0, 'BerkasSuratAcara/08122018080043PAPB_SI_6_Intent.pdf', '2018-12-08 03:00:00', '2018-12-08 05:00:00'),
(18, 2, 'Tes Validasi', 'Mohammad Alfan', '081334744293', 'mohalfan22@gmail.com', '', 'Testing Doang', 0, 'BerkasSuratAcara/11122018061130web_design-be6dda2c51.pdf', '2018-12-11 06:00:00', '2018-12-11 08:00:00'),
(19, 0, 'Seminar TOEFL', 'Usertes', '081334744293', 'mohalfan22@gmail.com', 'Fakultas Ilmu Komputer Universitas Brawijaya', 'Tes Toefl', 40, 'BerkasSuratAcara/2312201814150020_Updated_Jadwal_UAS_Semester_Genap_2017-2018.pdf', '2018-12-24 02:00:00', '2018-12-24 05:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `eventagenda`
--

CREATE TABLE `eventagenda` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(20) NOT NULL,
  `COLOR` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `eventagenda`
--

INSERT INTO `eventagenda` (`ID`, `NAME`, `COLOR`) VALUES
(1, 'Undangan', '#F22613'),
(2, 'Appointment', '#ff0080'),
(3, 'Rapat', '#ff8000'),
(4, 'Mengajar', '#00d82e');

-- --------------------------------------------------------

--
-- Struktur dari tabel `guestbook`
--

CREATE TABLE `guestbook` (
  `ID_GUESTBOOK` int(11) NOT NULL,
  `GUESTNAME` varchar(100) NOT NULL,
  `AFFILIATION` varchar(255) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `NOTELP` varchar(20) NOT NULL,
  `INTENTION` varchar(255) NOT NULL,
  `TIME_ARRIVE` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `TIME_LEAVE` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `reservation`
--

CREATE TABLE `reservation` (
  `ID_RESERVATION` int(11) NOT NULL,
  `APPLICANTNAME` varchar(100) NOT NULL,
  `APPLICANTAFFILIATION` varchar(100) NOT NULL,
  `APPLICANTEMAIL` varchar(100) NOT NULL,
  `APPLICANTNOTELP` varchar(20) NOT NULL,
  `REFERENCELETTERPATH` varchar(100) NOT NULL,
  `EVENTNAME` varchar(255) NOT NULL,
  `ADDITIONALINFO` varchar(255) NOT NULL,
  `ID_ROOM` int(11) NOT NULL,
  `TIME_START` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `TIME_END` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `reservation`
--

INSERT INTO `reservation` (`ID_RESERVATION`, `APPLICANTNAME`, `APPLICANTAFFILIATION`, `APPLICANTEMAIL`, `APPLICANTNOTELP`, `REFERENCELETTERPATH`, `EVENTNAME`, `ADDITIONALINFO`, `ID_ROOM`, `TIME_START`, `TIME_END`) VALUES
(13, 'Mohammad Alfan', 'Front Desk LPPM UB', 'mohalfan22@gmail.com', '081334744293', 'BerkasSuratAcara/08122018080043PAPB_SI_6_Intent.pdf', 'Tes Rapat', 'Tes Acara', 3, '2018-12-08 03:00:00', '2018-12-08 05:00:00'),
(14, 'Guwe', 'Filkom UB', 'mohalfan22@gmail.com', '081334744293', 'BerkasPinjamRuang/08122018080505PAPB_SI_5_EventHandler.pdf', 'semhas PKL', 'Tes Aja Hehe', 3, '2018-12-08 06:00:00', '2018-12-08 09:00:00'),
(15, 'Mohammad Alfan', 'Front Desk LPPM UB', 'mohalfan22@gmail.com', '081334744293', 'BerkasSuratAcara/11122018061130web_design-be6dda2c51.pdf', 'Tes Validasi', 'Testing Doang', 2, '2018-12-11 06:00:00', '2018-12-11 08:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `room`
--

CREATE TABLE `room` (
  `ID_ROOM` int(11) NOT NULL,
  `ROOMNAME` varchar(50) NOT NULL,
  `CAPACITY` int(11) NOT NULL,
  `ADDITIONALINFO` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `room`
--

INSERT INTO `room` (`ID_ROOM`, `ROOMNAME`, `CAPACITY`, `ADDITIONALINFO`) VALUES
(1, 'Ruang A', 30, ''),
(2, 'Ruang B', 30, ''),
(3, 'Ruang C', 40, ''),
(4, 'Ruang D', 40, ''),
(5, 'Lainnya', 30, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `JENIS_KELAMIN` varchar(10) NOT NULL,
  `TANGGAL_LAHIR` date NOT NULL,
  `NO_TELP` varchar(20) NOT NULL,
  `JABATAN` varchar(20) NOT NULL,
  `STATUS` varchar(20) NOT NULL,
  `KETERANGAN` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `FOTO_PROFIL` varchar(30) NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `nama`, `JENIS_KELAMIN`, `TANGGAL_LAHIR`, `NO_TELP`, `JABATAN`, `STATUS`, `KETERANGAN`, `email`, `FOTO_PROFIL`, `level`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Mohammad Alfan', 'L', '0000-00-00', '', '', '', '', '', 'user.png', 0),
(2, 'user1', '24c9e15e52afc47c225b757e7bee1f9d', 'Pimpinan Satu', 'L', '0000-00-00', '081334744293', 'Pimpinan', '', 'Coba Edit', 'mohalfan10@gmail.com', '171120181059382m09zh.jpg', 1),
(3, 'user2', '7e58d63b60197ceb55a1c487989a3720', 'Pimpinan Dua', 'L', '0000-00-00', '', '', '', '', 'mohalfan8@gmail.com', 'user.png', 1),
(4, 'user3', '92877af70a45fd6a2ed7fe81e1236b78', 'Pimpinan Tiga', 'L', '0000-00-00', '', '', '', '', 'pimpinan3@gmail.com', 'user.png', 1),
(5, 'user4', '3f02ebe3d7929b091e3d8ccfde2f3bc6', 'Pimpinan Empat', 'L', '0000-00-00', '', '', '', '', 'pimpinan4@gmail.com', 'user.png', 1),
(6, 'user5', '0a791842f52a0acfbb3a783378c066b8', 'Pimpinan Lima', 'L', '0000-00-00', '', '', '', '', 'pimpinan5@gmail.com', 'user.png', 1),
(7, 'sekretaris1', '279dfd0ab785aeca74cf4a8a61f675fa', 'Sekretaris Testing', 'L', '1998-10-31', '081999999999', 'Sekretaris', 'Aktif', 'Testing aja Guys', 'testing@gmail.com', 'user.png', 2),
(8, 'frontdesk', '83c0cf468771e10150e77501f8beb4ab', 'Mas Frondesk', 'P', '0000-00-00', '081234567890', 'Frontdesk', 'Aktif', 'User Frontdesk', 'frondesk@gmail.com', 'user.png', 3);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`ID_AGENDA`),
  ADD KEY `FK_jenis_agenda` (`JENIS_AGENDA`),
  ADD KEY `FK_user` (`ID_USER`),
  ADD KEY `FK_agenda_event` (`ID_ACARA`);

--
-- Indeks untuk tabel `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`ID_EVENT`),
  ADD KEY `FK_event_room` (`ID_ROOM`);

--
-- Indeks untuk tabel `eventagenda`
--
ALTER TABLE `eventagenda`
  ADD PRIMARY KEY (`ID`);

--
-- Indeks untuk tabel `guestbook`
--
ALTER TABLE `guestbook`
  ADD PRIMARY KEY (`ID_GUESTBOOK`);

--
-- Indeks untuk tabel `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`ID_RESERVATION`),
  ADD KEY `FK_RESERVATION_ROOM` (`ID_ROOM`);

--
-- Indeks untuk tabel `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`ID_ROOM`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `agenda`
--
ALTER TABLE `agenda`
  MODIFY `ID_AGENDA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `event`
--
ALTER TABLE `event`
  MODIFY `ID_EVENT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `eventagenda`
--
ALTER TABLE `eventagenda`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `guestbook`
--
ALTER TABLE `guestbook`
  MODIFY `ID_GUESTBOOK` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `reservation`
--
ALTER TABLE `reservation`
  MODIFY `ID_RESERVATION` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `room`
--
ALTER TABLE `room`
  MODIFY `ID_ROOM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `agenda`
--
ALTER TABLE `agenda`
  ADD CONSTRAINT `FK_jenis_agenda` FOREIGN KEY (`JENIS_AGENDA`) REFERENCES `eventagenda` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_user` FOREIGN KEY (`ID_USER`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `FK_RESERVATION_ROOM` FOREIGN KEY (`ID_ROOM`) REFERENCES `room` (`ID_ROOM`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
