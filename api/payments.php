<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, 
Access-Control-Request-Method, Access-Control-Allow-Origin");

include "config.php";
include "functions.php";

$RequestMethod = $_SERVER["REQUEST_METHOD"];

if($RequestMethod == "POST"){
    try {
        $user_id		    = addslashes(ucfirst(trim($_REQUEST['user_id'])));
        $package_id		    = addslashes(ucfirst(trim($_REQUEST['package_id'])));
        $transation_no		= addslashes(ucfirst(trim($_REQUEST['transaction_no'])));
        $amount		        = addslashes(ucfirst(trim($_REQUEST['amount'])));

        $UserDetails    = getUserDetails($conn, $user_id);
        $PackageDetails = getPackageDetails($conn, $package_id);

        $SubscriptionArray                            = array();
        $SubscriptionArray["user_id"]                 = $UserDetails["id"];
        $SubscriptionArray["user_name"]               = $UserDetails["username"];
        $SubscriptionArray["user_type"]               = "Student";
        $SubscriptionArray["package_id"]              = $PackageDetails["id"];
        $SubscriptionArray["package_name"]            = $PackageDetails["package_name"];
        $SubscriptionArray["package_cost"]            = $PackageDetails["package_cost"];
        $SubscriptionArray["amount_paid"]             = $amount;
        $SubscriptionArray["credits"]                 = $PackageDetails["credits"];
        $SubscriptionArray["payment_type"]            = "razorpay";
        $SubscriptionArray["transaction_no"]          = $transation_no;
        $SubscriptionArray["payment_received"]        = "1";
        $SubscriptionArray["payer_email"]             = $UserDetails["email"];
        $SubscriptionArray["subscribe_date"]          = date('Y-m-d H:i:s');
        $SubscriptionArray["user_group_id"]           = $UserDetails["user_belongs_group"];
        $SubscriptionArray["discount_type"]           = $PackageDetails["discount_type"];
        $SubscriptionArray["discount_value"]          = $PackageDetails["discount"];

        if( $PackageDetails["discount_type"] == "Value"){
            $SubscriptionArray["discount_amount"]         = $PackageDetails["discount"];
        }else{
            $PackageCost = (int) $PackageDetails["package_cost"];
            $Percentage  = (int) $PackageDetails["discount"];

            $SubscriptionArray["discount_amount"]         = ($Percentage / 100) * $PackageCost;
        }

        $columns = implode(", ",array_keys($SubscriptionArray));
        $escaped_values = array_map(array($conn, 'real_escape_string'), array_values($SubscriptionArray));
        $values  = implode("', '", $escaped_values);
        $AddNewUserQuery = "INSERT INTO pre_subscriptions ($columns) VALUES ('$values')";
        $ExecuteAddNewUserQuery = mysqli_query($conn,$AddNewUserQuery) or die ("Error in query: $AddNewUserQuery. ".mysqli_error($conn));
        $ref = mysqli_insert_id($conn);

        $TransactionArray                            = array();
        $TransactionArray["user_id"]                 = $UserDetails["id"];
        $TransactionArray["credits"]                 = $PackageDetails["credits"];
        $TransactionArray["per_credit_value"]        = "2";
        $TransactionArray["action"]                  = "credited";
        $TransactionArray["purpose"]                 = 'Package "'.$PackageDetails["package_name"].'" subscription';
        $TransactionArray["date_of_action"]          = date('Y-m-d H:i:s');
        $TransactionArray["reference_table"]         = "subscriptions";
        $TransactionArray["reference_id"]            = $ref;

        $columns = implode(", ",array_keys($TransactionArray));
        $escaped_values = array_map(array($conn, 'real_escape_string'), array_values($TransactionArray));
        $values  = implode("', '", $escaped_values);
        $AddNewUserQuery = "INSERT INTO pre_user_credit_transactions ($columns) VALUES ('$values')";
        $ExecuteAddNewUserQuery = mysqli_query($conn,$AddNewUserQuery) or die ("Error in query: $AddNewUserQuery. ".mysqli_error($conn));

        $TotalCredits     = (int) $UserDetails["net_credits"];
        $PurchasedCredits = (int) $PackageDetails["credits"];
        $NetCredits       = $TotalCredits + $PurchasedCredits;

        $UpdateArray                              = array();
        $UpdateArray["net_credits"]               = $NetCredits;
        $UpdateArray["last_updated"]              = date('Y-m-d H:i:s');

        $UpdatProfile = "UPDATE pre_users SET ";
        foreach($UpdateArray as $k => $v)
        {
            $UpdatProfile .= $k."='". $v."', ";
        }
        $UpdatProfile = rtrim($UpdatProfile, ", ");
        $UpdatProfile .= " where id = $user_id";

        $Data =[
            'status' => 200,
            'message' => 'Success',
        ];
    
        header("HTTP/1.0 200 Success");
        echo json_encode($Data);

    } catch (Exception $ex) {
        $Data =[
            'status' => 500,
            'message' => 'Internal Server Error'
        ];
    
        header("HTTP/1.0 500 Internal Server Error");
        echo json_encode($Data);
    }
}else{
    $Data =[
        'status' => 405,
        'message' => $RequestMethod . ' Method Not Allowed'
    ];

    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($Data);
}

?>