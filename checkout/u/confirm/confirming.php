<?php 

    session_start();
    if(isset($_SESSION['created']) && $_SESSION['created'] == true) {
        $razorpay_test_key = 'rzp_test_ijyRypKXGF4v9w'; // Your Test Key
        $razorpay_test_secret_key = 'fVZwEgLv9nULPte4hVHAwITc'; // Your Test Secret Key

        $razorpay_live_key = 'Your_Live_Key';
        $razorpay_live_secret_key = 'Your_Live_Secret_Key';
        $razorpay_mode = 'test';

        if ($razorpay_mode == 'test') {
            $razorpay_key = $razorpay_test_key;
            $authAPIkey = "Basic " . base64_encode($razorpay_test_key . ":" . $razorpay_test_secret_key);
        } else {
            $razorpay_key = $razorpay_live_key;
            $authAPIkey = "Basic " . base64_encode($razorpay_live_key . ":" . $razorpay_live_secret_key);
        }
        
        $ch = curl_init();
        $payment_id = $_SESSION['payment_id'];
        curl_setopt($ch, CURLOPT_URL, "https://api.razorpay.com/v1/orders/$payment_id");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$razorpay_key:$razorpay_test_secret_key");

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            echo json_encode(['res' => 'error']);
        } else {
            $responseData = json_decode($response, true);
            $_SESSION['response'] = $responseData;
            curl_close($ch);
            print_r($responseData);
            if ($responseData['status'] == 'paid') {
                $_SESSION['status'] = 200;
                $_SESSION['ordered'] = true;
                header('Location: ../../.php');

            } else {
                $_SESSION['status'] = 400;
                $_SESSION['ordered'] = false;
                header('Location: ../../payment-failed.php');
            }
        }

    }
?>