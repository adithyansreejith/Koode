
### Installation
  - To add the database, Import the "datingDB.sql" file which contains pre-entered data and test users from the root of the project directory into your phpMyAdmin or MySQL Workbench.
  - Set up your Database credentials in the database file located at "./Connector/DbConnectorPDO.php".
  - Run the project from your favourite IDE or put it in the "WWW" folder.

### Features

- Register Page : 
	- 1) This page has a form with validation 
	- 2) In this page user has to give his Email-id ,First name ,Last name ,Password ,City ,Birth Of date ,Gender and Image.
	- 3) All the field in this is compulsory
	- 4) There is Password and Confirm password field  both the field value matches then it will register or else it will show an error
			
			Example : 
			Email-Id : testing@gmail.com
			First Name : Test
			Last Name : User
			Password: test
			Confirm Password: test
			City: Montreal			
			Date of Birth: 05/12/1995
			Image: url
			Gender: male
			
	- 5) When a user selects an image, a preview will be shown of the image to the user.

- Login Page : 
	- 1) This Page has a form with validation
	- 2) If user enter wrong password then it will show an error
	- 3) Successful Email id and Password will give access to the website	
	      
	      Example: 
		  Email-Id : testing@gmail.com
		  Password: test 

- Chat User Page : 
	- 1) Logged in user can chat to other users. 
	- 2)  Winks sent from the profile page will be also sent into the chat directly.

- View-Profile : 
	- 1) In this page user can search the another user with First Name, City , Age and Gender.
	- 2) If the user is not logged in then user can only view the other user profiles but won't be able to send wink or messages or add them to their favourite list.
	- 3) User can search also for another user without logged in.
	- 4) To Chat with other user, user needs to be logged in to the website.
	- 5) User has a premium account then user can see whether the other user has read the message or not. 
	- 6) While having a premium account they can also add other users to their own favourite list and can also see who added them.
	- 7) User can send wink to other users directly.
	- 8) "Send wink" button will send the wink to the chat directly.

- Edit-Profile : 
	- 1) In this page, user can see and update their details.
	- 2) Here user can also update their profile image.

- Favourite Page: 
	- 1) In this page user can able to see whom they have marked favourite or other users that marked them favourite.
	- 2) User can remove the person from that list.


