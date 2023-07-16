
# Bank Fake  API
#### Simple banking operation simulator 


## Installation

After clone the repository follow these steps:

Move to the main directory of project. Copy .env.example contents to .env file.
Then run following command:
```bash
docker-compose up -d
```  
Now, to access the artisan or composer commands, simply run the following command:
```bash
docker-compose exec api sh
```   
#### Then run following commands on the opened terminal: 
Install packages :

```bash
composer install
```
Generate application key :
```bash
php artisan key:generate
```
Run migrations :

```bash
php artisan migrate
```
## APIs References

#### Register
```http
POST /api/customer/register
```

| Body | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `name`      | `string` | **Required** |
| `email`      | `string` | **Required** |
| `password`      | `string` | **Required** , At least 8 character|
| `password_confirmation` | `string` | **Required**, As the same of password field|

#### Login

```http
POST /api/customer/login
```
| Body | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `email` | `string` | **Required**|
| `password` | `string` | **Required**|


#### Open new account

```http
POST /api/account/open
```

| Body | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `balance` | `integer` | **Required**|


| Header | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `bearer` | **Required**|



#### Transfer Money

```http
POST /api/account/money-transfer
```

| Body | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `source_account` | `integer` | **Required**, ID of source account|
| `target_account` | `integer` | **Required**, ID of target account|
| `amount` | `integer` | **Required**|


| Header | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `bearer` | **Required**|


#### View Balance

```http
GET /api/account/${account}/balance
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `account`      | `integer` | **Required**, ID of customer account |


| Header | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `bearer` | **Required**|



#### Transaction Histroy

```http
GET /api/transaction/${account}/history
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `account`      | `integer` | **Required**, ID of customer account |
| `page`      | `integer` | **Optional**, number of page |


| Header | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `bearer` | **Required**|

## Running Tests

```bash
php artisan test
```

  

## View DB tables

By visiting http://localhost:8091, you can login as admin with these credentials and view all the data that has been recorded into the **bank** database:

username: root

password: secret

## Author

- [@OmidMorovati](https://github.com/OmidMorovati)

  