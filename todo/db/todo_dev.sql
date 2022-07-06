--
-- Database: `todo_dev`
--
CREATE DATABASE IF NOT EXISTS `todo_dev` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `todo_dev`;

-- --------------------------------------------------------

--
-- Table structure for table `todo_items`
--

CREATE TABLE `todo_items` (
  `todo_id` int(11) NOT NULL COMMENT 'Primary Key',
  `todo_title` varchar(255) NOT NULL COMMENT 'Title',
  `todo_status` int(4) NOT NULL DEFAULT 1 COMMENT 'status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `todo_items`
--
ALTER TABLE `todo_items`
  ADD PRIMARY KEY (`todo_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `todo_items`
--
ALTER TABLE `todo_items`
  MODIFY `todo_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key', AUTO_INCREMENT=1;
COMMIT;