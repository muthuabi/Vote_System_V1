# Vote System
Developed by **MUTHUKRISHNAN M**
The **Vote System** is a web-based application designed for college elections with multiple voting booths connected via a LAN network. This system allows booth staff to select criteria and proceed to vote if the poll is active, while admins manage polls and view live results.

## Project Overview
- **Multiple Voting Booths**: Booths connected through the same LAN network, with no login required for booth staff.
- **Criteria Selection**: Staff select criteria such as shift or gender before proceeding to vote.
- **Admin Control**: Admins can start and end polls, and perform CRUD operations on positions, candidates, and other admins.
- **Live Ballot**: Admins and viewers can see live polling results with viewer credentials created by the admin.
- **Data Migration**: Master admins can migrate current election data to an old table and reset tables for the next election cycle.
- **Dynamic Dashboard**: Displays multiple post cards with dynamic updates on total candidates and total votes once the poll has started.
- **Master Admin Actions**: Master admins can start (restart if ended accidentally) and end the poll, add/delete/restrict other admins, and delete votes, candidates, and positions tables with a single button. Deleting the poll returns it to the initial stage.
- **Print Features**: Print winners and all results with candidate image, college logo, and details after the poll ends, available for all officials (admin, sub-admin, viewer).
- **Live Ballot Notifications**: Toast notifications appear when the server goes offline and persist until it comes back online.
- **Position Status**: Indicates whether a candidate is unopposed, no contestants, or opposed. Unopposed candidates don't receive votes and are not shown in the live ballot but are visible in print marked as unopposed.

## Technology Stack
- PHP
- MySQL
- HTML
- CSS
- JavaScript

## Installation
1. Clone the repository: `git clone https://github.com/muthuabi/Vote_System`
2. Set up your web server (e.g., XAMPP) and ensure it is connected to the same LAN network as the voting booths.
3. Import the provided SQL file into your MySQL database.
4. Update the database configuration in the project files with your database credentials.
5. Start your web server and navigate to the project URL.

## Usage
- **Booth Staff**: Select criteria and proceed to vote.
- **Admin**: Manage polls, candidates, positions, and view live results.
- **Master Admin**: Perform data migration, reset tables, and manage other admins.

## License
This project is licensed under the MIT License with additional terms. See the [LICENSE](LICENSE) file for details.

## Contact
For any questions or inquiries, please contact me at [muthuabi292@gmail.com](mailto:muthuabi292@gmail.com).

## Project Link
[GitHub Repository](https://github.com/muthuabi/Vote_System_V1)

## Acknowledgement
This project was developed for St. Xavier's College, Palayamkottai, after the course period ended and is not an academic project.
