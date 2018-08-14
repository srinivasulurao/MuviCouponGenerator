<?php
set_time_limit(0); //Run the code for infinite time.

Class MuviCouponGenerator
{

//#########################################################
//Initiate Settings values, Class level properties.
//#########################################################

private $db_connection;
private $host="localhost";
private $username="root";
private $password="";
private $db="db_coupon";
private $coupon_length=30;
private $total_coupons=100000000; //10 crore coupons to be inserted.
private $batch_size=1000; //1 million records in single records.
private $coupon_code_array=array();

function __construct()
{
$this->ConnectDB();
}

//#########################################################
//Establish Persistent Database Connection
//#########################################################
function ConnectDB(){
    try {
        if($con = mysqli_connect($this->host, $this->username, $this->password, $this->db)){
        $this->db_connection=$con;
        }
        else{
            throw new Exception("Unable to connect the database, please check the database config values !");
        }

    } catch (Exception $e) {
        echo "Error Code:" . mysqli_connect_errno();
        echo "<br>";
        echo $e->getMessage() . "@ line no." . $e->getLine();
        die(); //Stop the execution of the code.
    }


}
//#########################################################
//Create unique alphanumeric string.
###########################################################
public function getUniqueCouponCode()
{
    $string = "";
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    for ($i = 0; $i < $this->coupon_length; $i++)
        $string .= substr($chars, rand(0, strlen($chars)), 1);

    if(!in_array($string,$this->coupon_code_array)) {
        $this->coupon_code_array[]=$string;
        return $string;
    }
    else{
        self::getUniqueCouponCode();
    }

}

//#########################################################
//get Price of the coupon code between 1 to 100
###########################################################
private function getRandomPrice(){
    return rand(1,100);

}


//#########################################################
//get currency for the coupon code price value.
###########################################################
private function getRandomCurrency(){
    $currency_array=array(1=>"GBP",2=>"USD",3=>"AUD");
    $rand=rand(1,3);
    return $currency_array[$rand];
}


//#########################################################
//Generate a single big insertion query
//#########################################################
private function generateSQLQuery($buffer_size){

    $sql="INSERT INTO coupons (coupon_code,coupon_price,currency) VALUES";

    for($i=0;$i<$buffer_size;$i++){
        $coupon_code=$this->getUniqueCouponCode();
        $coupon_price=$this->getRandomPrice();
        $currency=$this->getRandomCurrency();
        $sql.="('$coupon_code','$coupon_price','$currency'),";
    }

    $sql=rtrim($sql,",");

    return $sql;
}

//##########################################################
//AddCoupon Code to database.
//##########################################################

public function insertCouponCodes(){

    //Inserting batches, inserting 1000 records in single batch.
    $total_batches=($this->total_coupons)/$this->batch_size;
    for($j=0;$j<$total_batches;$j++){
        $sql = $this->generateSQLquery($this->batch_size);
        mysqli_query($this->db_connection, $sql);
    }

    mysqli_close($this->db_connection);
}

} //Class ends here.
?>

