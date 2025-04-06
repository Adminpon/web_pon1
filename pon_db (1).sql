-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2025 at 10:12 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pon_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image_path`) VALUES
(1, 'วัด', 'path/to/image.jpg'),
(2, 'คาเฟ่', 'path/to/image.jpg'),
(3, 'ร้านอาหาร', 'path/to/image_restaurant.jpg'),
(4, 'ตลาด', 'path/to/image_market.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE `places` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `opening_hours` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`id`, `name`, `description`, `image`, `address`, `category`, `latitude`, `longitude`, `contact`, `opening_hours`) VALUES
(4, 'ร้านอาหารอร่อย', 'ร้านอาหารไทยรสชาติต้นตำรับ', '../uploads/1743005756_blue_archive_anime_cover.jpg', 'กรุงเทพมหานคร', 'ร้านอาหาร', 13.7299, 100.523, '02-999-9999', '11:00-22:00'),
(9, 'จจจ', 'dddd', '../uploads/1742404269_blue_archive_anime_cover.jpg', '555', 'คาเฟ่', 0, 0, 'ddd', '10.00-10.30 น.'),
(11, 'ชชชชช', 'กหก', '../uploads/1743195382_frwr4.jpg', '555', 'คาเฟ่', 0, 0, '095-555-9996', ''),
(12, 'ddd', 'dddd', '../uploads/1743572804_Blue-Archive-image.png', '555', 'วัด', 0, 0, '095-555-9996', '10.00-10.30 น.'),
(14, 'Ai Garden Cafe & Studio', ' คาเฟ่อุบลในเมือง ที่พร้อมเสิร์ฟความสุขด้วยกลิ่นหอมของกาแฟและชาเขียว พื้นที่กว้างขวาง ร่มรื่น บรรยากาศดี มีปลาคาร์พนำเข้าจากญี่ปุ่นให้ลูกค้าได้ชมและสัมผัสบรรยากาศกันเต็มอิ่ม เหมือนยกญี่ปุ่นมาไว้ที่อุบลฯ นอกจากเครื่องดื่มแล้วก็ยังมีไอศกรีมหลากหลายรสชาติเอาไว้ให้ลิ้มลอง รวมถึงยังมีมุมถ่ายรูปสวย ๆ ซึ่งทางคาเฟ่ก็จะมีการตกแต่งเปลี่ยนไปตามแต่ละซีซั่น (ช่วงนี้เป็นสวนเลมอนลูกสีเหลือง ตัดกันดีกับใบสีเขียว) เป็นอีกหนึ่งสีสันความสนุกเมื่อมาเช็กอิน', '../uploads/1743665180_d3ad57e2-7e86-4a6b-b9ce-a1a20f26d9f1.jpg', 'หมู่ที่ 10 ซอยสกุลเงิน ตำบลขามใหญ่ อำเภอเมืองอุบลราชธานี จังหวัดอุบลราชธานี', 'คาเฟ่', 0, 0, ' 090 896 5446', '09.00-18.00 น.'),
(15, 'ถนนคนเดินริมมูล เทศบาลนครอุบลราชธานี', 'อาหารหลักสิบ แต่วิวหลักล้าน! อิ่มอร่อยไปกับอาหารหลากหลาย ทั้งของคาว ของหวาน และเครื่องดื่มสุดฟิน  และสายช้อปต้องมา! พบกับสินค้าหลากสไตล์ ทั้งของฝาก งานแฮนด์เมด และเสื้อผ้าแฟชั่นมากมาย', '../uploads/1743944113_488837554_663829879846940_7451046780665300376_n.jpg', ' ถนนคนเดินริมมูล เทศบาลนครอุบลราชธานี(ช่วงใต้สะพานเสรีประชาธิปไตย ถึงทางลงข้างวัดสุปัฏนาราม)', 'ตลาด', 0, 0, '', '17.00 - 22.00 น.'),
(16, 'Blendstorm Coffee Roasters', '         คาเฟ่อุบลในเมือง โดดเด่นด้วยสไตล์การตกแต่ง Contemporary ที่ผสมผสานระหว่างความมินิมอลและความเป็นตึกเก่าที่คงเอกลักษณ์เอาไว้ได้อย่างลงตัว ภายในร้านบรรยากาศสบาย ๆ แฝงโทนอบอุ่นด้วยเฟอร์นิเจอร์ไม้ พลาดไม่ได้กับเมนูแนะนำของทางร้าน “อเมริกาโน่” สัมผัสกับรสชาติกาแฟจริง ๆ ด้วยการเลือกใช้วัตถุดิบและอุปกรณ์ที่ดี เพื่อกาแฟที่มีคุณภาพ ให้ทุกคนที่มาเช็กอินประทับใจ', '../uploads/1743945974_0a9882e0-b91e-49d5-882a-709608647ea8.jpg', 'ถนนเขื่อนธานี ตำบลในเมือง อำเภอเมืองอุบลราชธานี จังหวัดอุบลราชธานี', 'คาเฟ่', 0, 0, '09-4251-1668', '07.00-17.00 น.'),
(17, 'Normal Ubon', '     คาเฟ่อุบลในเมืองย่านตัวเมืองเก่า มาในสไตล์มินิมอล บรรยากาศอบอุ่น คลาสสิก ตกแต่งอาคารด้วยสีเขียวให้ความรู้สึกสบายตา ประดับประดาด้วยไฟสีเหลืองดูอบอุ่น เมื่อเข้ามาข้างในจะเจอกับห้องโถงกว้าง เหมาะสำหรับการนั่งพักผ่อนจิบกาแฟชิล ๆ หรือทำงานเงียบ ๆ ก็ได้เช่นกัน พร้อมกับสั่งอาหารและเครื่องดื่ม รวมถึงยังมีเค้กหลากหลายรสชาติ อีกทั้งโทสต์ของที่ร้านก็ละมุน บวกกับมีมุมถ่ายรูปสวย ๆ ยิ่งทำให้ที่นี่บรรยากาศชิลมากขึ้นไปอีก', '../uploads/1743944638_d21b6f93-70d6-4ec6-aee7-da9175fde543.jpg', ' ถนนยุทธภัณฑ์ ตำบลในเมือง อำเภอเมืองอุบลราชธานี จังหวัดอุบลราชธานี', 'คาเฟ่', 0, 0, '08-8225-1000', '08.00-20.00 น.'),
(18, 'TREE CAFE Rim Moon ', 'บรรยากาศ - ร้านอาหารแนวๆคาเฟ่ มีรายการอาหารเครื่องดื่มทั้งอาหารจานเดียว อาหารกับข้าว กับแกล้ม ขนมหวาน ร้านเปิดตั้งแต่ช่วงสายๆไปจนถึงเที่ยงคืนแนะ เรียกได้ว่าจะมาเป็นมื้อสาย มื้อเที่ยงมื้อเย็นได้หมดเลย พนักงานบริการดี มีมุมถ่ายรูปไม่เยอะแต่วิวมองนอกกระจกร้านสวยริมแม่น้ำมูล', '../uploads/1743945103_480467123_1012143604271561_619919653224495219_n.jpg', 'ถ.เลียบแม่น้ำมูล, อุบลราชธานี, ประเทศไทย, อุบลราชธานี', 'คาเฟ่', 0, 0, ' 063 429 6614', '09:00 - 23:59 น.'),
(19, 'MongMoon -มองมูล ', 'ร้านนี้ คนมาอุบลจะต้องว๊อนที่จะมา เพราะบรรยากาศดี ริมฝั่งแม่น้ำมูลเลย เป็นทั้งคาเฟ่และร้านอาหาร ส่วนกลางคืนเป็นร้านอาหารแบบจัดเต็ม คนมาทานข้าวเยอะมาก ทั้งครอบครับ คู่รัก หมู่คณะ เพราะบรรยากาศดีเหลือเกินครับ มาถึงเลือกที่นั่งเลยนะ จะในห้องแอร์ รึริมมูลก็สะดวกครับ เมนูมีหลากหลาย หน้าตาดี รสชาติก็ดีครับ อ่านต่อได้ที่ ', '../uploads/1743945376_468679741_984054066866818_4239067316408452912_n.jpg', '251 ม.6 ต.แจระแม', 'คาเฟ่', 0, 0, '095 236 4264', '11:00 - 23:00 น.'),
(20, 'ตลาดโต้รุ่ง ทุ่งศรีเมือง', '#ตลาดโต้รุ่งทุ่งศรีเมือง #อุบลราชธานี รวมร้านอาหารระดับตำนาน และเป็นแหล่งรวมอาหารเวียดนาม ซึ่งเน้นไปที่อาหารการกินนานาชนิดรวบรวมกันไว้ได้หลากหลายวัฒนธรรม ทั้งอาหารไทย จีน อีสาน รวมถึงอาหารเวียดนามที่ขึ้นชื่อของเมืองอุบล', '../uploads/1743945887_3944f6a69d5c48d5b0ccf2c34839a0cf.jpg', 'ถนน เขื่อนธานี อำเภอเมืองอุบลราชธานี อุบลราชธานี 34000', 'ตลาด', 0, 0, '', '16.00-23.00 น'),
(21, 'ตลาดสุนีย์เฟลียร์มาร์เก็ต', 'ตลาด สุนีย์ เฟลียร์ มาร์เก็ต แหล่งช้อปปิ้งกลางคืนของคนอุบล สายกินสายช้อปต้องเข้าเเล้วละ กับหลากหลายเมนูสินค้าที่สุดจัดจ้านในย่านนี้ มีทั้งของกินของใช้ให้เลือกช้อปกันอย่างมากมาย', '../uploads/1743951737_0.2.2.png', '512/8 ถ. ชยางกูร ตำบล ในเมือง อำเภอเมืองอุบลราชธานี อุบลราชธานี 34000', 'ตลาด', 0, 0, '083-9742263', '17.00 น. - 23.00 น.'),
(22, 'ตลาดฮักมูล..เดิน-ชิม-ฮิม-มูล', 'บรรยากาศดี อาหารรสชาติดี ราคาไม่แพง วิวดีมาก ผ่านมาแวะเลยแนะนำและเป็นตลาดนัดกลางคืนนี้มีร้านอาหารให้เลือกรับประทานได้หลากหลายหลายและมีเพลงฟัง มีเบียร์ด้วย ดนตรีสดหนูเหมาะสำหรับทุกเพศทุกวัย', '../uploads/1743946652_maxresdefault.jpg', '119/2 ต.บุ้งไหม อ.วารินชำราบ จ.อุบลราชธานี, Ubon Ratchathani, Thailand, Ubon Ratchathani', 'ตลาด', 0, 0, ' 087 255 6444', '16.00 น. - 24.00 น.'),
(23, 'วัดพระธาตุหนองบัว', ' สักการะ พระธาตุเจดีย์ศรีมหาโพธิ์ หรือที่ชาวอุบลเรียกกันว่า พระธาตุหนองบัว พระธาตุประจำปีเกิดปีมะเส็งที่ วัดพระธาตุหนองบัว พระธาตุแห่งนี้ได้จำลองรูปแบบสถาปัตยกรรมมาจากเจดีย์พุทธคยา สถานที่ตรัสรู้ของพระพุทธเจ้าที่ประเทศอินเดีย จึงทำให้มีลักษณะแตกต่างจากองค์เจดีย์พระธาตุทั่วไปในประเทศไทย ด้านในเป็นที่บรรจุพระบรมสารีริกธาตุเพื่อให้ผู้คนได้มากราบไหว้ขอพรกัน', '../uploads/1743947995_ecea7fd0eaeea8e691fec9e9bb2575e8.jpg', 'ตำบลในเมือง อำเภอเมืองอุบลราชธานี จังหวัดอุบลราชธานี', 'วัด', 0, 0, '', '06.00-18.00 น.'),
(24, 'วัดสิรินธรวรารามภูพร้าว', 'วัดสิรินธรวรารามภูพร้าว หรือ วัดภูพร้าว ตั้งอยู่บนเนินเขาสูง ในอำเภอสิรินธร จังหวัดอุบลราชธานี โดดเด่นด้วยพระอุโบสถสีปัดทอง แต่งแต้มด้วยงานจิตรกรรมปรากฏเป็นรูปต้นกัลปพฤกษ์สีเขียวเรืองแสง พร้อมกับลวดลายบนบึงบนที่จะกักเก็บพลังงานแสงอาทิตย์ในตอนกลางวัน และเปล่งประกายเป็นสีน้ำเงินเจิดจ้าในยามกลางคืน', '../uploads/1743948200_วัดสิรินธรวรารามภูพร้าวยามค่ำคืน.jpg', 'ตำบลช่องเม็ก อำเภอสิรินธร จังหวัดอุบลราชธานี', 'วัด', 0, 0, '', '06.00-20.00 น.'),
(25, 'วัดมหาวนาราม', 'วัดมหาวนาราม มีความหมายว่า วัดป่าใหญ่ เป็นพระอารามหลวงคู่บ้านคู่เมืองอุบลราชธานีที่สร้างขึ้นเมื่อปี พ.ศ. 2322 มีกลิ่นอายของสถาปัตยกรรมแบบล้านนา สังเกตได้จากพระอุโบสถที่จะมีหลังคาจั่วซ้อนกันหลายชั้น นอกจากนี้ ในโบสถ์วัดมหาวนารามยังเป็นที่ประดิษฐาน พระเจ้าใหญ่อินแปง พระพุทธรูปศักดิ์สิทธิ์ที่ชาวอุบลฯ', '../uploads/1743948441_wiharn.jpg', '370 ถนนหลวง ตำบลในเมือง อำเภอเมืองอุบลราชธานี จังหวัดอุบลราชธานี', 'วัด', 0, 0, '', '06.00-18.00 น.'),
(26, 'วัดทุ่งศรีเมือง', 'วัดทุ่งศรีเมือง เป็นวัดที่ตั้งอยู่ใจกลางเมืองอุบลฯ ที่มีความเงียบสงบ และมีพื้นที่โล่งกว้าง แตกต่างจากวัดอื่นในเมือง จุดเด่นของวัดแห่งนี้คือ หอพระไตรปิฎกโบราณกลางน้ำ ที่สร้างขึ้นตั้งแต่สมัยรัชกาลที่ 3 เป็นเรือนไม้ผสมผสานศิลปะระหว่างไทย พม่า และลาว โดยตัวอาคารเป็นเรือนไทยแบบฝาปะกน ส่วนหน้าบันจะมีลวดลายแกะสลักด้วยศิลปะแบบลาว เมื่อตั้งอยู่กลางน้ำแล้วก็ให้อารมณ์สุนทรีย์เป็นอย่างมากเลยทีเดียว', '../uploads/1743948791__MG_2611.jpg', '95 ถนนหลวง ตำบลในเมือง อำเภอเมืองอุบลราชธานี จังหวัดอุบลราชธานี', 'วัด', 0, 0, '', '08.00-18.00'),
(27, 'ร้านอาหารชมจันทร์', 'ร้านชมจันทร์เป็นร้านอาหารติดริมแม่น้ำ ขรรยากาศดีอีกร้านของอุบลราชธานีค่ะ ร้านนี้มีที่พักให้บริการด้วยนะ อ่านต่อได้ที่ เมนูอาหารมีให้เลือกหลากหลาย รสชาติโดยรวมๆ ถือว่า ใช้ได้เลยนะ เมนูที่โดนใจเลยจะเป็นพวกต้มยำ รสชาติเปรี้ยวจัดจ้าน ทานคู่กับไข่เจียว ก็อร่อยละ ส่วนเมนูตำถั่ว หมูกรอบนี่ก็เด็ด รสชาติเผ็ดนัว หอมกลิ่นปลาร้า ห่อหมกทะเล รสชาติจัดจ้าน ก็พลาดไม่ได้เช่นกัน ', '../uploads/1743950070_3612278962023-05-03.jpg', '119/1 หมู่ที่8 ต.บุ่งไหม อ.วารินชำราบ , Ubon Ratchathani, Thailand, Ubon Ratchathani', 'ร้านอาหาร', 0, 0, ' 084 477 1999', '11:00 - 00:00 น.'),
(28, 'ข้าวต้มสันติโภชนา', 'ข้าวต้มสันติโภชนาเป็นร้านข้าวต้มที่ขึ้นชื่อในเรื่องของรสชาติและคุณภาพวัตถุดิบที่สดใหม่ ด้วยประสบการณ์ที่ยาวนาน ทำให้ร้านนี้เป็นที่นิยมในหมู่คนท้องถิ่นและนักท่องเที่ยวที่อยากลองลิ้มรสอาหารไทยแบบดั้งเดิม\r\n\r\nเมื่อเดินเข้ามาในร้านจะสัมผัสได้ถึงบรรยากาศที่อบอุ่นและเป็นกันเอง พนักงานบริการดีและคอยดูแลอย่างเต็มที่ หน้าตาของร้านก็สะอาดสะอ้านทำให้รู้สึกสบายใจขณะทานอาหาร', '../uploads/1743950520_caption.jpg', '101-107, ถนนชวาลานอก, Ubon Ratchathani, Thailand, Ubon Ratchathani', 'ร้านอาหาร', 0, 0, '045 240 233', '14:00 - 23:30 น.'),
(29, 'โอชิเน อุบล', 'โอชิเน อุบล (Oshine Ubon) เป็นร้านอาหารญี่ปุ่นที่ได้รับความนิยมในจังหวัดอุบลราชธานี ด้วยบรรยากาศร้านที่น่ารักและสะอาดตา รวมถึงการบริการที่ดีเยี่ยม ทำให้ร้านนี้กลายเป็นที่นิยมของทั้งคนท้องถิ่นและนักท่องเที่ยวที่ชื่นชอบอาหารญี่ปุ่น\r\n\r\nบรรยากาศและการบริการ ร้านโอชิเน อุบลมีการตกแต่งที่ทันสมัย แต่ยังคงมีความอบอุ่นในสไตล์ญี่ปุ่น การตกแต่งโดยรวมค่อนข้างเรียบง่ายและสะอาดตา ทำให้รู้สึกผ่อนคลายขณะทานอาหาร พนักงานบริการดี มีความเป็นมิตรและใส่ใจลูกค้าอย่างเต็มที่ แม้ร้านจะค่อนข้างมีลูกค้าเยอะในบางช่วงเวลา แต่การบริการก็ยังคงรวดเร็วและเอาใจใส่', '../uploads/1743951626_010101.png', '92 ถ.ชวาลาใน ต.ในเมือง อ.เมือง, Ubon Ratchathani, Thailand, Ubon Ratchathani', 'ร้านอาหาร', 0, 0, '088 100 2000', '11:00 - 22:00 น.'),
(30, 'แปด はち', 'ร้าน แปด はち เป็นร้านอาหารญี่ปุ่นที่มีสไตล์การตกแต่งที่ทันสมัยและอบอุ่น ตั้งอยู่ในทำเลที่เข้าถึงง่ายในตัวเมืองอุบลราชธานี ร้านนี้เป็นที่รู้จักกันดีในเรื่องของอาหารญี่ปุ่นรสชาติอร่อยและคุณภาพเยี่ยม ที่นี่เป็นตัวเลือกที่ยอดเยี่ยมสำหรับคนที่อยากทานอาหารญี่ปุ่นแท้ๆ ในบรรยากาศสบายๆ', '../uploads/1743952282_05.01.png', 'ร้าน PAED (ชั้น 1 ในโรงแรมบดินทร์) ถนนน พโลชัย, Ubon Ratchathani, Thailand, Ubon Ratchathani', 'ร้านอาหาร', 0, 0, ' 088 930 2160', '11:00 - 21:00 น.');

-- --------------------------------------------------------

--
-- Table structure for table `place_images`
--

CREATE TABLE `place_images` (
  `id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `place_images`
