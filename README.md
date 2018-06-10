# Carbon Emission Dashboard for De La Salle Philippines
A capstone project by Yuri Banawa, Kurl Ebol, and Richard Parayno.

# Set up Instructions
_MAKE SURE THAT YOU HAVE INSTALLED MAMP/XAMPP ON YOUR MACHINE. You also need a copy of composer working on your machine._
1. Clone the repository
2. Run composer install in the directory
3. Copy the existing .env.example file and copy it to .env. 
```
cp .env.example .env
```
4. Generate the application key
```
php artisan key:generate
```


# Milestone 1 (Report Modules) Requirements:
The following reports are the requirements for Milestone 1, which is to be fully completed by the end of the 2nd sprint.
* A. Emissions Needed
	- Vehicle Type
	- Institution/Location
	- Department per Institution
	- Car Brand
* B. List of CO2 Emissions for a given period for all schools
* C. Most Used Car
* D. Average
	- per month
* E. Year to Year Comparison
	- 2 months from 2 different years
	- For this car, for this school
* F. Tables & Text/Numbers
* G. Print out
* H. Tabular Reports
	- By Car:
		- Month
		- Institution
		- Summary
	- By Institution:
		- Month
		- Car
		- Summary
	- By Institution:
		- Month
		- Department
		- Summary
	- By Car Brand
		- Month
		- Car
		- Summary
* I. Fuel Type
* J. Fuel Efficiency
