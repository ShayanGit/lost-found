-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Nov 07, 2016 at 03:02 AM
-- Server version: 5.6.33
-- PHP Version: 5.6.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lostandfound`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `AssignProperty` (IN `category` BIGINT, IN `property` BIGINT, IN `necessary` INT)  NO SQL
INSERT INTO category_property (category_property.Category_id,category_property.Property_id,category_property.Necessary) VALUES (category,property,necessary)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConfirmReport` (IN `id` BIGINT(100))  NO SQL
UPDATE item SET item.Confirmed = 1 WHERE item.Object_id = id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteItem` (IN `item_id` BIGINT(100))  NO SQL
DELETE FROM item WHERE item.Object_id = item_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteProperty` (IN `id` BIGINT(20))  NO SQL
DELETE FROM property WHERE property.Id = id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteUser` (IN `username` VARCHAR(100))  NO SQL
DELETE FROM user WHERE user.Username = username$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `FindAdmin` (IN `usr` VARCHAR(100))  NO SQL
SELECT * FROM user WHERE user.Username = usr AND user.Role = 'admin' AND user.Verified = 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `FindCategory` (IN `name` VARCHAR(100))  NO SQL
SELECT * FROM category WHERE category.Name = name$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `FindProperty` (IN `name` VARCHAR(100))  NO SQL
SELECT * FROM property WHERE property.Name = name$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `FindSubCategory` (IN `name` VARCHAR(100))  NO SQL
SELECT * FROM sub_category WHERE sub_category.Name=name$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `FindUser` (IN `usr` VARCHAR(100))  NO SQL
SELECT * FROM user WHERE user.Username = usr AND user.Role='user' AND user.Verified = 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `FoundItems` ()  NO SQL
SELECT * FROM item WHERE item.Confirmed = 1 and item.Status = 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetCategories` ()  NO SQL
SELECT * FROM category WHERE category.Category_id IS NULL$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetProperties` (IN `category` BIGINT(20))  NO SQL
SELECT category_property.Necessary ,property.Id,property.Name FROM category_property,property WHERE category_property.Category_id = category AND category_property.Property_id = property.Id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetReports` (IN `username` VARCHAR(100))  NO SQL
SELECT * FROM item,category WHERE item.User_id = username AND item.Confirmed = 1 AND item.Category = category.Id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetSubCategories` (IN `CategoryId` BIGINT(20))  NO SQL
SELECT * FROM category WHERE category.Category_id = CategoryId$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetVerificationCode` (IN `userId` VARCHAR(100))  NO SQL
SELECT * FROM (SELECT * FROM verification WHERE verification.User_id = UserId) temp ORDER BY verification.Id DESC LIMIT 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InvalidCode` (IN `userId` VARCHAR(100))  NO SQL
UPDATE verification SET verification.WrongNum = verification.WrongNum + 1 WHERE verification.User_id = userId$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Login` (IN `username` VARCHAR(100))  NO SQL
SELECT * FROM user WHERE user.Username = username$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `LostItems` ()  NO SQL
SELECT * FROM item WHERE item.Confirmed = 1 AND item.Status = 0$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `NewAdmin` (IN `name` VARCHAR(100), IN `family` VARCHAR(100), IN `username` VARCHAR(100), IN `pass` VARCHAR(100), IN `email` VARCHAR(100), IN `tel` VARCHAR(100))  NO SQL
INSERT INTO user (user.Name,user.Family, user.Username,user.Password,user.Email,user.Telephone, user.Role, user.Verified) VALUES (name,family,username,pass,email,tel,"admin",1)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `NewCategory` (IN `name` VARCHAR(100))  NO SQL
INSERT INTO category (category.Name,category.Category_id) VALUES (name,NULL)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `NewProperty` (IN `name` VARCHAR(100))  NO SQL
INSERT INTO property (property.Name) VALUES (name)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `NewSubCategory` (IN `name` VARCHAR(100), IN `parent` BIGINT)  NO SQL
INSERT INTO category (category.Name,category.Category_id) VALUES (name,parent)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `NewUser` (IN `name` VARCHAR(100), IN `family` VARCHAR(100), IN `username` VARCHAR(100), IN `pass` VARCHAR(100), IN `email` VARCHAR(100), IN `tel` VARCHAR(100))  NO SQL
INSERT INTO user (user.Name,user.Family, user.Username,user.Password,user.Email,user.Telephone, user.Role, user.Verified) VALUES (name,family,username,pass,email,tel,"user",0)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `NewVerificationCode` (IN `v_code` VARCHAR(100), IN `s_time` DATETIME, IN `userId` VARCHAR(100))  NO SQL
INSERT INTo verification (verification.Code,verification.SentTime,verification.ExpiryTime,verification.WrongNum,verification.User_id) VALUES (v_code,s_time,900,0,userId)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `NotConfirmedItem` ()  NO SQL
SELECT * FROM item WHERE item.Confirmed = 0$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ReportNewItem` (IN `Title` VARCHAR(100), IN `Category` BIGINT(20), IN `Description` TEXT, IN `Date` DATE, IN `Image_address` VARCHAR(100), IN `Status` BIT(1), IN `User_id` VARCHAR(100))  NO SQL
INSERT INTO item (item.Title, item.Category, item.Description, item.Date, item.Image_address, item.Confirmed, item.Status, item.User_id) VALUES (Title, Category, Description, Date, Image_address, 0, Status, User_id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SetAdmin` (IN `username` VARCHAR(100))  NO SQL
UPDATE user SET user.Role='admin' WHERE user.Username=username$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SetProperty` (IN `Item_id` BIGINT(100), IN `Property_id` BIGINT(20), IN `Value` VARCHAR(100))  NO SQL
INSERT INTO item_property (item_property.Item_id,item_property.Property_id,item_property.Value) VALUES (Item_id, Property_id, Value)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UserExist` (IN `username` VARCHAR(100))  NO SQL
SELECT * FROM user WHERE user.Username = username$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `VerifyUser` (IN `userId` VARCHAR(100))  NO SQL
UPDATE user SET user.Verified = 1 WHERE user.Username = userId$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `Id` bigint(20) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Category_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`Id`, `Name`, `Category_id`) VALUES
(17, 'لوازم خانگی', NULL),
(18, 'صوتی و تصویری', 17),
(19, 'کالای دیجیتال', NULL),
(28, 'موبایل', 19),
(31, 'اتوموبیل', NULL),
(32, 'سواری', 31),
(33, 'کامیون', 31),
(34, 'کامیون', 31);

