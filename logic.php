<?php
$encryptedDataFile = 'encrypted-data.php';
require_once($encryptedDataFile);
function encryptData($data, $key)
{
    $iv = random_bytes(16); // Generate a random initialization vector
    $cipherText = openssl_encrypt($data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    $encryptedData = base64_encode($iv . $cipherText);
    return $encryptedData;
}

function decryptData($encryptedData, $key)
{
    $data = base64_decode($encryptedData);
    $iv = substr($data, 0, 16);
    $cipherText = substr($data, 16);
    $decryptedData = openssl_decrypt($cipherText, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    return $decryptedData;
}
function add($data)
{
    global $encryptedAccounts, $encryptedDataFile;
    $msg = '';
    $account = ['username' => $data['username'], 'password' => $data['password']];
    if ($encryptedAccounts == '') {
        $accounts = [
            $data['platform'] => [
                $account
            ]
        ];
        $encryptedAccounts = encryptData(json_encode($accounts), $data['master_pass']);
        $msg = 'your first account has been added to encrypted factory';
    } else {
        $dData = decryptData($encryptedAccounts,  $data['master_pass']);
        if ($dData != false) {
            $decryptedAccounts = json_decode(decryptData($encryptedAccounts,  $data['master_pass']), true);
            if(array_key_exists($data['platform'],$decryptedAccounts) &&
            array_key_exists($data['add'],$decryptedAccounts[$data['platform']])){
                $decryptedAccounts[$data['platform']][$data['add']] = $account;
            }else{
                $decryptedAccounts[$data['platform']][] = $account;
            }
            $encryptedAccounts = encryptData(json_encode($decryptedAccounts),  $data['master_pass']);
            $msg = 'one more account has been added to encrypted factory';
        } else {
            $msg = 'invalid key! system failed to decrypt your data.';
        }
    }
    // Update and save the encrypted data in the PHP file
    $encryptedData = "<?php\n\n";
    $encryptedData .= "// Encrypted accounts\n";
    $encryptedData .= "\$encryptedAccounts = '$encryptedAccounts';\n";
    $encryptedData .= "\n?>";

    file_put_contents($encryptedDataFile, $encryptedData);
    return $msg;
}
function find($data)
{
    global $encryptedAccounts;
    $dData = decryptData($encryptedAccounts,  $data['master_pass']);
    if ($dData != false) {
        $decryptedAccounts = json_decode(decryptData($encryptedAccounts,  $data['master_pass']), true);
        $key = strtolower($data['platform']);
        $accounts = [];
        foreach ($decryptedAccounts as $platform => $account) {
            if (strtolower($platform) === $key) {
                 $accounts = array_merge($accounts,$account);
            }
        }
        if (count($accounts)>0) {
            return $accounts;
        } else {
            $msg = ['error' => 'Your desired platform was not found'];
            // Handle the error...
        }
    } else {
        $msg = ['error' => 'invalid key! system failed to decrypt your data.'];
    }
    return $msg;
}
