<?php
session_start();

// store current page before login
$_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
?>

<!-- LOGIN CSS -->
<link rel="stylesheet" href="../css/Login.css?v=<?php echo time(); ?>">

<?php include '../header.php'; ?>

<div class="auth-wrapper">

    <div class="authBox">
        <h2>Continue with Google</h2>

        <div id="messageArea"></div>

        <!-- Google Login -->
        <div id="g_id_onload"
             data-client_id="448895490149-mqpbkucbb8q0ton9e8uvo92m73to0s03.apps.googleusercontent.com"
             data-callback="handleCredentialResponse"
             data-auto_prompt="false">
        </div>

        <div class="g_id_signin"
             data-type="standard"
             data-theme="outline"
             data-size="large">
        </div>

    </div>

</div>

<script src="https://accounts.google.com/gsi/client" async defer></script>

<script>
function handleCredentialResponse(response) {

    const idToken = response.credential;

    fetch('googleloginhandler.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ id_token: idToken })
    })
    .then(res => res.json())
    .then(data => {

        if (data.success) {
            window.location.href = data.redirect || "../index.php";
        } else {
            document.getElementById("messageArea").innerHTML =
                "<p style='color:red'>" + data.message + "</p>";
        }
    })
    .catch(() => {
        alert("Login failed");
    });
}
</script>

<?php include '../footer.php'; ?>