--

INSERT INTO `place_images` (`id`, `place_id`, `image_path`) VALUES
(1, 11, 'uploads/1743195382_blue_archive_anime_cover.jpg'),
(2, 11, 'uploads/1743195382_frwr4.jpg'),
(3, 12, '../uploads/1743572804_2000291057_EN_Blue_Archive_Montana_Takahashi_Tirpitz_Art_j9328_2560x1440_WoWS.jpg.05dbf0ab2d26e9610162d80ddb3bbcb4.jpg'),
(4, 12, '../uploads/1743572804_Blue-Archive-image.png'),
(5, 14, '../uploads/1743665180_91d74324-8050-4b2d-86b6-4577b7a55487.jpg'),
(6, 14, '../uploads/1743665180_A1-Cover.png'),
(7, 14, '../uploads/1743665180_d3ad57e2-7e86-4a6b-b9ce-a1a20f26d9f1.jpg'),
(8, 15, '../uploads/1743944113_488068360_663829736513621_172626988594673416_n.jpg'),
(9, 15, '../uploads/1743944113_488485498_663828456513749_8890864423315459322_n.jpg'),
(10, 15, '../uploads/1743944113_488837554_663829879846940_7451046780665300376_n.jpg'),
(11, 16, '../uploads/1743944433_0a9882e0-b91e-49d5-882a-709608647ea8.jpg'),
(12, 16, '../uploads/1743944433_b694feaf-5223-46ba-b974-351d5638698b.jpg'),
(13, 17, '../uploads/1743944638_d4ab7340-d621-4b59-a879-5b36fdf8fc30.jpg'),
(14, 17, '../uploads/1743944638_d21b6f93-70d6-4ec6-aee7-da9175fde543.jpg'),
(15, 18, '../uploads/1743945102_46768433_2421788161168822_5772625217658552320_n.jpg'),
(16, 18, '../uploads/1743945103_480467123_1012143604271561_619919653224495219_n.jpg'),
(17, 19, '../uploads/1743945376_039e2ab6c55f41b5a2fae1b645d4a716.jpg'),
(18, 19, '../uploads/1743945376_468679741_984054066866818_4239067316408452912_n.jpg'),
(19, 20, '../uploads/1743945841_683dcbb0-497e-11ec-95de-2b631ed824ba_original.jpg'),
(20, 20, '../uploads/1743945841_3944f6a69d5c48d5b0ccf2c34839a0cf.jpg'),
(21, 20, '../uploads/1743945841_c0095fc25c344b55afec78e29721c30e.jpg'),
(22, 21, '../uploads/1743946296_21bb94b968624ae0a0fe3fcca0e5aabf.jpg'),
(23, 21, '../uploads/1743946296_images.jpg'),
(24, 22, '../uploads/1743946652_images (1).jpg'),
(25, 22, '../uploads/1743946652_images (2).jpg'),
(26, 22, '../uploads/1743946652_maxresdefault.jpg'),
(27, 23, '../uploads/1743947995__MG_2522.jpg'),
(28, 23, '../uploads/1743947995_ecea7fd0eaeea8e691fec9e9bb2575e8.jpg'),
(29, 24, '../uploads/1743948200_6f586111cbbbbad9d59d913943ff13ae.jpg'),
(30, 24, '../uploads/1743948200_1491193743.jpg'),
(31, 24, '../uploads/1743948200_วัดสิรินธรวรารามภูพร้าวยามค่ำคืน.jpg'),
(32, 25, '../uploads/1743948441_7128ef326a3d4a8b9a4a4a7ca984fddf.jpg'),
(33, 25, '../uploads/1743948441_DSxG1pvV4AAEJes.jpg'),
(34, 25, '../uploads/1743948441_wiharn.jpg'),
(35, 26, '../uploads/1743948766__MG_2611.jpg'),
(36, 26, '../uploads/1743948766_images (3).jpg'),
(37, 27, '../uploads/1743949992_3612278962023-05-03.jpg'),
(38, 27, '../uploads/1743949992_16021740262023-05-03.jpg'),
(39, 28, '../uploads/1743950520_458613931_2630682793809633_2100894030544000515_n.jpg'),
(40, 28, '../uploads/1743950520_caption (1).jpg'),
(41, 28, '../uploads/1743950520_caption.jpg'),
(42, 29, '../uploads/1743951095_LINE_ALBUM_6468_250406_1.jpg'),
(43, 29, '../uploads/1743951095_LINE_ALBUM_6468_250406_2.jpg'),
(44, 29, '../uploads/1743951095_LINE_ALBUM_6468_250406_3.jpg'),
(45, 29, '../uploads/1743951095_LINE_ALBUM_6468_250406_4.jpg'),
(46, 29, '../uploads/1743951095_LINE_ALBUM_6468_250406_5.jpg'),
(47, 30, '../uploads/1743952282_05.04.png'),
(48, 30, '../uploads/1743952282_05.03.png'),
(49, 30, '../uploads/1743952282_05.02.png'),
(50, 30, '../uploads/1743952282_05.01.png');

