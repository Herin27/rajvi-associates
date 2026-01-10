<?php
session_start();
include 'db.php'; // તમારા ડેટાબેઝ કનેક્શનની ફાઇલ

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password']; // પાસવર્ડ સુરક્ષા માટે તમે password_hash વાપરી શકો

    // ડેટાબેઝમાં એડમિન ચેક કરવા માટેની ક્વેરી (તમારા ટેબલ મુજબ)
    $query = "SELECT * FROM users WHERE email='$username' AND password='$password' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_name'] = $user['name'];
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid Username or Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="gu">

<head>
    <meta charset="UTF-8">
    <title>Login | InquiryHub Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f8fafc;
    }
    </style>
</head>

<body class="h-screen flex items-center justify-center">
    <div class="bg-white p-10 rounded-[2.5rem] shadow-2xl border border-gray-100 w-full max-w-md">
        <div class="text-center mb-10">
            <div
                class="bg-blue-600 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-blue-100">
                <i class="fas fa-cube text-white text-3xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Welcome Back</h2>
            <p class="text-gray-400 text-sm mt-2">Login to manage Rajvi Associates</p>
        </div>

        <?php if(isset($error)): ?>
        <div
            class="bg-red-50 text-red-500 p-4 rounded-xl text-xs font-bold mb-6 border border-red-100 italic text-center">
            <?php echo $error; ?>
        </div>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-6">
            <div>
                <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2 ml-1">Email Address</label>
                <input type="email" name="username" required
                    class="w-full border-2 border-gray-50 p-4 rounded-2xl focus:border-blue-500 outline-none transition bg-gray-50/50">
            </div>
            <div>
                <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2 ml-1">Password</label>
                <input type="password" name="password" required
                    class="w-full border-2 border-gray-50 p-4 rounded-2xl focus:border-blue-500 outline-none transition bg-gray-50/50">
            </div>
            <button type="submit" name="login"
                class="w-full bg-blue-600 text-white font-bold py-4 rounded-2xl shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all uppercase tracking-widest text-xs">
                Login Securely
            </button>
        </form>
    </div>
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
</body>

</html>