<?php
session_start();
require "../koneksi.php";

$error = "";

if (isset($_POST['loginbtn'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error = "Username dan Password wajib diisi.";
    } else {
        $stmt = $con->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $data = $result->fetch_assoc();
            $dbPassword = $data['password'];

            // cek password hash/bukan
            if (password_verify($password, $dbPassword) || hash_equals($dbPassword, $password)) {
                $_SESSION['username'] = $data['username'];
                $_SESSION['login'] = true;
                header('Location: ../admin');
                exit;
            } else {
                $error = "Password salah.";
            }
        } else {
            $error = "Username tidak ditemukan.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Login | Wins Beads</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        body {
            background: url('../image/background.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-box {
            background: rgba(151, 110, 137, 0.6);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 40px 30px;
            width: 100%;
            max-width: 420px;
            color: #fff;
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
            font-size: 2rem;
            text-shadow: 0 0 6px rgba(0, 0, 0, 0.4);
        }

        label {
            font-weight: 500;
            margin-bottom: 6px;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            border: none;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            backdrop-filter: blur(5px);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.3);
            outline: none;
            box-shadow: 0 0 10px rgba(199, 139, 179, 0.5);
        }

        .custom-login-btn {
            background-color: rgba(199, 139, 179, 0.6);
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            padding: 12px;
            width: 100%;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .custom-login-btn:hover {
            background-color: rgba(199, 139, 179, 0.8);
        }

        .error-msg {
            margin-top: 15px;
            background-color: rgba(179, 58, 58, 0.2);
            color: #fff;
            font-weight: 500;
            text-align: center;
            padding: 10px 15px;
            border-radius: 8px;
            border: 1px solid rgba(179, 58, 58, 0.4);
        }
    </style>
</head>
<body>

<div class="login-box" role="main" aria-label="Form Login">
    <h2>Login</h2>
    <form action="" method="post" autocomplete="off" novalidate>
        <div class="mb-3">
            <label for="username">Username</label>
            <input
                type="text"
                id="username"
                name="username"
                class="form-control"
                placeholder="Masukkan username"
                required
                value="<?php echo htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES); ?>"
            />
        </div>
        <div class="mb-3">
            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                class="form-control"
                placeholder="Masukkan password"
                required
            />
        </div>
        <button type="submit" name="loginbtn" class="custom-login-btn">Login</button>
    </form>

    <div class="text-center mt-3">
    <small>
        <a href="../login.php" style="color: #fff; text-decoration: underline;">
            Login as user
        </a>
    </small>
    </div>

    <?php if ($error): ?>
        <div class="error-msg" role="alert" aria-live="assertive">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
