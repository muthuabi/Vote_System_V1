--
-- Database: `sxc_election`
--
-- Project Name: `Vote_System`
--
-- Project Developer: `Muthukrishnan M1
--
-- SQL Authentication STATEMENTS FOR CRITICAL SUPPORT (QUERIES) to control Data ACCESS.
--
CREATE USER 'critical_support'@'localhost' IDENTIFIED BY 'critical_support';
GRANT ALL PRIVILEGES ON *.* TO 'critical_support'@'localhost' WITH GRANT OPTION;

USE sxc_election;

INSERT INTO `admin` (`username`, `name`, `email`, `password`, `role`, `created_on`, `updated_on`)
VALUES('critical_support', 'Critical Support', 'critical@gmail.com', '459b8d5fc8d05dff1b7f2305ebaa9d58d8f1bf9e5eaa2d516e48877e9cc57135', 'admin', '2025-01-11 19:04:31', '2025-01-11 00:09:45');

-- ALTER USER 'root'@'localhost' ACCOUNT UNLOCK;