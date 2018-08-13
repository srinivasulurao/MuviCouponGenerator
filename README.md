# Steps for Setup

- Create a database called **db_coupon**
- Import the database file, it will create a single table **coupons** with four columns (id, coupon_code, coupon_price, currency).
- Now just open the file **MuviCouponGenerator.php** and add database related credentials (Host, Database name, Database Password, Database username etc)
- You can also change the number of records to be inserted, as of now it is 10crores.
- You can also change the batch size, which inserts no. of records in a single insert operation, as of now it is given 1000 for smooth operation.
- Finally just run the code in a local server.


# Algorithm for coupon generation code

As per requirement the code is generating 10 CRORE records in the mysql database. Following steps has been taken to accomplish the task.

- Added set_time_limit(0), which runs the code for infinite time and will not terminate the code in the middle.
- Connected the databases inside the constructor of the class file, which fetches all database connection parameters from the class level properties.
- Now we are generating a unique coupon codes using the function **getUniqueCouponCode()**, this function is basically generating a coupon code and then it is checking that whether the generated coupon code is unique or not. To check the uniqueness we are the storing the unique code inside an **coupon code array** and then we are searching the coupon code inside the coupon code array, if it is not found then it is a unique code, otherwise it will be rejected and the function **getUniqueCouponCode()** will be called again and the same process goes on.
- Now we are generating currency value using our function **getRandomCurrency()**, this is randomly picking one currency out of three currencies GBP, USD and AUD.
- Similar to the previous step, we are using our function **getRandomPrice()** which is generating price between 1 to 100. Inorder to generate random data, we are using PHP's **rand()** with upper limit and lower limit as our parameter.
- Now comes the insertion part, in order to make the operation smoother, each time we are generating a SQL query which can insert 1000 records in one shot. In that way we are running total of 1 lakh insert query ($total_coupon_codes / $batch_size), if we increase the batch size then the number of insert queries will decrease, however it is not recommended, because it can cause fatal error for using a lot of memory to store the values in a variable, hence I have used a batch size of 1000 records, which gets inserted within 1 or 2 second(s).
- Each time a insert query is created the format will be like as shown below
```
INSERT INTO coupons (coupon_code,coupon_price,currency) VALUES ('$coupon_code','$coupon_price',$currency'),
                                                                  ('$coupon_code','$coupon_price',$currency'),
                                                                  ('$coupon_code','$coupon_price',$currency'),
                                                                  ('$coupon_code','$coupon_price',$currency'),
                                                                  ...
                                                                  SO ON.
```
                                                                  
