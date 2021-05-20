-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Värd: localhost:8889
-- Tid vid skapande: 19 maj 2021 kl 12:59
-- Serverversion: 5.7.32
-- PHP-version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Databas: `superstore`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumpning av Data i tabell `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`) VALUES
(1, 'Robin', 'robin@gmail.com', 'admin1234'),
(2, 'Kweku', 'kweku@gmail.com', 'admin1234'),
(3, 'Özgur', 'ozgur@gmail.com', 'admin1234'),
(4, 'Sebastian', 'sebastian@gmail.com', 'admin1234');

-- --------------------------------------------------------

--
-- Tabellstruktur `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumpning av Data i tabell `customer`
--

INSERT INTO `customer` (`id`, `name`, `email`, `password`) VALUES
(1, 'Robin Hedlund', 'robin@gmail.com', '1234'),
(2, 'Kweku Moses', 'kweku@gmail.com', '1234'),
(6, 'admin', 'admin@gmail.com', 'admin'),
(8, 'Robin Hedlund', 'admin@live.se', '$2y$10$uVUUlCF2cbyHu/j/Ha7uTOOC1vrrElfhyTA.HvjKVp791xtYQnIXa'),
(9, 'Robin Hedlund', 'robin.hedlund@live.se', '$2y$10$jkaCLHKSaQF3R6H1DN1DU.BZoVuDuC48YPcqFVsUwplvefNNbVOua'),
(10, 'Customer', 'customer@gmail.com', '$2y$10$giOU/p2tB15cV0n3D5Bb1eWSJ5RI1xwxL3teCJuPniv1K86m5KxFK');

-- --------------------------------------------------------

--
-- Tabellstruktur `order`
--

CREATE TABLE `order` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  `total_price` int(11) NOT NULL,
  `is_shipped` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumpning av Data i tabell `order`
--

INSERT INTO `order` (`order_id`, `customer_id`, `date`, `total_price`, `is_shipped`) VALUES
(1, 6, '2021-05-19 13:54:26', 300, 0),
(2, 10, '2021-05-19 14:05:08', 107799, 0),
(3, 10, '2021-05-19 14:13:37', 107799, 0),
(4, 10, '2021-05-19 14:14:39', 107799, 0),
(5, 10, '2021-05-19 14:18:07', 107799, 0),
(6, 10, '2021-05-19 14:20:51', 107799, 0),
(7, 10, '2021-05-19 14:38:19', 107799, 0),
(8, 10, '2021-05-19 14:38:58', 107799, 0),
(9, 10, '2021-05-19 14:45:38', 122789, 0),
(10, 10, '2021-05-19 14:45:57', 0, 0);

-- --------------------------------------------------------

--
-- Tabellstruktur `order_item`
--

CREATE TABLE `order_item` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumpning av Data i tabell `order_item`
--

INSERT INTO `order_item` (`order_id`, `product_id`, `quantity`) VALUES
(8, 1, 2),
(8, 2, 1),
(8, 3, 1),
(9, 1, 2),
(9, 2, 1),
(9, 3, 1),
(9, 4, 1),
(9, 5, 1);

-- --------------------------------------------------------

--
-- Tabellstruktur `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `price` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `category` varchar(50) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumpning av Data i tabell `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `description`, `image`, `category`) VALUES
(1, 'Black Bad Boy Boots', 3600, 'Walk like a motherhugging king', 'https://cdn.shopify.com/s/files/1/2521/5640/products/Luca_BlackLux_01_1800x1800.jpg?v=1566318524', 'mens clothing'),
(2, 'Fat Dollar Sign Gold Necklace', 100000, 'Nice chains bro', 'https://images-na.ssl-images-amazon.com/images/I/81H2B3uGTPL._AC_UL1500_.jpg', 'jewelery'),
(3, 'Stolen Voi', 599, 'Only the best price for you my friend', 'https://images.ohmyhosting.se/CmIW6qR66GXAhR34uZp0y10iJgk=/1080x928/smart/filters:quality(85)/https%3A%2F%2Fwww.voiscooters.com%2Fwp-content%2Fuploads%2F2019%2F09%2Fvoi2-1.jpg', 'electronics'),
(4, 'Hideous Boots', 7495, 'Green boots(socks??) from Balenciaga', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQXdxn31dx9ORyvcZ0bjKwo_RjWl6B_PmxAYpWryPuqPPGpIATpryfFR2IqdVHdUiFebb89ZcSg&usqp=CAc', 'womens clothing'),
(5, 'Bikeless Leather Jacket', 7495, 'We all know you can\'t afford the bike', 'https://assets.trouva.com/image/upload/w_690,f_auto,q_auto:eco,dpr_auto,c_pad,b_white/v1604063150/brand/5da6e14620dd0500038c09b0/14432544-de4a-4d36-a11e-1034c6b733df.jpg', 'mens clothing'),
(6, 'Knitted Gucci Sweater', 7999, 'Nothing feels better than a Gucci sweater', 'https://cdn-images.farfetch-contents.com/14/60/78/59/14607859_23127090_480.jpg', 'mens clothing'),
(7, 'Camo Beanie', 599, 'Camo WHERE IS IT beanie from Carharttttttttt', 'https://cdna.lystit.com/1040/1300/n/photos/nugnes1920/fc15e444/carhartt-Green-Hat-Man.jpeg', 'mens clothing'),
(8, 'DB Backback', 1999, 'Backpack from and for douchebags', 'https://douchebags.centracdn.net/client/dynamic/images/80_068992bb5a-explorer_black-full.jpg', 'mens clothing'),
(9, 'Engagement Ring', 50000, 'Oh no now you\'re fucked forever', 'https://i.pinimg.com/originals/aa/e0/27/aae027de9d0a8d7dda03fd52b8492c8e.jpg', 'jewelery'),
(10, 'Illuminati Ring', 0, 'So everyone can see you\'re in the new world order', 'https://images-na.ssl-images-amazon.com/images/I/71JVtkLXtBL._SY500_.jpg', 'jewelery'),
(11, 'Battery as Earring', 10, 'If you can\'t afford anything else', 'https://res.cloudinary.com/rsc/image/upload/b_rgb:FFFFFF,c_pad,dpr_1.0,f_auto,h_337,q_auto,w_600/c_pad,h_337,w_600/F7082361-01?pgw=1', 'jewelery'),
(12, 'Average Looking Nose Ring', 299, 'Show everyone how edgy you are', 'https://images-na.ssl-images-amazon.com/images/I/41QZELkNwOL.jpg', 'jewelery'),
(13, 'Apple Mac Pro', 200000, 'An oversized cheese grater', 'https://support.apple.com/library/content/dam/edam/applecare/images/en_US/social/2019-identify-mac-pro-social-card.jpg', 'electronics'),
(14, 'Samsung 100-inch QLED', 40000, 'So you can watch everything bigger', 'https://www.mansworldindia.com/wp-content/uploads/2018/09/The-Vu-100-TV-1-1024x675.jpg', 'electronics'),
(15, 'Xbox Series X', 3000, 'Have fun not playing with all your friends since all of them have playstation', 'https://www.techinn.com/f/13777/137776929/microsoft-xbox-series-x-1tb.jpg', 'electronics'),
(16, 'Robotic Lawn Mower', 4999, 'We know we\'re all too lazy to to it ourselves', 'https://i.pinimg.com/originals/45/e5/16/45e51631075b885e914828516a42c294.jpg', 'electronics'),
(17, '80\'s Glasses', 299, 'Let\'s kick it like its 1985', 'https://i.pinimg.com/originals/ed/b7/37/edb737927ee3e0a6414d8fdcdb813562.jpg', 'womens clothing'),
(18, 'Overpriced Floral Silk Dress', 16999, 'Super spicy dress from Miu Miu', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRosK-vLveMFjvRJahAO5WOu-Jq0IkIuPb6e-fQkZYsgo0r6IhuuVPvfGUhRLGHVv2jNIUtMW0C&usqp=CAc', 'womens clothing'),
(19, 'Cowboy Hat', 1500, 'Release your inner Dolly Parton', 'https://i.pinimg.com/originals/fc/5a/ff/fc5affa15964640ca0e0c5cb964afab3.jpg', 'womens clothing'),
(20, 'Jurassic Park Mamasaurus Edition', 299, 'Don\'t mess with mamasaurus cause apparantly you\'ll get jurasskicked', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR0mVeRWXYuUNwwFA8wKfObDMTzgpcRV_MfVByl_TQguC9VMV4m8GaUcPIsDPayfEldtkknGmMz&usqp=CAc', 'womens clothing');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index för tabell `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index för tabell `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Index för tabell `order_item`
--
ALTER TABLE `order_item`
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Index för tabell `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT för tabell `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT för tabell `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT för tabell `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`);

--
-- Restriktioner för tabell `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`),
  ADD CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
