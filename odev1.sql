-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 08 Kas 2020, 21:18:24
-- Sunucu sürümü: 10.4.14-MariaDB
-- PHP Sürümü: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `odev1`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `alternative_brands`
--

CREATE TABLE `alternative_brands` (
  `BRAND_BARCODE` char(13) NOT NULL,
  `M_SYSCODE` int(11) NOT NULL,
  `ALTERNATIVE_BRAND_BARCODE` char(13) NOT NULL,
  `ALTERNATIVE_M_SYSCODE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `brand_orgs`
--

CREATE TABLE `brand_orgs` (
  `LOT_ID` int(11) NOT NULL,
  `ORG_ID` int(11) NOT NULL,
  `BRAND_BARCODE` char(13) NOT NULL,
  `EXPIRY_DATE` date NOT NULL,
  `BASE_PRICE` float DEFAULT NULL,
  `IN_AMOUNT` float NOT NULL,
  `OUT_AMOUNT` float NOT NULL,
  `QUANTITY` float GENERATED ALWAYS AS (`IN_AMOUNT` + `OUT_AMOUNT`) VIRTUAL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `country`
--

CREATE TABLE `country` (
  `COUNTRY_CODE` char(3) NOT NULL,
  `Country_Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `country_city`
--

CREATE TABLE `country_city` (
  `CITY_ID` int(11) NOT NULL,
  `CITY_NAME` varchar(100) NOT NULL,
  `COUNTRY_CODE` char(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `features`
--

CREATE TABLE `features` (
  `FEATURE_ID` int(11) NOT NULL,
  `FEATURE_NAME` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `flow`
--

CREATE TABLE `flow` (
  `SOURCE_LOT_ID` int(11) NOT NULL,
  `SOURCE_ORG_ID` int(11) NOT NULL,
  `TARGET_LOT_ID` int(11) NOT NULL,
  `TARGET_ORG_ID` int(11) NOT NULL,
  `BRAND_BARCODE` char(13) NOT NULL,
  `QUANTITY` float DEFAULT NULL,
  `FLOWDATE` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `manufacturers`
--

CREATE TABLE `manufacturers` (
  `MANUFACTURER_ID` int(11) NOT NULL,
  `MANUFACTURER_NAME` varchar(200) NOT NULL,
  `MANUFACTURER_ADDRESS` varchar(200) NOT NULL,
  `CITY` int(11) NOT NULL,
  `COUNTRY` char(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `organisations`
--

CREATE TABLE `organisations` (
  `ORG_ID` int(11) NOT NULL,
  `ORG_NAME` varchar(100) NOT NULL,
  `PARENT_ORG` int(11) DEFAULT NULL,
  `ORG_ABSTRACT` tinyint(1) NOT NULL,
  `ORG_ADDRESS` varchar(200) NOT NULL,
  `ORG_CITY` int(11) NOT NULL,
  `ORG_DISTRICT` varchar(50) DEFAULT NULL,
  `ORG_TYPE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `org_owner`
--

CREATE TABLE `org_owner` (
  `ORG_NAME` varchar(100) NOT NULL,
  `NAME` varchar(50) NOT NULL,
  `SURNAME` varchar(50) NOT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `PHONE` varchar(50) NOT NULL,
  `FAX` varchar(50) NOT NULL,
  `ADRESS` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `product`
--

CREATE TABLE `product` (
  `M_SYSCODE` int(11) NOT NULL,
  `M_CODE` varchar(15) NOT NULL,
  `M_NAME` varchar(30) NOT NULL,
  `M_SHORTNAME` varchar(10) DEFAULT NULL,
  `M_PARENTCODE` varchar(15) NOT NULL,
  `M_ABSTRACT` tinyint(1) NOT NULL,
  `M_CATEGORY` varchar(12) NOT NULL,
  `IS_ACTIVE` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `product_brands`
--

CREATE TABLE `product_brands` (
  `BRAND_BARCODE` char(13) NOT NULL,
  `BRAND_NAME` varchar(100) NOT NULL,
  `MANUFACTURER_ID` int(11) NOT NULL,
  `M_SYSCODE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `product_features`
--

CREATE TABLE `product_features` (
  `M_SYSCODE` int(11) NOT NULL,
  `FEATURE_ID` int(11) NOT NULL,
  `MINVAL` float DEFAULT NULL,
  `MAXVAL` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `USER_ID` int(11) NOT NULL,
  `PASSWORD` varchar(50) NOT NULL,
  `USERNAME` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`USER_ID`, `PASSWORD`, `USERNAME`) VALUES
(1, 'admin', 'admin');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `alternative_brands`
--
ALTER TABLE `alternative_brands`
  ADD PRIMARY KEY (`BRAND_BARCODE`,`M_SYSCODE`,`ALTERNATIVE_M_SYSCODE`,`ALTERNATIVE_BRAND_BARCODE`),
  ADD KEY `ALTERNATIVE_BRAND_BARCODE` (`ALTERNATIVE_BRAND_BARCODE`),
  ADD KEY `M_SYSCODE` (`M_SYSCODE`),
  ADD KEY `ALTERNATIVE_M_SYSCODE` (`ALTERNATIVE_M_SYSCODE`);

--
-- Tablo için indeksler `brand_orgs`
--
ALTER TABLE `brand_orgs`
  ADD PRIMARY KEY (`LOT_ID`,`ORG_ID`,`BRAND_BARCODE`,`EXPIRY_DATE`);

--
-- Tablo için indeksler `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`COUNTRY_CODE`);

--
-- Tablo için indeksler `country_city`
--
ALTER TABLE `country_city`
  ADD PRIMARY KEY (`CITY_ID`),
  ADD KEY `COUNTRY_CODE` (`COUNTRY_CODE`);

--
-- Tablo için indeksler `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`FEATURE_ID`);

--
-- Tablo için indeksler `flow`
--
ALTER TABLE `flow`
  ADD PRIMARY KEY (`SOURCE_LOT_ID`,`SOURCE_ORG_ID`,`TARGET_ORG_ID`,`TARGET_LOT_ID`,`BRAND_BARCODE`),
  ADD KEY `BRAND_BARCODE` (`BRAND_BARCODE`),
  ADD KEY `TARGET_LOT_ID` (`TARGET_LOT_ID`),
  ADD KEY `SOURCE_ORG_ID` (`SOURCE_ORG_ID`),
  ADD KEY `TARGET_ORG_ID` (`TARGET_ORG_ID`);

--
-- Tablo için indeksler `manufacturers`
--
ALTER TABLE `manufacturers`
  ADD PRIMARY KEY (`MANUFACTURER_ID`),
  ADD KEY `CITY` (`CITY`),
  ADD KEY `COUNTRY` (`COUNTRY`);

--
-- Tablo için indeksler `organisations`
--
ALTER TABLE `organisations`
  ADD PRIMARY KEY (`ORG_ID`),
  ADD KEY `ORG_CITY` (`ORG_CITY`);

--
-- Tablo için indeksler `org_owner`
--
ALTER TABLE `org_owner`
  ADD PRIMARY KEY (`ORG_NAME`);

--
-- Tablo için indeksler `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`M_SYSCODE`),
  ADD UNIQUE KEY `M_CODE` (`M_CODE`);

--
-- Tablo için indeksler `product_brands`
--
ALTER TABLE `product_brands`
  ADD PRIMARY KEY (`M_SYSCODE`,`BRAND_BARCODE`),
  ADD KEY `BRAND_BARCODE` (`BRAND_BARCODE`),
  ADD KEY `MANUFACTURER_ID` (`MANUFACTURER_ID`);

--
-- Tablo için indeksler `product_features`
--
ALTER TABLE `product_features`
  ADD PRIMARY KEY (`M_SYSCODE`,`FEATURE_ID`),
  ADD KEY `FEATURE_ID` (`FEATURE_ID`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`USER_ID`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `brand_orgs`
--
ALTER TABLE `brand_orgs`
  MODIFY `LOT_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `country_city`
--
ALTER TABLE `country_city`
  MODIFY `CITY_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `features`
--
ALTER TABLE `features`
  MODIFY `FEATURE_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `manufacturers`
--
ALTER TABLE `manufacturers`
  MODIFY `MANUFACTURER_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `organisations`
--
ALTER TABLE `organisations`
  MODIFY `ORG_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `product`
--
ALTER TABLE `product`
  MODIFY `M_SYSCODE` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `USER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `alternative_brands`
--
ALTER TABLE `alternative_brands`
  ADD CONSTRAINT `alternative_brands_ibfk_1` FOREIGN KEY (`BRAND_BARCODE`) REFERENCES `product_brands` (`BRAND_BARCODE`),
  ADD CONSTRAINT `alternative_brands_ibfk_2` FOREIGN KEY (`ALTERNATIVE_BRAND_BARCODE`) REFERENCES `product_brands` (`BRAND_BARCODE`),
  ADD CONSTRAINT `alternative_brands_ibfk_3` FOREIGN KEY (`M_SYSCODE`) REFERENCES `product` (`M_SYSCODE`),
  ADD CONSTRAINT `alternative_brands_ibfk_4` FOREIGN KEY (`ALTERNATIVE_M_SYSCODE`) REFERENCES `product` (`M_SYSCODE`);

--
-- Tablo kısıtlamaları `country_city`
--
ALTER TABLE `country_city`
  ADD CONSTRAINT `country_city_ibfk_1` FOREIGN KEY (`COUNTRY_CODE`) REFERENCES `country` (`COUNTRY_CODE`);

--
-- Tablo kısıtlamaları `flow`
--
ALTER TABLE `flow`
  ADD CONSTRAINT `flow_ibfk_1` FOREIGN KEY (`BRAND_BARCODE`) REFERENCES `product_brands` (`BRAND_BARCODE`),
  ADD CONSTRAINT `flow_ibfk_2` FOREIGN KEY (`SOURCE_LOT_ID`) REFERENCES `brand_orgs` (`LOT_ID`),
  ADD CONSTRAINT `flow_ibfk_3` FOREIGN KEY (`TARGET_LOT_ID`) REFERENCES `brand_orgs` (`LOT_ID`),
  ADD CONSTRAINT `flow_ibfk_4` FOREIGN KEY (`SOURCE_ORG_ID`) REFERENCES `organisations` (`ORG_ID`),
  ADD CONSTRAINT `flow_ibfk_5` FOREIGN KEY (`TARGET_ORG_ID`) REFERENCES `organisations` (`ORG_ID`);

--
-- Tablo kısıtlamaları `manufacturers`
--
ALTER TABLE `manufacturers`
  ADD CONSTRAINT `manufacturers_ibfk_1` FOREIGN KEY (`CITY`) REFERENCES `country_city` (`CITY_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `manufacturers_ibfk_2` FOREIGN KEY (`COUNTRY`) REFERENCES `country` (`COUNTRY_CODE`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `organisations`
--
ALTER TABLE `organisations`
  ADD CONSTRAINT `organisations_ibfk_1` FOREIGN KEY (`ORG_CITY`) REFERENCES `country_city` (`CITY_ID`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `product_brands`
--
ALTER TABLE `product_brands`
  ADD CONSTRAINT `product_brands_ibfk_1` FOREIGN KEY (`M_SYSCODE`) REFERENCES `product` (`M_SYSCODE`),
  ADD CONSTRAINT `product_brands_ibfk_2` FOREIGN KEY (`MANUFACTURER_ID`) REFERENCES `manufacturers` (`MANUFACTURER_ID`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `product_features`
--
ALTER TABLE `product_features`
  ADD CONSTRAINT `product_features_ibfk_1` FOREIGN KEY (`M_SYSCODE`) REFERENCES `product` (`M_SYSCODE`),
  ADD CONSTRAINT `product_features_ibfk_2` FOREIGN KEY (`FEATURE_ID`) REFERENCES `features` (`FEATURE_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
