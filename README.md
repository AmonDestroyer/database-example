# database-example
## Purpose
This repository is for the final project of CS451 (Database Processing) for Winter Term 2023 at the University of Oregon. An example MySQL work order (WO) processing database is the back-end that is to be attached. This project allows for the addition and viewing of the database through a web interface.

## Applications
The applications within this web interface to the database.

- Directories
  - Employe Directory: An employe directory containing the employee name, job title, phone number, and contact address.
  - Tentant Directory: A tenant directory containing the tenant name, phone number, and contact address.
- Work Orders
  - New Work Order: A tenant form for sending in a new work order.
  - View Work Orders: A list of all work orders with filters.
- Rentals
  - View Available Rentals: A filtered search of all available rentals (no tenants) for a given state.
  - Search Rentals: A search of all rentals and the tenants in the given rental with their phone number.

## Future Improvements
- Add a login feature so if someone is logged in then different views and options are provided to the user.
- Add more appltions to add/edit people, employees, addresses.
- Remove the SSN as the primary key for people as this is a security risk and visible during the person selection in the New Work Order applicaiton.

# Usage
## Dependencies
- MySQL: For database interface
- PHP: For the web applicaitons
## Setup
Follow the below steps to setup the web interface to the database. 
1. Create a MySQL server using the provided [MySQL Workbench model](/resources/models/model.mwb).
2. Create a guest account with SELECT privileges to the database and INSERT and UPDATE privileges to the work_order table.
3. Optional: Upload example data from [example data directory](/resources/example_data/).
4. Copy the [credentials-skel.ini](/config/credentials-skel.ini) file, rename to `credentials.ini` and fill out with the approriate server connection information.
5. Done