-- --------------------------------------------------------

--
-- Table structure for table `problem`
--

CREATE TABLE `problem` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `problem_details` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `problem`
--

INSERT INTO `problem` (`id`, `username`, `phone`, `email`, `subject`, `problem_details`) VALUES
(6, 'ssss', '095-599-11111', 'Dkkk@gmail.com', 'ssss', 'sssaaxx'),
(7, 'admin2', '095-599-11111', 'ssss@gmail.com', 'ssss', 'pppp'),
(8, 'admin2', '095-599-11111', 'ssss@gmail.com', 'ssss', 'pppp'),
(9, 'admin2', '095-599-11111', 'ssss@gmail.com', 'ssss', 'pppp');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `place_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `review_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `place_id`, `user_id`, `rating`, `comment`, `review_date`) VALUES
(1, 9, 2, 3, '4444', '2025-04-03 09:04:06'),
(2, 14, 2, 1, 'ดีมากๆ', '2025-04-03 18:57:52'),
(3, 14, 2, 1, 'ดีมากๆ', '2025-04-03 18:58:31'),
(4, 14, 2, 2, 'ดีมากๆ', '2025-04-03 18:59:02'),
(5, 14, 2, 3, 'มากๆ', '2025-04-03 18:59:25'),
(6, 14, 2, 4, 'นกนก', '2025-04-03 18:59:37'),
(7, 14, 2, 5, 'มาก', '2025-04-03 18:59:54'),
(8, 12, 2, 5, 'ddd', '2025-04-05 04:35:16'),
(9, 12, 2, 1, 'dddd', '2025-04-05 04:38:44'),
(10, 12, 2, 4, 'กกก', '2025-04-05 04:42:30'),
(11, 12, 2, 1, '48848', '2025-04-05 04:44:41'),
(12, 12, 2, 3, '48848', '2025-04-05 04:46:33'),
(13, 11, 2, 5, 'ดีมาก', '2025-04-06 06:23:25'),
(14, 11, 2, 4, 'มาก', '2025-04-06 06:23:33'),
(15, 11, 2, 3, 'ปานกลาง', '2025-04-06 06:23:52'),
(16, 11, 2, 2, 'น้อย', '2025-04-06 06:24:02'),
(17, 11, 2, 1, 'น้อยมาก', '2025-04-06 06:24:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `is_admin`) VALUES
(1, 'admin', '$2y$10$xxxxxxxxxxxxxxxxxxxxxxxxxxxxx', 1),
(2, 'admin2', '$2y$10$dRpwc7Ei8qjtbysvAvlb2.ZLdv.cHe6EhM5SF/WB5ZIDUB.rB62mu', 1),
(3, 'pon', '$2y$10$7vdpQx4nK5l.snjR19CN0.9GgOTWcrMCf5XiNrU0HYEe85RV3lqR2', 0),
(4, 'poo', '$2y$10$wpJcamdlVwjlT286L.pCHOHqNkXBtZl8y/5XHaDE7fZnzPzI7n7qm', 0),
(5, 'ooo', '$2y$10$F/e5jXAZm4Qcfosh9JtWtuq0XGgZNjhYkpsHdo0NE1VgdLjSOHClO', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_category` (`category`),
  ADD KEY `idx_place_name` (`name`);

--
-- Indexes for table `place_images`
--
ALTER TABLE `place_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `place_id` (`place_id`);

--
-- Indexes for table `problem`
--
ALTER TABLE `problem`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_place_id` (`place_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `place_images`
--
ALTER TABLE `place_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `problem`
--
ALTER TABLE `problem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `place_images`
--
ALTER TABLE `place_images`
  ADD CONSTRAINT `place_images_ibfk_1` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