-- --------------------------------------------------------

--
-- Table structure for table `category_property`
--

CREATE TABLE `category_property` (
  `Id` bigint(20) NOT NULL,
  `Category_id` bigint(20) NOT NULL,
  `Property_id` bigint(20) NOT NULL,
  `Necessary` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category_property`
--

INSERT INTO `category_property` (`Id`, `Category_id`, `Property_id`, `Necessary`) VALUES
(1, 19, 1, 0),
(20, 28, 2, 1),
(21, 31, 1, 1),
(22, 31, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `Object_id` bigint(100) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Category` bigint(20) NOT NULL,
  `Description` text NOT NULL,
  `Date` date NOT NULL,
  `Image_address` varchar(100) DEFAULT NULL,
  `Confirmed` bit(1) NOT NULL,
  `Status` bit(1) NOT NULL,
  `User_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`Object_id`, `Title`, `Category`, `Description`, `Date`, `Image_address`, `Confirmed`, `Status`, `User_id`) VALUES
(1, 'موبایل', 28, 'سکیبهسشیمبمشتب', '2016-10-24', '', b'1', b'0', 'shayan');

-- --------------------------------------------------------

--
-- Table structure for table `item_property`
--

CREATE TABLE `item_property` (
  `Id` bigint(100) NOT NULL,
  `Item_id` bigint(100) NOT NULL,
  `Property_id` bigint(20) NOT NULL,
  `Value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item_property`
--

INSERT INTO `item_property` (`Id`, `Item_id`, `Property_id`, `Value`) VALUES
(1, 1, 1, 'سفید'),
(2, 1, 2, 's5');

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

CREATE TABLE `property` (
  `Id` bigint(20) NOT NULL,
  `Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`Id`, `Name`) VALUES
