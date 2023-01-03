-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 28 Ara 2022, 11:04:02
-- Sunucu sürümü: 10.4.22-MariaDB
-- PHP Sürümü: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `business_comment`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `KId` int(11) NOT NULL,
  `Kadi` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `Ksoyadi` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `DTarihi` date NOT NULL,
  `TelNo` varchar(10) COLLATE utf8_turkish_ci DEFAULT NULL,
  `EMail` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `KullaniciUnvan` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `KullaniciUlke` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `KullaniciSehir` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `KullaniciIlce` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `KayitTarihi` datetime NOT NULL DEFAULT current_timestamp(),
  `Kullanici_Tip_Id` int(11) NOT NULL,
  `SirketId` int(11) NOT NULL,
  `YorumYapilsinMi` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`KId`, `Kadi`, `Ksoyadi`, `DTarihi`, `TelNo`, `EMail`, `KullaniciUnvan`, `KullaniciUlke`, `KullaniciSehir`, `KullaniciIlce`, `KayitTarihi`, `Kullanici_Tip_Id`, `SirketId`, `YorumYapilsinMi`) VALUES
(1, 'Çağatay', 'Gündoğdu,', '2002-07-23', '5074852470', 'cagataygundogdu2@gmail.com', 'Veritabanı Yöneticisi', 'Türkiye', 'İstanbul', 'Küçükçekmece', '2022-12-25 00:00:00', 1, 1, b'1'),
(2, 'Berkant', 'Ahmadi,', '2002-01-01', '5074852698', 'bahmadi@gmail.com', 'Veritabanı Yönetici Yardımcısı', 'Türkiye', 'İstanbul', 'Küçükçekmece', '2022-12-25 00:00:00', 1, 1, b'1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanici_tip`
--

CREATE TABLE `kullanici_tip` (
  `Kullanici_Tip_Id` int(11) NOT NULL,
  `Kullanici_Tip_Tanim` varchar(255) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `kullanici_tip`
--

INSERT INTO `kullanici_tip` (`Kullanici_Tip_Id`, `Kullanici_Tip_Tanim`) VALUES
(1, 'Admin'),
(2, 'Yönetici'),
(3, 'Çalışan');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanici_yorumlari`
--

CREATE TABLE `kullanici_yorumlari` (
  `KId` int(11) NOT NULL,
  `YorumIcerik` varchar(300) COLLATE utf8_turkish_ci NOT NULL,
  `YorumDurum` bit(1) NOT NULL,
  `YorumTarih` datetime NOT NULL DEFAULT current_timestamp(),
  `YorumId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `kullanici_yorumlari`
--

INSERT INTO `kullanici_yorumlari` (`KId`, `YorumIcerik`, `YorumDurum`, `YorumTarih`, `YorumId`) VALUES
(1, 'Başarılı bir çalışan olduğunu düşünüyorum.', b'1', '2022-12-26 00:52:00', 1),
(2, 'Başarılı bir çalışan olduğunu düşünüyorum.', b'1', '2022-12-26 00:53:00', 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sektor`
--

CREATE TABLE `sektor` (
  `SektorId` int(11) NOT NULL,
  `SektorTanim` varchar(255) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `sektor`
--

INSERT INTO `sektor` (`SektorId`, `SektorTanim`) VALUES
(1, 'Yazılım'),
(2, 'Otomotiv'),
(3, 'İlaç Sanayi');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sirketler`
--

CREATE TABLE `sirketler` (
  `Sirket_Adi` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `SektorId` int(11) NOT NULL,
  `SirketId` int(11) NOT NULL,
  `SektorTanim` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `SirketUlke` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `SirketSehir` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `SirketIlce` varchar(255) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `sirketler`
--

INSERT INTO `sirketler` (`Sirket_Adi`, `SektorId`, `SirketId`, `SektorTanim`, `SirketUlke`, `SirketSehir`, `SirketIlce`) VALUES
('Business Comment', 1, 1, 'Yazılım', 'Türkiye', 'İstanbul', 'Avcılar');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`KId`),
  ADD KEY `Kullanici_Tip_Id` (`Kullanici_Tip_Id`),
  ADD KEY `SirketId` (`SirketId`);

--
-- Tablo için indeksler `kullanici_tip`
--
ALTER TABLE `kullanici_tip`
  ADD PRIMARY KEY (`Kullanici_Tip_Id`);

--
-- Tablo için indeksler `kullanici_yorumlari`
--
ALTER TABLE `kullanici_yorumlari`
  ADD PRIMARY KEY (`YorumId`),
  ADD KEY `KId` (`KId`);

--
-- Tablo için indeksler `sektor`
--
ALTER TABLE `sektor`
  ADD PRIMARY KEY (`SektorId`);

--
-- Tablo için indeksler `sirketler`
--
ALTER TABLE `sirketler`
  ADD PRIMARY KEY (`SirketId`),
  ADD KEY `SektorId` (`SektorId`),
  ADD KEY `SektorId_2` (`SektorId`),
  ADD KEY `SektorId_3` (`SektorId`),
  ADD KEY `SektorTanim` (`SektorTanim`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `KId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `kullanici_tip`
--
ALTER TABLE `kullanici_tip`
  MODIFY `Kullanici_Tip_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `kullanici_yorumlari`
--
ALTER TABLE `kullanici_yorumlari`
  MODIFY `YorumId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `sektor`
--
ALTER TABLE `sektor`
  MODIFY `SektorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD CONSTRAINT `kullanicilar_ibfk_1` FOREIGN KEY (`Kullanici_Tip_Id`) REFERENCES `kullanici_tip` (`Kullanici_Tip_Id`),
  ADD CONSTRAINT `kullanicilar_ibfk_2` FOREIGN KEY (`SirketId`) REFERENCES `sirketler` (`SirketId`);

--
-- Tablo kısıtlamaları `kullanici_yorumlari`
--
ALTER TABLE `kullanici_yorumlari`
  ADD CONSTRAINT `kullanici_yorumlari_ibfk_1` FOREIGN KEY (`KId`) REFERENCES `kullanicilar` (`KId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
