--
-- Database: `sxc_election`
--
-- Project Name: `Vote_System`
--
-- Project Developer: `Muthukrishnan M1
--
-- SQL Authentication STATEMENTS (QUERIES) to control Data ACCESS.
--
CREATE USER 'muthuabi'@'localhost' IDENTIFIED BY 'Muthu*123';
GRANT ALL PRIVILEGES ON *.* TO 'muthuabi'@'localhost' WITH GRANT OPTION;

ALTER USER 'root'@'localhost' ACCOUNT LOCK;

-- END OF SQL