(1, 'رنگ'),
(2, 'مدل'),
(5, 'سایز');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `Username` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Family` varchar(100) NOT NULL,
  `Telephone` varchar(100) NOT NULL,
  `Role` varchar(100) NOT NULL,
  `Verified` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Username`, `Password`, `Email`, `Name`, `Family`, `Telephone`, `Role`, `Verified`) VALUES
('admin', '$2y$11$z.jeRrgoK5QhVZcvkBpS9.Oi3hWyEZlYe9Hqt5.F9ZQ.zvt9/ARca', 'admin@gmail.com', 'ali', 'ahmadi', '71892398', 'admin', 1),
('ali', '$2y$11$0jg1Xas1FMNtXLiiWaVOUewsW0FyqSiKHHfE74J/D6I/05/tU8fcq', 'ali@yahoo.com', 'علی', 'احمدی', '102983108', 'user', 1),
('reza', '$2y$11$Bs.qs.4qNNcwrhH0xP1qBe/L5ailgF28kHRxBruAAeWnIZ56oBZ1y', 'test@yahoo.com', 'رضا', 'رضایی', '129387', 'user', 0),
('shayan', '$2y$11$fQotVzoNS3vnlRPV3jwiz.nfxkY3BwO.Mc7vuQoacSeO01s.bvyO6', 'shayan@yahoo.com', 'شایان', 'شیروانی', '09013842375', 'user', 1);

-- --------------------------------------------------------

--
-- Table structure for table `verification`
--

CREATE TABLE `verification` (
  `Id` bigint(20) NOT NULL,
  `Code` varchar(100) NOT NULL,
  `SentTime` datetime NOT NULL,
  `ExpiryTime` int(11) NOT NULL,
  `WrongNum` int(11) NOT NULL,
  `User_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `verification`
--

INSERT INTO `verification` (`Id`, `Code`, `SentTime`, `ExpiryTime`, `WrongNum`, `User_id`) VALUES
(1, 'sdlfkjklsdjflls', '2016-02-01 00:00:00', 900, 0, 'shayan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Category_id` (`Category_id`);

--
-- Indexes for table `category_property`
--
ALTER TABLE `category_property`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Category_id` (`Category_id`),
  ADD KEY `Property_id` (`Property_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`Object_id`),
  ADD KEY `User_id` (`User_id`),
  ADD KEY `Category` (`Category`);

--
-- Indexes for table `item_property`
--
ALTER TABLE `item_property`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Item_id` (`Item_id`),
  ADD KEY `Property_id` (`Property_id`);

--
-- Indexes for table `property`
--
ALTER TABLE `property`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Username`);

--
-- Indexes for table `verification`
--
ALTER TABLE `verification`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `User_id` (`User_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `category_property`
--
ALTER TABLE `category_property`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `Object_id` bigint(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `item_property`
--
ALTER TABLE `item_property`
  MODIFY `Id` bigint(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `property`
--
ALTER TABLE `property`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `verification`
--
ALTER TABLE `verification`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `category_ibfk_1` FOREIGN KEY (`Category_id`) REFERENCES `category` (`Id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `category_property`
--
ALTER TABLE `category_property`
  ADD CONSTRAINT `category_property_ibfk_1` FOREIGN KEY (`Category_id`) REFERENCES `category` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `category_property_ibfk_2` FOREIGN KEY (`Property_id`) REFERENCES `property` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`User_id`) REFERENCES `user` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `item_ibfk_2` FOREIGN KEY (`Category`) REFERENCES `category` (`Id`);

--
-- Constraints for table `item_property`
--
ALTER TABLE `item_property`
  ADD CONSTRAINT `item_property_ibfk_1` FOREIGN KEY (`Item_id`) REFERENCES `item` (`Object_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `item_property_ibfk_2` FOREIGN KEY (`Property_id`) REFERENCES `property` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `verification`
--
ALTER TABLE `verification`
  ADD CONSTRAINT `verification_ibfk_1` FOREIGN KEY (`User_id`) REFERENCES `user` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
