## About The Backend Challenge

the app is handel to build user authentication and authorization service,

-   responsible for authenticate and login users.
-   responsible for validating whether logged user is permitted to do specific action or not.
-   responsible for logging users out from the system

the App build using [Laravel php framework](https://Laravel.com) with the help of [jwt-auth](https://jwt-auth.readthedocs.io/en/develop/) ( JSON Web Token Authentication ) for generating secure token , if you would like to know more about `JWT` (JSON Web Token) , here are some resources

-   [The Anatomy of a JSON Web Token](https://www.digitalocean.com/community/tutorials/the-anatomy-of-a-json-web-token)

-   [JWT.IO](https://jwt.io/)
-   What is JSON Web Token?

    -   JSON Web Token (JWT) is an open standard (RFC 7519) that defines a compact and self-contained way for securely transmitting information between parties as a JSON object. This information can be verified and trusted because it is digitally signed. JWTs can be signed using a secret (with the HMAC algorithm) or a public/private key pair using RSA or ECDSA.

    -   Although JWTs can be encrypted to also provide secrecy between parties, we will focus on signed tokens. Signed tokens can verify the integrity of the claims contained within it, while encrypted tokens hide those claims from other parties. When tokens are signed using public/private key pairs, the signature also certifies that only the party holding the private key is the one that signed it.

    -   JWT contains three parts: <header, payload, signature>. I won't go into details but basically payload contains who the user is and what s/he can do, and signature verifies the token is valid. So when server receives a JWT, it can already retrieve all the information directly from the token, i.e., self-contained.

-   Why JWT?

    -   in back-end systems that need to handle extremely high volume of http requests, the need to do a database lookup for every single SessionID included in each request can be expensive as it increases latency and reduces throughput. This is not an issue for JWT as it's all self-contained. The server can simply read the JSON payload from the JWT, without making any database lookups.

-   Nice! Why not JWT Everything then?

    -   First of all, JWT requires you to properly store and distribute private / public keys that are used for signing and verifying JWTs. And key management is hard to be done right, especially in a large-scale distributed system.

    -   Secondly, since JWTs are self-contained, there is no way to revoke a JWT token. Unlike a SessionID that you can simply delete from the database and thus remove its link to a user, JWTs are not stored in database so once it's created it's valid until expired.

    -   Last but not least, because JWTs cannot be revoked, we tend to give them shorter expiration time, which requires users to re-fetch a new JWT more often. There is an option to use refresh tokens.

#

### Let's talk about authorization

-   our app is assigning a punch of permission inside a role then we can assign that role to a user this user now have all those permissions he is authorize now to do this actions also we can assign specific permission to a user without assigned it to a role.
-   as you might see in the app for every permission being created there is an observer to that event , it will assign the permission to the super role
-   the Super role is the big role which have all the authorization inside our system so you will find that the default admin have that role , also you can upgrade new user to be admin by assigning the super role to him.
-   in the `collection of postman apis` you will find `Permission` and `Role` Folders have all the needed functionality to try this scenarios yourself.

#

# Time To Setup the Application

## Setting up

### Requirements

-   [PHP >= 7.4](http://php.net/)
-   [Composer](https://getcomposer.org/)
-   [Xampp (Apache Server - PhpMyAdmin )](https://www.apachefriends.org/)
-   [Git](https://git-scm.com/)

### Clone GitHub repo for this project locally

`git clone https://github.com/baselrabia/backend-challenge.git`

-   `cd backend-challenge`
-   `composer install`
-   `cp .env.example .env`
-   `php artisan key:generate`

## Linking Mysql Database to the Project

-   Open your local `PhpMyAdmin`
-   create new database for the application
-   edit the configuration of the database in the `.env` file
-   Run the command line for making the migration of the database and seeding data <br>
    `php artisan migrate --seed`

## Starting the application

now everything is almost done just one step more to start your App

-   Run this command line for serving the App to your localhost -> `php artisan serve`

## Test Running  

there are some punch of testCases covers authentication and authorizations throw app layer by http request and throw database layer by mocking logged in user 

-   Run this command line for testing -> `php artisan test`

#
# REST APIS Usage
### Here is some instructions to show how we can use the rest apis
- at first you will see a folder inside the project called "`REST APIS Collection`"
- open the [postman](https://postman.com) app and import the collection inside it.
- everything is configured you don't have to change any environment variable.


| API | Usage | auth - permission |
|---|---|---|
| Auth > Login  | login API by using email and password |  No auth  |
| Auth > Logout | authanticated user can logout | auth  |
| Users > List  | list all system users | auth + "list-users" permission |
| Permissions > list | list all system Permissions | auth + "list-permissions" permission |
| Permissions > create | Create new permission | auth + "list-permissions" permission |
| Permissions > Assign to Role | Assign the Permission To a Role | auth + "list-permissions" permission |
| Permissions > Assign to User | Assign the Permission To a User | auth + "list-permissions" permission |
| Roles > List | list all system Roles | auth + "list-roles" permission |
| Roles > Create | Create new role | auth + "list-roles" permission |
| Roles > Assign | Assign the Role To a User | auth + "list-roles" permission |
| Page > home | display simple text | auth + "view-home" permission |
| Page > dashboard | display simple text | auth + "view-dashboard" permission |
| Page > view post | display simple text | auth + "view-post" permission |
| Page > upload photo | display simple text | auth + "upload-photo permission |


## Seed Data 
if we follow the setup in the above commands  we seeded some data to our database 
here's it 

there's an admin user has the role of `Super` which can do all the actions in the system 
- email : user@user.com
- password : 123456

and there are 5 normal users with the same password you can use them to assign roles and access to some pages 
 - user1@user.com , user2@user.com , user3@user.com , user4@user.com , user5@user.com